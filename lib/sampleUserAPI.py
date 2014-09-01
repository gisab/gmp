#!/usr/bin/python
import libQueue
from osgeo import ogr

def getReferenceArea():
    w='POLYGON ((-72.01217987742835 73.70150873297709,-70.1739093379158 66.24699837430212,-63.32479021131556 65.36182400682944,-61.51370525768952 72.57468986097602,-72.01217987742835 73.70150873297709))'
    w='POLYGON ((73 -72, 66 -70, 65 -63, 72 -61, 73 -72 ))'
    geom=ogr.CreateGeometryFromWkt(w)
    #print geom
    #print geom.GetBoundary()
    return geom

def compare(area1, area2):
    print "Comparing two areas"
    x=area2.Intersect(area1)
    print "There is an intesection? %s" % str(x)
    if x:
        intersection=area2.Intersection(area1)
        print "the intersection is:"
        print intersection.ExportToWkt()
        #print intersection.ExportToKML()

def main(x):
    x.openManifest()
    x.parseManifest()
    from osgeo import ogr
    xgeom=ogr.CreateGeometryFromWkt(x.coordinatesWKT)
    y=getReferenceArea()
    compare(xgeom,y)
    if xgeom.Intersect(y):
        x.addTag('area1')
    pass
