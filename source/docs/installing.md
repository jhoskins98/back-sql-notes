---
title: Installing
description: Installing OpenLDAP and back-sql.
extends: _layouts.documentation
section: content
---

# Getting Started {#installing}

To use back-sql, you need to install OpenLDAP, your database and configure both to interact.  

## Install required software {#install-required-software}

Although most software is installed using packages, these instructions will walk through the installation process using the downloaded software.  In addition, a compatible database needs to be installedd.  The following instructions are based on apt and ubuntu but they may be easily translatable.


```
sudo apt update && sudo apt upgrade -y && sudo reboot
sudo apt install mysql-server unixodbc make gcc libmysqlclient-dev unixodbc-dev groff ldap-utils
```

### Add ODBC connector

Install ODBC connector to provide connectivity between OpenLDAP and MySQL. 


```
wget https://dev.mysql.com/get/Downloads/Connector-ODBC/8.0/mysql-connector-odbc-8.0.11-linux-ubuntu18.04-x86-64bit.tar.gz
tar -xvzf mysql-connector-odbc-8.0.11-linux-ubuntu18.04-x86-64bit.tar.gz
cd mysql-connector-odbc-*/
sudo cp lib/libmyodbc8* /usr/lib/x86_64-linux-gnu/odbc/
```


### create file /etc/odbcinst.ini

```
[MySQL Unicode]
Description = MySQL ODBC 8.0 Unicode Driver
Driver = /usr/lib/x86_64-linux-gnu/odbc/libmyodbc8w.so
Setup = /usr/lib/x86_64-linux-gnu/odbc/libmyodbc8S.so
FileUsage = 1

[MySQL ANSI]
Description = MySQL ODBC 8.0 ANSI Driver
Driver = /usr/lib/x86_64-linux-gnu/odbc/libmyodbc8a.so
Setup = /usr/lib/x86_64-linux-gnu/odbc/libmyodbc8S.so
FileUsage = 1
```

### edit /etc/odbc.ini

Note that the database, user and password should be set to match with the MySQL values 

**NOTE** - name between brackets has to match the dbname in the slapd.conf file (? don't know if the dbuser & dbpasswd are actually used)
```
[ldap]
Description = MySQL Connector for LDAP
Driver = MySQL Unicode
Database = ldap
Server = 127.0.0.1
User = ldap_user
Password = ldap_password
Port = 3306
```

## Add database and import 

On the MySQL server, add the database and grant the user access.  Note if you are using another source for data, then you may not need to create a separate database.

``` 
CREATE DATABASE ldap;
GRANT ALL PRIVILEGES ON ldap.* TO 'ldap_user'@'localhost' identified by 'ldap_password';
```

## Test connection

Test the database driver set

```
sudo echo "show databases" | isql -v ldap
```


## Download, compile, and install OpenLDAP from source

Compile OpenLDAP, although there are some packages for some distributions, not clear if they are up to date or not.

``` 
wget ftp://ftp.openldap.org/pub/OpenLDAP/openldap-release/openldap-2.4.46.tgz
tar -xvzf openldap-2.4.46.tgz
sudo mv openldap-2.4.46 /opt/openldap
cd /opt/openldap
sudo ./configure --prefix=/usr --exec-prefix=/usr --bindir=/usr/bin --sbindir=/usr/sbin --sysconfdir=/etc --datadir=/usr/share --localstatedir=/var --mandir=/usr/share/man --infodir=/usr/share/info --enable-sql --disable-bdb --disable-ndb --disable-hdb
sudo make depend
sudo make
sudo make install
```

After compiling, go into /etc/openldap and configure the slap.d file to conform to the database connection used by odbc.ini.

## Add the needed database tables and data

If you want to use the example ones 