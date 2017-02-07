<?php

$host = '';
$db 	= '';
$user = '';
$pass = '';

$conn = new PDO("mysql:host=$host;dbname=$db;charset=UTF8", $user, $pass,
    [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]
);

?>