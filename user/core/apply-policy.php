<?php
session_start();
require_once('../../db/config.php');
require_once('../../const/check_session.php');
require_once('../../const/organization.php');

if (isset($_GET['id'])) {
$policy_id = $_GET['id'];
$app_id = time();
$active_date = date('Y-m-d');
try {
$conn = new PDO('mysql:host='.DBHost.';dbname='.DBName.';charset='.DBCharset.';collation='.DBCollation.';prefix='.DBPrefix.'', DBUser, DBPass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $conn->prepare("SELECT * FROM tbl_insuarance_policy WHERE id = ? AND status = '1'");
$stmt->execute([$policy_id]);
$result = $stmt->fetchAll();

if (count($result) < 1) {
$_SESSION['reply'] = array (array("danger",'Policy is not available'));
header("location:../?page=apply");
}else{

foreach ($result as $row) {
$sum_ass = $row[4];
$premium = $row[5];
$tenture = $row[6];
}

$stmt = $conn->prepare("INSERT INTO tbl_policy_applications (id, member_id, policy_id, sum_assured, premium, tenture, active_date) VALUES (?,?,?,?,?,?,?)");
$stmt->execute([$app_id, $account_id, $policy_id, $sum_ass, $premium, $tenture, $active_date]);
$_SESSION['reply'] = array (array("success",'You have successfully applied for insurance policy, your request is now await approval.'));
header("location:../?page=apply");
}

}catch(PDOException $e)
{
echo "Connection failed: " . $e->getMessage();
}


}else{
header("location:../?page=dashboard");
}
?>
