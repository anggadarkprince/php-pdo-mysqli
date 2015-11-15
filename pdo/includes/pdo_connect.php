<?php

$dsn = "mysql:host=localhost;dbname=oophp";
$dsn = "mysql:host=localhost;dbname=oophp;port=8080";
$dsn = "sqlite:C:/Users/Angga Ari Wijaya/PhpstormProjects/php-database/oophp.db";

try{
    $db = new PDO($dsn, 'root', '');
}
catch (PDOException $e){
    echo $e->getMessage();
}