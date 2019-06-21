---
title: Basic auth using Wordpress
description: Reuse wordpress users and bcrypt passwords
extends: _layouts.documentation
section: content
---

# Premise 

Wordpress has users and passwords and wouldn't it be great reuse it.  



## First hurdle - getting ldap entries working
 
The `ldap_entries` tables is difficult because it needs to have a list of all types of entries and provide a complete hierarchy. For us we need both, glue and users.  The glue provide the structure for the directory.  


Step 1 - Make a union of all the entry types using a view

```
  create view ldap_entries as 
  select * from glue_ldap_entries
  UNION
  SELECT * from ldap_wp_users;
```

Step 2 - Make your glue table and entries

```
create table glue_ldap_entries
(
    id integer unsigned not null primary key auto_increment,
    dn varchar(255) not null,
    oc_map_id integer unsigned not null references ldap_oc_mappings(id),
    parent int NOT NULL ,
    keyval int NOT NULL 
);
  
insert into glue_ldap_entries (id,dn,oc_map_id,parent,keyval)
    values (1,'dc=nova-labs,dc=org',3,0,1);
```

The `glue_ldap_entries` needs to be the same format as the `ldap_entries` table.  The single entry is the root of the directory, which might be needed for consistency and reference by the user entries.

Step 3 - Make a view for the WordPress users 

```
create view ldap_wp_users as select 
	ID + 1000 as id,
	concat("uid=", user_login, ",dc=nova-labs,dc=org") as dn,
	1 as oc_map_id,
	1 as parent,
	ID as keyval
	from wp_users;
```

We are going to add 1000 so that the ids set for the resulting view don't clash with our glue records.  


## Our next hurdle - mapping user data in `ldap_attr_mappings`

The password is the biggest one.  First, we need to map password so that they can be successfully reused.  

```
insert into ldap_oc_mappings (id,name,keytbl,keycol,create_proc,delete_proc,expect_return)
values (1,'inetOrgPerson','wp_users','ID',NULL,NULL,0);
```


```
insert into ldap_attr_mappings (id,oc_map_id,name,sel_expr,from_tbls,join_where,add_proc,delete_proc,param_order,expect_return)
values (1,1,'cn',"wp_users.user_nicename",'wp_users',NULL,NULL,NULL,3,0);

insert into ldap_attr_mappings (id,oc_map_id,name,sel_expr,from_tbls,join_where,add_proc,delete_proc,param_order,expect_return)
values (5,1,'userPassword','persons.password','wp_users','persons.password IS NOT NULL',NULL,NULL,3,0);
```
idea ----- make a view where we pull data from wp_usermeta

user_id - meta_key  -> first_name, last_name, nickname


## Last hurdle is to fix passwords

The plan is to use bcrypt since that is supposed by native PHP thus available to WordPress and is supported by `{crpyt}` scheme in OpenLDAP.  See the notes about bcrypt to understand about the need to change the $2y$ to $2a$.

```
select user_pass,
CASE
    WHEN SUBSTRING(user_pass, 1, 4) = '$2y$' THEN  CONCAT('$2a$', SUBSTRING(user_pass, 5))
    ELSE user_pass
END AS user_password
	from `wp_users_test`
```