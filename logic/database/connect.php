<?php

$driver = 'mysql';
$host = 'sql203.epizy.com';
$db_name = 'epiz_29893294_ebanutii';
$db_user = 'epiz_29893294';
$db_pass = 'BCfHBrXbMtG8';
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