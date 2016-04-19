#!/usr/bin/python
#
###########################################################
#                                                         #
# Project: GMP                                            #
# Author:  gianluca.sabella@gmail.com                     #
#                                                         #
# Module:  pluginODA.py                                   #
# First version: 26/08/2014                               #
#                                                         #
###########################################################

## @package pluginODA
# This module make a specialization of the generic pluginClass for the ODA

prjName='gmp'
APPID  ='pluginOda'
#currDir=os.getcwd()
import os,sys
thisFolder=os.path.dirname(__file__)
prjFolder=os.path.split(thisFolder)[0]
sys.path.append(prjFolder+'/lib')

from lxml import etree
import dbif
import pluginClass
import libQueue
import httplib
import config
import httplib
import base64
import string
import datetime
import pprint
import json
import subprocess
import traceback

#config
#host     = config.ini.get(APPID,'host')
#port     = config.ini.get(APPID,'port')
urlplan  = config.ini.get(APPID,'urlplan')
urlmeta  = config.ini.get(APPID,'urlmeta')
#username = config.ini.get(APPID,'username')
#password = config.ini.get(APPID,'password')
agent    = config.ini.get(APPID,'agent')
debug    = True

## gmpPluginDhus class
# It is a specialization of the generic pluginClass
class gmpPluginOda(pluginClass.gmpPlugin):
    
    ## The constructor
    def __init__(self,connection):
        if not libQueue.checkConnectionParameters(connection):
            raise "connection object was not valid"
        self.id      =connection['id']
        self.type    =connection['type']
        assert self.type=='oda'
        self.username=connection['username']
        self.password=connection['password']
        self.protocol=connection['protocol']
        self.port    =connection['port']
        self.host    =connection['host']

        auth = base64.encodestring('%s:%s' % (self.username, self.password)).replace('\n', '')
        self.headers = { 'Authorization' : 'Basic %s' %  auth }
        self.conn = httplib.HTTPConnection(self.host,self.port)
        self.plan=list()
    
    ## Ovverride of the generic downloadPlan function
    # @param self The object pointer
    # @return plan a list of dictionary for each item to be downloaded
    def getPlan(self):
        getRealPlan=True
        if getRealPlan:
            self.conn.request('GET', urlplan, headers=self.headers)
            res = self.conn.getresponse()
            if res.status!=200:
                print "Failed connection (%s)" % res.reason
                return
            dataraw=res.read()
        else:
            dataraw=getSampleDataRaw() #.replace('\n','')
        data=json.loads(dataraw)
        self.plan=list()
        for prod in data['products']:
            #Product attributes
            productId=prod['productid']
            print "getPlan: Found product %s" % productId
            #remove unused properties
            prod.pop('productid')
            prod.pop('product_name')
            prod.pop('starttime')
            prod.pop('stoptime')
            prod.pop('userid')
            note=json.dumps(prod)
            
            #Creating downloadable item
            newItem=libQueue.newItem()
            newItem.setID(productId)
            newItem.setAgent(agent)
            newItem.setTarget(self.id)
            newItem.setNote(note)
            
            self.plan.append(newItem)
        return

    def getAllMetalinks(self):
        x=libQueue.queue()
        while(True):
            y=x.getItemForMetalinkDownload(str(os.getpid()))
            if y=='#':
                #no record found
                break
            try:
                self.getMetalink(y)
            except:
                pass

    def getMetalink(self,queuedItem):
        url=urlmeta.replace('$PRODUCTID',queuedItem.id)
        self.conn.request('GET', url, headers=self.headers)
        res = self.conn.getresponse()
        print 'ODA returned code: %s' % res.status
        if res.status==202:
            #queuedItem.setStatus('ROLLED')
            raise Exception('getMetalink', 'Product %s rolled out (HTTP code 202) ' % queuedItem.id )
            pass
        if res.status not in (200, 202):
            #queuedItem.setStatus('ERROR')
            print "Generic error on product %s (HTTP code %s)" % (queuedItem.id,res.status)
            pprint.pprint(res.__dict__)
            raise Exception('getMetalink', 'Product %s error (HTTP code %s) ' % (queuedItem.id,res.status) )
            pass
        if res.status==200:
            #get and process metalink
            metalink=res.read()
            parser = etree.fromstring(metalink)
            for prod in parser.findall(".//{http://www.metalinker.org/}file"):
                #Product attributes
                fname=prod.attrib['name']
                tmp=prod.find('.//{http://www.metalinker.org/}url')
                furl=tmp.text.replace('\n','')
                queuedItem.addFile(fname,furl)
        pass
    
    def getMetadata(self,queuedItem):
        #search for manifest
        for ifile in queuedItem.files:
            if 'manifest' in ifile['filename'].lower():
                repFolder=config.ini.get('downloader','repository').replace('$PRJ',prjFolder)
                maxBandwidth=config.ini.get('downloader','maxBandwidth')
                targetFilename=repFolder+ifile['filename']
                targetFolder=os.path.split(targetFilename)[0]
                if not os.path.exists(targetFolder):
                    os.makedirs(targetFolder)
                cmd=queuedItem.agentcli.replace('$LOG', '/dev/nul').replace('$FILENAME', targetFilename).replace('$URL', ifile['url'])
                cmd=cmd.replace('$USER',self.username)
                cmd=cmd.replace('$PASS',self.password)
                cmd=cmd.replace('$MAXBANDWIDTH',maxBandwidth)
                #temporary network patch
                if False:
                    cmd=cmd.replace('s1-pac1dmz-oda-v-20.sentinel1.eo.esa.int:80','localhost:14002')
                print cmd
                z=subprocess.Popen(['/bin/sh', '-c', cmd]);
                z.wait()
                
    def parseMetadata(self,queuedItem):
        #parse manifest in local rep that has been already downloaded by getMetadta function
        queuedItem.openManifest() 
        queuedItem.parseManifest()
        queuedItem.storeManifestMetadata()

    def createItem(self,productId):
        #Creating libQueue object
        newItem=libQueue.newItem()
        newItem.setID(productId)
        newItem.setAgent(agent)
        newItem.setTarget(self.id)
        
        #Getting metalink if product exist (code 200)
        url=urlmeta.replace('$PRODUCTID',productId)
        self.conn.request('GET', url, headers=self.headers)
        res = self.conn.getresponse()
        #if res.status not in (200,202):
        #    print "Failed connection (%s)" % res.reason
        #    return
        #print productId, res.status
        if res.status==202:
            newItem.forceStatus('ROLLED')
        if res.status not in (200, 202):
            newItem.forceStatus('ERROR')
        if res.status==200:
            #get and process metalink
            metalink=res.read()
            parser = etree.fromstring(metalink)
            for prod in parser.findall(".//{http://www.metalinker.org/}file"):
                #Product attributes
                fname=prod.attrib['name']
                tmp=prod.find('.//{http://www.metalinker.org/}url')
                furl=tmp.text.replace('\n','')
                newItem.addFile(fname,furl)
        return newItem

def getSampleDataRaw():
    dataraw="""'{'created': '2014-08-28 08:06:36 UTC',
 'load': [0, 0, 0],
 'name': '2_STExternalUser_212.99.29.167_2014-07-29_11:14:40',
 'num': 1087,
 'products': [{'datasetid': 'Global_GRDH_SM',
                'id_product': '27838',
                'ingestion_time': '2014-08-21 08:01:47',
                'path_id': '170340',
                'product_name': 'S1A_S2_GRDH_1SSH_20140821T021018_20140821T021043_002032_001F90_ADF2.SAFE',
                'productid': 'S1A_S2_GRDH_1SSH_20140821T021018_20140821T021043_002032_001F90_ADF2.SAFE',
                'starttime': '2010-01-01 00:00:00',
                'stoptime': '2015-03-01 00:00:00',
                'userid': 'STExternalUser'},
               {'datasetid': 'Global_GRDH_SM',
                'id_product': '27839',
                'ingestion_time': '2014-08-21 08:16:02',
                'path_id': '170349',
                'product_name': 'S1A_S2_GRDH_1SSH_20140821T021108_20140821T021133_002032_001F90_0D52.SAFE',
                'productid': 'S1A_S2_GRDH_1SSH_20140821T021108_20140821T021133_002032_001F90_0D52.SAFE',
                'starttime': '2010-01-01 00:00:00',
                'stoptime': '2015-03-01 00:00:00',
                'userid': 'STExternalUser'},
               {'datasetid': 'Global_GRDH_SM',
                'id_product': '27840',
                'ingestion_time': '2014-08-21 08:16:24',
                'path_id': '170360',
                'product_name': 'S1A_S2_GRDH_1SSH_20140821T020838_20140821T020903_002032_001F90_D030.SAFE',
                'productid': 'S1A_S2_GRDH_1SSH_20140821T020838_20140821T020903_002032_001F90_D030.SAFE',
                'starttime': '2010-01-01 00:00:00',
                'stoptime': '2015-03-01 00:00:00',
                'userid': 'STExternalUser'}],
 'start': '2014-08-21 08:01:47',
 'stop': '2014-08-28 07:23:51'}'
"""
    #dataraw=open('../examples/prod-oda.ukpac.ST-saved_query.txt').read()
    dataraw=open('../examples/prod-oda.ukpac.ST-saved_query2.txt').read()
    return dataraw


def addSingleODAProduct(productID, targetid):
    targets=dbif.getTargetList("id='%s'" % targetid)
    x=libQueue.queue()
    for itarget in targets:
        print "Processing %s" % itarget['id']
        oda=gmpPluginOda(itarget)
        if 'SAFE' not in productID:
            productID+='.SAFE' 
        try:
            newProduct=oda.createItem(productID)
            x.addItem(newProduct)
            return
        except:
            print "Failed to get metalink from ODA for product %s" % productID
            traceback.print_exc(file=sys.stdout)
            return
    print "ERROR: No target %s found" %targetid
    return

def mainworkflow():
    #check DB connection
    q=libQueue.queue()
    del q

    targets=dbif.getTargetList("type='oda'")
    for itarget in targets:
        print "Processing %s" % itarget['id']
        x=gmpPluginOda(itarget)
        try:
            x.getPlan()
        except:
            print "ERROR: Failed to get plan from target %s" % itarget
            traceback.print_exc(file=sys.stdout)
        try:
            x.storePlan()
        except:
            print "ERROR: Failed to store plan from target %s" % itarget
            traceback.print_exc(file=sys.stdout)
        del x
        
    #Process queue
    #libQueue.serialWorkflow()
    
if __name__ == "__main__":
    #Processing arguments from command line
    import argparse
    parser = argparse.ArgumentParser(description="class library for interfacing the ODA")
    parser.add_argument("--run", dest="run", action="store_true", help="get the plan and start the workflow")
    parser.add_argument("--from-file", dest="fromfile", help="add products parsing a file")
    parser.add_argument("--add-product", dest="productId", help="add a single product in the queue")
    parser.add_argument("--target", dest="targetid", help="specify target for --add-product file")
    args=parser.parse_args()
    if args.productId:
        #specific product request
        addSingleODAProduct(args.productId, args.targetid)
        sys.exit()
    if args.fromfile:
        #get list from file
        prods=open(args.fromfile).readlines()
        for prod in prods:
            prodid=prod.replace('\n','')
            if 'SAFE' not in prodid:
                prodid+='.SAFE'
            addSingleODAProduct(prodid)
        sys.exit()
    if args.run:
        #no specific request; get full available plan
        mainworkflow()
        sys.exit()
    print "No valid argument found; try -h."
