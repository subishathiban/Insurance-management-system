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

try {
$conn = new PDO('mysql:host='.DBHost.';dbname='.DBName.';charset='.DBCharset.';collation='.DBCollation.';prefix='.DBPrefix.'', DBUser, DBPass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $conn->prepare("SELECT * FROM tbl_insuarance_policy WHERE name = ?");
$stmt->execute([$pname]);
$result = $stmt->fetchAll();

if (count($result) > 0) {
$_SESSION['reply'] = array (array("danger",'Policy "'.$pname.'" is already registered'));
header("location:../?page=policy");
}else{
$stmt = $conn->prepare("INSERT INTO tbl_insuarance_policy (name, category, sub_category, sum_assured, premium, tenture) VALUES (?,?,?,?,?,?)");
$stmt->execute([$pname, $category, $subcategory, $sum_ass, $premium, $tenure]);
$_SESSION['reply'] = array (array("success",'Policy "'.$pname.'" registered successfully'));
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
