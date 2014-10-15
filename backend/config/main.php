<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
	require(__DIR__ . '/params.php'),
	require(__DIR__ . '/params-local.php')
);

return [
	'id' => 'app-backend',
	'basePath' => dirname(__DIR__),
	'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
	'modules' => [],
	'components' => [
		'user' => [
			'identityClass' => 'common\models\User',
			'enableAutoLogin' => true,
		],
		'log' => [
			'traceLevel' => YII_DEBUG ? 3 : 0,
			'targets' => [
				[
					'class' => 'yii\log\FileTarget',
					'levels' => ['error', 'warning'],
				],
			],
		],
		'errorHandler' => [
			'errorAction' => 'site/error',
		],
		'i18n' => [
			'translations' => [
				'yii' => [
					'class' => 'yii\i18n\PhpMessageSource',
					'basePath' => '@common/messages', // the yii translations are currently in the common section of the application template @todo: Move it to the correct location
					'sourceLanguage' => 'en-US',
				],
				'common' => [
					'class' => 'yii\i18n\PhpMessageSource',
					'basePath' => '@common/messages',
					'sourceLanguage' => 'en-US',
				],
				'base' => [
					'class' => 'yii\i18n\PhpMessageSource',
					'basePath' => '@app/messages',
					'sourceLanguage' => 'en-US',
				],
			],
		],
	],
	'params' => $params,
];
