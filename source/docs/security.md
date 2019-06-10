---
title: back-sql Security
description: Security of back-sql 
extends: _layouts.documentation
section: content
---

# Overview

The security of LDAP is part of the text file side of the configuration and is the same as it would be using other backends.

See slapd.access(5) for the **full** details.  

## Defaults

Default setup is no ACLs which results in `access to * by * read` and full access by rootdn

This is too permissive and should be fixed.

## Example from [zytran](http://www.zytrax.com/books/ldap/ch5/step2.html) site about LDAP 

ACLs:
- ACL #1 - For password, users can write a new password, people can authenticate, IT can write it, and a deny all otherwise
- ACL #2 - For selected attributes, users can write them, HR can write them, and a deny all otherwise 
- ACL #3 - For everything that hasn't been defined above, users can write their own data, HR can write everyone's data, everyone can read each others and a deny all otherwise

```
# ACL1 
access to attrs=userpassword
       by self       write
       by anonymous  auth
       by group.exact="cn=itpeople,ou=groups,dc=example,dc=com"
                     write
       by *          none
# ACL2
access to attrs=carlicense,homepostaladdress,homephone
       by self       write
       by group.exact="cn=hrpeople,ou=groups,dc=example,dc=com"
                     write
       by *          none
# ACL3
access to *
       by self       write
       by group.exact="cn=hrpeople,ou=groups,dc=example,dc=com"
                     write
       by users      read
       by *          none
```

## Suggested 

For read only use scenarios: users should be able bind and read their own data, passwords should be used for auth, and a deny all otherwise.

```
# ACL1 
access to attrs=userpassword
       by anonymous  auth
       by *          none
# ACL2
access to *
       by self       read
       by users      read
       by *          none
```