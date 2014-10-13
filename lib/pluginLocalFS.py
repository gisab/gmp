#!/usr/bin/python
#
###########################################################
#                                                         #
# Project: GMP                                            #
# Author:  gianluca.sabella@gmail.com                     #
#                                                         #
# Module:  pluginLocalFS.py                               #
# First version: 21/09/2014                               #
#                                                         #
###########################################################

## @package pluginLocalFS
# This module make a spacialization of the generic pluginClass for local file system repository

prjName='gmp'
APPID  ='pluginLocalFS'
#currDir=os.getcwd()
import os,sys
currDir=os.path.realpath(__file__)
prjFolder=currDir.split(prjName)[0]+prjName
sys.path.append(prjFolder+'/lib')
from lxml import etree
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
import re

#config
folder   = config.ini.get(APPID,'folder')
agent    = config.ini.get(APPID,'agent')

## gmpPluginDhus class
# It is a specialization of the generic pluginClass
class gmpPluginLFS(pluginClass.gmpPlugin):
    
    ## The constructor
    def __init__(self):
        self.type='lfs'
        self.plan=list()
        
    ## Ovverride of the generic downloadPlan function
    # @param self The object pointer
    # @return plan a list of product found on the local FS
    def getPlan(self,idir='#'):
        if idir=='#':
            idir=folder
            self.plan=list()
        for dirname, dirnames, filenames in os.walk(idir):
            for subdirname in dirnames:
                ifld=os.path.join(dirname, subdirname)
                #print "processing %s" % ifld
                if isProduct(subdirname,type='folder'):
                    print "Found Folder %s" % ifld
                    newItem=libQueue.newItem()
                    newItem.setID(subdirname)
                    newItem.setAgent(agent)
                    newItem.setTarget(self.type)
                    note={"folder":dirname}
                    newItem.setNote(json.dumps(note))
                    self.plan.append(newItem)
                else:
                    self.getPlan(ifld)
            for filename in filenames:
                ifile=os.path.join(dirname, filename)
                #print "processing file %s"  % ifile
                if isProduct(filename,type='file'):
                    print "Found File %s"  % ifile
                    self.plan.append(ifile)
        return
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
            newItem.setTarget(self.type)
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
        #Not applicable for local file system
        #Files are already available
        pass
    
    def getMetadata(self,queuedItem):
        #search for the manifest
        manifest=queuedItem.note['folder']+'/'+queuedItem.id + '/manifest.safe'
        if not os.path.isfile(manifest):
            raise Exception('lfs.getMetalink' "manifest not found (%s)" % manifest)
            pass
        #Add manifest file 
        queuedItem.addFile(queuedItem.id + '/manifest.safe','#')
        parser = etree.parse(manifest)
        for prod in parser.findall(".//{*}fileLocation"):
                #Product attributes
                fname=prod.attrib['href'].replace('./','/')
                queuedItem.addFile(queuedItem.id+fname,'#')
        pass
                
    def parseMetadata(self,queuedItem):
        #parse manifest in local rep that has been already downloaded by getMetadta function
        queuedItem.openManifest()
        queuedItem.parseManifest()
        queuedItem.storeManifestMetadata()

def testworkflow():
    getNewPlan=True
    if getNewPlan:
        x=gmpPluginLFS()
        x.getPlan()
        x.storePlan()
        del x
    
    #Process queue
    libQueue.workflow()


def isProduct(istring,type='#'):
    if type=='#':
        return False
    if type=='folder':
        x=re_apply(istring,rePrjFld,case_sensitive=False)
        if x[0]!='#':
            #product recognised
            return True
        else:
            return False
    if type=='file':
        x=re_apply(istring,rePrjFile,case_sensitive=False)
        if x[0]!='#':
            #product recognised
            return True
        else:
            return False
    return False

def re_apply(input_string,re_expr,case_sensitive=False):
    #Cleaning input string
    if case_sensitive==False:
        input_string=input_string.upper()
    #whitespaces
    #input_string=re.sub("\s","",input_string).upper()
    #ex: [1]
    input_string=re.sub("\[[0-9]\]","",input_string)
    retstr=("#",'-1')
    #i=0;
    for ex in re_expr:
        #i+=1
        m=re.search(ex['exp'],input_string)
        if m:
            #retstr=str(i)+"/"+m.group(0)
            retstr=(m.group(0),str(ex['idx']))
            break
    return retstr

rePrjFld=[
    {'idx':0,'exp':'S1[AB]_[A-Z0-9]{2}_[A-Z]{4}_[A-Z0-9]{4}_[0-9]{8}T[0-9]{6}_[0-9]{8}T[0-9]{6}_[0-9]{6}_[A-Z0-9]{6}_[A-Z0-9]{4}.SAFE'}
    ]
rePrjFile=[
    {'idx':0,'exp':'S1[AB]_[A-Z0-9]{2}_[A-Z]{4}_[A-Z0-9]{4}_[0-9]{8}T[0-9]{6}_[0-9]{8}T[0-9]{6}_[0-9]{6}_[A-Z0-9]{6}_[A-Z0-9]{4}.SAFE.zip'}
    ]
    
if __name__ == "__main__":
    #test()
    testworkflow()