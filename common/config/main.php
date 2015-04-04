<?php
return [
    'name' => 'Parke nicht auf unseren Wegen',
    'version' => '1.2.2',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];
