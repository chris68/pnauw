## Foreign ppa ##
For Ubuntu 12.04 you must use foreign ppas. In order to install them easily via ``add-apt-repository`` you must install it first.
### Install  ``add-apt-repository`` ###
``add-apt-repository`` resides in package ``python-software-properties``. Install it via:
```
sudo apt-get install python-software-properties
```
With Ubuntu >= 12.10 it will be (see http://stackoverflow.com/questions/13018626/add-apt-repository-not-found):
```
sudo apt-get install software-properties-common
```
## Usage ##
Before you install things from a foreign ppa it make sense to update the system before to the an up-to-date level via
```
sudo apt-get update
sudo apt-get dist-upgrade
```
## Php ##
### Install PHP 5.4 ###
To use Yii2 for Ubuntu 12.04 you must first install PHP 5.4 manually since Ubuntu 12.04 only comes with PHP 5.3.

PHP 5.4 is packaged in the ppa https://launchpad.net/~ondrej/+archive/ubuntu/php5-oldstable. Install it via:
```
sudo add-apt-repository ppa:ondrej/php5
sudo apt-get update
sudo apt-get dist-upgrade
```

Restart the apache server via ``sudo service apache restart``
### Kill superfluous xcache.ini ###
There might exist a second and superflous file ``/etc/php/apache2/conf.d/xcache.ini``, parallel to the correct ``20-xcache.ini``. Delete it since otherwise you get constant errors about a wrong ``xcache.so`` file.

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
## FTP ##
The ftp server ``vsftpd`` is best used for the ftp access.
### Install package ###
Install the package via ``sudo apt-get vsftpd``
### Set up file stucture ###
Set up the file structure as follows:
```
/srv/ftp/pnauw:
dr-xr-xr-x 4 www-data www-data 4096 Okt 22 18:35 .
drwxrwxrwt 5 root     ftp      4096 Okt 22 18:09 ..
dr-xr-xr-x 5 www-data www-data 4096 Okt 22 18:35 upload
dr-xr-xr-x 5 www-data www-data 4096 Okt 22 18:34 upload_dev
/srv/ftp/pnauw/upload:
dr-xr-xr-x 5 www-data www-data 4096 Okt 22 18:35 .
dr-xr-xr-x 4 www-data www-data 4096 Okt 22 18:35 ..
drwxr-xr-x 2 www-data www-data 4096 Okt 22 18:35 user_a
drwxr-xr-x 2 www-data www-data 4096 Okt 22 18:35 user_b
/srv/ftp/pnauw//upload/upload_dev:
total 12
dr-xr-xr-x 3 www-data www-data 4096 Okt 22 18:35 .
dr-xr-xr-x 5 www-data www-data 4096 Okt 22 18:35 ..
drwxr-xr-x 2 www-data www-data 4096 Okt 22 18:35 user_a
drwxr-xr-x 2 www-data www-data 4096 Okt 22 18:35 user_b
```
It is important that ``/srv/ftp/pnauw`` and everything below is owned by ``www-data:www-data`` (the user the apache process runs in) 
and that the permissions are exactly as indicated with **not giving write access** to the folders except for the very 
users folders ``user_a``, ``user_b``, etc. 

Of course, you need to fill in the actual user names you want to give access to the ftp server instead of the template names shown here.
### Adapt the configuration ###
Add the following to the end of ``\etc\vsftpd.conf``

```
# Allow anonymous FTP
anonymous_enable=YES
# Can write to the ftp server
write_enable=YES
# Even anonymous can write
anon_upload_enable=YES
# Chown for anonymous uploads to www-data 
chown_uploads=YES
chown_username=www-data
# The username for anonymous uploads
ftp_username=www-data
# Upload dir for anonymous uploads 
anon_root=/srv/ftp/pnauw
# Dir lists forbidden
dirlist_enable=NO
# Downloads forbidden
download_enable=NO
# If the upload failed, delete it
delete_failed_uploads=YES
```

Restart the service via ``sudo service vsftpd restart``

## Editing markdown (*.md) file ##
Use http://dillinger.io to verify the correctness of the syntax!
