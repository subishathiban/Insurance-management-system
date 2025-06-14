<?php
session_start();
require_once('../../db/config.php');
if (isset($_POST['submit'])) {
$category = $_POST['category'];

try {
$conn = new PDO('mysql:host='.DBHost.';dbname='.DBName.';charset='.DBCharset.';collation='.DBCollation.';prefix='.DBPrefix.'', DBUser, DBPass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $conn->prepare("SELECT * FROM tbl_insuarance_sub_category WHERE category = ? AND status = '1'");
$stmt->execute([$category]);
$result = $stmt->fetchAll();

foreach($result as $row) {
?><option value="<?php echo $row[0]; ?>"><?php echo $row[2]; ?></option><?php
}

}catch(PDOException $e)
{
echo "Connection failed: " . $e->getMessage();
}

}
?>
