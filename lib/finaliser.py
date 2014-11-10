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

APPID  ='finaliser'

import os,sys
thisFolder=os.path.dirname(__file__)
prjFolder=os.path.split(thisFolder)[0]
sys.path.append(prjFolder+'/lib')

from lxml import etree
import libQueue
import dbif
import config
import pprint
import json
import datetime
import traceback

#config
mapcliraw   =config.ini.get(APPID,'mapcli')
mapcli      =json.loads(mapcliraw)

logFile =open(prjFolder+'/log/'+ APPID + '.log','a')

def log(logtext):
    #print datetime.datetime.now().isoformat()+' ' + logtext
    logFile.write(datetime.datetime.now().isoformat()+' ' + logtext + '\n')
    logFile.flush()

def mapcliParameters(obj,cli):
    for ikey in mapcli.keys():
        if ikey in cli:
            cli=cli.replace(ikey,obj.__getattribute__(mapcli[ikey]))
    if '$ALLMETADATA' in cli:
        cli=cli.replace('$ALLMETADATA',pprint.pformat(obj.__dict__))
    cli=cli.replace('$PRJ',prjFolder)
    return cli

## Finalise the items in the queue
def main():
    log(APPID +' process starting')

    #Init the queue object
    x=libQueue.queue()

    #Init the rules
    try:
        rules=dbif.getRules()
        log('Rules succesfully loaded (%s rules found)' % str(len(rules)))
    except:
        log('Failed to load the rules')
        traceback.print_exc(logFile)

    for irule in rules:
        log("Applying rule %s: " % irule['id'])
        log("      condition: %s" % irule['condition'])
        log("      cliaction: %s" % irule['cliaction'])
        queuedItemsID=x.search(irule['condition']+' and finstatus is null')
        log("      found %s items" % len(queuedItemsID))
        for queuedItemID in queuedItemsID:
            
            #Create the queueItem object starting from the ID
            try:
                queuedItem=libQueue.queuedItem(queuedItemID)
                log("  Found item %s; object succesfully loaded " % queuedItemID)
            except:
                log("  Found item %s; error in initializing the object" % queuedItemID)
                traceback.print_exc(logFile)

            #prepare the command line
            cli=irule['cliaction']
            cli=mapcliParameters(queuedItem, cli)
            #cli=cli.replace('$ITEM',queuedItemID)
            #cli=cli.replace('$ALLMETADATA',pprint.pformat(queuedItem.__dict__))
            
            #Invoke the command line
            log("    Invoking cli: %s" %cli)
            try:
                os.system(cli)
                #Flag the item as processed
                queuedItem.setFinStatus('OK')
                log("    Execution OK and item succesfully tagged as OK")
            except:
                queuedItem.setFinStatus('NOK')
                log("    Execution FAILED and item tagged as NOK")
                traceback.print_exc(logFile)
        pass
    pass
    log(APPID +' process completed')

if __name__ == "__main__":
    #Processing arguments from command line
    import argparse
    parser = argparse.ArgumentParser(description="Finalise items in the queue based on config.ini setting")
    args=parser.parse_args()
    main()
