<?php

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);

// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);  

//require_once(__DIR__ . '/../framework/yii.php');

echo __DIR__ ;
$scan = scandir('/var/www/');
foreach($scan as $file) {
//    if (!is_dir("myFolder/$file")) {
//       echo $file.' ';
//    }
   echo $file.' ';
}
// echo phpinfo();

require_once(__DIR__ . '/yii/framework/yii.php');

$config = require(__DIR__ . '/protected/config/main.php');

date_default_timezone_set('Asia/Kolkata');

Yii::createWebApplication($config)->run(); //Error or not
