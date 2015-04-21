Zend 2 Skeleton Application Extension
=======================

Introduction
------------
Using ZF2 MVC layer, Using PHP >= 5.3.2

Installation
------------
See zend2Demo/config/autoload/global.php for config your local db

Using Composer (recommended)
----------------------------
After cloned to your directory
   + cd to zend2Demo
   + php composer.phar self-update
   + php composer.php install

Note: please make sure you enabled PHP CLI, check it by cmd : php -v
   If not, go to Computer > Properties > Set Environments > System variables > Find "path" variable
   In my case, i add at the end :   ";C:\xampp\php"
   Saved !

### PHP CLI Server

The simplest way to get started if you are using PHP 5.4 or above is to start the internal PHP cli-server in the root directory:

    php -S 0.0.0.0:8080 -t public/ public/index.php

This will start the cli-server on port 8080, and bind it to all network
interfaces.

**Note: ** The built-in CLI server is *for development only*.

### Apache Setup
Default app run on link:  http://localhost/zend2Demo/public

If you want to run this demo application on virtual host, see bellow :
To setup apache, setup a virtual host to point to the public/ directory of the
project and you should be ready to go! It should look something like below:

    <VirtualHost *:80>
        ServerName zf2-tutorial.localhost
        DocumentRoot /path/to/zf2-tutorial/public
        SetEnv APPLICATION_ENV "development"
        <Directory /path/to/zf2-tutorial/public>
            DirectoryIndex index.php
            AllowOverride All
            Order allow,deny
            Allow from all
        </Directory>
    </VirtualHost>
