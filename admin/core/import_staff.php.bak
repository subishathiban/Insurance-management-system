<?php
session_start();
require_once('../../db/config.php');
require_once('../../const/uniques.php');
require_once('../../const/phpexcel/SimpleXLSX.php');

if (isset($_POST['submit'])) {

$file = $_FILES['file']['tmp_name'];
$st_rec = 0;
$un_successfully = 0;

try {
$conn = new PDO('mysql:host='.DBHost.';dbname='.DBName.';charset='.DBCharset.';collation='.DBCollation.';prefix='.DBPrefix.'', DBUser, DBPass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



if ( $xlsx = SimpleXLSX::parse($file) ) {
foreach( $xlsx->rows() as $r ) {

if ($st_rec == 0) {

}else{
$id = get_rand_numbers(4);
$fname = ucwords($r[0]);
$lname = ucwords($r[1]);
$email = $r[2];
$gender = $r[3];
$phone = $r[4];
$pass = password_hash("@ims1234", PASSWORD_DEFAULT);
$level = "1";
$status = "0";

$stmt = $conn->prepare("SELECT * FROM tbl_users WHERE email = ?");
$stmt->execute([$email]);
$result = $stmt->fetchAll();

if (count($result) > 0) {
}else{
$stmt = $conn->prepare("INSERT INTO tbl_users (id, first_name, last_name, email, gender, phone, login, level, status) VALUES (?,?,?,?,?,?,?,?,?)");
$stmt->execute([$id, $fname, $lname, $email, $gender, $phone, $pass, $level, $status]);
}


}
$st_rec++;
}

$_SESSION['reply'] = array (array("success",'Staff import completed'));
header("location:../?page=staff");

} else {
echo SimpleXLSX::parseError();
}



}catch(PDOException $e)
{
echo "Connection failed: " . $e->getMessage();
}


}else{
header("location:../?page=dashboard");
}
?>
