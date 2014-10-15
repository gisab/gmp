Welcome to GMP
==============

GMP, also known as 'Get My Products' is a GPL free software which allows you to download and catalogue Copernicus Sentinels Imagery.

For downloading and using the Copernicus Sentinels Imagery you need to be registered at https://scihub.esa.int.

The registration is free and implies you agree with the "TERMS AND CONDITIONS FOR THE USE AND DISTRIBUTION OF SENTINEL DATA" (https://sentinel.esa.int/documents/247904/690755/TC_Sentinel_Data_31072014.pdf).

1. PRE REQUIREMENT
------------------

GMP is tested on linux like operative system and OS X.

GMP relies on some open source components which are reported here as pre-requirement for the installation:
- httpd
- mysqld
- python
- php

Several solution exist and may be used for hosting GMP, like:
- linux:   LAMP http://it.wikipedia.org/wiki/LAMP_(piattaforma)
- OS X:    MAMP http://it.wikipedia.org/wiki/MAMP and http://www.mamp.info/en/
- Windows: WAMP http://it.wikipedia.org/wiki/WAMP and http://www.wampserver.com/en/

For the python environment few packages sometimes not included in standard distribution may be needed:
- argparse
- lxml
- MySQLdb

To install the packages use the setuptools procedure:
sudo easy_install argparse
sudo easy_install lxml
sudo easy_install MySQLdb


2. INSTALLATION
---------------

For the installation you need to download the software from the official repository and configure it.

a. Download the software
open a shell and execute:
git clone https://github.com/gisab/gmp.git

b. Configure
- edit the file lib/config.ini and set into the section [dbif] the credential for accessing mysql db; the db, if not existing, will be generated at the first run.
- edit the file web/phpgen_settings.php and set into the function GetGlobalConnectionOptions the credential for accessing mysql db.

c. Deploy
- link the folder web under your httpd folder; for example if you are using MAMP for OSX launch the command:
ln -s {path of}/gmp/web/ /Applications/MAMP/htdocs/gmp

d. Download latest patches
After the installation, at any time you may download the latest build of the software by running the command:
git pull

3. USE
------

a. Downloading imagery metadata
For getting the metadata on the available imagery execute the plugin:
cd lib
python ./pluginDhus.py
and let the program tun till the end.
At any time you can run this command again to get imagery updates from the scihub server

b. Browsing the catalogue
According to your local httpd configuration and the link you set up in the step 2c, you may access the catalogue with any bworser.
For example, if you are using MAMP for OSX you can point your browser to:
http://localhost:8888/gmp/

c. Adding a product in the download queue
To add a product in the download queue you need to click the button QUEUE present into Product and Queue pages

d. Download product in the queue
To download the first product (based on queue request) in the queue you can simply run the on-shot command
python ./downloader.py

If you want to setup an automatic download daemon, you may use the download manager which run as a daemon and run an instance of the downloader for any available product
python ./downloadManager.py

e. Accessing the product from your local file system
The downloaded imagery are stored according to the variable 'repository' set into the [downloader] section of the config.ini.

4.  Contacts
------------

If you want to be informed about new code releases, bug fixes, general news and information contact the author via email at gianluca.sabella@gmail.com

If you want to contribute to the project, follow it on https://github.com/gisab/gmp.

The project is not founded and based on spontaneous donation.
If you found it useful and you want to contribute, please follow this link:
https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=gianluca%2esabella%40gmail%2ecom&lc=IT&item_name=GMP&item_number=GMPweb&currency_code=EUR&bn=PP%2dDonationsBF%3abtn_donate_SM%2egif%3aNonHosted
It will be very much appreciated.

-------------------------------------------------------------------------------
Copyright (C) 2014 Gianluca Sabella 

This file is part of the GMP project

This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program; if not, see <http://www.gnu.org/licenses/>.