<?php

Yii::setAlias('common', realpath(__DIR__ . '/../'));
Yii::setAlias('frontend', realpath(__DIR__ . '/../../frontend'));
Yii::setAlias('backend', realpath(__DIR__ . '/../../backend'));
Yii::setAlias('console', realpath(__DIR__ . '/../../console'));

return [
	'adminEmail' => 'admin@example.com',
	'supportEmail' => 'support@example.com',

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
		'password' => 'mailwitch',
		'charset' => 'utf8',
	],
	'components.auth' => [
		'class' => 'common\components\RBACPhpManager',
		// @Todo: Fix after the bugfix for issue https://github.com/yiisoft/yii2/issues/1356 in Yii is done
		//'authFile' => '@common/data/rbac.php',
		'authFile' => realpath(__DIR__ . '/../').'/data/rbac.php',
		'defaultRoles' => ['guest'],
	],
];
