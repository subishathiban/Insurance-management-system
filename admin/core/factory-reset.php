<?php
session_start();
require_once('../../db/config.php');
require_once('../../const/organization.php');
require_once('../../const/check_session.php');

if ($res == 1 && $level == 0) {

$sidebar_color = "sidebar-dark";
$sidebar_position = "sidebar-l";
$sidebar_mode = "";
$header_color = "page-header-dark";
$header_mode = "page-header-fixed";
$body_content = "main-content-narrowed";
$theme = "xdream.min-5.7.css";

try {
$conn = new PDO('mysql:host='.DBHost.';dbname='.DBName.';charset='.DBCharset.';collation='.DBCollation.';prefix='.DBPrefix.'', DBUser, DBPass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $conn->prepare("UPDATE tbl_organization SET side_bar = ?, header = ?, sidebar_pos = ?, sidebar_min = ?, main_content = ?, page_header = ?, color_theme = ?");
$stmt->execute([$sidebar_color, $header_color, $sidebar_position, $sidebar_mode, $body_content, $header_mode, $theme]);
$_SESSION['reply'] = array (array("success","Theme and appearance updated"));
header("location:../?page=settings");

}catch(PDOException $e)
{
echo "Connection failed: " . $e->getMessage();
}

}else{
header("location:../../");
}
?>
