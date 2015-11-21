<?php
try{
    require_once 'includes/mysqli_connect.php';
    $sql = "INSERT INTO names(name, meaning, gender) VALUES('William', 'resolute guardian', 'male')";
    $db->query($sql);
    echo "Row affected: ".$db->affected_rows."<br>";
    echo "Inserted ID: ".$db->insert_id;
}
catch(Exception $e){
    echo $e->getMessage();
}
$db->close();