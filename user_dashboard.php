<?php
try {
$conn = new PDO('mysql:host='.DBHost.';dbname='.DBName.';charset='.DBCharset.';collation='.DBCollation.';prefix='.DBPrefix.'', DBUser, DBPass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $conn->prepare("SELECT * FROM tbl_notifications WHERE user = ? AND status = '0'");
$stmt->execute([$account_id]);
$result = $stmt->fetchAll();
$notifications = count($result);

}catch(PDOException $e)
{
echo "Connection failed: " . $e->getMessage();
}

$pending_policy_holders = 0;
$active_policy_holders = 0;
$denied_policy_holders = 0;

$pending_tickets = 0;
$active_tickets = 0;
$closed_tickets = 0;

try {
$conn = new PDO('mysql:host='.DBHost.';dbname='.DBName.';charset='.DBCharset.';collation='.DBCollation.';prefix='.DBPrefix.'', DBUser, DBPass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $conn->prepare("SELECT * FROM tbl_policy_applications WHERE member_id = ?");
$stmt->execute([$account_id]);
$result = $stmt->fetchAll();
$policy_holders = count($result);

foreach ($result as $row) {
switch ($row[8]) {
case '0':
$pending_policy_holders++;
break;

case '1':
$active_policy_holders++;
break;

case '2':
$denied_policy_holders++;
break;
}
}


$stmt = $conn->prepare("SELECT * FROM tbl_tickets WHERE member_id = ?");
$stmt->execute([$account_id]);
$result = $stmt->fetchAll();
$tickets = count($result);

foreach ($result as $row) {
switch ($row[8]) {
case '0':
$pending_tickets++;
break;

case '1':
$active_tickets++;
break;

case '2':
$closed_tickets++;
break;
}
}
}catch(PDOException $e)
{
echo "Connection failed: " . $e->getMessage();
}
?>
