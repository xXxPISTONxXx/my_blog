<?php

$driver = 'mysql';
$host = 'sql203.epizy.com';
$db_name = 'xxx';
$db_user = 'xxx';
$db_pass = 'xxx';
$charset = 'utf8';
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC];

try {
    $pdo = new PDO(
        "$driver:host=$host;dbname=$db_name;charset=$charset", $db_user, $db_pass, $options
    );
} catch (PDOException $i) {
    die("Error while connecting to DB!");
}
