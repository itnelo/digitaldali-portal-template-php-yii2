<?php

return [
    'name' => 'My Company',
    'id' => 'basic',
    'basePath' => dirname(__DIR__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR,
    'bootstrap' => ['log'],
    'language' => 'ru-RU',
    'sourceLanguage' => 'en-US',
    'components' => [
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<controller:\w+>' => '<controller>/index',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                '<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
            ],
        ],
        'i18n' => [
            'translations' => [
                'common*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                ],
                'user*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                ],
                'error*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                ],
                'yii' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                ]
            ],
        ],
        'request' => [
            'baseUrl' => '',
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'wlxlzzEZkW3Vu5TDbb3HrE27VAauzAKV',
        ],
        'session' => [
            'class' => 'yii\web\DbSession',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@app/mail',
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@dektrium/user/views' => '@app/modules/user/views'
                ],
            ],
        ],
    ],
    'params' => require(__DIR__ . '/params.php'),
    'modules' => [
        'user' => [
            'class' => 'dektrium\user\Module',
            'enableUnconfirmedLogin' => false,
            'admins' => ['itnelo@gmail.com'],
            'modelMap' => [
                'RegistrationForm' => 'app\modules\user\models\RegistrationForm',
                'LoginForm' => 'app\modules\user\models\LoginForm',
                'User' => 'app\modules\user\models\User',
                'Profile' => 'app\modules\user\models\Profile',
            ],
            'controllerMap' => [
                'registration' => 'app\modules\user\controllers\RegistrationController',
                'security' => 'app\modules\user\controllers\SecurityController',
                'settings' => 'app\modules\user\controllers\SettingsController'
            ],
        ],
        'rbac' => [
            'class' => 'dektrium\rbac\Module'
        ]
    ]
];
