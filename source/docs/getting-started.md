---
title: Getting Started with back-sql 
description: The steps to get started back-sql
extends: _layouts.documentation
section: content
---

# Getting Started {#getting-started}

To use back-sql, you need to install OpenLDAP, your database (either MySQL or MariaDB) and configure both to interact.  To effectively use back-sql, some knowledge of LDAP, its structure and use is required and not covered here.  

You can install with the example code that is part of the OpenLDAP repo.  This step is helpful to understand the overall back-sql environment before you start designing with it.

This is primarily focused on using existing data in a database to populate OpenLDAP with back-sql rather than just using back-sql as an alternative to the native BDB.  

## Understanding the Structure {#understanding-structure} 

The layout of the tables is straight forward but how you interact with those tables is a bit different than setups using `ldif` files.  
There are tables that hold the attribute and object class mappings.  The tables also hold structural elements (ou's for example) to link the overall LDAP together.  Finally, there are the individual LDAP entries and their attributes.    

## Design the LDAP

This section is the most subjective and will need enhancement in the future.  For each type of entry in the directory, a decision needs to be made on the data element for that entry type as well how to store it within the database tables.

## Implementation Choices

When implementing, the choice of how to get the data from its source to its use within your system come down to two ways - first, script a method to move data from its source to read-only data tables or map existing tables through views and Object Class mapping.  

## Hook to your system

And then Profit!
