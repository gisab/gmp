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
import pprint

## download the first item in the queue

def main():
    x=libQueue.queue()
    #resetDownloadQueue for debug purposes
    x.resetDownloadQueue()
    y=x.getItem(str(os.getpid()))
    if y=='#':
        #no record found
        return
    pprint.pprint(y.__dict__)
    
if __name__ == "__main__":
    #Processing arguments from command line
    import argparse
    parser = argparse.ArgumentParser(description="Download the first item in the queue")
    parser.add_argument("--test", action="store_true", dest="test",   help="self test")
    args=parser.parse_args()
    main()
