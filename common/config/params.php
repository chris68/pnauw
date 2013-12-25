<?php

Yii::setAlias('common', realpath(__DIR__ . '/../'));
Yii::setAlias('frontend', realpath(__DIR__ . '/../../frontend'));
Yii::setAlias('backend', realpath(__DIR__ . '/../../backend'));
Yii::setAlias('console', realpath(__DIR__ . '/../../console'));

return [
	'adminEmail' => 'admin@parke-nicht-auf-diesen-wegen.de',
	'supportEmail' => 'support@parke-nicht-auf-diesen-wegen.de',
	'noreplyEmail' => 'noreply@parke-nicht-auf-diesen-wegen.de',
	'contactEmail' => 'gehwegvomgehweg@gmail.com',

	'components.cache' => [
		'class' => 'yii\caching\FileCache',
	],

	'components.mail' => [
		'class' => 'yii\swiftmailer\Mailer',
		'viewPath' => '@common/mails',
	],

	'components.db' => [
		'class' => 'yii\db\Connection',
		'dsn' => 'pgsql:host=localhost;dbname=pnauw',
		'tablePrefix' => 'tbl_',
		'username' => 'mailwitch',
		// passwort does not matter since we use unix authentication; so just set it to the username
		'password' => 'mailwitch', 
		'charset' => 'utf8',
	],
	'components.auth' => [
		'class' => 'common\components\RBACPhpManager',
		'authFile' => '@common/data/rbac.php',
		'defaultRoles' => ['guest'],
	],
];
