<?php
require_once('db/config.php'); // Adjust this path to the actual config file

try {
    $conn = new PDO('mysql:host='.DBHost.';dbname='.DBName.';charset='.DBCharset.';collation='.DBCollation.';prefix='.DBPrefix.'', DBUser, DBPass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Describe the table to get the structure
    $stmt = $conn->query('DESCRIBE tbl_organization');
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    print_r($result);

    // Update the WBName
    $stmt = $conn->prepare('UPDATE tbl_organization SET column_name = ? WHERE condition');
    $stmt->execute(['Subish Insurance Company']);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>
