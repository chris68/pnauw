<?php
return [
// @chris68
    'name' => 'Parke nicht auf unseren Wegen',
    'version' => '2.2.3',

    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];
