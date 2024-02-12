<?php

require_once __DIR__ . '/../Conf/config.php';

try {
	$pdo = new PDO("$db_connection:host=$db_host;port=$db_port;dbname=$db_database", $db_username, $db_password);

	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	die($e->getMessage());
}
