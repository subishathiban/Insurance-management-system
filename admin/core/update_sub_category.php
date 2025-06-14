<?php
session_start();
require_once('../../db/config.php');

if (isset($_POST['submit'])) {
$name = ucwords($_POST['name']);
$category = $_POST['category'];
$status = $_POST['status'];
$id = $_POST['id'];

try {
$conn = new PDO('mysql:host='.DBHost.';dbname='.DBName.';charset='.DBCharset.';collation='.DBCollation.';prefix='.DBPrefix.'', DBUser, DBPass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $conn->prepare("SELECT * FROM tbl_insuarance_sub_category WHERE name = ? AND category = ? AND id != ?");
$stmt->execute([$name, $category, $id]);
$result = $stmt->fetchAll();

if (count($result) > 0) {
$_SESSION['reply'] = array (array("danger",'Sub-Category "'.$name.'" is already registered'));
header("location:../?page=sub-categories");
}else{
$stmt = $conn->prepare("UPDATE tbl_insuarance_sub_category SET category = ?, name = ?, status = ? WHERE id = ?");
$stmt->execute([$category, $name, $status, $id]);
$_SESSION['reply'] = array (array("success",'Sub-Category "'.$name.'" updated successfully'));
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
