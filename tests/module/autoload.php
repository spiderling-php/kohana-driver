<?php

error_reporting(E_ALL ^ E_NOTICE);
Kohana::$caching = false;
$_SERVER['HTTP_HOST'] = 'localhost';

Kohana::modules(['test-module' => __DIR__]);
