#!/usr/bin/python
#
###########################################################
#                                                         #
# Project: GMP                                            #
# Author:  gianluca.sabella@gmail.com                     #
#                                                         #
# Module:  pluginDhus.py                                  #
# First version: 26/08/2014                               #
#                                                         #
###########################################################

## @package pluginDhus
# This module make a spacialization of the generic pluginClass for the DHUS

prjName='gmp'
APPID  ='pluginDhus'
#currDir=os.getcwd()
import os,sys
currDir=os.path.realpath(__file__)
prjFolder=currDir.split(prjName)[0]+prjName
sys.path.append(prjFolder+'/lib')
from lxml import etree
import pluginClass
import libQueue
import httplib, urllib
import config
import base64
import string
import datetime
import pprint
import json
import traceback

import platform
if platform.system()=='Windows':
    isWin=True
else:
    isWin=False
print "Is windows %s" % isWin

#config
host     = config.ini.get(APPID,'host')
protocol = config.ini.get(APPID,'protocol')
port     = config.ini.get(APPID,'port')
url      = config.ini.get(APPID,'url')
urlmeta  = config.ini.get(APPID,'urlmeta')
username = config.ini.get(APPID,'username')
password = config.ini.get(APPID,'password')
agent    = config.ini.get(APPID,'agent')
metadatafile=config.ini.get(APPID,'metadatafile')
resourcefile=config.ini.get(APPID,'resourcefile').replace('$PRJ',prjFolder)
dhusMetadataRepository=config.ini.get(APPID,'dhusmetadatarepository').replace('$PRJ',prjFolder)
debug    = True

if isWin:
    dhusMetadataRepository=dhusMetadataRepository.replace('/','\\')
    resourcefile=resourcefile.replace('/','\\')

## gmpPluginDhus class
# It is a specialization of the generic pluginClass
class gmpPluginDhus(pluginClass.gmpPlugin):
    
    ## The constructor
    def __init__(self):
        self.type='dhus'
        self.plan=list()
        auth = base64.encodestring('%s:%s' % (username, password)).replace('\n', '')
        self.headers = { 'Authorization' : 'Basic %s' %  auth }
        if protocol=='http':
            self.conn = httplib.HTTPConnection(host,port)
        if protocol=='https':
            self.conn = httplib.HTTPSConnection(host,port)
        
    ## Ovverride of the generic downloadPlan function
    # @param self The object pointer
    # @return plan a list of dictionary for each item to be downloaded
    def getPlan(self):
        #take the last execution time to be used as reference for the new query
        try:
            self.res=json.load(open(resourcefile,'r'))
        except:
            #the file is not existing; init class with default parameters
            self.res=dict()
            self.res['last_execution_time']=datetime.datetime(2014, 10, 1, 00, 00, 00, 000001).isoformat()

        d=datetime.datetime.strptime(self.res['last_execution_time'],'%Y-%m-%dT%H:%M:%S.%f')
        delta = datetime.timedelta(days=1)
        self.plan=list()

        while d <= datetime.datetime.now():
            print "Searching products ingested on day %s " % d.strftime("%Y-%m-%d")

            turl=url.replace('$YEAR',str(d.year)).replace('$MONTH', str(d.month)).replace('$DAY',str(d.day))
            prevskip=skip=0

            skip=0
            while(True):
                queryurl=turl.replace('$SKIP',str(skip))
                #print queryurl
                nProdPrevious=len(self.plan)
                self.getPlan_byurl(queryurl)
                nProdCurrent=len(self.plan)
                prevskip=skip
                skip+=nProdCurrent-nProdPrevious
                print "   found %s products (total %s)" % (str(skip),len(self.plan))
                #print "nProdCurrent %s; nProdPrevious %s; skip %s" % (nProdCurrent, nProdPrevious, skip)
                if prevskip==skip:
                    #no new record found; exiting from loop
                    #print "no new record found on this day"
                    break
            d += delta
        
        #set the execution time to be saved at the end of the loop in case the routine go till the end
        self.res['last_execution_time']=datetime.datetime.now().isoformat()
        #save the last execution time
        json.dump(self.res,open(resourcefile,'w'))
    
    def getPlan_byurl(self,queryurl):
        queryurl=urllib.quote(queryurl,'/&?()$=')
        #print queryurl
        self.conn.request('GET', queryurl, headers=self.headers)
        res = self.conn.getresponse()
        if res.status!=200:
            print "Failed connection (%s)" % res.reason
            try:
                data=res.read()
                import pprint
                pprint.pprint(res.__dict__)
                pprint.pprint(data.__dict__)
            except:
                pass
            return
        data=res.read()
        data=data.replace('&lt;','<')
        data=data.replace('<?xml version="1.0" encoding="UTF-8" standalone="no"?>','\n')
        open("dhus.xml", "w").write(data)
        parser = etree.fromstring(data)
        for prod in parser.findall(".//{*}entry"):
            note=dict()
            #id
            tmp=prod.find('.//{*}Id')
            note['id']=tmp.text
            #Product attributes
            tmp=prod.find('.//{*}file')
            fname=tmp.attrib['name']
            tmp=prod.find('.//{*}url')
            furl=tmp.text.replace('\n','').replace("'","\'")
            #tmp=prod.find('.//{*}coordinates')
            #pcoord=tmp.text
            #Creating libQueue object
            newItem=libQueue.newItem()
            newItem.setID(fname[:-4]+'.SAFE')
            newItem.addFile(fname,furl)
            newItem.setAgent(agent)
            newItem.setTarget(self.type)
            #note={'xml':etree.tostring(prod)}
            newItem.setNote(json.dumps(note))
            self.plan.append(newItem)
        return

    def getMetalink(self,queuedItem):
        #Not applicable for DHuS plugin as the getPlan already provide the url to be downloaded
        pass
    
    def getMetadata(self,queuedItem):
        if not os.path.exists(dhusMetadataRepository):
            try:
                os.makedirs(dhusMetadataRepository)
            except:
                print "ERROR: dhusMetadataRepository is not existing and cannot be created"
                print "       check config.ini setting"
                print "       directory: %s " % dhusMetadataRepository
                pass
        #query dhus for getting metadata
        produrl=urlmeta.replace('$ID',queuedItem.note['id'])
        self.conn.request('GET', produrl, headers=self.headers)
        res = self.conn.getresponse()
        if res.status!=200:
            print "Failed connection (%s)" % res.reason
            try:
                data=res.read()
                import pprint
                pprint.pprint(data.__dict__)
            except:
                pass
            return
        data=res.read()
        data=data.replace('&lt;','<')
        data=data.replace('<?xml version="1.0" encoding="UTF-8" standalone="no"?>','\n')
        targetFilename=dhusMetadataRepository+queuedItem.id+metadatafile
        #try to parse data and reformat it
        try:
            #prettydata=etree.dump(etree.fromstring(data),pretty_print=True)
            xmldata=etree.fromstring(data)
            open(targetFilename, "w").write(etree.tostring(xmldata))
            queuedItem.addFile(filename=queuedItem.id+metadatafile, url='',status=libQueue.cDwnStatusCompleted)
        except:
            open(targetFilename, "w").write(data)
            print "Failed to parse dhus metadata"
            traceback.print_exc(file=sys.stdout)
        return
    
    def parseMetadata(self,queuedItem):
        #parse manifest in local rep that has been already downloaded by getMetadta function
        queuedItem.openDhusMetadata()
        queuedItem.parseDhusMetadata()
        queuedItem.storeDhusMetadata()

def testworkflow():
    #check DB connection
    q=libQueue.queue()
    del q
    
    getNewPlan=True
    if getNewPlan:
        #q=libQueue.queue(init='new')
        x=gmpPluginDhus()
        x.getPlan()
        x.storePlan()
        del x
        
    #Process queue
    libQueue.workflow()
    
if __name__ == "__main__":
    #test()
    testworkflow()
