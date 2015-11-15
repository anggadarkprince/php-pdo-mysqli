<?php
// query() will return result set better for select and no problem with insert, update, or delete even
// exec() will return affected rows, better for insert, update and delete but will not return data on select
try {
    require_once 'includes/pdo_connect.php';
    $sql = 'DELETE FROM names WHERE name = "William"';
    $affected = $db->exec($sql);
    echo $affected . ' records deleted.';
} catch (Exception $e) {
    $error = $e->getMessage();
}
if (isset($error)) {
    echo $error;
}