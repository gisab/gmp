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
#currDir=os.getcwd()
import os,sys
currDir=os.path.realpath(__file__)
prjFolder=currDir.split(prjName)[0]+prjName
sys.path.append(prjFolder+'/lib')

import libQueue
import datetime
import pprint
import subprocess
import time

# config
maxFilesPerItem=2
waittime=1
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

logFile =open('downloader.log','a')
logFile.write('\n\n'+'*'.center(80,'*') + '\n\n\n\n')

def log(logtext):
    print datetime.datetime.now().isoformat()+' ' + logtext
    logFile.write(datetime.datetime.now().isoformat()+' ' + logtext + '\n')
    logFile.flush()
    
## download the first item in the queue
def main():
    #Get the first available item to be downloaded
    x=libQueue.queue()
    #resetDownloadQueue for debug purposes
    x.resetDownloadQueue()
    y=x.getItem(str(os.getpid()))
    if y=='#':
        #no record found
        return
    pprint.pprint(y.__dict__)
    
    #Invoce agents for files to be downloaded
    previousMonitor=dict()
    previousMonitor['failed']=list()
    previousMonitor['ok']=list()
    for ifile in y.files:
        newid=str(ifile['fileid'])
        currMonitor=monitorChilds(childs)
        #wait for a free resource
        while(currMonitor['nRun']>=maxFilesPerItem):
            log('MAIN: waiting for childs: ' + str(currMonitor['running']))
            time.sleep(waittime)
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

        log('MAIN: Spawning new process ' +newid)
        logf='wget.log'
        cmd=y.agentcli.replace('$LOG', logf).replace('$FILENAME', ifile['filename']).replace('$URL', ifile['url'])+ ' 2>> ' + logf + ' 1>> ' + logf
        print cmd
        newProc=subprocess.Popen(['/bin/sh', '-c', cmd]);
        childs.append(newProc)
        #time.sleep(1)
    os.wait()
    result=monitorChilds(childs)
    pprint.pprint(result)
    
if __name__ == "__main__":
    #Processing arguments from command line
    import argparse
    parser = argparse.ArgumentParser(description="Download the first item in the queue")
    parser.add_argument("--test", action="store_true", dest="test",   help="self test")
    args=parser.parse_args()
    main()
