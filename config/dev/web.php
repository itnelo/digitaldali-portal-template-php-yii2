<?php

return [
    'bootstrap' => ['log','debug','gii'],
    'components' => [
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
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@app/mail',
            'useFileTransport' => false,
        ],
    ],
    'params' => require(__DIR__ . '/params.php'),
    'modules' => [
        'debug' => [
            'class' => 'yii\debug\Module',
            'allowedIPs' => ['*']
        ],
        'gii' => [
            'class' => 'yii\gii\Module',
            'allowedIPs' => ['*']
        ],
    ]
];
