## Php ##
Php >= 5.4 is required
### Further modules ###
The following modules are needed. Install/Activate them via

```
sudo apt-get install php-imagick
sudo phpenmod imagick

sudo apt-get install php-gd
sudo phpenmod gd
```
### php.ini ###
Add the following to the end of php.ini
```
[custom]
; Settings for pnauw
max_file_uploads = 50
post_max_size = 55M
upload_max_filesize = 10M
memory_limit = 128M
```
## Postgres ##
Postgres 9.5 is used.
### Install postgis ###
``sudo apt-get install postgresql-9.5-postgis-2.2``
## Migrate postgres ##
If you need to migrate postgres from e.g. 9.1 to 9.3 then make sure that postgis is installed first.

Then follow the instructions in http://nixmash.com/postgresql/upgrading-postgresql-9-1-to-9-3-in-ubuntu

Finally you need to fix the port for 9.3 again to listen to 5432 (it listens to 5433 after the install!)
## FTP ##
The ftp server ``vsftpd`` is best used for the ftp access.
### Install package ###
Install the package via ``sudo apt-get install vsftpd``
### Set up file structure ###
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
### Migrate file structure ###
Usually you will migrate it from another server:

```
# On the source server
cd /srv/ftp
sudo tar -cvzpf pnauw.tar.gz pnauw
```

```
# On the destination server
cd /srv/ftp
sudo scp mailwitch@mailwitch.com:/srv/ftp/pnauw.tar.gz /srv/ftp/.
sudo tar -xvzf /srv/ftp/pnauw.tar.gz
sudo rm pnauw.tar.gz
```

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

# SEE https://bugs.alpinelinux.org/issues/1607
seccomp_sandbox=0

```

Restart the service via ``sudo service vsftpd restart``

Check via ``sudo service vsftpd status`` the status.

If the server fails to start try to start it from command line via ``sudo /usr/sbin/vsftpd /etc/vsftpd.conf´´and check the error.

## ALPR ##
We use http://www.openalpr.com/ for the automatic licence plate recognition. 

Starting with Ubuntu 16.04 this was part of the distribution. See https://github.com/openalpr/openalpr/wiki/Compilation-instructions-(Ubuntu-Linux) for instruction on how to install it.

Starting with Ubuntu 18.04 the local alpr installation unfortunately no longer works. Therefore, the web api is used (see section oauth)
## Editing markdown (*.md) file ##
Use http://dillinger.io to verify the correctness of the syntax!
### OAUTH ###
The oauth file looks as follows. The <> has to be replaced by the respective credentials

```
[google]
clientId="<>"
clientSecret="<>"
[facebook]
clientId="<>"
clientSecret="<>"
[alpr]
; The secret key from the alpr api - not really oauth but in the same file....
secretKey="<>"
```

## Crontab ##
Edit the crontab (``via crontab -e``) and add
```
0 5 * * * { /home/mailwitch/pnauw/yii picture/purge-guest-users; /home/mailwitch/pnauw/yii picture/purge-pictures; }
```
The time should be well after the backup
