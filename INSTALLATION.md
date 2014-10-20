## Foreign ppa ##
You must use foreign ppas. In order to install them easily via ``add-apt-repository`` you must install it first.
### Install  ``add-apt-repository`` ###
``add-apt-repository`` resides in package ``python-software-properties``. Install it via:
```
sudo apt-get install python-software-properties
```
## Php ##
To use Yii2 for Ubuntu 12.04 you must first install PHP 5.4 manually since Ubuntu 12.04 only comes with PHP 5.3.
### Install PHP 5.4 ###
PHP 5.4 is packaged in the ppa https://launchpad.net/~ondrej/+archive/ubuntu/php5-oldstable. Install it via:
```
sudo add-apt-repository ppa:ondrej/php5
sudo apt-get update
sudo apt-get upgrade
```
## Postgres ##
### Install postgis ###
To use postgis for Ubuntu 12.04 you must first install it manually.

Be sure that no old installation (e.g. version 1.5) exists before. If it does remove it via ``sudo apt-get remove postgresql-9.1-postgis``

Then install version 2.x from the ppa https://launchpad.net/~ubuntugis/+archive/ubuntu/ppa via:
```
sudo add-apt-repository ppa:ubuntugis/ppa
sudo apt-get update
sudo apt-get install postgresql-9.1-postgis
```
