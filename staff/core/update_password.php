<?php
session_start();
require_once('../../db/config.php');
require_once('../../const/organization.php');
require_once('../../const/check_session.php');

if (isset($_POST['submit'])) {
$cpassword = $_POST['cpassword'];
$npassword = password_hash($_POST['npassword'], PASSWORD_DEFAULT);

if (password_verify($cpassword, $login)) {

try {
$conn = new PDO('mysql:host='.DBHost.';dbname='.DBName.';charset='.DBCharset.';collation='.DBCollation.';prefix='.DBPrefix.'', DBUser, DBPass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $conn->prepare("UPDATE tbl_users SET login = ? WHERE id = ?");
$stmt->execute([$npassword, $account_id]);

$_SESSION['reply'] = array (array("success","Password updated successfully"));
header("location:../?page=profile");

}catch(PDOException $e)
{
echo "Connection failed: " . $e->getMessage();
}



}else{
$_SESSION['reply'] = array (array("warning","Current password is not correct"));
header("location:../?page=profile");
}

}else{
header("location:../?page=dashboard");
}
?>
