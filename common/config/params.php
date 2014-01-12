<?php

Yii::setAlias('common', dirname(__DIR__));
Yii::setAlias('frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('console', dirname(dirname(__DIR__)) . '/console');

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

	'components.auth' => [
		'class' => 'common\components\RBACPhpManager',
		'authFile' => '@common/data/rbac.php',
		'defaultRoles' => ['guest'],
	],
];
