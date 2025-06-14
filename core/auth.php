<?php
session_start();
require_once('../db/config.php');
require_once('../const/uniques.php');

if (isset($_POST['submit'])) {
$_username = $_POST['username'];
$_password = $_POST['password'];
if (isset($_POST['remember']) && !empty($_POST['remember'])) {
$cookie_length = "20160";
}else{
$cookie_length = "1440";
}


try {
$conn = new PDO('mysql:host='.DBHost.';dbname='.DBName.';charset='.DBCharset.';collation='.DBCollation.';prefix='.DBPrefix.'', DBUser, DBPass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $conn->prepare("SELECT * FROM tbl_users WHERE email = ?");
$stmt->execute([$_username]);
$result = $stmt->fetchAll();

if (count($result) < 1) {
$_SESSION['reply'] = array (array("danger","Invalid login credentials"));
header("location:../");
}else{

foreach($result as $row)
{
$account_id = $row['id'];
$session_id = mb_strtoupper(get_rand_alphanumeric(20));
$ip =  $_SERVER['REMOTE_ADDR'];
$loc = $row['level'];
if ($row[10] == "0") {
$_SESSION['reply'] = array (array("danger","Your access is revoked"));
header("location:../");
}else{
if (password_verify($_password, $row[8])) {

$stmt = $conn->prepare("DELETE FROM tbl_login_sessions WHERE account = ?");
$stmt->execute([$account_id]);

$stmt = $conn->prepare("INSERT INTO tbl_login_sessions (sess_id, sess_ip, account) VALUES (?,?,?)");
$stmt->execute([$session_id, $ip, $account_id]);

setcookie("__insuarance__logged", "1", time() + (60 * $cookie_length), "/");
setcookie("__insuarance__key", $session_id, time() + (60 * $cookie_length), "/");

switch ($loc) {
case '0':
header("location:../admin?page=dashboard");
break;

case '1':
header("location:../staff?page=dashboard");
break;

default:
header("location:../user?page=dashboard");
}

}else{
$_SESSION['reply'] = array (array("danger","Invalid login credentials"));
header("location:../");
}
}
}


}

}catch(PDOException $e)
{
echo "Connection failed: " . $e->getMessage();
}

}else{
header("location:../");
}
?>
