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
        if chost=='localhost':
            csocket=config.ini.get('dbif','socket')
            self.connection = MySQLdb.connect(host='localhost',unix_socket = csocket, db=cschema,user=cuser,passwd = cpwd)
        else:
            cport  =int(config.ini.get('dbif','port'))
            self.connection = MySQLdb.connect(host=chost,port=cport,db=cschema,user=cuser,passwd = cpwd)
        self.cur = self.connection.cursor()
        if sqlbody!="#":
            self.cur.execute(sqlbody)
    
    def exe(self,sqlbody):
        self.cur.execute(sqlbody)
        self.connection.commit()
      

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

def upload_image(idir,ifile):
    idscen=ifile.split(".")[0]
    image=open(os.path.join(idir,ifile), 'rb').read()
    qry = "INSERT INTO SCENARIO (idscen, image) VALUES (%s,%s);"
    t=gencur()
    t.cur.execute(qry, (idscen,image))
    t.connection.commit()
    #cursor.execute(sql, (idscen,image))

def delete_flag():
    tag=config.ini.get('dbif','tag')
    qry="delete from TAG where TAGID='" + tag + "';"
    t=gencur(qry)
    t.connection.commit()
    
def main(idir):
	known_ext=["jpg","png","gif"]
	for dirname, dirnames, filenames in os.walk(idir):
		for filename in filenames:
			ext=filename[-3:]
			if ext in known_ext:
				print "Processing " +os.path.join(dirname, filename)
				upload_image(dirname, filename)
