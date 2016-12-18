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
    'bootstrap' => ['log'],
// @chris68
    'language' => 'en-US',
    'controllerNamespace' => 'console\controllers',
    'components' => [
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],

// @chris68
        'authManager' => [
            'class' => 'yii\rbac\PhpManager',
            'itemFile' => '@common/data/items.php', 
            'assignmentFile' => '@common/data/assignments.php', 
            'ruleFile' => '@common/data/rules.php', 
        ],
        'i18n' => [
            'translations' => [
                'common' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                    'sourceLanguage' => 'en-US',
                ],
                // Currently no translations for console exist but if one needs them they should follow the usual pattern 
                //'base' => [
                //    'class' => 'yii\i18n\PhpMessageSource',
                //    'basePath' => '@app/messages',
                //    'sourceLanguage' => 'en-US',
                //],
            ],
        ],
    ],
    'params' => $params,
];
