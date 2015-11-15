<?php
try {
    require_once 'includes/pdo_connect.php';
    // throw error to exception
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT name, meaning, gender FROM name
            ORDER BY name';
    $result = $db->query($sql);
    $errorInfo = $db->errorInfo();
    if(isset($errorInfo[2]))
    print_r($errorInfo);
} catch (Exception $e) {
    $error = $e->getMessage();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>PDO: Error Messages</title>
    <link href="../styles/styles.css" rel="stylesheet" type="text/css">
</head>
<body>
<h1>PDO: Getting Error Messages</h1>
<?php if (isset($error)) {
    echo "<p>$error</p>";
}
?>
<table>
    <tr>
        <th>Name</th>
        <th>Meaning</th>
        <th>Gender</th>
    </tr>
    <?php while ($row = $result->fetch()) { ?>
    <tr>
        <td><?php echo $row['name']; ?></td>
        <td><?php echo $row['meaning']; ?></td>
        <td><?php echo $row['gender']; ?></td>
    </tr>
    <?php } ?>
</table>
</body>
</html>