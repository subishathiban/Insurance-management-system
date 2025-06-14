<?php
session_start();
require_once('../../db/config.php');

if (isset($_POST['submit'])) {
$fname = ucwords($_POST['fname']);
$lname = ucwords($_POST['lname']);
$email = $_POST['email'];
$gender = $_POST['gender'];
$phone = $_POST['phone'];
$status = $_POST['status'];
$city = $_POST['city'];
$street = $_POST['street'];
$id = $_POST['id'];


try {
$conn = new PDO('mysql:host='.DBHost.';dbname='.DBName.';charset='.DBCharset.';collation='.DBCollation.';prefix='.DBPrefix.'', DBUser, DBPass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $conn->prepare("SELECT * FROM tbl_users WHERE email = ? AND id != ?");
$stmt->execute([$email, $id]);
$result = $stmt->fetchAll();

if (count($result) > 0) {
$_SESSION['reply'] = array (array("danger",'Email "'.$email.'" is used, please select another email'));
header("location:../?page=users");
}else{
$stmt = $conn->prepare("UPDATE tbl_users SET first_name = ?, last_name = ?, email = ?, gender = ?, phone = ?, city = ?, street = ?, status = ? WHERE id = ?");
$stmt->execute([$fname, $lname, $email, $gender, $phone, $city, $street, $status, $id]);
$_SESSION['reply'] = array (array("success",'User "'.$fname.' '.$lname.'" updated successfully'));
header("location:../?page=users");
}

}catch(PDOException $e)
{
echo "Connection failed: " . $e->getMessage();
}


}else{
header("location:../?page=dashboard");
}
?>
