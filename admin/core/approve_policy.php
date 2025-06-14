<?php
session_start();
require_once('../../db/config.php');
require_once('../../const/check_session.php');
require_once('../../const/organization.php');

if ($res == 1 && $level == 0) {
if (isset($_GET['id'])) {
$tit = $_GET['tit'];
$id = $_GET['id'];
$author = $_GET['auth'];
$src = $_GET['src'];
$not = 'Your application for '.$tit.' policy have been approved.';

try {
$conn = new PDO('mysql:host='.DBHost.';dbname='.DBName.';charset='.DBCharset.';collation='.DBCollation.';prefix='.DBPrefix.'', DBUser, DBPass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $conn->prepare("UPDATE tbl_policy_applications SET approved_by = ?, status = '1' WHERE id = ?");
$stmt->execute([$account_id, $id]);

$stmt = $conn->prepare("INSERT INTO tbl_notifications (user, notification) VALUES (?,?)");
$stmt->execute([$author, $not]);

$_SESSION['reply'] = array (array("success",'Policy holder approved successfully'));
header("location:../?page=$src");

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
