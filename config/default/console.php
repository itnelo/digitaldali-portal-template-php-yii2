<?php

Yii::setAlias('@tests', dirname(__DIR__) . '/tests');

return [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR,
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'modules' => [],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'db' => require(__DIR__ . '/db.php'),
    ],
    'params' => require(__DIR__ . '/params.php'),
];
