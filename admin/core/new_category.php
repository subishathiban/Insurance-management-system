<?php
session_start();
require_once('../../db/config.php');

if (isset($_POST['submit'])) {
$name = ucwords($_POST['name']);
$status = $_POST['status'];

try {
$conn = new PDO('mysql:host='.DBHost.';dbname='.DBName.';charset='.DBCharset.';collation='.DBCollation.';prefix='.DBPrefix.'', DBUser, DBPass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $conn->prepare("SELECT * FROM tbl_insuarance_category WHERE name = ?");
$stmt->execute([$name]);
$result = $stmt->fetchAll();

if (count($result) > 0) {
$_SESSION['reply'] = array (array("danger",'Category "'.$name.'" is already registered'));
header("location:../?page=categories");
}else{
$stmt = $conn->prepare("INSERT INTO tbl_insuarance_category (name, status) VALUES (?,?)");
$stmt->execute([$name, $status]);
$_SESSION['reply'] = array (array("success",'Category "'.$name.'" registered successfully'));
header("location:../?page=categories");
}

}catch(PDOException $e)
{
echo "Connection failed: " . $e->getMessage();
}


}else{
header("location:../?page=dashboard");
}
?>
