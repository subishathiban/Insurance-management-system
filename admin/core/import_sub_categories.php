<?php
session_start();
require_once('../../db/config.php');
require_once('../../const/phpexcel/SimpleXLSX.php');

if (isset($_POST['submit'])) {

$file = $_FILES['file']['tmp_name'];
$st_rec = 0;
$un_successfully = 0;

try {
$conn = new PDO('mysql:host='.DBHost.';dbname='.DBName.';charset='.DBCharset.';collation='.DBCollation.';prefix='.DBPrefix.'', DBUser, DBPass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



if ( $xlsx = SimpleXLSX::parse($file) ) {
foreach( $xlsx->rows() as $r ) {

if ($st_rec == 0) {

}else{

$name = ucwords($r[0]);
$status = "1";
$category = $_POST['category'];

$stmt = $conn->prepare("SELECT * FROM tbl_insuarance_sub_category WHERE name = ? AND category = ?");
$stmt->execute([$name, $category]);
$result = $stmt->fetchAll();

if (count($result) > 0) {
}else{
$stmt = $conn->prepare("INSERT INTO tbl_insuarance_sub_category (category, name, status) VALUES (?,?,?)");
$stmt->execute([$category, $name, $status]);
}


}
$st_rec++;
}

$_SESSION['reply'] = array (array("success",'Sub-Category import completed'));
header("location:../?page=sub-categories");

} else {
echo SimpleXLSX::parseError();
}



}catch(PDOException $e)
{
echo "Connection failed: " . $e->getMessage();
}


}else{
header("location:../?page=dashboard");
}
?>
