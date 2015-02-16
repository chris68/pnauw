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
    'bootstrap' => ['log', 'gii'],
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
        'urlManager' => [
            'baseUrl' => 'http://parke-nicht-auf-unseren-wegen.de/',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ]
    ],
    'params' => $params,
];
