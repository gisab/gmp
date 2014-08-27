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
currDir=os.path.realpath(__file__)
prjFolder=currDir.split(prjName)[0]+prjName
sys.path.append(prjFolder+'/lib')
import libQueue

class gmpPlugin(object):
    def __init__(self):
        self.type='generic'
        pass
    
    def downloadPlan(self):
        #Return a generic Plan as dictionary
        sample=dict()
        return sample
    
    def storePlan(self,plan):
        #store the plan into the DB
        print "Storing the plan into the DB"
        return