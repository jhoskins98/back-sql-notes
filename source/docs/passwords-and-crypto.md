---
title: Passwords and Cypto
description: OpenLDAP passwords storage and cryptographic methods
extends: _layouts.documentation
section: content
---

# Overview

A quick note about passwords - The state of cryptography changes over time so password storage practices are updated as CPU & GPUs advance, flaws are found or attacks advanced.  The problem with OpenLDAP is that the supported algorithms has not kept pace.  It still allows password hashes that are too weak and support for stronger ones is not well documented.    

## Password storage

Normally, passwords are stored wihtin the userPassword attribute of a person object (and other objects).  

## Supported Algorithms 

OpenLDAP supports out of the box MD5, SMD5, SHA and SSHA.   There is notation in some places that LDAP or OpenLDAP supports others natively (**research needed**).  The format for the password field after hashing is {scheme}hash.  There are more specifics about the encoding, etc. but if you look at the stored values, you can see which scheme is being use.  


Currently used hash schemes according to 
prefix	Description	Algorithm reference
- {MD5}	MD-5 without salt	[RFC1321]
- {SMD5}	salted MD-5	[RFC1321]
- {SHA}	SHA-1 without salt	[FIPS-180-4]
- {SSHA}	salted SHA-1	[FIPS-180-4]
- {SHA256}	SHA-256 without salt	[FIPS-180-4]
- {SSHA256}	salted SHA-256	[FIPS-180-4]
- {SHA384}	SHA-384 without salt	[FIPS-180-4]
- {SSHA384}	salted SHA-384	[FIPS-180-4]
- {SHA512}	SHA-512 without salt	[FIPS-180-4]
- {SSHA512}	salted SHA-512	[FIPS-180-4]

## Using the Crypt Scheme

In addition to the native schemes, OpenLDAP provides the use of {crypt} scheme which allows the support of Operating System implemented cryptographic schemes.  And has a format of:

```
$<id>$<param>$<salt><hash>
```

The value of Scheme ID values are
- 1	MD5
- 2a	Blowfish / bcrypt
- 3	NTHASH
- 5	SHA-256
- 6	SHA-512

## Notes about Bcrypt

Bycrypt or Blowfish (although its derived from not exactly the same) was originally implemented with a error on certain platforms.  This error meant that the hashes produced were not 100% compatible with other implementations.  Please see versioning history section in the bcrypt entry of Wikipidea for a full explanation.  
OpenLDAP wants to use the designation of $2a$ rather than any of the other variants.  But since the hash itself is now the same on all the currently installed variants, the designation can be changed while reusing the hash.  

---


