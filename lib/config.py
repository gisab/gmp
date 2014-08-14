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

import ConfigParser,os
ini=ConfigParser.SafeConfigParser()
#Config file
#Second config file, if present, override the first one
ini.read([os.path.split(os.path.realpath(__file__))[0]+"/config.ini","config.ini","config-local.ini"])
