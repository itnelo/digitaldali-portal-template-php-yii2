<?php

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

$config_def = require(__DIR__ . '/../config/default/web.php');
$config_env = require(__DIR__ . '/../config/' . YII_ENV . '/web.php');

(new yii\web\Application(array_replace_recursive($config_def, $config_env)))->run();
