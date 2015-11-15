<?php
// query() will return result set better for select and no problem with insert, update, or delete even
// exec() will return affected rows, better for insert, update and delete but will not return data on select
try {
    require_once 'includes/pdo_connect.php';
    $sql = 'INSERT INTO names (name, meaning, gender)
            VALUES ("William", "resolute guardian", "boy")';
    $result = $db->query($sql);
    echo $result->queryString;
} catch (Exception $e) {
    $error = $e->getMessage();
}
if (isset($error)) {
    echo $error;
}