#!/usr/bin/python
#
###########################################################
#                                                         #
# Project: GMP                                            #
# Author:  gianluca.sabella@gmail.com                     #
#                                                         #
# Module:  config.py                                      #
# First version: 18/10/2014                               #
#                                                         #
###########################################################

import os,sys
thisFolder=os.path.dirname(__file__)
prjFolder=os.path.split(thisFolder)[0]
sys.path.append(prjFolder+'/lib')

import dbif

sql=list()
sql.append(
  "update queue set dwnstatus='Q' where status='CATALOGUED' and pid is Null and dwnstatus='N';"
)
sql.append(
  "update queue set pid=Null where pid is not null and LAST_UPDATE<(now() - INTERVAL 20 MINUTE);"
)

def main():
    db=dbif.gencur('SELECT * FROM queue')
    for isql in sql:
        out=isql[:50]
        try:
            db.exe(isql)
            out+= ' OK'
        except:
            out+= ' ERROR'
        print out
    pass

if __name__ == "__main__":
    main()