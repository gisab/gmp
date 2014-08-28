#!/usr/bin/python
#
###########################################################
#                                                         #
# Project: GMP                                            #
# Author:  gianluca.sabella@gmail.com                     #
#                                                         #
# Module:  getPlan.py                                     #
# First version: 13/08/2014                               #
#                                                         #
###########################################################

prjName='gmp'
#currDir=os.getcwd()
import os,sys
currDir=os.path.realpath(__file__)
prjFolder=currDir.split(prjName)[0]+prjName
sys.path.append(prjFolder+'/lib')
import libQueue
import pprint

## get a download plan and add to the queue

def getSampleProduct():
    urlprefix='http://localhost:8888/S1/S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.ISIP/'
    files=(
        './not_existing_file',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/annotation/calibration/calibration-s1a-wv1-slc-hh-20140406t133433-20140406t133436-000039-7fff80-001.xml',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/annotation/calibration/calibration-s1a-wv1-slc-hh-20140406t133503-20140406t133506-000039-7fff80-003.xml',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/annotation/calibration/calibration-s1a-wv1-slc-hh-20140406t133532-20140406t133535-000039-7fff80-005.xml',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/annotation/calibration/calibration-s1a-wv1-slc-hh-20140406t133602-20140406t133605-000039-7fff80-007.xml',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/annotation/calibration/calibration-s1a-wv1-slc-hh-20140406t133631-20140406t133634-000039-7fff80-009.xml',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/annotation/calibration/calibration-s1a-wv1-slc-hh-20140406t133700-20140406t133703-000039-7fff80-011.xml',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/annotation/calibration/calibration-s1a-wv1-slc-hh-20140406t133730-20140406t133733-000039-7fff80-013.xml',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/annotation/calibration/calibration-s1a-wv1-slc-hh-20140406t133758-20140406t133801-000039-7fff80-015.xml',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/annotation/calibration/calibration-s1a-wv2-slc-hh-20140406t133449-20140406t133452-000039-7fff80-002.xml',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/annotation/calibration/calibration-s1a-wv2-slc-hh-20140406t133517-20140406t133520-000039-7fff80-004.xml',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/annotation/calibration/calibration-s1a-wv2-slc-hh-20140406t133547-20140406t133550-000039-7fff80-006.xml',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/annotation/calibration/calibration-s1a-wv2-slc-hh-20140406t133616-20140406t133619-000039-7fff80-008.xml',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/annotation/calibration/calibration-s1a-wv2-slc-hh-20140406t133646-20140406t133649-000039-7fff80-010.xml',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/annotation/calibration/calibration-s1a-wv2-slc-hh-20140406t133715-20140406t133718-000039-7fff80-012.xml',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/annotation/calibration/calibration-s1a-wv2-slc-hh-20140406t133744-20140406t133747-000039-7fff80-014.xml',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/annotation/calibration/calibration-s1a-wv2-slc-hh-20140406t133813-20140406t133816-000039-7fff80-016.xml',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/annotation/calibration/noise-s1a-wv1-slc-hh-20140406t133433-20140406t133436-000039-7fff80-001.xml',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/annotation/calibration/noise-s1a-wv1-slc-hh-20140406t133503-20140406t133506-000039-7fff80-003.xml',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/annotation/calibration/noise-s1a-wv1-slc-hh-20140406t133532-20140406t133535-000039-7fff80-005.xml',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/annotation/calibration/noise-s1a-wv1-slc-hh-20140406t133602-20140406t133605-000039-7fff80-007.xml',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/annotation/calibration/noise-s1a-wv1-slc-hh-20140406t133631-20140406t133634-000039-7fff80-009.xml',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/annotation/calibration/noise-s1a-wv1-slc-hh-20140406t133700-20140406t133703-000039-7fff80-011.xml',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/annotation/calibration/noise-s1a-wv1-slc-hh-20140406t133730-20140406t133733-000039-7fff80-013.xml',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/annotation/calibration/noise-s1a-wv1-slc-hh-20140406t133758-20140406t133801-000039-7fff80-015.xml',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/annotation/calibration/noise-s1a-wv2-slc-hh-20140406t133449-20140406t133452-000039-7fff80-002.xml',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/annotation/calibration/noise-s1a-wv2-slc-hh-20140406t133517-20140406t133520-000039-7fff80-004.xml',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/annotation/calibration/noise-s1a-wv2-slc-hh-20140406t133547-20140406t133550-000039-7fff80-006.xml',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/annotation/calibration/noise-s1a-wv2-slc-hh-20140406t133616-20140406t133619-000039-7fff80-008.xml',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/annotation/calibration/noise-s1a-wv2-slc-hh-20140406t133646-20140406t133649-000039-7fff80-010.xml',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/annotation/calibration/noise-s1a-wv2-slc-hh-20140406t133715-20140406t133718-000039-7fff80-012.xml',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/annotation/calibration/noise-s1a-wv2-slc-hh-20140406t133744-20140406t133747-000039-7fff80-014.xml',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/annotation/calibration/noise-s1a-wv2-slc-hh-20140406t133813-20140406t133816-000039-7fff80-016.xml',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/annotation/s1a-wv1-slc-hh-20140406t133433-20140406t133436-000039-7fff80-001.xml',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/annotation/s1a-wv1-slc-hh-20140406t133503-20140406t133506-000039-7fff80-003.xml',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/annotation/s1a-wv1-slc-hh-20140406t133532-20140406t133535-000039-7fff80-005.xml',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/annotation/s1a-wv1-slc-hh-20140406t133602-20140406t133605-000039-7fff80-007.xml',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/annotation/s1a-wv1-slc-hh-20140406t133631-20140406t133634-000039-7fff80-009.xml',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/annotation/s1a-wv1-slc-hh-20140406t133700-20140406t133703-000039-7fff80-011.xml',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/annotation/s1a-wv1-slc-hh-20140406t133730-20140406t133733-000039-7fff80-013.xml',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/annotation/s1a-wv1-slc-hh-20140406t133758-20140406t133801-000039-7fff80-015.xml',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/annotation/s1a-wv2-slc-hh-20140406t133449-20140406t133452-000039-7fff80-002.xml',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/annotation/s1a-wv2-slc-hh-20140406t133517-20140406t133520-000039-7fff80-004.xml',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/annotation/s1a-wv2-slc-hh-20140406t133547-20140406t133550-000039-7fff80-006.xml',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/annotation/s1a-wv2-slc-hh-20140406t133616-20140406t133619-000039-7fff80-008.xml',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/annotation/s1a-wv2-slc-hh-20140406t133646-20140406t133649-000039-7fff80-010.xml',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/annotation/s1a-wv2-slc-hh-20140406t133715-20140406t133718-000039-7fff80-012.xml',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/annotation/s1a-wv2-slc-hh-20140406t133744-20140406t133747-000039-7fff80-014.xml',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/annotation/s1a-wv2-slc-hh-20140406t133813-20140406t133816-000039-7fff80-016.xml',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/manifest.safe',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/measurement/s1a-wv1-slc-hh-20140406t133433-20140406t133436-000039-7fff80-001.tiff',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/measurement/s1a-wv1-slc-hh-20140406t133503-20140406t133506-000039-7fff80-003.tiff',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/measurement/s1a-wv1-slc-hh-20140406t133532-20140406t133535-000039-7fff80-005.tiff',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/measurement/s1a-wv1-slc-hh-20140406t133602-20140406t133605-000039-7fff80-007.tiff',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/measurement/s1a-wv1-slc-hh-20140406t133631-20140406t133634-000039-7fff80-009.tiff',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/measurement/s1a-wv1-slc-hh-20140406t133700-20140406t133703-000039-7fff80-011.tiff',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/measurement/s1a-wv1-slc-hh-20140406t133730-20140406t133733-000039-7fff80-013.tiff',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/measurement/s1a-wv1-slc-hh-20140406t133758-20140406t133801-000039-7fff80-015.tiff',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/measurement/s1a-wv2-slc-hh-20140406t133449-20140406t133452-000039-7fff80-002.tiff',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/measurement/s1a-wv2-slc-hh-20140406t133517-20140406t133520-000039-7fff80-004.tiff',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/measurement/s1a-wv2-slc-hh-20140406t133547-20140406t133550-000039-7fff80-006.tiff',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/measurement/s1a-wv2-slc-hh-20140406t133616-20140406t133619-000039-7fff80-008.tiff',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/measurement/s1a-wv2-slc-hh-20140406t133646-20140406t133649-000039-7fff80-010.tiff',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/measurement/s1a-wv2-slc-hh-20140406t133715-20140406t133718-000039-7fff80-012.tiff',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/measurement/s1a-wv2-slc-hh-20140406t133744-20140406t133747-000039-7fff80-014.tiff',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/measurement/s1a-wv2-slc-hh-20140406t133813-20140406t133816-000039-7fff80-016.tiff',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/preview/icons/logo.png',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/preview/map-overlay.kml',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/preview/product-preview.html',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE-report-20140406T152159.pdf',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/support/s1-level-1-calibration.xsd',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/support/s1-level-1-measurement.xsd',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/support/s1-level-1-noise.xsd',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/support/s1-level-1-product.xsd',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/support/s1-level-1-quicklook.xsd',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/support/s1-map-overlay.xsd',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/support/s1-object-types.xsd',
        './S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE/support/s1-product-preview.xsd')
    x=libQueue.queue('new')
    y=libQueue.newItem()
    y.setID('S1A_WV_SLC__1SSH_20140406T133433_20140406T133816_000039_7FFF80_54EF.SAFE.'+str(os.getpid()))
    y.setAgent('wget')
    for i in files:
        y.addFile(i,urlprefix+i[2:])
    x.addItem(y)
    x.dump()
    
def selftest():
    x=libQueue.queue()
    y=libQueue.newItem()
    y.setID('new object '+str(os.getpid()))
    y.addFile('test.dat','http://test.dat','test file with desc')
    y.addFile('test.dat','http://test.dat')
    x.addItem(y)
    x.dump()
    

def getPlugin(target):
    if target=='dhus':
        import pluginDhus
        x=pluginDhus.gmpPluginDhus()
        return x
    if target=='oda':
        import pluginOda
        x=pluginOda.gmpPluginOda()
        return x
    return

##Add single product
def addSingleODAProduct(productID):
    archive=getPlugin('oda')
    try:
        newItem=archive.createItem(productID)
    except:
        print "Failed to get metalink from ODA for product %s" % productID
    x=libQueue.queue()
    try:
        x.addItem(newItem)
    except:
        print "Failed to import product %s" % newItem.ID
    
## Main function
def main(target):
    archive=getPlugin(target)
    plan=archive.downloadPlan()
    x=libQueue.queue()
    i=0
    for plannedItem in plan:
        i+=1
        if i>5:
            return
        try:
            x.addItem(plannedItem)
        except:
            print "Failed to import product %s" % plannedItem.ID

if __name__ == "__main__":
    #Processing arguments from command line
    import argparse
    parser = argparse.ArgumentParser(description="Query for a download plan and add to the queue")
    parser.add_argument("--target", dest="target", help="target system to be contacted")
    parser.add_argument("--singleproduct", dest="productId", help="add a single product in the queue")
    parser.add_argument("--clean", action="store_true", dest="clean",   help="clean queue")
    parser.add_argument("--test", action="store_true", dest="test",   help="self test")
    args=parser.parse_args()
    if args.clean:
        debug=True
        x=libQueue.queue(init='new')
        sys.exit(0)
    if args.test:
        debug=True
        #selftest()
        getSampleProduct()
        sys.exit(0)
    if args.target in ['dhus']:
        main(args.target)
        sys.exit()
    if args.target in ['oda']:
        if args.productId:
            #specific product request
            addSingleODAProduct(args.productId)
        else:
            #no single product request; get full available plan
            main(args.target)
        sys.exit()
    print "No valid argument found; try -h."