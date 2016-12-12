<?php


$config = include_once 'settings.php';

$app = new \Slim\App($config);
include_once 'dependencies.php';

include_once 'routes.php';



$app->run();