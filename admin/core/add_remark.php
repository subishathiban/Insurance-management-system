<?php
session_start();
require_once('../../db/config.php');
require_once('../../const/check_session.php');
require_once('../../const/organization.php');
if ($res == 1 && $level == 0) {
if (isset($_POST['submit'])) {
$id = $_POST['id'];
$src = $_POST['src'];
$author = $_POST['author'];
$close_date = date('Y-m-d');
$remark = $_POST['remark'];
$not = 'A remark was added on your ticket ('.$author.'-'.$id.')';

try {
$conn = new PDO('mysql:host='.DBHost.';dbname='.DBName.';charset='.DBCharset.';collation='.DBCollation.';prefix='.DBPrefix.'', DBUser, DBPass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $conn->prepare("UPDATE tbl_tickets SET close_date = ?, status = '2', remark = ? WHERE id = ?");
$stmt->execute([$close_date, $remark, $id]);

$stmt = $conn->prepare("INSERT INTO tbl_notifications (user, notification, ticket) VALUES (?,?,?)");
$stmt->execute([$author, $not, $id]);

if ($src == "ticket-detail") {
$_SESSION['reply'] = array (array("success",'Remark added successfully'));
header("location:../?page=ticket-detail&id=$id");
}else{
$_SESSION['reply'] = array (array("success",'Remark added successfully'));
header("location:../?page=$src");
}

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
