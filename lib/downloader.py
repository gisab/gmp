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
APPID  ='downloader'

import os,sys
currDir=os.path.realpath(__file__)
prjFolder=currDir.split(prjName)[0]+prjName
sys.path.append(prjFolder+'/lib')

import libQueue
import config
import datetime
import pprint
import subprocess
import time

# config
maxDwnFilesPerItem  =int(config.ini.get(APPID,'maxDwnFilesPerItem'))
repFolder           =config.ini.get(APPID,'repository').replace('$PRJ',prjFolder)
maxBandwidth        =config.ini.get(APPID,'maxBandwidth')
sleepTimeBetweenFileDownload =int(config.ini.get(APPID,'sleepTimeBetweenFileDownload'))
performDownload     =True
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
logcmd =open('download-commands.log','a')

def log(logtext):
    #print datetime.datetime.now().isoformat()+' ' + logtext
    logFile.write(datetime.datetime.now().isoformat()+' ' + logtext + '\n')
    logFile.flush()

def getCredential(targetid):
    dwnappid='plugin'+targetid[0].upper()+targetid[1:].lower()
    username = config.ini.get(dwnappid,'username')
    password = config.ini.get(dwnappid,'password')
    return (username,password)

## download the first item in the queue
def main():
    #Get the first available item to be downloaded
    x=libQueue.queue()
    #resetDownloadQueue for debug purposes
    #x.resetDownloadQueue()
    y=x.getItem(str(os.getpid()))
    if y=='#':
        #no record found
        return
    #pprint.pprint(y.__dict__)
    print "Downloading %s" % y.id
    
    #Get credential
    (username,password)=getCredential(y.targetid)
    
    #Invoke agents for files to be downloaded
    previousMonitor=dict()
    previousMonitor['failed']=list()
    previousMonitor['ok']=list()
    for ifile in y.files:
        newid=str(ifile['fileid'])
        currMonitor=monitorChilds(childs)
        #wait for a free resource
        while(currMonitor['nRun']>=maxDwnFilesPerItem):
            log('MAIN: waiting for childs: ' + str(currMonitor['running']))
            time.sleep(sleepTimeBetweenFileDownload)
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
        targetFilename=repFolder+ifile['filename']
        targetFolder=os.path.split(targetFilename)[0]
        if not os.path.exists(targetFolder):
            os.makedirs(targetFolder)
            logcmd.write('mkdir -p %s \n' % targetFolder)
        cmd=y.agentcli.replace('$LOG', logf).replace('$FILENAME', targetFilename).replace('$URL', ifile['url'])+ ' 2>> ' + logf + ' 1>> ' + logf
        cmd=cmd.replace('$USER',username)
        cmd=cmd.replace('$PASS',password)
        cmd=cmd.replace('$MAXBANDWIDTH',maxBandwidth)
        #temporary network patch
        if False:
            cmd=cmd.replace('s1-pac1dmz-oda-v-20.sentinel1.eo.esa.int:80','localhost:14002')
            print cmd
        log(cmd)
        logcmd.write(cmd+'\n')
        if performDownload:
            newProc=subprocess.Popen(['/bin/sh', '-c', cmd]);
            childs.append(newProc)
        #time.sleep(1)
    exit_codes = [p.wait() for p in childs]
    print exit_codes

    #result=monitorChilds(childs)
    #pprint.pprint(result)
    
if __name__ == "__main__":
    #Processing arguments from command line
    import argparse
    parser = argparse.ArgumentParser(description="Download the first item in the queue")
    parser.add_argument("--test", action="store_true", dest="test",   help="self test")
    parser.add_argument("--nodownload", action="store_true", dest="nodownload",   help="self test")
    args=parser.parse_args()
    if args.nodownload:
        performDownload=False
    main()
