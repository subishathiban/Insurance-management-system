<?php
session_start();
require_once('../db/config.php');
require_once('../const/uniques.php');

if (isset($_POST['submit'])) {
$id = get_rand_numbers(6);
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$gender = $_POST['gender'];
$phone = $_POST['phone'];
$city = $_POST['city'];
$street = $_POST['street'];
$email = $_POST['email'];
$pass = password_hash($_POST['password'], PASSWORD_DEFAULT);;


try {
$conn = new PDO('mysql:host='.DBHost.';dbname='.DBName.';charset='.DBCharset.';collation='.DBCollation.';prefix='.DBPrefix.'', DBUser, DBPass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $conn->prepare("SELECT * FROM tbl_users WHERE email = ?");
$stmt->execute([$email]);
$result = $stmt->fetchAll();

if (count($result) > 0) {
$_SESSION['reply'] = array (array("danger","Email address is used"));
header("location:../?page=onboard");
}else{
$stmt = $conn->prepare("INSERT INTO tbl_users (id, first_name, last_name, gender, phone, city, street, email, login) VALUES (?,?,?,?,?,?,?,?,?)");
$stmt->execute([$id, $fname, $lname, $gender, $phone, $city, $street, $email, $pass]);
$_SESSION['reply'] = array (array("success","Account created successfully"));
header("location:../?page=onboard");
}

}catch(PDOException $e)
{
echo "Connection failed: " . $e->getMessage();
}

}else{
header("location:../");
}
?>
