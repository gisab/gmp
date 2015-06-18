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
thisFolder=os.path.abspath(__file__)
prjFolder=os.path.split(thisFolder)[0]+os.path.sep+'..'
sys.path.append(prjFolder+'/lib')

import libQueue
import config
import datetime
import pprint
import subprocess
import time
import dbif

# config
maxDwnFilesPerItem  =int(config.ini.get(APPID,'maxDwnFilesPerItem'))
#repFolder           =config.ini.get(APPID,'repository').replace('$PRJ',prjFolder)
maxBandwidth        =config.ini.get(APPID,'maxBandwidth')
sleepTimeBetweenFileDownload =int(config.ini.get(APPID,'sleepTimeBetweenFileDownload'))
performDownload     =True
childs=list()

def monitorChilds(processList):
    pids=dict()
    pids['running']=list()
    pids['failed']=list()
    pids['ok']=list()

    for p in processList:
        proc=p['proc']
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
#logcmd =open('download-commands.log','a')

def log(logtext):
    #print datetime.datetime.now().isoformat()+' ' + logtext
    logFile.write(datetime.datetime.now().isoformat()+' ' + logtext + '\n')
    logFile.flush()

def getCredential(targetid):
    connection=dbif.getTargetList("id='%s'" %targetid)
    #dwnappid='plugin'+targetid[0].upper()+targetid[1:].lower()
    #username = config.ini.get(dwnappid,'username')
    #password = config.ini.get(dwnappid,'password')
    return connection

## download the first item in the queue
def main():
    #Get the first available item to be downloaded
    x=libQueue.queue()
    #resetDownloadQueue for debug purposes
    #x.resetDownloadQueue()
    y=x.getItemForDownload(str(os.getpid()))
    if y=='#':
        #no record found
        return
    #pprint.pprint(y.__dict__)
    log("Downloading %s" % y.id)
    
    #Redirecting the log
    #logFileName=prjFolder+'/log/downloads/'+ y.id + '.log'
    #logFile=open(logFileName,'w')
    
    #Get credential
    connection=getCredential(y.targetid)[0]
    #import pprint
    #pprint.pprint(connection)
    
    #Invoke agents for files to be downloaded
    previousMonitor=dict()
    previousMonitor['failed']=list()
    previousMonitor['ok']=list()
    for ifile in y.files:
        if ifile['dwnstatus']!=libQueue.cDwnStatusQueued:
            continue
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

        if ifile['url']==None or ifile['url']=='':
            continue
        log('MAIN: Spawning new process ' +newid)
        logf='wget.log'
        targetFilename=connection['rep']+os.path.sep+ifile['filename']
        targetFolder=os.path.split(targetFilename)[0]
        if not os.path.exists(targetFolder):
            os.makedirs(targetFolder)
            #logcmd.write('mkdir -p %s \n' % targetFolder)
        cmd=y.agentcli.replace('$LOG', logf).replace('$FILENAME', targetFilename).replace('$URL', ifile['url'])+ ' 2>> ' + logf + ' 1>> ' + logf
        cmd=cmd.replace('$USER',connection['username'])
        cmd=cmd.replace('$PASS',connection['password'])
        cmd=cmd.replace('$MAXBANDWIDTH',maxBandwidth)
        cmd=cmd.replace('$','%24')
        #temporary network patch
        if False:
            cmd=cmd.replace('s1-pac1dmz-oda-v-20.sentinel1.eo.esa.int:80','localhost:14002')
            print cmd
        log(cmd)
        #logcmd.write(cmd+'\n')
        if performDownload:
            newProc=subprocess.Popen(['/bin/sh', '-c', cmd]);
            proc=dict()
            proc['proc']    =newProc
            proc['fileid']  =newid
            proc['filename']=ifile['filename']
            childs.append(proc)
        #time.sleep(1)

    #Wait that all downlaod/subprocessed are completed
    noErrorFound=True
    for proc in childs:
        exitCode=proc['proc'].wait()
        if exitCode==0:
            y.setFileStatus(proc['fileid'], libQueue.cDwnStatusCompleted)
        else:
            print ' failed download of %s: %s' % (proc['fileid'], proc['filename'])
            noErrorFound=False
    
    if noErrorFound:
        #Download completed succesfully
        y.setDwnStatus(libQueue.cDwnStatusCompleted)
    
    y.unlock()
    return

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
