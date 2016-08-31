#!/usr/bin/python
#
###########################################################
#                                                         #
# Project: GMP                                            #
# Author:  gianluca.sabella@gmail.com                     #
#                                                         #
# Module:  downloader.py                                  #
# First version: 13/08/2014                               #
#                                                         #
###########################################################

prjName='gmp'
APPID  ='downloadManager'

import os,sys
thisFolder=os.path.abspath(__file__)
prjFolder=os.path.split(thisFolder)[0]+os.path.sep+'..'
sys.path.append(prjFolder+'/lib')

import libQueue
import config
import datetime
import pprint
import subprocess
import time

# config
pythonex       =config.ini.get('general','pythonex')
cli            =config.ini.get(APPID,'cli').replace('$PRJ',prjFolder).replace('$PYTHONEX',pythonex)
maxDownloader  =int(config.ini.get(APPID,'maxDownloader'))
sleepTimeBetweenDownloader =int(config.ini.get(APPID,'sleepTimeBetweenDownloader').replace('$PRJ',prjFolder))

childs=list()

def monitorChilds(processList):
    pids=dict()
    pids['running']=list()
    pids['failed']=list()
    pids['ok']=list()

    for proc in processList:
        #print "proc" , proc.pid , "status " , proc.poll()
        if proc.poll()==None:
            pids['running'].append(proc.pid)
            continue
        if proc.poll()==0:
            pids['ok'].append(proc.pid)
            continue        
        if proc.poll()!=0:
            pids['failed'].append(proc.pid)
    pids['nRun']=len(pids['running'])
    #print pids
    return pids

logFileName=prjFolder+'/log/'+ APPID + '.log'
#print logFileName
if not os.path.isfile(logFileName):
    open(logFileName,'w')
logFile =open(logFileName,'a')

def log(logtext):
    #print datetime.datetime.now().isoformat()+' ' + logtext
    logFile.write(datetime.datetime.now().isoformat()+' ' + logtext + '\n')
    logFile.flush()

log(' STARTING '.center(80,'*') + '\n')

## download the first item in the queue
def main():
    #Invoke agents for files to be downloaded
    previousMonitor=dict()
    previousMonitor['failed']=list()
    previousMonitor['ok']=list()
    while(True):
        currMonitor=monitorChilds(childs)
        #wait for a free resource
        while(currMonitor['nRun']>=maxDownloader):
            log('MAIN: waiting for childs: ' + str(currMonitor['running']))
            time.sleep(sleepTimeBetweenDownloader)
            currMonitor=monitorChilds(childs)
        #print the result of the last released resource
        #compare succeded processes
        for status in ['ok','failed']:
            new=currMonitor[status]
            newset=set(new)
            diff=newset.difference(previousMonitor[status])
            for i in diff:
                log("MAIN: Completed " + status + " process " +str(i))
        previousMonitor=currMonitor     
        log('MAIN: Spawning new process ')
        newProc=subprocess.Popen(['/bin/sh', '-c', cli + ' ']);
        childs.append(newProc)
        time.sleep(sleepTimeBetweenDownloader)

    subprocess.os.wait()
    result=monitorChilds(childs)
    pprint.pprint(result)
    
if __name__ == "__main__":
    #Processing arguments from command line
    import argparse
    parser = argparse.ArgumentParser(description="Download Manager")
    parser.add_argument("--test", action="store_true", dest="test",   help="self test")
    args=parser.parse_args()
    main()
