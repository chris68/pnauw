<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'pnauw',
    'basePath' => dirname(__DIR__),
    'language' => 'de',
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
        'markdown' => [
            // the module class
            'class' => 'kartik\markdown\Module',
            // whether to use PHP SmartyPants to process Markdown output
            'smartyPants' => false

        ],
    ],
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'as loginLogger' => [
                'class' => 'common\behaviors\ProtocolLogin',
                // ... property init values ...
            ],
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
        'authManager' => [
            'class' => 'yii\rbac\PhpManager',
            'itemFile' => '@common/data/items.php', 
            'assignmentFile' => '@common/data/assignments.php', 
            'ruleFile' => '@common/data/rules.php', 
            'defaultRoles' => ['admin','moderator','trusted','user','anonymous'],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],
        'i18n' => [
            'translations' => [
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
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'dateFormat' => 'yyyy-MM-dd',
//            'datetimeFormat' => 'yyyy-MM-dd H:i:s',
            //'timeFormat' => 'H:i:s',
        ],
        'assetManager' => [
            'linkAssets' => true,
            'appendTimestamp' => true,
        ],
    ],
    'params' => $params,
];
