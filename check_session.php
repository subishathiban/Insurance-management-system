<?php
if(!isset($_COOKIE["__insuarance__logged"])) {
$res = "0";
} else {

if(!isset($_COOKIE["__insuarance__key"])) {
$res = "0";
}else{
$session_key = $_COOKIE["__insuarance__key"];
$current_ip = $_SERVER['REMOTE_ADDR'];

try {
$conn = new PDO('mysql:host='.DBHost.';dbname='.DBName.';charset='.DBCharset.';collation='.DBCollation.';prefix='.DBPrefix.'', DBUser, DBPass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$stmt = $conn->prepare("SELECT * FROM tbl_login_sessions LEFT JOIN tbl_users ON tbl_users.id = tbl_login_sessions.account  WHERE tbl_login_sessions.sess_id = ? ");
$stmt->execute([$session_key]);
$result = $stmt->fetchAll();

if (count($result) < 1) {
$res = "0";
}else{
foreach($result as $row)
{
$session_ip = $row[1];
}

foreach($result as $row)
{
$session_ip = $row[1];
$account_id = $row[2];
$fname = $row[4];
$lname = $row[5];
$gender = $row[6];
$phone = $row[7];
$city = $row[8];
$street = $row[9];
$email = $row[10];
$login = $row[11];
$level = $row[12];
$status = $row[13];
}

if ($current_ip == $session_ip) {
if ($status == "1") {
$res = "1";
}else{
$res = "2";
}
}else{
$res = "2";
}

}

}catch(PDOException $e)
{
echo "Connection failed: " . $e->getMessage();
}

}
}
?>
