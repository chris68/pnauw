<?php
return [
    'name' => 'Parke nicht auf unseren Wegen',
    'version' => '1.3.4',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];
