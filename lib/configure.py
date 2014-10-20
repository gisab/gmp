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
import json
import pprint
import argparse

APPID  ='configure'
config_ini=config.getPath(APPID,'config_ini')
php_setting=config.getPath(APPID,'php_setting')
resourcefile=config.getPath(APPID,'resourcefile')

class configure():

    def init(self, reconfigure):
        if os.path.isfile(resourcefile):
            self.res=json.load(open(resourcefile,'r'))
        else:
            reconfigure=True
            #the file is not existing; init class with default parameters
            self.res=dict()
            self.res['dbhost']      ='127.0.0.1'
            self.res['dbschema']    ='gmp'
            self.res['dbport']      ='3306'
            self.res['dbuser']      ='admin'
            self.res['dbpassword']  ='admin'

        if reconfigure:
            self.ask_user()
            json.dump(self.res,open(resourcefile,'w'),indent=2)
        
        config_map=list()
        config_map.append(('dbhost'     ,self.res['dbhost']))
        config_map.append(('dbschema'   ,self.res['dbschema']))
        config_map.append(('dbport'     ,self.res['dbport']))
        config_map.append(('dbuser'     ,self.res['dbuser']))
        config_map.append(('dbpassword' ,self.res['dbpassword']))
        
        php_map=list()
        php_map.append(('server'   ,self.res['dbhost']))
        php_map.append(('database' ,self.res['dbschema']))
        php_map.append(('port'     ,self.res['dbport']))
        php_map.append(('username' ,self.res['dbuser']))
        php_map.append(('password' ,self.res['dbpassword']))
        
        self.gmap=list()
        
        self.gmap.append({
            'file'    :config_ini,
            'regex'   :config_map,
            'pattern' :'(\s*=)([A-Za-z0-9.]+)(\n)'
             })
        
        self.gmap.append({
            'file'    :php_setting,
            'regex'   :php_map,
            'pattern' :"(' => ')([A-Za-z0-9.]+)(')"
             })
            
    def ask_user(self):
        print "Please entry the parameter for connecting to the MySQL db and Product Archive services"
        print "  [RETURN] for the default value"
        
        for i in self.res.keys():
            ask=" %12s [%s]: " % (i,self.res[i])
            ask=ask.ljust(30,' ')
            res=raw_input(ask)
            if res!='':
                self.res[i]=res
        print ""
        print "Summary of values entered:"
        pprint.pprint(self.res)
        res=raw_input("Do you confirm [OK]: ")
        if res.upper() in ('OK','Y',''):
            return
        else:
            print "Configuration procedure stopped!"
            sys.exit()
    
    def configure(self):
        #configure files
        for imap in self.gmap:
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

    def go(self,reconfigure):
        self.init(reconfigure)
        self.configure()
        print "Configuration completed succesfully!"

        
if __name__ == "__main__":
    print "Configure GMP environment"
    print "Use -h for the help.\n"
    parser = argparse.ArgumentParser()
    parser.add_argument("--reconfigure", dest="reconf", action="store_true", help="reconfigure all parameters")
    args=parser.parse_args()
    if args.reconf:
        x=configure()
        x.go(reconfigure=True)
        sys.exit()
    x=configure()
    x.go(reconfigure=False)