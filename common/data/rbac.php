<?php

use yii\rbac\Item;
use common\models\User;

return [
	// Guest is somenbody who is not logged in
	'guest' => [
		'type' => Item::TYPE_ROLE,
		'description' => \Yii::t('common', 'Guest'),
		'bizRule' => 'return Yii::$app->user->isGuest;',
		'data' => NULL,
	],
	// Checks whether the current user is the owner of the object
	'isObjectOwner' => [
		'type' => Item::TYPE_TASK,
		'description' => 'common', 'Is the user the owner of the object?',
		'bizRule' => 'return Yii::$app->user->id==$params["model"]->owner_id;',
		'data' => NULL,
	],
	// User is somebody who is logged in
	'user' => [
		'type' => Item::TYPE_ROLE,
		'description' => \Yii::t('common', 'User'),
		'bizRule' => NULL,
		'data' => NULL,
		'children' => [
			'guest',
			'isObjectOwner'
		],
	],
	// Anonymous user - will not be able to login another time
	'anonymous' => [
		'type' => Item::TYPE_ROLE,
		'description' => \Yii::t('common', 'Anonymous User'),
		'bizRule' => NULL,
		'data' => NULL,
		'children' => [
			'user',
		],
	],
	'trusted' => [
		'type' => Item::TYPE_ROLE,
		'description' => \Yii::t('common', 'Trusted User'),
		'bizRule' => NULL,
		'data' => NULL,
		'children' => [
			'user',
		],
	],
	'moderator' => [
		'type' => Item::TYPE_ROLE,
		'description' => \Yii::t('common', 'Moderator'),
		'bizRule' => NULL,
		'data' => NULL,
		'children' => [
			'trusted',
		],
	],
	'admin' => [
		'type' => Item::TYPE_ROLE,
		'description' => \Yii::t('common', 'Administrator'),
		'bizRule' => NULL,
		'data' => NULL,
		'children' => [
			'moderator',
		],
	],
	
	// Mapping from db roles to internal roles
	User::ROLE_USER => [
		'type' => Item::TYPE_ROLE,
		'description' => 'User (db)',
		'bizRule' => NULL,
		'data' => NULL,
		'children' => [
			'user',
		],
	],
	User::ROLE_ANONYMOUS => [
		'type' => Item::TYPE_ROLE,
		'description' => 'Anonymous User (db)',
		'bizRule' => NULL,
		'data' => NULL,
		'children' => [
			'anonymous',
		],
	],
	User::ROLE_TRUSTED => [
		'type' => Item::TYPE_ROLE,
		'description' => 'Trusted User (db)',
		'bizRule' => NULL,
		'data' => NULL,
		'children' => [
			'trusted',
		],
	],
	User::ROLE_MODERATOR => [
		'type' => Item::TYPE_ROLE,
		'description' => 'Moderator (db)',
		'bizRule' => NULL,
		'data' => NULL,
		'children' => [
			'moderator',
		],
	],
	User::ROLE_ADMIN => [
		'type' => Item::TYPE_ROLE,
		'description' => 'User (db)',
		'bizRule' => NULL,
		'data' => NULL,
		'children' => [
			'admin',
		],
	],
];
?>