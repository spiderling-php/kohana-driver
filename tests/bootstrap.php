<?php

error_reporting(E_ALL ^ E_NOTICE);
require_once __DIR__.'/../vendor/autoload.php';

Kohana::$caching = false;
$_SERVER['HTTP_HOST'] = 'localhost';

Kohana::modules(['test-module' => __DIR__.'/module']);
Kohana::$environment = Kohana::TESTING;
