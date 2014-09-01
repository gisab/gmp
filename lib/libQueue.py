#!/usr/bin/python
#
###########################################################
#                                                         #
# Project: GMP                                            #
# Author:  gianluca.sabella@gmail.com                     #
#                                                         #
# Module:  libQueue.py                                    #
# First version: 13/08/2014                               #
#                                                         #
###########################################################

prjName='gmp'
#currDir=os.getcwd()
import os,sys
currDir=os.path.realpath(__file__)
prjFolder=currDir.split(prjName)[0]+prjName
sys.path.append(prjFolder+'/lib')

import MySQLdb
import config
import argparse
import logging
import pprint
import libQueue
import dbif
import time
from lxml import etree

CharToBool={'Y': True, 'N': False}
BoolToChar={True:'Y', False:'N'}
if config.ini.get('general','debug')=='Y':
    debug=True
else:
    debug=False

#global constant for queue workflow
cnew          ='NEW'
cdwn          ='DWNING'
cdwnmeta      ='DWNMETA'
cdwncompleted ='DWNFULL'
cdwnverified  ='DWNOK'
cfinalising   ='PARSING'
cdone         ='DONE'

rep           =config.ini.get('downloader','repository').replace('$PRJ',prjFolder)

class queue(object):
    def __init__(self,init='#'):
        self.getqueue()
        if init=='new':
            self.db=dbif.gencur('DELETE FROM queue')
            self.db.connection.commit()
            self.getqueue()
        pass

    def getqueue(self):
        self.db=dbif.gencur('SELECT * FROM queue')
        self.queue=self.db.cur.fetchall()
    
    def addItem(self,newItemObj):
        #check that newItem is instance of newItem
        assert isinstance(newItemObj, newItem)
        if hasattr(newItemObj,'forcedStatus'):
            newStatus=newItemObj.forcedStatus
        else:
            newStatus=cnew
        qry="INSERT INTO queue (id,status,agentid,targetid,note) values ('%s','%s','%s','%s','%s');" % (newItemObj.ID,newStatus,newItemObj.agentID,newItemObj.targetID,newItemObj.note)
        if debug:
            print qry
        self.db.exe(qry)
        qry="INSERT INTO files (qid, filename, url) values ('%s', '%s', '%s');"
        for i in newItemObj.files:
            iqry=qry % (newItemObj.ID, i['filename'], i['url'])
            if debug:
                print iqry
            self.db.exe(iqry)
        pass
    
    def getItemDownloaded(self,pid='#'):
        if pid=='#':
            #Download without lock a queued item for triggering the download
            return self.getItem(fromStatus=(cdwnmeta,cdwncompleted,cdwnverified))
        else:
            #Download and lock a queued item for triggering the download
            return self.getItem(lockpid=pid,fromStatus=(cdwnmeta,cdwncompleted,cdwnverified),toStatus=cfinalising)

    def getItemForDownload(self,pid):
        #Download and lock a queued item for triggering the download
        return self.getItem(lockpid=pid,fromStatus=(cnew,),toStatus=cdwn)

    def getItem(self,lockpid='#',fromStatus='#',toStatus='#'):
        assert fromStatus!='#'
        
        if lockpid=='#':
            #get withoud locking the first avaiable item in the list
            fromStatusCriteria = "'"+"','".join(fromStatus)+"'" 
            qry="SELECT ID, STATUS FROM queue where STATUS in (%s) order by LAST_UPDATE ASC limit 1;" % fromStatusCriteria
            self.db.cur.execute(qry)
            rec=self.db.cur.fetchone()
            if rec==None:
                #no record found
                return "#"
            nid=rec[0]
        else:
            #get and lock the first avaiable item in the list
            fromStatusCriteria = "'"+"','".join(fromStatus)+"'" 
            qry="SELECT ID, STATUS FROM queue where STATUS in (%s) and pid is null order by LAST_UPDATE ASC limit 1;" % fromStatusCriteria
            self.db.cur.execute(qry)
            rec=self.db.cur.fetchone()
            if rec==None:
                #no record found
                return "#"
            nid=rec[0]
            #lock the current record
            assert toStatus!='#'
            qry="UPDATE queue SET status='%s', pid='%s' where ID='%s';" % (toStatus, lockpid, nid)
            print qry
            self.db.exe(qry)
            #wait 1 second and check that the record is indeed locked by this running instance
            time.sleep(1)
            qry="SELECT ID, PID FROM queue where id='%s' and pid='%s';" % (nid, lockpid)
            self.db.cur.execute(qry)
            rec=self.db.cur.fetchone()
            if rec==None:
                #no record found, i.e. the record has not been locked properly
                return "#"
            self.db.connection.commit()
        #Prepare queuedItem object
        x=queuedItem(nid)
        return x

    def resetDownloadQueue(self):
        qry="UPDATE queue SET pid='', status='%s';" % (cnew)
        print qry
        self.db.exe(qry)
                
    def dump(self):
        self.getqueue()
        pprint.pprint(self.queue)
        pass
    
    def cleanpid(self):
        qry="UPDATE queue SET pid=Null;"
        print qry
        self.db.exe(qry)

class queuedItem(object):
    ##Constructor
    def __init__(self, itemID):
        self.db=dbif.gencur("select 'none';")
        qry="SELECT ID, STATUS, pid, agentid, targetid, LAST_UPDATE FROM queue where ID='%s';" % itemID
        self.db.cur.execute(qry)
        rec=self.db.cur.fetchone()
        if rec==None:
            #no record found
            self.id="#"
            return
        self.id      =rec[0]
        self.status  =rec[1]
        self.pid     =rec[2]
        self.agentid =rec[3]
        self.targetid=rec[4]
        self.last_update=rec[5]

        #Get the download agent characteristic
        qry="SELECT ID, cli FROM agent where id='%s';" % self.agentid
        self.db.cur.execute(qry)
        rec=self.db.cur.fetchone()
        if rec!=None:
            self.agentcli=rec[1]
        else:
            self.agentcli="ERROR: Agent CLI not found!"
        
        #Get the list of files to be downloaded
        qry="SELECT ID, filename, url FROM files where qid='%s';" % itemID
        self.db.cur.execute(qry)
        rec=self.db.cur.fetchall()
        if rec==None:
            #no record found
            return
        self.files=list()
        for i in rec:
            x=dict()
            x['fileid']   =i[0]
            x['filename'] =i[1]
            x['url']      =i[2]
            self.files.append(x)
        return
    
    ## Destructor
    def __del__(self):
        self.unlock()
        pass

    ##Set new status for the object
    def setStatus(self,newStatus):
        qry="UPDATE queue set STATUS='%s' where ID='%s';" % (newStatus, self.id)
        self.db.exe(qry)
        self.status=newStatus
        pass

    ##Clean pid attribute, i.e. unlock
    def unlock(self):
        qry="UPDATE queue set pid=Null where ID='%s';" % str(self.id)
        self.db.exe(qry)
        pass
    
    ## Search for the manifest and create file and xml handlers
    def openManifest(self):
        if self.targetid=='oda':
            for i in self.files:
                if 'manifest' in i['filename'].lower():
                    print 'manifest: %s' % i['filename']
                    manifest=i['filename']
                    self.manifestPath=rep+manifest
                    self.manifestParser=etree.fromstring(open(self.manifestPath).read())
                    return 

    ## Search for the manifest and create file and xml handlers
    def parseManifest(self):
        if self.manifestParser:
            self.coordinatesKML=self.manifestParser.find('.//{http://www.opengis.net/gml}coordinates').text
            #Translate from KML in WKT
            tmp=self.coordinatesKML.replace(',','/').replace(' ',',').replace('/',' ')
            firstpoint=tmp.split(',')[0]
            self.coordinatesWKT='POLYGON ((' + tmp +',' + firstpoint+ '))'

    def addTag(self,newtag):
        qry="SELECT tags FROM queue where ID='%s';" % str(self.id)
        self.db.cur.execute(qry)
        rec=self.db.cur.fetchone()
        if rec[0]==None:
            newfield=newtag
        else:
            self.tags=rec[0].split(',')
            self.tags.append(newtag)
            newfield=','.join(sorted(self.tags))
        qry="UPDATE queue set tags='%s' where ID='%s';" % (newfield,str(self.id))
        self.db.exe(qry)
        pass

    def delTag(self,newtag):
        #qry="UPDATE queue set pid=Null where ID='%s';" % str(self.id)
        #self.db.cur.execute(qry)
        pass

    def cleanTag(self):
        qry="UPDATE queue set tags=Null where ID='%s';" % str(self.id)
        self.db.cur.execute(qry)
        self.tags=list()
        pass

class newItem(object):
    def __init__(self):
        default="#"
        self.ID=default
        self.agentID=default
        self.note=default
        self.targetID=default
        self.files=list()
    
    def setID(self,value):
        self.ID=value

    def setNote(self,value):
        self.note=value

    def setAgent(self,value):
        self.agentID=value

    def setTarget(self,value):
        self.targetID=value

    def forceStatus(self,value):
        self.forcedStatus=value

    def addFile(self, filename, url, desc="#"):
        x={'filename':filename,
           'url':url}
        if desc!="#":
            x['desc']=desc
        self.files.append(x)