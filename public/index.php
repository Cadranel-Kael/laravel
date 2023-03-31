<?php

define('BASE_PATH', __DIR__ . '/../');
require BASE_PATH . 'core/functions.php';


require base_path('vendor/autoload.php');
define('STYLES_CONFIG', require base_path("config/styles.php"));
define('ENV_FILE', base_path('env.local.ini'));

require base_path('router.php');
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

routeToController($path);
