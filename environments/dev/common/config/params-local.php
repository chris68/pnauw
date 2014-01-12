<?php
return [
	'components.db' => [
		'class' => 'yii\db\Connection',
		'tablePrefix' => 'tbl_',
		'charset' => 'utf8',
		'dsn' => 'pgsql:host=localhost;dbname=pnauw_dev',
		'username' => 'mailwitch',
		// passwort does not matter since we use unix authentication; so just set it to the username
		'password' => 'mailwitch', 
	],
];
