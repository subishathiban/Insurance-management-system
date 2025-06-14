<?php
session_start();
require_once('../../db/config.php');
require_once('../../const/uniques.php');

if (isset($_POST['submit'])) {
$id = get_rand_numbers(4);
$fname = ucwords($_POST['fname']);
$lname = ucwords($_POST['lname']);
$email = $_POST['email'];
$gender = $_POST['gender'];
$phone = $_POST['phone'];
$pass = password_hash("@ims1234", PASSWORD_DEFAULT);
$level = "1";
$status = "0";


try {
$conn = new PDO('mysql:host='.DBHost.';dbname='.DBName.';charset='.DBCharset.';collation='.DBCollation.';prefix='.DBPrefix.'', DBUser, DBPass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $conn->prepare("SELECT * FROM tbl_users WHERE email = ?");
$stmt->execute([$email]);
$result = $stmt->fetchAll();

if (count($result) > 0) {
$_SESSION['reply'] = array (array("danger",'Email "'.$email.'" is used, please select another email'));
header("location:../?page=staff");
}else{
$stmt = $conn->prepare("INSERT INTO tbl_users (id, first_name, last_name, email, gender, phone, login, level, status) VALUES (?,?,?,?,?,?,?,?,?)");
$stmt->execute([$id, $fname, $lname, $email, $gender, $phone, $pass, $level, $status]);
$_SESSION['reply'] = array (array("success",'Staff "'.$fname.' '.$lname.'" registered successfully'));
header("location:../?page=staff");
}

}catch(PDOException $e)
{
echo "Connection failed: " . $e->getMessage();
}


}else{
header("location:../?page=dashboard");
}
?>
