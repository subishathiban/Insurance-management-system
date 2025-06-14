<?php
session_start();
require_once('../../db/config.php');
require_once('../../const/check_session.php');

if ($res == 1 && $level == 0) {
if (isset($_GET['id'])) {
$id = $_GET['id'];

try {
$conn = new PDO('mysql:host='.DBHost.';dbname='.DBName.';charset='.DBCharset.';collation='.DBCollation.';prefix='.DBPrefix.'', DBUser, DBPass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $conn->prepare("DELETE FROM tbl_insuarance_sub_category WHERE id = ?");
$stmt->execute([$id]);

$_SESSION['reply'] = array (array("success",'Insurance sub-category deleted successfully'));
header("location:../?page=sub-categories");

}catch(PDOException $e)
{
echo "Connection failed: " . $e->getMessage();
}

}else{
header("location:../../");
}
}else{
header("location:../../");
}
?>
