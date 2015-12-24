<?php

return [
    'components' => [
        'db' => require(__DIR__ . '/db.php'),
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@app/mail',
            'useFileTransport' => false,
            /*'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.mail.yahoo.com',
                'username' => 'digitaldali.test@yahoo.com',
                'password' => '3.141592',
                'port' => '587',
                'encryption' => 'tls',
            ]*/
        ],
    ],
    'params' => require(__DIR__ . '/params.php'),
];
