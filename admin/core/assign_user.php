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
$staff = $_POST['staff'];
$not = 'A staff was assigned on your ticket ('.$author.'-'.$id.'), he/she will keep in touch with you shortly.';

try {
$conn = new PDO('mysql:host='.DBHost.';dbname='.DBName.';charset='.DBCharset.';collation='.DBCollation.';prefix='.DBPrefix.'', DBUser, DBPass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $conn->prepare("UPDATE tbl_tickets SET assigned_to = ?, status = '1' WHERE id = ?");
$stmt->execute([$staff, $id]);

$stmt = $conn->prepare("INSERT INTO tbl_notifications (user, notification) VALUES (?,?)");
$stmt->execute([$author, $not]);

$_SESSION['reply'] = array (array("success",'Staff assigned successfully'));
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
