#!/usr/bin/python
#
###########################################################
#                                                         #
# Project: GMP                                            #
# Author:  gianluca.sabella@gmail.com                     #
#                                                         #
# Module:  config.py                                      #
# First version: 13/08/2014                               #
#                                                         #
###########################################################

import ConfigParser

ini=ConfigParser.SafeConfigParser()
#Config file
#Second config file, if present, override the first one
ini.read(["config.ini","config-local.ini"])
#conf.get('unpacker','test')
