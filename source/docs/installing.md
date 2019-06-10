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

```
[ldap]
Description = MySQL Connector for LDAP
Driver = MySQL Unicode
Database = ldap
Server = 127.0.0.1
User = ldap
Password = ldap
Port = 3306
```

## Add database and import 




## Download, compile, and install OpenLDAP from source


