<?php
session_start();
require_once('../../db/config.php');
require_once('../../const/organization.php');
require_once('../../const/check_session.php');

if (isset($_POST['submit'])) {
$fname = ucwords($_POST['fname']);
$lname = ucwords($_POST['lname']);
$gender = $_POST['gender'];
$phone = $_POST['phone'];
$email = $_POST['email'];

try {
$conn = new PDO('mysql:host='.DBHost.';dbname='.DBName.';charset='.DBCharset.';collation='.DBCollation.';prefix='.DBPrefix.'', DBUser, DBPass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$stmt = $conn->prepare("SELECT email FROM tbl_users WHERE email = ? AND id != ?");
$stmt->execute([$email, $account_id]);
$result = $stmt->fetchAll();

if (count($result) > 0) {
$_SESSION['retain'] = $_POST;
$_SESSION['reply'] = array (array("danger","Email is already registred"));
header("location:../?page=profile");
}else{

$stmt = $conn->prepare("UPDATE tbl_users SET first_name = ?, last_name = ?, gender = ?, phone = ?, email = ? WHERE id = ?");
$stmt->execute([$fname, $lname, $gender, $phone, $email, $account_id]);

$_SESSION['reply'] = array (array("success","Profile updated successfully"));
header("location:../?page=profile");

}

}catch(PDOException $e)
{
echo "Connection failed: " . $e->getMessage();
}

}else{
header("location:../?page=dashboard");
}
?>
