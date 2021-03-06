<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@data'   => '@app/data'
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '8N6DSjcqQXt0-DWBvIfVhBHp7L_bV9kY',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        // 'errorHandler' => [
        //     'errorAction' => 'site/error',
        // ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            'rules' => [
                // 'GET playlist' => 'site/download',
                'GET file/<id:\d+>' => 'file/view',
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'entry',
                    'pluralize'=>false,
                    "extraPatterns" => 
                    [
                        "GET all" => "all",
                        "GET refresh" => "refresh",
                        "GET sync" => "sync",
                        "GET test" => "test",
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => 'playlist',
                    'pluralize'=>false,
                    "extraPatterns" => 
                    [
                        "GET <id:\d+>/entry" => "entry",
                        "GET <id:\d+>/noentry" => "noentry",
                    ]
                ],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'playlistentry','pluralize'=>false],
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
