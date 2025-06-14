<?php
session_start();
require_once('../../db/config.php');
require_once('../../const/organization.php');

if (isset($_POST['submit'])) {
$org = $_POST['org'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$phone2 = $_POST['phone2'];
$country = $_POST['country'];
$city = $_POST['city'];
$street = $_POST['street'];
$currency = $_POST['currency'];
$timezone = $_POST['timezone'];
if($_FILES['logo']['name'] == "")  {

try {
$conn = new PDO('mysql:host='.DBHost.';dbname='.DBName.';charset='.DBCharset.';collation='.DBCollation.';prefix='.DBPrefix.'', DBUser, DBPass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $conn->prepare("UPDATE tbl_organization SET name = ?, email = ?, phone = ?, phone_alt = ?, city = ?, street = ?, country = ?, currency = ?, timezone = ?");
$stmt->execute([$org, $email, $phone, $phone2, $city, $street, $country, $currency, $timezone]);
$_SESSION['reply'] = array (array("success","Basic settings updated"));
header("location:../?page=settings");

}catch(PDOException $e)
{
echo "Connection failed: " . $e->getMessage();
}

}else{

$target_dir = "../../assets/media/logo/";
$target_file = $target_dir . basename($_FILES["logo"]["name"]);
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
$destn_file = 'logo_'.time().'.'.$imageFileType.'';
$destn_upload = $target_dir . $destn_file;

if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
$_SESSION['reply'] = array (array("warning","Only JPG, PNG and JPEG files are allowed"));
header("location:../?page=settings");

}else{

if (move_uploaded_file($_FILES["logo"]["tmp_name"], $destn_upload)) {
unlink('../../assets/media/logo/'.WBLogo.'');

try {
$conn = new PDO('mysql:host='.DBHost.';dbname='.DBName.';charset='.DBCharset.';collation='.DBCollation.';prefix='.DBPrefix.'', DBUser, DBPass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $conn->prepare("UPDATE tbl_organization SET name = ?, email = ?, phone = ?, phone_alt = ?, city = ?, street = ?, country = ?, currency = ?, timezone = ?, logo = ?");
$stmt->execute([$org, $email, $phone, $phone2, $city, $street, $country, $currency, $timezone, $destn_file]);
$_SESSION['reply'] = array (array("success","Basic settings updated"));
header("location:../?page=settings");

}catch(PDOException $e)
{
echo "Connection failed: " . $e->getMessage();
}

}else{
$_SESSION['reply'] = array (array("warning","An error occured while uploading image"));
header("location:../?page=settings");
}

}

}

}else{
header("location:../?page=dashboard");
}
?>
