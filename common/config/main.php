<?php
return [
    'name' => 'Parke nicht auf unseren Wegen',
    'version' => '1.4.5',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];
