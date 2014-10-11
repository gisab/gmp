#!/usr/bin/python
#
###########################################################
#                                                         #
# Project: GMP                                            #
# Author:  gianluca.sabella@gmail.com                     #
#                                                         #
# Module:  dbif.py                                        #
# First version: 13/08/2014                               #
#                                                         #
###########################################################

prjName='gmp'

import MySQLdb
import config
import sys,os,argparse
import logging

## Generic cursor 
# Establish a connection with the db and return a read only cursor
# @param schema the target schema; allowed values: global, node
# @param sqlbody a sql code used for the cursor
# @return connection object
class gencur(object):
    ## The constructor.
    def __init__(self,sqlbody="#"):
        cuser  =config.ini.get('dbif','user')
        cpwd   =config.ini.get('dbif','password')
        chost  =config.ini.get('dbif','host')
        cschema=config.ini.get('dbif','schema')
        try:
            if chost=='localhost':
                csocket=config.ini.get('dbif','socket')
                self.connection = MySQLdb.connect(host='localhost',unix_socket = csocket,user=cuser,passwd = cpwd)
            else:
                cport  =int(config.ini.get('dbif','port'))
                #self.connection = MySQLdb.connect(host=chost,port=cport,db=cschema,user=cuser,passwd = cpwd)
                self.connection = MySQLdb.connect(host=chost,port=cport,user=cuser,passwd = cpwd)
        except:
            print "Error in connecting to mysql db; please check parameter in config.ini, section [dbif]"
            raise
        #check if db exist
        try:
            self.connection.cursor().execute("USE `%s`;" % cschema)
        except:
            print "Target DB does not esist; creating new schema %s" % cschema
            self.connection.cursor().execute("CREATE DATABASE `%s`;" % cschema)
            self.connection.cursor().execute("USE `%s`;" % cschema)
            self.createdb()
        self.cur = self.connection.cursor()
        if sqlbody!="#":
            self.cur.execute(sqlbody)
    
    def exe(self,sqlbody):
        self.cur.execute(sqlbody)
        self.connection.commit()
    
    def createdb(self):
        import os
        #getting directory
        currDir=os.path.realpath(__file__)
        prjFolder=currDir.split(prjName)[0]+prjName
        dumpfiles=['gmp-schema.sql', 'gmp-tab.sql']
        
        cuser  =config.ini.get('dbif','user')
        cpwd   =config.ini.get('dbif','password')
        chost  =config.ini.get('dbif','host')
        cschema=config.ini.get('dbif','schema')
        cport  =int(config.ini.get('dbif','port'))
        
        for idump in dumpfiles:
            ifile=prjFolder+'/db/'+idump
            cli='mysql --user=%s --password=%s --host=%s --port=%s --database=%s < %s'
            cli=cli % (cuser, cpwd, chost, cport, cschema, ifile)
            try:
                #print cli
                os.system(cli)
            except:
                print"Error importing %s " % ifile
                raise

## setObject Store an object into MySQL master db
# @param iobj input object
# @param tschema target schema
# @param ttable target table
# @param tcolumn target column in target table
# @param twhere where condition to select a specific row
def setObject(iobj,ttable,tcolumn,twhere):
    import simplejson
    sobj=simplejson.dumps(iobj)
    qry="update "+ttable +" set " + tcolumn +"='" + sobj +"' where " + twhere +" " 
    gvar.dl(11,"dbif.setObject: "+qry)
    t=gencur(qry)
    t.connection.commit()
    return True

def delete_flag():
    tag=config.ini.get('dbif','tag')
    qry="delete from TAG where TAGID='" + tag + "';"
    t=gencur(qry)
    t.connection.commit()
    

