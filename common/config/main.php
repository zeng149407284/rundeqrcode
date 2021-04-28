<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => array_merge([
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'formatter' =>  [
            'dateFormat' => 'php:Y-M-D H:i',
            'datetimeFormat' => 'php:Y-M-D H:i:s',
            'decimalSeparator' => ',',
            'thousandSeparator' => ' ',
            'currencyCode' => 'CHY',
            'nullDisplay' => '-',
        ],
    ], require "services.php")
];
