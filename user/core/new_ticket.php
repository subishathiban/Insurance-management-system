<?php
session_start();
require_once('../../db/config.php');
require_once('../../const/check_session.php');
require_once('../../const/organization.php');

if (isset($_POST['submit'])) {
$category = $_POST['category'];
$subject = $_POST['subject'];
$description = $_POST['description'];
$open_date = date('Y-m-d');

try {
$conn = new PDO('mysql:host='.DBHost.';dbname='.DBName.';charset='.DBCharset.';collation='.DBCollation.';prefix='.DBPrefix.'', DBUser, DBPass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $conn->prepare("INSERT INTO tbl_tickets (member_id, category, subject, ticket_description, open_date) VALUES (?,?,?,?,?)");
$stmt->execute([$account_id, $category, $subject, $description, $open_date]);
$_SESSION['reply'] = array (array("success",'You have successfully create a ticket.'));
header("location:../?page=generate");

}catch(PDOException $e)
{
echo "Connection failed: " . $e->getMessage();
}


}else{
header("location:../?page=dashboard");
}
?>
