<?php

$db = new mysqli('localhost', 'root', '', 'oophp');
//$db = new mysqli('localhost', 'root', 'secret', 'sandbox', '8080');

if($db->connect_error){
    $error = $db->connect_error;
}

$db->set_charset('utf8');