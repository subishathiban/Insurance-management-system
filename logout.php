<?php
session_start();
require_once('db/config.php');
$session_key = $_COOKIE['__insuarance__key'];
setcookie("__insuarance__logged", "0", time() - 3600, '/');
setcookie("__insuarance__key", "0", time() - 3600, '/');

try {
$conn = new PDO('mysql:host='.DBHost.';dbname='.DBName.';charset='.DBCharset.';collation='.DBCollation.';prefix='.DBPrefix.'', DBUser, DBPass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $conn->prepare("DELETE FROM tbl_login_sessions WHERE sess_id = ?");
$stmt->execute([$session_key]);

$_SESSION['reply'] = array (array("success","Your have successfully logged out"));

}catch(PDOException $e)
{
echo "Connection failed: " . $e->getMessage();
}
header("location:./");
?>
