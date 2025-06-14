<?php
session_start();
require_once('../../db/config.php');
require_once('../../const/check_session.php');
require_once('../../const/organization.php');
if ($res == 1 && $level == 2) {
if (isset($_POST['submit'])) {
$id = $_POST['ticket'];
$ticket_id = $_POST['ticket_id'];
$author = $_POST['author'];
$staff = $account_id;
$not = 'A message was added on ticket ('.$ticket_id.').';
$message = $_POST['message'];
$rep_date = date('Y-m-d h:i:d A');

try {
$conn = new PDO('mysql:host='.DBHost.';dbname='.DBName.';charset='.DBCharset.';collation='.DBCollation.';prefix='.DBPrefix.'', DBUser, DBPass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $conn->prepare("INSERT INTO tbl_tickets_replies (ticket, sender, reply, rep_date) VALUES (?,?,?,?)");
$stmt->execute([$id, $staff, $message, $rep_date]);


$stmt = $conn->prepare("INSERT INTO tbl_notifications (user, notification, ticket) VALUES (?,?,?)");
$stmt->execute([$author, $not, $id]);

header("location:../?page=message_center&id=$id");


}catch(PDOException $e)
{
echo "Connection failed: " . $e->getMessage();
}

}else{
header("location:../../");
}
}else{
header("location:../../");
}
?>
