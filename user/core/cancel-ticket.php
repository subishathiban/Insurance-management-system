<?php
session_start();
require_once('../../db/config.php');
require_once('../../const/check_session.php');

if (isset($_GET['id'])) {
$ticket_id = $_GET['id'];;
try {
$conn = new PDO('mysql:host='.DBHost.';dbname='.DBName.';charset='.DBCharset.';collation='.DBCollation.';prefix='.DBPrefix.'', DBUser, DBPass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $conn->prepare("DELETE FROM tbl_tickets WHERE id = ? AND member_id = ? AND status = '0'");
$stmt->execute([$ticket_id, $account_id]);

$_SESSION['reply'] = array (array("success",'Ticket <strong>('.$account_id.'-'.$ticket_id.')</strong> cancelled successfully'));
header("location:../?page=history2");

}catch(PDOException $e)
{
echo "Connection failed: " . $e->getMessage();
}


}else{
header("location:../?page=dashboard");
}
?>
