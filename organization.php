<?php
try
{
$conn = new PDO('mysql:host='.DBHost.';dbname='.DBName.';charset='.DBCharset.';collation='.DBCollation.';prefix='.DBPrefix.'', DBUser, DBPass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $conn->prepare("SELECT * FROM tbl_organization LIMIT 1");
$stmt->execute();
$result = $stmt->fetchAll();
foreach($result as $row)
{
DEFINE('WBName', $row[0]);
DEFINE('WBEmail', $row[1]);
DEFINE('WBPhone', $row[2]);
DEFINE('WBPhoneAlt', $row[3]);
DEFINE('WBCity', $row[4]);
DEFINE('WBStreet', $row[5]);
DEFINE('WBCountry', $row[6]);
DEFINE('WBCurrency', $row[7]);
DEFINE('WBTimezone', $row[8]);
DEFINE('WBLogo', $row[9]);
DEFINE('WBIso', $row[10]);

DEFINE('Sidebar', $row[11]);
DEFINE('Header', $row[12]);
DEFINE('Sidebar_Pos', $row[13]);
DEFINE('Sidebar_Min', $row[14]);
DEFINE('MainContent', $row[15]);
DEFINE('PageHeader', $row[16]);
DEFINE('Theme', $row[17]);
date_default_timezone_set(WBTimezone);
}
}catch(PDOException $e)
{
}
?>
