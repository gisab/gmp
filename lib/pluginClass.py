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

prjName='gmp'
#currDir=os.getcwd()
import os,sys
thisFolder=os.path.dirname(__file__)
prjFolder=os.path.split(thisFolder)[0]
sys.path.append(prjFolder+'/lib')
import libQueue
import traceback

class gmpPlugin(object):
    def __init__(self):
        self.type='generic'
        self.plan=list()
        pass
    
    def getPlan(self):
        #Return a generic Plan as dictionary
        sample=dict()
        return sample
    
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
    if target=='ftpz':
        import pluginLocalFS
        x=pluginFTP.gmpPluginFTPZ(connection)
        return x
    raise Exception('getPlugin', 'Target %s for product %s is unknown' % (target, queuedItem.id) )
    return
    
    
    