#!/usr/bin/python
#
###########################################################
#                                                         #
# Project: GMP                                            #
# Author:  gianluca.sabella@gmail.com                     #
#                                                         #
# Module:  pluginClass.py                                 #
# First version: 26/08/2014                               #
#                                                         #
###########################################################
from S1libProd.libProduct import productList

prjName='gmp'
APPID  ='pluginFTP'

import os,sys
thisFolder=os.path.dirname(os.path.abspath(__file__))
prjFolder=os.path.split(thisFolder)[0]
sys.path.append(prjFolder+'/lib')
import libQueue
import traceback
import ftplib
import json
import config
import pluginClass

# EXAMPLE
# import ftplib 
# ftp = ftplib.FTP(host='xxxx', user='xxx',passwd='xxx')
# ftp.nlst()

resourcefile = config.getPath(APPID,'resourcefile')
agent        = config.ini.get(APPID,'agent')

class gmpPluginFTPZ(pluginClass.gmpPlugin):

    def __init__(self,connection):
        if not libQueue.checkConnectionParameters(connection):
            raise "connection object was not valid"
        self.id      =connection['id']
        self.type    =connection['type']
        assert self.type=='ftpz'
        self.username=connection['username']
        self.password=connection['password']
        self.protocol=connection['protocol']
        self.port    =connection['port']
        self.host    =connection['host']
        
        self.plan=list()
        self.conn = ftplib.FTP(host=self.host, user=self.username,passwd=self.password)
    
    def getPlan(self):
        #Return a generic Plan as dictionary
        #sample=dict()
        #return sample
        #take the last execution time to be used as reference for the new query
        try:
            self.res=json.load(open(resourcefile,'r'))
        except:
            #the file is not existing; init class with default parameters
            self.res=dict()

        productList=self.conn.nlst()
        productListfiltered=list()
        
        for item in productList:
            if 'zip' not in item.upper():
                continue
            productListfiltered.append(item)
            #Creating downloadable item
            newItem=libQueue.newItem()
            newItem.setID(item)
            newItem.setAgent(agent)
            newItem.setTarget(self.id)

            self.plan.append(newItem)
        
        
        #store the list of file already processed
        self.res['products']=list(set(self.res['products'] + productListfiltered))
        #save the last execution time
        json.dump(self.res,open(resourcefile,'w'))

    def storePlan(self):
        #store the plan into the DB
        print "Storing the plan into the DB"
        x=libQueue.queue()
        i=0
        for plannedItem in self.plan:
            i+=1
            try:
                x.addItem(plannedItem)
            except:
                print "Failed to import product %s" % plannedItem.ID
                traceback.print_exc(file=sys.stdout)
        return
    
    def getAllMetalinks(self):
        #empty funtion; do nothing
        return
    
    def getMetalink(self,queuedItem):
        #empty funtion; do nothing
        return
    
    
def getPlugin(target,connection):
    if target=='dhus':
        import pluginDhus
        x=pluginDhus.gmpPluginDhus(connection)
        return x
    if target=='oda':
        import pluginOda
        x=pluginOda.gmpPluginOda(connection)
        return x
    if target=='lfs':
        import pluginLocalFS
        x=pluginLocalFS.gmpPluginLFS(connection)
        return x
    raise Exception('getPlugin', 'Target %s for product %s is unknown' % (target, queuedItem.id) )
    return
    
def addSingleFTPProduct(any_argument):
    print "feature not yet supported"

def mainworkflow():
    #check DB connection
    q=libQueue.queue()
    del q

    targets=dbif.getTargetList("type='ftpz'")
    for itarget in targets:
        print "Processing %s" % itarget['id']
        x=gmpPluginFTPZ(itarget)
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
    parser = argparse.ArgumentParser(description="class library for interfacing an FTP repository")
    parser.add_argument("--run", dest="run", action="store_true", help="get the plan and start the workflow")
    parser.add_argument("--add-product", dest="productId", help="add a single product in the queue")
    args=parser.parse_args()
    if args.productId:
        #specific product request
        addSingleFTPProduct(args.productId, args.targetid)
        sys.exit()
    if args.run:
        #no specific request; get full available plan
        mainworkflow()
        sys.exit()
    print "No valid argument found; try -h."