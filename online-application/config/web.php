<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'layout' => 'base',
    'modules' => [
        'admin' => [
            'class' => 'app\modules\admin\Module',
            'layout' => 'admin',
        ],
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'tZLYf4OOwpRbV4-2D2Zr6ar9yzI4Xt-s',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass'   => 'app\models\User',
            'enableAutoLogin' => TRUE,
            'identityCookie'  => ['name' => '_identity-backend', 'httpOnly' => TRUE],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
        'db' => require(__DIR__ . '/db.php'),

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '/' => 'site/index',
                'home' => 'site/index',
                '<referral:\w+>' => 'site/index',
                'admin' => 'admin/site/login',
                'admin/login' => 'admin/site/login',
                'admin/settings' => 'admin/site/changepassword',
                'admin/logout' => 'admin/site/logout',
                'online-application' => 'site/vehicle',
                'online-application/<referral:\w+>' => 'site/vehicle',
                'submit-order' => 'site/finish',
                'validate-order' => 'site/validate',
                'privacy-policy' => 'site/privacy',
                'terms-and-conditions' => 'site/terms'
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
        'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        //'password' => 'Rq2#@5t(s^Z)&%p*q!J',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
