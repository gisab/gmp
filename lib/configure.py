#!/usr/bin/python
#
###########################################################
#                                                         #
# Project: GMP                                            #
# Author:  gianluca.sabella@gmail.com                     #
#                                                         #
# Module:  configure.py                                   #
# First version: 19/10/2014                               #
#                                                         #
###########################################################

import os,sys
thisFolder=os.path.dirname(__file__)
prjFolder=os.path.split(thisFolder)[0]
sys.path.append(prjFolder+'/lib')

import re
import config
import pprint

APPID  ='configure'
config_ini=config.getPath(APPID,'config_ini')
php_setting=config.getPath(APPID,'php_setting')

dbhost      ='127.0.0.1'
dbschema    ='gmp'
dbport      ='8889'
dbuser      ='admin'
dbpassword  ='admin'

config_map=list()
config_map.append(('dbhost'     ,dbhost))
config_map.append(('dbschema'   ,dbschema))
config_map.append(('dbport'     ,dbport))
config_map.append(('dbuser'     ,dbuser))
config_map.append(('dbpassword' ,dbpassword))

php_map=list()
php_map.append(('server'   ,dbhost))
php_map.append(('database' ,dbschema))
php_map.append(('port'     ,dbport))
php_map.append(('username' ,dbuser))
php_map.append(('password' ,dbpassword))

gmap=list()

gmap.append({
    'file'    :config_ini,
    'regex'   :config_map,
    'pattern' :'(\s*=)([A-Za-z0-9.]+)(\n)'
     })

gmap.append({
    'file'    :php_setting,
    'regex'   :php_map,
    'pattern' :"(' => ')([A-Za-z0-9.]+)(')"
     })


def configure():
    dbhost='nuovo'

    #configure files
    for imap in gmap:
        print "Procesing file %s" % imap['file']
        ifile=open(imap['file'],'r').read()
        ipattern=imap['pattern']
        for ireg in imap['regex']:
            rsearch='(' +ireg[0] + ')' + ipattern
            #checking if multiple items are found
            items=re.findall(rsearch,ifile)
            if len(items)>1:
                print "expression %s found %s times" % (ireg[0],len(items))
                pprint.pprint(items)
                raise
            #replacing
            p=re.compile(rsearch)
            ifile=p.sub(r'\g<1>\g<2>'+ireg[1]+'\g<4>',ifile)
            #print ifile[400:600] #for php
            #print ifile[580:780] #for config
        open(imap['file'],'w').write(ifile)
    return

if __name__ == "__main__":
    #test()
    configure()