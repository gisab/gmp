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
import pluginClass
from lxml import etree
import traceback
import libProduct
import json
import subprocess

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

chasmetalink   ="HASMETALINK"
chasmetadata   ="HASMETADATA"
cmetadataparsed="METADATAPARSED"
ccatalogued    ="CATALOGUED"

#global constant for file queue workflow
cDwnStatusNo        ='N'
cDwnStatusQueued    ='Q'
cDwnStatusCompleted ='C'

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

        #Insert record into PRODUCT table
        qry="INSERT INTO product (id, footprint) values ('%s', GeomFromText('POINT(0 0)'));" % (newItemObj.ID)
        if debug:
            print qry
        try:
            self.db.exe(qry)
        except:
            print "Product already exists; maybe it comes from other sources"
        
        #Insert record into QUEUE table
        if hasattr(newItemObj,'forcedStatus'):
            newStatus=newItemObj.forcedStatus
        else:
            newStatus=cnew
        qry="INSERT INTO queue (id,status,agentid,targetid,note) values ('%s','%s','%s','%s','%s');" % (newItemObj.ID,newStatus,newItemObj.agentID,newItemObj.targetID,newItemObj.note)
        if debug:
            print qry
        self.db.exe(qry)
        
        #Insert records into FILES table
        qry='INSERT INTO files (qid, targetid, filename, url) values ("%s","%s", "%s", "%s");'
        for i in newItemObj.files:
            iqry=qry % (newItemObj.ID, newItemObj.targetID, i['filename'], i['url'])
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

    def getItemForMetalinkDownload(self,pid):
        #Download and lock a queued item for triggering the download
        return self.getItem(lockpid=pid,fromStatus=(cnew,),toStatus=chasmetalink)

    def getItemForGettingMetadata(self,pid):
        #Download and lock a queued item for triggering the download
        return self.getItem(lockpid=pid,fromStatus=(chasmetalink,),toStatus=chasmetadata)

    def getItemForParsingMetadata(self,pid):
        #Download and lock a queued item for triggering the download
        return self.getItem(lockpid=pid,fromStatus=(chasmetadata,),toStatus=cmetadataparsed)

    def getItemForCatalouging(self,pid):
        #Download and lock a queued item for triggering the download
        return self.getItem(lockpid=pid,fromStatus=(cmetadataparsed,),toStatus=ccatalogued)

    def getItemForDownload(self,pid):
        #Download and lock a queued item for triggering the download
        return self.getItem(lockpid=pid,fromStatus=('%'),dwnStatus=cDwnStatusQueued)

    def getItem(self,lockpid='#',fromStatus='#',toStatus='#', dwnStatus='#'):
        assert fromStatus!='#'
        if dwnStatus!='#':
            dwnquery=" AND dwnstatus='%s'" % dwnStatus
        else:
            dwnquery=""
        if fromStatus=='%':
            qwhere=" True "
        else:
            fromStatusCriteria = "'"+"','".join(fromStatus)+"'" 
            qwhere="STATUS in (%s) " % fromStatusCriteria
        qwhere+=dwnquery
        if lockpid=='#':
            #get withoud locking the first avaiable item in the list
            fromStatusCriteria = "'"+"','".join(fromStatus)+"'" 
            qry="SELECT ID, STATUS FROM queue where %s order by LAST_UPDATE ASC limit 1;" % (qwhere)
            self.db.cur.execute(qry)
            rec=self.db.cur.fetchone()
            if rec==None:
                #no record found
                return "#"
            nid=rec[0]
        else:
            qry="START TRANSACTION;"
            self.db.cur.execute(qry)
            #get and lock the first avaiable item in the list
            fromStatusCriteria = "'"+"','".join(fromStatus)+"'" 
            qry="SELECT ID, TARGETID FROM queue where %s and pid is null order by LAST_UPDATE ASC limit 1 FOR UPDATE;" % (qwhere)
            counter=0
            while True:
                if counter>5:
                    raise "Not able to lock a record"
                try:
                    counter+=1
                    self.db.cur.execute(qry)
                    break
                except:
                    print "Deadlock exception; sleeping and retry"
                    time.sleep(1)
            rec=self.db.cur.fetchone()
            if rec==None:
                #no record found
                return "#"
            nid=rec[0]
            ntargetid=rec[1]
            #lock the current record
            qry="UPDATE queue SET pid='%s' where ID='%s'and TARGETID='%s';" % (lockpid, nid, ntargetid)
            #print qry
            self.db.exe(qry)
            self.db.connection.commit()
            #wait 1 second and check that the record is indeed locked by this running instance
            #time.sleep(1)
            #qry="SELECT ID, PID FROM queue where id='%s' and pid='%s';" % (nid, lockpid)
            #self.db.cur.execute(qry)
            #rec=self.db.cur.fetchone()
            #if rec==None:
            #    #no record found, i.e. the record has not been locked properly
            #    return "#"
            #self.db.connection.commit()
        #Prepare queuedItem object
        x=queuedItem(nid)
        x.closeStatus=toStatus
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

    def cleanNOK(self):
        qry="UPDATE queue SET status='%s' where status='NOK';" % cnew
        print qry
        self.db.exe(qry)
    
    def getAllMetalinks(self,pid):
        somethingProcessed=False
        while(True):
            y=self.getItemForMetalinkDownload(pid)
            if y=='#':
                #no record found
                break
            try:
                y.getMetalink()
                y.close()
                somethingProcessed=True
            except:
                traceback.print_exc(file=sys.stdout)
                pass
            y=None
        return somethingProcessed

    def getAllMetadata(self,pid):
        somethingProcessed=False
        processedInThisRun=list()
        while(True):
            y=self.getItemForGettingMetadata(pid)
            if y=='#':
                #no record found
                break
            if y.id in processedInThisRun:
                #completed a loop on all available item
                #exit from this loop
                break
            if y.product.wkt not in (None, '','#'):
                #Product already extracted
                #probably the product is found on more than one target and metadata have been alreadt extracted by other target plugin.
                #Do nothing and mark product as processed
                y.close()
                somethingProcessed=True
                continue
            try:
                processedInThisRun.append(y.id)
                print "Processing getMetadata %s" % y.id
                y.getMetadata()
                y.close()
                somethingProcessed=True
            except:
                #Do not flag the product as NOK
                #For ODA the product may be rolled an in a next run may be OK
                #y.setStatus('NOK')
                traceback.print_exc(file=sys.stdout)
                pass
            y=None
        return somethingProcessed

    def parseAllMetadata(self,pid):
        somethingProcessed=False
        processedInThisRun=list()
        while(True):
            y=self.getItemForParsingMetadata(pid)
            if y=='#':
                #no record found
                break
            if y.id in processedInThisRun:
                #completed a loop on all available item
                #exit from this loop
                break
            if ('POLYGON' in y.product.footprint.upper()) or ('LINESTRING' in y.product.footprint.upper()):
                #Product footprint already extracted
                #probably the product is found on more than one target and metadata have been alreadt extracted by other target plugin.
                #Do nothing and mark product as processed
                y.close()
                somethingProcessed=True
                continue
            try:
                processedInThisRun.append(y.id)
                print "Processing parseMetadata %s" % y.id
                y.parseMetadata()
                y.close()
                somethingProcessed=True
            except:
                y.setStatus('NOK')
                traceback.print_exc(file=sys.stdout)
                pass
            y=None
        return somethingProcessed

    def catalogueAll(self,pid):
        somethingProcessed=False
        while(True):
            y=self.getItemForCatalouging(pid)
            if y=='#':
                #no record found
                break
            try:
                print "Processing catalogue %s" % y.id
                y.product.catalogue()
                y.close()
                somethingProcessed=True
            except:
                y.setStatus('NOK')
                traceback.print_exc(file=sys.stdout)
                pass
            y=None
        return somethingProcessed

class queuedItem(object):
    ##Constructor
    def __init__(self, itemID, closeStatus='#'):
        self.db=dbif.gencur("select 'none';")
        qry="SELECT ID, STATUS, pid, agentid, targetid, note, LAST_UPDATE FROM queue where ID='%s';" % itemID
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
        self.note    =rec[5]
        try:
            self.note    =json.loads(self.note)
        except:
            pass
        self.last_update=rec[6]
        self.closeStatus=closeStatus
        
        #Get the target characteristic
        self.connection=dbif.getTargetList("id='%s'" % self.targetid)[0]
        self.targettype=self.connection['type']

        #Get the download agent characteristic
        qry="SELECT ID, cli FROM agent where id='%s';" % self.agentid
        self.db.cur.execute(qry)
        rec=self.db.cur.fetchone()
        if rec!=None:
            self.agentcli=rec[1]
        else:
            self.agentcli="ERROR: Agent CLI not found!"
        
        #Get the list of files to be downloaded
        qry="SELECT ID, filename, url, dwnstatus FROM files where qid='%s';" % itemID
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
            x['dwnstatus']   =i[3]
            self.files.append(x)

        #Get the product characteristic
        self.product=libProduct.product(itemID)

        return

    ## Destructor
    def __del__(self):
        self.unlock()
        pass

    def getMetalink(self):
        plugin=pluginClass.getPlugin(self.targettype,self.connection)
        self.getMetalink=plugin.getMetalink(self)

    def getMetadata(self):
        plugin=pluginClass.getPlugin(self.targettype,self.connection)
        self.getMetadata=plugin.getMetadata(self)

    def parseMetadata(self):
        plugin=pluginClass.getPlugin(self.targettype,self.connection)
        self.parseMetadata=plugin.parseMetadata(self)

    ##Set new status for the object
    def setStatus(self,newStatus):
        qry="UPDATE queue set STATUS='%s' where ID='%s' and pid='%s';" % (newStatus, self.id, self.pid)
        self.db.exe(qry)
        self.status=newStatus
        pass

    ##Set new pid for the object
    def setPid(self,newValue):
        qry="UPDATE queue set pid='%s' where ID='%s';" % (newValue, self.id)
        self.db.exe(qry)
        self.pid=newValue
        pass

    def setDwnStatus(self,newStatus):
        qry="UPDATE queue set dwnstatus='%s' where ID='%s' and pid='%s';" % (newStatus, self.id, self.pid)
        self.db.exe(qry)
        self.dwnstatus=newStatus
        pass

    def setFileStatus(self,fileid, newStatus):
        qry="UPDATE files set dwnstatus='%s' where ID=%s;" % (newStatus, fileid)
        self.db.exe(qry)
        self.dwnstatus=newStatus
        pass

    ##Clean pid attribute, i.e. unlock
    def unlock(self):
        qry="UPDATE queue set pid=Null where ID='%s' and pid='%s';" % (str(self.id), self.pid)
        self.db.exe(qry)
        pass
    
    ## Search for the manifest and create file and xml handlers
    def openManifest(self):
        if self.targettype=='dhus':
            #open zipfile
            import zipfile
            archive = zipfile.ZipFile(rep+self.files[0]['filename'], 'r')
            for i in archive.namelist():
                if 'manifest' in i.lower():
                    filename =i
                    manifest = archive.read(i)
                    self.manifestPath=rep+filename
                    self.manifestParser=etree.fromstring(manifest)
                    break
            return
        if self.targettype=='oda':
            for i in self.files:
                if 'manifest' in i['filename'].lower():
                    print 'manifest: %s' % i['filename']
                    manifest=i['filename']
                    self.manifestPath=rep+manifest
                    self.manifestParser=etree.parse(self.manifestPath)
                    break
            return 
        if self.targetid=='lfs':
            for i in self.files:
                if 'manifest' in i['filename'].lower():
                    print 'manifest: %s' % i['filename']
                    manifest=i['filename']
                    self.manifestPath=self.note['folder']+'/'+manifest
                    self.manifestParser=etree.parse(self.manifestPath)
                    break
            return 

    ## Search for the manifest and create file and xml handlers
    def parseManifest(self):
        #if self.manifestParser:
        if hasattr(self,'manifestParser'):
            self.coordinatesKML=self.manifestParser.find('.//{http://www.opengis.net/gml}coordinates').text
            #Translate from KML in WKT
            #tmp=self.coordinatesKML.replace(',','/').replace(' ',',').replace('/',' ')
            #firstpoint=tmp.split(',')[0]
            #self.coordinatesWKT='POLYGON ((' + tmp +',' + firstpoint+ '))'
            self.coordinatesWKT=gml2wkt(self.coordinatesKML)
            for itag in ('startTime','stopTime'):
                val=self.manifestParser.find('.//{http://www.esa.int/safe/sentinel-1.0}'+itag).text
                self.product.addJson({itag:val})
            for itag in ('orbitNumber','relativeOrbitNumber'):
                val=self.manifestParser.find('.//{*}'+itag).text
                self.product.addJson({itag:val})
            #get product size
            self.size=0
            for istream in self.manifestParser.findall('.//{*}byteStream'):
                try:
                    size=int(istream.attrib['size'])
                except:
                    print "Not able to extract size information"
                    size=0
                self.size+=size
            pass
    
    def storeManifestMetadata(self):
        #kmlraw                =config.ini.get('kml','kmlraw').replace('\n','')
        #kml=gml2gml_swap(self.coordinatesKML)
        #kmlraw=kmlraw.replace('$COORD',kml)
        #kmlraw=kmlraw.replace('$NAME',self.id)
        #kmlraw=kmlraw.replace('$TSTART',self.product.json['startTime'])
        #kmlraw=kmlraw.replace('$TSTOP' ,self.product.json['stopTime'])
        #kmlbody=kmlraw
        #qry="UPDATE product set kml='%s', wkt='%s', footprint=GeomFromText('%s') where id ='%s';" % (kmlbody, self.coordinatesWKT, self.coordinatesWKT, self.id)
        qry="UPDATE product set size=%s, footprint=GeomFromText('%s') where id ='%s';" % (self.size, self.coordinatesWKT, self.id)
        self.db.exe(qry)
        pass

    ## Search for the manifest and create file and xml handlers
    def openDhusMetadata(self):
        assert self.targettype=='dhus'
        dhusMetadataRepository=config.ini.get('pluginDhus','dhusmetadatarepository').replace('$PRJ',prjFolder)
        for i in self.files:
            if 'xml' in i['filename'].lower():
                print 'metadata file: %s' % i['filename']
                metadata=i['filename']
                self.metadataPath=dhusMetadataRepository+metadata
                self.metadataParser=etree.parse(self.metadataPath)
                break
        return 

    ## Search for the manifest and create file and xml handlers
    def parseDhusMetadata(self):
        #if self.manifestParser:
        if hasattr(self,'metadataParser'):
            self.coordinatesKML=self.metadataParser.find('.//{*}coordinates').text
            #TODO: WARNING
            #DHUS footprint is wrong and coordinates are swapped
            #to take into account DHuS bug, the coordinates are swapped
            self.coordinatesWKT=gml2wkt(self.coordinatesKML)
            self.coordinatesWKT=gml2wkt_swap(self.coordinatesKML)
            for itag in ('Start','End'):
                val=self.metadataParser.find('.//{http://schemas.microsoft.com/ado/2007/08/dataservices}'+itag).text
                self.product.addJson({itag:val})
    
    def storeDhusMetadata(self):
        qry="UPDATE product set wkt='%s', footprint=GeomFromText('%s') where id ='%s';" % (self.coordinatesWKT, self.coordinatesWKT, self.id)
        self.db.exe(qry)
        pass
    
    def close(self):
        if self.closeStatus!='#':
            self.setStatus(self.closeStatus)
        else:
            print "Warning: closing product %s with closeout status not set" % self.id

    def addFile(self,filename,url,status=''):
        #Insert records into FILES table
        qry="INSERT INTO files (qid, targetid, filename, url) values ('%s', '%s', '%s', '%s');"
        iqry=qry % (self.id, self.targetid, filename, url)
        self.db.exe(iqry)
        x=dict()
        x['filename'] =filename
        x['url']      =url
        x['status']   =status
        self.files.append(x)
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

def serialWorkflow():
    #loop on queue items
    inloop=True
    pid=str(os.getpid())
    while(inloop):
        inloop=False
                
        #getMetalink
        q=queue()
        isSomethingProcessed=q.getAllMetalinks(pid)
        if isSomethingProcessed:
            inloop=True
            
        #getMetadata
        q=queue()
        isSomethingProcessed=q.getAllMetadata(pid)
        if isSomethingProcessed:
            inloop=True

        #parseMetadata
        q=queue()
        isSomethingProcessed=q.parseAllMetadata(pid)
        if isSomethingProcessed:
            inloop=True
            
        #catalogue
        q=queue()
        isSomethingProcessed=q.catalogueAll(pid)
        if isSomethingProcessed:
            inloop=True
            
            #y.getMetadata()
            #y.parseMetadata()
            #y.catalogue()
            #y.userAPI()
        #except:
        #    traceback.print_exc(file=sys.stdout)
        #pass
    pass

def parallelWorkflow():
    pid=str(os.getpid())
    import downloader
    maxParallelItem=50
    sleepTimeForWaitingChilds=1
    childs=list()
    previousMonitor=dict()
    previousMonitor['failed']=list()
    previousMonitor['ok']=list()
    q=libQueue.queue()
    while True:
        currMonitor=downloader.monitorChilds(childs)
        #wait for a free resource
        while(currMonitor['nRun']>=maxParallelItem):
            print 'MAIN: waiting for childs: ' + str(currMonitor['running'])
            time.sleep(sleepTimeForWaitingChilds)
            currMonitor=downloader.monitorChilds(childs)
        #print the result of the last released resource
        #compare succeded processes
        for status in ['ok','failed']:
            new=currMonitor[status]
            newset=set(new)
            diff=newset.difference(previousMonitor[status])
            for i in diff:
                print "MAIN: Completed " + status + " process " +str(i)
        previousMonitor=currMonitor
        x=q.getItem(lockpid=pid,fromStatus=(cnew, chasmetalink, chasmetadata, cmetadataparsed),toStatus=chasmetadata)
        if x=="#":
            break
        cmd=sys.argv[0] +" " + prjFolder + "/lib/libQueue.py --id %s" % x.id
        del x
        print cmd
        newProc=subprocess.Popen(['/bin/sh', '-c', cmd]);
        proc=dict()
        proc['proc']    =newProc
        proc['id']      =id
        childs.append(proc)
        
    #Wait that all downlaod/subprocessed are completed
    noErrorFound=True
    for proc in childs:
        exitCode=proc['proc'].wait()
        if exitCode==0:
            pass
        else:
            print "Workflow for product %s failed" % proc['id']
            noErrorFound=False
    print noErrorFound

def process(id):
    pid=str(os.getpid())
    x=queuedItem(id)
    
    counter=0
    while True:
        counter+=1
        if counter>5:
            raise "product %s is locked since a while; exiting" % id
        if x.pid is not None:
            print "product %s is locked; sleeping" % id
            time.sleep(10)
            #note: when recreating x, the delete of the previous instance remove the pid lock!
            x=queuedItem(id)
        break

    x.setPid(pid)
    
    if x.status in (cnew):
        try:
            x.getMetalink()
            x.setStatus(chasmetalink)
        except:
            traceback.print_exc(file=sys.stdout)
            x.setStatus('NOK')

    if x.status in (chasmetalink):
        try:
            x.getMetadata()
            x.setStatus(chasmetadata)
        except:
            traceback.print_exc(file=sys.stdout)
            x.setStatus('NOK')
    
    if x.status in (chasmetadata):
        try:
            x.parseMetadata()
            x.setStatus(cmetadataparsed)
        except:
            traceback.print_exc(file=sys.stdout)
            x.setStatus('NOK')

    if x.status in (cmetadataparsed):
        try:
            x.product.catalogue()
            x.setStatus(ccatalogued)
        except:
            traceback.print_exc(file=sys.stdout)
            x.setStatus('NOK')
    pass

def checkConnectionParameters(connection):
    if not isinstance(connection,dict):
        print "connection is %s and not a dictionary" % type(connection)
        return False
    check=True
    for parameter in ['id','type','host','protocol','port','username','password','rep']:
        if parameter not in connection.keys():
            print "parameter %s not found in connection.keys()" % parameter
            check=False
        if connection[parameter] in ('','None','Null','#'):
            print "parameter %s not initialized (found %s)" % connection[parameter]
            check=False
    return check

def gml2wkt(gml):
    tmp=gml.replace(',','/').replace(' ',',').replace('/',' ')
    firstpoint=tmp.split(',')[0]
    wkt='POLYGON ((' + tmp +',' + firstpoint+ '))'
    return wkt

def gml2wkt_swap(gml):
    wkt='POLYGON ((' 
    xylist=gml.split(' ')
    for p in xylist:
        x=p.split(',')[0]
        y=p.split(',')[1]
        wkt+=y+' '+x+','
    #add first point as last
    p=xylist[0]
    x=p.split(',')[0]
    y=p.split(',')[1]
    wkt+=y+' '+x+'))'
    return wkt

def gml2gml_swap(gml):
    wkt='' 
    xylist=gml.split(' ')
    for p in xylist:
        x=p.split(',')[0]
        y=p.split(',')[1]
        wkt+=y+','+x+' '
    #add first point as last
    #p=xylist[0]
    #x=p.split(',')[0]
    #y=p.split(',')[1]
    #wkt+=y+' '+x+'))'
    return wkt

if __name__ == "__main__":
    import argparse
    parser = argparse.ArgumentParser(description="Library for managing the queue")
    parser.add_argument("--id", dest="id", help="Process the full workflow about a specific product")
    parser.add_argument("--gos", dest="gos", action="store_true", help="Process the full workflow in a serial way")
    parser.add_argument("--gop", dest="gop", action="store_true", help="Process the full workflow in a parallel way")
    parser.add_argument("--go", dest="go", action="store_true", help="Process the full workflow in a parallel way; fix error and finish processing in a serial way")
    args=parser.parse_args()
    if args.id:
        process(args.id)
        sys.exit()
    if args.gos:
        serialWorkflow()
        sys.exit(0)
    if args.gop:
        parallelWorkflow()
        sys.exit(0)
    if args.go:
        parallelWorkflow()
        q=queue()
        q.cleanpid()
        q.cleanNOK()
        serialWorkflow()
        sys.exit(0)
    print "No valid argument found; try -h."