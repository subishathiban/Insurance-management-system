<?php
session_start();
require_once('../../db/config.php');
require_once('../../const/organization.php');

if (isset($_POST['submit'])) {
$smtp_server = $_POST['mail_server'];
$smtp_username = $_POST['mail_username'];
$smtp_password = $_POST['mail_password'];
$smtp_conn_type = $_POST['mail_encryption'];
$smtp_conn_port = $_POST['mail_port'];

try {
$conn = new PDO('mysql:host='.DBHost.';dbname='.DBName.';charset='.DBCharset.';collation='.DBCollation.';prefix='.DBPrefix.'', DBUser, DBPass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $conn->prepare("UPDATE tbl_smtp SET server = ?, username = ?, password = ?, port = ?, security = ?");
$stmt->execute([$smtp_server, $smtp_username, $smtp_password, $smtp_conn_port, $smtp_conn_type]);
$_SESSION['reply'] = array (array("success","Mail settings updated"));
header("location:../?page=settings");

}catch(PDOException $e)
{
echo "Connection failed: " . $e->getMessage();
}

}else{
header("location:../?page=dashboard");
}
?>
