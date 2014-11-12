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
  "update queue set dwnstatus='Q' where status='CATALOGUED' and pid is Null and dwnstatus='N';")
sql.append(
  "update queue set pid=Null where pid is not null and LAST_UPDATE<(now() - INTERVAL 20 MINUTE);")
sql.append(
  "update queue set status='NEW' where status='NOK' and pid is null and LAST_UPDATE<(now() - interval 1 hour);")

#Query for searching for interferometric pairs
sql.append("""
    INSERT INTO slc (name, area,producttype,relativeorbit)
    SELECT
       concat('Area',floor(Area(ST_Intersection(p1.footprint, p2.footprint))/Area(p1.footprint)*100)),
       ST_Intersection(p1.footprint, p2.footprint),
       p1.producttype,
       mod(p1.orbit -73, 175)+1 relorb
    FROM product p1, product p2
    WHERE
       (p1.id != p2.id) and 
       p1.producttype=p2.producttype and
       p1.producttype like '%SLC' and
       p1.producttype not like 'WV%SLC' and
       p1.slcid is null and
       p2.slcid is null and
       mod(p1.orbit,175)=mod(p2.orbit,175) and
       AsText(ST_Intersection(p1.footprint, p2.footprint)) is not null and
       Area(ST_Intersection(p1.footprint, p2.footprint))/Area(p1.footprint)>0.6
    ORDER BY Area(ST_Intersection(p1.footprint, p2.footprint))/Area(p1.footprint) desc limit 1;
""")
sql.append("""
    UPDATE product P INNER JOIN slc S on P.producttype=S.producttype
    SET P.SLCID=S.ID
    WHERE
     P.SLCID is null and
     mod(P.orbit -73, 175)+1 = S.relativeorbit and
     Area(ST_Intersection(P.footprint, S.area))/Area(P.footprint)>0.6;
""")

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