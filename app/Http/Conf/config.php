<?php
require_once __DIR__ . '/../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../..');
$dotenv->load();

require_once __DIR__ . '/env.php';
require_once __DIR__ . '/function.php';
