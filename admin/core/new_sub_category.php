<?php
session_start();
require_once('../../db/config.php');

if (isset($_POST['submit'])) {
$name = ucwords($_POST['name']);
$category = $_POST['category'];
$status = $_POST['status'];

try {
$conn = new PDO('mysql:host='.DBHost.';dbname='.DBName.';charset='.DBCharset.';collation='.DBCollation.';prefix='.DBPrefix.'', DBUser, DBPass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $conn->prepare("SELECT * FROM tbl_insuarance_sub_category WHERE name = ? AND category = ?");
$stmt->execute([$name, $category]);
$result = $stmt->fetchAll();

if (count($result) > 0) {
$_SESSION['reply'] = array (array("danger",'Sub-Category "'.$name.'" is already registered'));
header("location:../?page=sub-categories");
}else{
$stmt = $conn->prepare("INSERT INTO tbl_insuarance_sub_category (category, name, status) VALUES (?,?,?)");
$stmt->execute([$category, $name, $status]);
$_SESSION['reply'] = array (array("success",'Sub-Category "'.$name.'" registered successfully'));
header("location:../?page=sub-categories");
}

}catch(PDOException $e)
{
echo "Connection failed: " . $e->getMessage();
}


}else{
header("location:../?page=dashboard");
}
?>
