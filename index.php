<?php

define('VIEWS_PATH', $_SERVER['DOCUMENT_ROOT'] . '/views');
define('CONTROLLERS_PATH', $_SERVER['DOCUMENT_ROOT'] . '/controllers');
define('STYLES_CONFIG', require "./config/styles.php");

require './utils/functions.php';

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
require './router.php';

routeToController($path);
