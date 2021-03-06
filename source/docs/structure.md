---
title: back-sql Structure
description: Structure of back-sql 
extends: _layouts.documentation
section: content
---

# Overview

The normal setup of OpenLDAP consists of configuration files, setup files (normally ldif files) and imported structure & users (also ldif files). The back-sql uses configurations files, database setup files and structure & user database files. 

 

# Files

The `slapd.conf` file is the major point of configuration the database is specified as well as the ACLs.  The major parts of slap.d are database connection details, ACL rules, and root admin with password.

abridged file list
```
├── ldap.conf
├── schema
│   ├── README
│   ├── cosine.schema
│   ├── inetorgperson.schema
│   └── openldap.schema
├── slapd.conf
└── slapd.ldif
```


# Tables 

There are basically four tables that define the back-sql structure.  

## ldap_oc_mappings

This table maps `object classes` to implementation.  The main point is to tie a loaded schema to a database table and the stored procedures, if applicable.  

Notes from OpenLDAP:
```
--  id          a unique number identifying the objectClass
--  name        the name of the objectClass; it MUST match the name of an objectClass that is loaded in slapd's schema
--  keytbl      the name of the table that is referenced for the primary key of an entry
--  keycol      the name of the column in "keytbl" that contains the primary key of an entry; the pair "keytbl.keycol" uniquely identifies an entry of objectClass "id" 
```

Example:
```
insert into ldap_oc_mappings (id,name,keytbl,keycol,create_proc,delete_proc,expect_return)
  values (1,'inetOrgPerson','persons','id',NULL,NULL,0);
```

## ldap_attr_mappings

This table is used to map the attributes of a class to database entries.  

```
--  id      a unique number identifying the attribute   
--  oc_map_id   the value of "ldap_oc_mappings.id" that identifies the objectClass this attributeType is defined for
--  name        the name of the attributeType; it MUST match the name of an attributeType that is loaded in slapd's schema
--  sel_expr    the expression that is used to select this attribute (the "select <sel_expr> from ..." portion)
--  from_tbls   the expression that defines the table(s) this attribute is taken from (the "select ... from <from_tbls> where ..." portion)
--  join_where  the expression that defines the condition to select this attribute (the "select ... where <join_where> ..." portion)```
```
Example
```
insert into ldap_attr_mappings (id,oc_map_id,name,sel_expr,from_tbls,join_where,add_proc,delete_proc,param_order,expect_return)
   values (1,1,'cn',"concat(persons.name,' ',persons.surname)",'persons',NULL,NULL,NULL,3,0);
```

## ldap_entries

The table provides the first lookup of all entries in the implementation.  The `dn` is used to look up all the entries.  While `oc_attr_mappings` and `ldap_attr_mappings` are set before hand, `ldap_entries` can be changed after a system is in operation either by adding entries using LDAP or by adding entries using SQL.  

```
--  id          a unique number > 0 identifying the entry
--  dn          the DN of the entry, in "pretty" form
--  oc_map_id   the "ldap_oc_mappings.id" of the main objectClass of this entry (view it as the structuralObjectClass)
--  parent      the "ldap_entries.id" of the parent of this objectClass; 0 if it is the "suffix" of the database
--  keyval      the value of the "keytbl.keycol" defined for this objectClass
```


## ldap_entry_objclasses

This table provides secondary object classes for entries.  Not useful for our basic needs but would be used to provide deeper functionality.  

Columns in table
```
--  entry_id    the "ldap_entries.id" of the entry this objectClass value must be added
--  oc_name     the name of the objectClass; it MUST match the name of an objectClass that is loaded in slapd's schema
```

---

Full File list
```
├── ldap.conf
├── schema
│   ├── README
│   ├── collective.ldif
│   ├── collective.schema
│   ├── corba.ldif
│   ├── corba.schema
│   ├── core.ldif
│   ├── core.schema
│   ├── cosine.ldif
│   ├── cosine.schema
│   ├── duaconf.ldif
│   ├── duaconf.schema
│   ├── dyngroup.ldif
│   ├── dyngroup.schema
│   ├── inetorgperson.ldif
│   ├── inetorgperson.schema
│   ├── java.ldif
│   ├── java.schema
│   ├── misc.ldif
│   ├── misc.schema
│   ├── nis.ldif
│   ├── nis.schema
│   ├── openldap.ldif
│   ├── openldap.schema
│   ├── pmi.ldif
│   ├── pmi.schema
│   ├── ppolicy.ldif
│   └── ppolicy.schema
├── slapd.conf
└── slapd.ldif
```