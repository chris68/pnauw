<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
	require(__DIR__ . '/params.php'),
	require(__DIR__ . '/params-local.php')
);

return [
	'id' => 'app-console',
	'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'gii'],
	'language' => 'en-US',
	'controllerNamespace' => 'console\controllers',
	'modules' => [
        'gii' => 'yii\gii\Module',
	],
	'components' => [
		'log' => [
			'targets' => [
				[
					'class' => 'yii\log\FileTarget',
					'levels' => ['error', 'warning'],
				],
			],
		],
		'authManager' => [
			'class' => 'yii\rbac\PhpManager',
            'itemFile' => '@common/data/items.php', 
            'assignmentFile' => '@common/data/assignments.php', 
			'ruleFile' => '@common/data/rules.php', 
		],
		'i18n' => [
			'translations' => [
				'yii' => [
					'class' => 'yii\i18n\PhpMessageSource',
					//'basePath' => $rootDir . '/vendor/yiisoft/yii2/yii/messages', // would actually be the correct base path - but yiisoft did not incorporate translations yet!
					'basePath' => '@common/messages', // the yii translations are currently in the common section of the application template
					'sourceLanguage' => 'en-US',
				],
				'common' => [
					'class' => 'yii\i18n\PhpMessageSource',
					'basePath' => '@common/messages',
					'sourceLanguage' => 'en-US',
				],
				// Currently no translations for console exist but if one needs them they should follow the usual pattern 
				//'base' => [
				//	'class' => 'yii\i18n\PhpMessageSource',
				//	'basePath' => '@app/messages',
				//	'sourceLanguage' => 'en-US',
				//],
			],
		],
	],
	'params' => $params,
];
