---
title: Embedded Example
description: OpenLDAP has an example file build in 
extends: _layouts.documentation
section: content
---

# Location

The embedded example is located within the overall 2.4 git repo for OpenLDAP.  

[Link](http://www.openldap.org/devel/gitweb.cgi?p=openldap.git;a=tree;f=servers/slapd/back-sql/rdbms_depend/mysql;h=a3e06c2d9f8f17dd1ef6a6b28057a7d02482bf23;hb=refs/heads/OPENLDAP_REL_ENG_2_4)


## Files and purpose

- slapd.conf - basic setup for slapd but lacks the default admin user and other features like ACLs.  Use mostly for sql database definitions.
- backsql_create.sql - needed structure for LDAP specific tables
- testdb_create.sql - needed structure for people, phones, etc. in example. **NOTE**: need to expand password field for use on other hash formats
- testdb_metadata.sql - two parts - objectClass and attributeType mapping & LDAP entries and secondary objectClass mappings
- testdb_data.sql - example data for ldap entries

The example provides a basic layout of three people within an organization.  With a couple of documents and one referral.  While this provides some basics, it is missing many of the features that we will demonstrate in our example.  

---

## Read the metadata file

This provides the clearest explanation of the overall process.

## How a person entry is built

In this example, a person exists first off as an entry in the `ldap_entries` table.  The entry gets its primary **objectClass** from the `oc_map_id` which points to the `inetOrgPerson` class.  

Additional data for the person is built using the `ldap_attr_mappings` table entries where the `oc_map_id` is 1, the value of `inetOrgPerson` class.  Which results in up to 6 values.  

## What is missing

The example does not show how groups or group membership would be built.  Most directories have both people as well as groups.  