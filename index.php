<?php

define('VIEWS_PATH', $_SERVER['DOCUMENT_ROOT'] . '/views');
define('CONTROLLERS_PATH', $_SERVER['DOCUMENT_ROOT'] . '/controllers');
define('STYLES_CONFIG', require "./config/styles.php");
define('ENV_FILE', $_SERVER['DOCUMENT_ROOT'] . '/env.local.ini');

require './utils/functions.php';
require './database/Database.php';
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
require './router.php';

routeToController($path);
