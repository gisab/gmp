#!/usr/bin/python
#
###########################################################
#                                                         #
# Project: GMP                                            #
# Author:  gianluca.sabella@gmail.com                     #
#                                                         #
# Module:  finaliser.py                                   #
# First version: 31/08/2014                               #
#                                                         #
###########################################################

prjName='gmp'
APPID  ='finaliser'

import os,sys
currDir=os.path.realpath(__file__)
prjFolder=currDir.split(prjName)[0]+prjName
sys.path.append(prjFolder+'/lib')

from lxml import etree
import libQueue
import config
import datetime
import pprint
import subprocess
import time
import traceback

# config
repFolder           =config.ini.get('downloader','repository').replace('$PRJ',prjFolder)
cli                 =config.ini.get(APPID,'cli')

logFile =open('finaliser.log','a')

def log(logtext):
    #print datetime.datetime.now().isoformat()+' ' + logtext
    logFile.write(datetime.datetime.now().isoformat()+' ' + logtext + '\n')
    logFile.flush()

## finalise the first item in the queue
def main():
    #Get the first available item to be downloaded
    x=libQueue.queue()
    #resetDownloadQueue for debug purposes
    #x.resetDownloadQueue()
    y=x.getItemDownloaded(str(os.getpid()))
    if y=='#':
        #no record found
        return
    #pprint.pprint(y.__dict__)
    print "Fianlising %s" % y.id
    
    try:
        import sampleUserAPI
        sampleUserAPI.main(y)
    except:
        traceback.print_exc(file=sys.stdout)

    #y.setStatus(libQueue.cdone)
    #debug
    tmp=libQueue.cdwncompleted
    y.setStatus(tmp)
    
if __name__ == "__main__":
    #Processing arguments from command line
    import argparse
    parser = argparse.ArgumentParser(description="Fi the first item in the queue")
    parser.add_argument("--test", action="store_true", dest="test",   help="self test")
    args=parser.parse_args()
    main()
