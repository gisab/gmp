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

CharToBool={'Y': True, 'N': False}
BoolToChar={True:'Y', False:'N'}
if config.ini.get('general','debug')=='Y':
    debug=True
else:
    debug=False

#global constant for queue workflow
cnew   ='NEW'
cdwn   ='DOWN'

class queue(object):
    def __init__(self,init='#'):
        if init=='new':
            self.db=dbif.gencur('DELETE FROM queue')
            self.db.connection.commit()
        self.getqueue()
        pass

    def getqueue(self):
        self.db=dbif.gencur('SELECT * FROM queue')
        self.queue=self.db.cur.fetchall()
    
    def addItem(self,newItem):
        print 'add check that newItem is instance of newItem'
        qry="INSERT INTO queue (id,status) values ('%s','%s');" % (newItem.ID,cnew)
        if debug:
            print qry
        self.db.exe(qry)
        qry="INSERT INTO files (qid, filename, url) values ('%s', '%s', '%s');"
        for i in newItem.files:
            iqry=qry % (newItem.ID, i['filename'], i['url'])
            if debug:
                print iqry
            self.db.exe(iqry)
        pass
    
    def getItem(self,pid):
        #get and lock the first avaiable item in the list
        qry="SELECT ID, STATUS FROM queue where STATUS='%s' order by LAST_UPDATE ASC limit 1;" % cnew
        self.db.cur.execute(qry)
        rec=self.db.cur.fetchone()
        if rec==None:
            #no record found
            return "#"
        nid=rec[0]
        qry="UPDATE queue SET status='%s', note='%s' where ID='%s';" % (cdwn, pid, nid)
        print qry
        self.db.exe(qry)
        return nid
        
    def dump(self):
        self.getqueue()
        pprint.pprint(self.queue)
        pass
    

class queuedItem(object):
    def __init__(self):
        pass

class newItem(object):
    def __init__(self):
        default="#"
        self.ID=default
        self.files=list()
    
    def setID(self,newid):
        self.ID=newid
        
    def addFile(self, filename, url, desc="#"):
        x={'filename':filename,
           'url':url}
        if desc!="#":
            x['desc']=desc
        self.files.append(x)