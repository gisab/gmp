#!/usr/bin/python
#
###########################################################
#                                                         #
# Project: GMP                                            #
# Author:  gianluca.sabella@gmail.com                     #
#                                                         #
# Module:  libProduct.py                                  #
# First version: 07/09/2014                               #
#                                                         #
###########################################################

prjName='gmp'
#currDir=os.getcwd()
import os,sys
currDir=os.path.realpath(__file__)
prjFolder=currDir.split(prjName)[0]+prjName
sys.path.append(prjFolder+'/lib')

import MySQLdb
import config
import argparse
import logging
import pprint
import libQueue
import dbif
import time
from lxml import etree
import json
import traceback

CharToBool={'Y': True, 'N': False}
BoolToChar={True:'Y', False:'N'}
if config.ini.get('general','debug')=='Y':
    debug=True
else:
    debug=False

rep           =config.ini.get('downloader','repository').replace('$PRJ',prjFolder)

class product(object):
    def __init__(self,init='#'):
        if init=='#':
            print "product ID is missing"
            return
        self.productid=init
        self.db=dbif.gencur()
        self.getProduct(init)
        pass
    
    def reload(self):
        self.getProduct(self.productid)
        
    def getProduct(self,productID):
        fields=('id','producttype','start','stop','duration','orbit','crc','footprint','polarization','tags','json')
        qry='`, `'.join(fields)
        qry='SELECT `' + qry + "`, AsText(footprint) from product where id='%s';" % productID
        self.db.cur.execute(qry)
        rec=self.db.cur.fetchone()
        if rec==None:
            #no record found
            self.id="#"
            return
        i=0
        for field in fields:
            self.__setattr__(field,rec[i])
            i+=1
        self.__setattr__('footprint',rec[i])
        pass
        if self.tags!=None and self.tags!='':
            self.tags=self.tags.split(',')
        else:
            self.tags=list()
        if self.json!=None and self.json!='':
            self.json=json.loads(self.json)
        else:
            self.json=dict()

    def addTag(self,newtag):
        qry="SELECT tags FROM product where ID='%s';" % str(self.id)
        self.db.cur.execute(qry)
        rec=self.db.cur.fetchone()
        if rec[0]==None:
            newfield=newtag
        else:
            self.tags=rec[0].split(',')
            if newtag in self.tags:
                #tag already existing; skipping tag update
                return
            self.tags.append(newtag)
            newfield=','.join(sorted(self.tags)).replace(',,',',').strip(',')
        qry="UPDATE product set tags='%s' where ID='%s';" % (newfield,str(self.id))
        self.db.exe(qry)
        pass

    def delTag(self,tag):
        qry="SELECT tags FROM product where ID='%s';" % str(self.id)
        self.db.cur.execute(qry)
        rec=self.db.cur.fetchone()
        if rec[0]==None:
            return
        else:
            self.tags=rec[0].split(',')
            try:
                self.tags.remove(tag)
            except:
                pass
            newfield=','.join(sorted(self.tags))
        qry="UPDATE product set tags='%s' where ID='%s';" % (newfield,str(self.id))
        self.db.exe(qry)
        pass

    def cleanTag(self):
        qry="UPDATE product set tags=Null where ID='%s';" % str(self.id)
        self.db.cur.execute(qry)
        self.tags=list()
        pass

    def addJson(self,newdict):
        assert isinstance(newdict,dict)
        qry="SELECT json FROM product where ID='%s';" % str(self.id)
        self.db.cur.execute(qry)
        rec=self.db.cur.fetchone()
        if rec[0]==None or rec[0]=='':
            self.json=newdict
        else:
            self.json=convert(json.loads(rec[0]))
            self.json.update(newdict)
        newvalue=json.dumps(self.json)
        qry="UPDATE product set json='%s' where ID='%s';" % (newvalue,str(self.id))
        self.db.exe(qry)
        pass

    def delJson(self,key):
        qry="SELECT json FROM product where ID='%s';" % str(self.id)
        self.db.cur.execute(qry)
        rec=self.db.cur.fetchone()
        if rec[0]==None:
            return
        else:
            self.json=convert(json.loads(rec[0]))
            self.json.pop(key)
        newvalue=json.dumps(self.json)
        qry="UPDATE product set json='%s' where ID='%s';" % (newvalue,str(self.id))
        self.db.exe(qry)
        pass

    def cleanJson(self):
        qry="UPDATE product set Json=Null where ID='%s';" % str(self.id)
        self.db.cur.execute(qry)
        self.json=dict()
        pass
    
    def catalogue(self):
        wkt=self.footprint
        qry="SELECT DISTINCT id,`name`, AsText(geom) FROM area WHERE MBRContains(GeomFromText('%s'),geom);" % wkt
        db=dbif.gencur(qry)
        res=db.cur.fetchall()
        for icountry in res:
            print "adding tag %s" % icountry[1]
            try:
                self.addTag(icountry[1])
            except:
                print "ERROR: Failed to add tag %s" % icountry[1]
                traceback.print_exc(file=sys.stdout)
            
def gml2wkt(gml):
    tmp=gml.replace(',','/').replace(' ',',').replace('/',' ')
    firstpoint=tmp.split(',')[0]
    wkt='POLYGON ((' + tmp +',' + firstpoint+ '))'
    return wkt

def gml2wkt_swap(gml):
    wkt='POLYGON ((' 
    xylist=gml.split(' ')
    for p in xylist:
        x=p.split(',')[0]
        y=p.split(',')[1]
        wkt+=y+' '+x+','
    #add first point as last
    p=xylist[0]
    x=p.split(',')[0]
    y=p.split(',')[1]
    wkt+=y+' '+x+'))'
    return wkt

def convert(input):
    if isinstance(input, dict):
        return {convert(key): convert(value) for key, value in input.iteritems()}
    elif isinstance(input, list):
        return [convert(element) for element in input]
    elif isinstance(input, unicode):
        return input.encode('utf-8')
    else:
        return input
    
if __name__ == "__main__":
    x=product('S1A_EW_GRDH_1SDH_20140801T163508_20140801T163612_001749_001A67_92F5')