<?php

require_once __DIR__ . '/Config/load.php';

require_once str_replace('Core', '', __DIR__) . 'vendor/autoload.php';


$kernel = new \Lawana\Kernel\Kernel();

$kernel->start();

