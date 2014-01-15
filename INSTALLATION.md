## Postgres ##
### Install postgis ###

To use postgis for Ubuntu 12.04 you must first install it manually.

Be sure that no old installation (e.g. version 1.5) exists before. If it does remove it via ``sudo apt-get remove postgresql-9.1-postgis``

Then install version 2.x from the ppa ubuntugis.

```
sudo apt-get install python-software-properties
sudo add-apt-repository ppa:ubuntugis/ppa
sudo apt-get update
sudo apt-get install postgresql-9.1-postgis
```
