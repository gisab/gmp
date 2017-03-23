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

import sys,os
thisFolder=os.path.dirname(__file__)
prjFolder=os.path.split(thisFolder)[0]
sys.path.append(prjFolder+'/lib')

import MySQLdb
import config

## Generic cursor 
# Establish a connection with the db and return a read only cursor
# @param schema the target schema; allowed values: global, node
# @param sqlbody a sql code used for the cursor
# @return connection object
class gencur(object):
    ## The constructor.
    def __init__(self,sqlbody="#"):
        cuser  =config.ini.get('dbif','dbuser')
        cpwd   =config.ini.get('dbif','dbpassword')
        chost  =config.ini.get('dbif','dbhost')
        cschema=config.ini.get('dbif','dbschema')
        try:
            if chost=='localhost':
                csocket=config.ini.get('dbif','dbsocket')
                self.connection = MySQLdb.connect(host='localhost',unix_socket = csocket,user=cuser,passwd = cpwd)
            else:
                cport  =int(config.ini.get('dbif','dbport'))
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
        dumpfiles=['gmp-schema.sql', 'gmp-tab.sql']
        
        cuser  =config.ini.get('dbif','dbuser')
        cpwd   =config.ini.get('dbif','dbpassword')
        chost  =config.ini.get('dbif','dbhost')
        cschema=config.ini.get('dbif','dbschema')
        cport  =int(config.ini.get('dbif','dbport'))
        
        for idump in dumpfiles:
            ifile=prjFolder+'/db/'+idump
            cli='mysql --user="%s" --password="%s" --host="%s" --port="%s" --database="%s" < "%s"'
            cli=cli % (cuser, cpwd, chost, cport, cschema, ifile)
            try:
                #print cli
                os.system(cli)
            except:
                print"Error importing %s " % ifile
                raise

def getTargetList(filter='#'):
    if filter!='#':
        qwhere=" where %s " % filter
    else:
        qwhere=''
    qry="SELECT id, type, hostname, username, `password`, rep, protocol, port FROM target " + qwhere
    db=gencur(qry)
    res=db.cur.fetchall()
    ret=list()
    for irec in res:
        icon=dict()
        icon['id']       =irec[0]
        icon['type']     =irec[1]
        icon['host']     =irec[2]
        icon['username'] =irec[3]
        icon['password'] =irec[4]
        icon['rep']      =irec[5].replace('$PRJ',prjFolder)
        icon['protocol'] =irec[6]
        icon['port']     =irec[7]
        ret.append(icon)
    #import pprint
    #pprint.pprint(ret)
    return ret

def getRules():
    qry="SELECT `id`, `condition`, cliaction FROM rule where isactive='Y' order by id ASC;"
    db=gencur(qry)
    res=db.cur.fetchall()
    ret=list()
    for irec in res:
        i=dict()
        i['id']        =irec[0]
        i['condition'] =irec[1]
        i['cliaction'] =irec[2]
        ret.append(i)
    #import pprint
    #pprint.pprint(ret)
    return ret

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
    

