<?php
session_start();
require_once('../../db/config.php');

if (isset($_POST['submit'])) {
$category = $_POST['category'];
$subcategory = $_POST['subcategory'];
$pname = ucwords($_POST['pname']);
$sum_ass = $_POST['sum_ass'];
$premium = $_POST['premium'];
$tenure = $_POST['tenure'];
$status = $_POST['status'];
$id = $_POST['id'];

try {
$conn = new PDO('mysql:host='.DBHost.';dbname='.DBName.';charset='.DBCharset.';collation='.DBCollation.';prefix='.DBPrefix.'', DBUser, DBPass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $conn->prepare("SELECT * FROM tbl_insuarance_policy WHERE name = ? AND id != ?");
$stmt->execute([$pname, $id]);
$result = $stmt->fetchAll();

if (count($result) > 0) {
$_SESSION['reply'] = array (array("danger",'Policy "'.$pname.'" is already registered'));
header("location:../?page=policy");
}else{
$stmt = $conn->prepare("UPDATE tbl_insuarance_policy SET name = ?, category = ?, sub_category = ?, sum_assured = ?, premium = ?, tenture = ?, status = ? WHERE id = ?");
$stmt->execute([$pname, $category, $subcategory, $sum_ass, $premium, $tenure, $status, $id]);
$_SESSION['reply'] = array (array("success",'Policy updated successfully'));
header("location:../?page=policy");
}

}catch(PDOException $e)
{
echo "Connection failed: " . $e->getMessage();
}


}else{
header("location:../?page=dashboard");
}
?>
