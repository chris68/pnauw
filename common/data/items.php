<?php
return [
    'isObjectOwner' => [
        'type' => 2,
        'description' => 'Is the user the owner of the object?',
        'ruleName' => 'ObjectOwner',
    ],
    'user' => [
        'type' => 1,
        'description' => 'User',
        'ruleName' => 'UserRole',
        'children' => [
            'isObjectOwner',
        ],
    ],
    'anonymous' => [
        'type' => 1,
        'description' => 'Anonymous User',
        'ruleName' => 'UserRole',
        'children' => [
            'user',
        ],
    ],
    'canUploadFromServer' => [
        'type' => 2,
        'description' => 'Can the user upload from the server?',
    ],
    'trusted' => [
        'type' => 1,
        'description' => 'Trusted User',
        'ruleName' => 'UserRole',
        'children' => [
            'user',
            'canUploadFromServer',
        ],
    ],
    'moderator' => [
        'type' => 1,
        'description' => 'Moderator',
        'ruleName' => 'UserRole',
        'children' => [
            'trusted',
        ],
    ],
    'admin' => [
        'type' => 1,
        'description' => 'Administrator',
        'ruleName' => 'UserRole',
        'children' => [
            'moderator',
        ],
    ],
];
