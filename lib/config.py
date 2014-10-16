#!/usr/bin/python
#
###########################################################
#                                                         #
# Project: GMP                                            #
# Author:  gianluca.sabella@gmail.com                     #
#                                                         #
# Module:  config.py                                      #
# First version: 13/08/2014                               #
#                                                         #
###########################################################

import ConfigParser,os,sys
thisFolder=os.path.dirname(__file__)
prjFolder=os.path.split(thisFolder)[0]
sys.path.append(prjFolder+'/lib')

#import platform
#if platform.system()=='Windows':
#    isWin=True
#else:
#    isWin=False
#print "Is windows %s" % isWin

ini=ConfigParser.SafeConfigParser()
#Config file
#Second config file, if present, override the first one
ini.read([os.path.split(os.path.realpath(__file__))[0]+"/config.ini","config.ini","config-local.ini"])

def getPath(section, variable):
    value=ini.get(section,variable)
    value=value.replace('/',os.path.sep)
    value=value.replace('$PRJ',prjFolder)
    return value