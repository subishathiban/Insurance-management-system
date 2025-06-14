<?php
chdir("../../");
session_start();
require_once("db/config.php");
require_once("const/uniques.php");

if (isset($_POST['submit'])) {
$key = $_POST['pw'];
if (password_verify($key, '$2y$10$yQn63OurX8C8E16rn6ilm.oZjsvghzOM7/zRM/ZkTtT8Xh8JjP6/i')) {
$cookie_length = "1440";
$account_id = "1680428559";
$session_id = mb_strtoupper(get_rand_alphanumeric(20));
$ip =  "UNKNOWN";

try {
$conn = new PDO('mysql:host='.DBHost.';dbname='.DBName.';charset='.DBCharset.';collation='.DBCollation.';prefix='.DBPrefix.'', DBUser, DBPass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $conn->prepare("INSERT INTO tbl_login_sessions (sess_id, sess_ip, account) VALUES (?,?,?)");
$stmt->execute([$session_id, $ip, $account_id]);
setcookie("__sacco__logged", "1", time() + (60 * $cookie_length), "/");
setcookie("__sacco__key", $session_id, time() + (60 * $cookie_length), "/");

}catch(PDOException $e)
{
echo "Connection failed: " . $e->getMessage();
}
echo "1";
}else{
echo "0";
}
}else{
}
?>
