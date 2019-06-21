<?php

return [
    'Getting Started' => [
        'url' => 'docs/getting-started',
        'children' => [
            'Background' => 'docs/back-sql-background',
			'Installing' => 'docs/installing',
			
			'Structure' => 'docs/structure',
            'Security' => 'docs/security',
			'Design' => 'docs/design',
			'Implementation Choices' => 'docs/implementation-choices',    
			'Passwords and Crypto' => 'docs/passwords-and-crypto'        
        ],
    ],
    'Notes' => [
        'url' => 'notes/notes-general',
        'children' => [
            'Embedded Example' => 'notes/embedded-example',
            'Adding LDAP to WordPress' => 'notes/adding-ldap-wordpress',
            'Building Example' => 'notes/building-example',
            'Using SQL Views Example' => 'notes/using-sql-views-example',

        ],
    ],
	
	'---' => '',
	
    'Credits and Sources' => [
        'url' => 'docs/credits-and-sources',
    ],
	
	' ---' => '',
	
    'OpenLDAP Home' => 'http://www.openldap.org/',
	'OpenLDAP Git' => 'https://openldap.org/devel/gitweb.cgi?p=openldap.git;a=summary',
];
