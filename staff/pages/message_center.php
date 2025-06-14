<?php
if (isset($_GET['id'])) {
$ticket = $_GET['id'];

try {
$conn = new PDO('mysql:host='.DBHost.';dbname='.DBName.';charset='.DBCharset.';collation='.DBCollation.';prefix='.DBPrefix.'', DBUser, DBPass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $conn->prepare("SELECT * FROM tbl_tickets LEFT JOIN tbl_ticket_categories ON tbl_tickets.category = tbl_ticket_categories.id LEFT JOIN tbl_users ON tbl_tickets.member_id = tbl_users.id WHERE tbl_tickets.assigned_to = ? AND tbl_tickets.id = ? ORDER BY tbl_tickets.id");
$stmt->execute([$account_id, $ticket]);
$result = $stmt->fetchAll();

if (count($result) < 1) {
header("location:?page=tickets");
}else{

foreach($result as $row)
{
$auth = $row[1];
$ticket_id = ''.$row[1].'-'.$row[0].'';
$customer_name = ''.$row[14].' '.$row[15].'';
$customer_contact = $row[17];
$customer_gender = $row[16];
$ticket_subject = $row[3];
$ticket_description = $row[4];
$ticket_category = $row[11];
$open_date = $row[5];
$close_date = $row[7];
$remark = $row[9];
$st = $row[8];
}
}

}catch(PDOException $e)
{
echo "Connection failed: " . $e->getMessage();
}

}else{
header("location:?page=tickets");
}
?>
﻿<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title><?php echo WBName; ?> - Message Center</title>
<meta name="description" content="Insurance Management System">
<meta name="author" content="Bwire Mashauri">
<base href="../">
<link rel="icon" href="assets/media/favicons/favicon.ico" type="image/x-icon">

<link rel="stylesheet" id="css-main" href="assets/css/dashmix.min-5.4.css">
<link rel="stylesheet" href="assets/js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="assets/js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css">
<link rel="stylesheet" href="assets/js/plugins/datatables-responsive-bs5/css/responsive.bootstrap5.min.css">
<link type="text/css" rel="stylesheet" href="assets/loader/waitMe.css">
<?php if (Theme !== "") { print '<link rel="stylesheet" id="css-theme" href="assets/css/themes/'.Theme.'">'; } ?>
</head>


<body>
<div id="page-container">

<main id="main-container">
<div class="block hero flex-column mb-0 bg-body-dark">
<div class="block-header w-100 bg-body-dark" style="min-height: 68px;">
<h3 class="block-title">
<img class="img-avatar img-avatar32" src="assets/media/avatars/<?php echo $customer_gender; ?>.png" alt="">
<a class="fs-sm  ms-2" href="javascript:void(0)"><?php echo $customer_name; ?></a>
</h3>
</div>
<div class="js-chat-messages block-content block-content-full text-break overflow-y-auto w-100 flex-grow-1 px-lg-8 px-xlg-10 bg-body" data-chat-id="5"></div>
<div class="block-content p-3 w-100 d-flex align-items-center bg-body-dark" style="min-height: 70px; height: 70px;">
<form id="app_frm2"  class="w-100" action="staff/core/add_message" method="POST" autocomplete="off">
<div class="input-group dropup">
<input type="hidden" name="submit" value="1">
<input type="hidden" name="ticket" value="<?php echo $ticket; ?>">
<input type="hidden" name="author" value="<?php echo $auth; ?>">
<input type="text" name="message" required class="form-control form-control-alt border-0 bg-transparent"  placeholder="Type a message..">
<button id="sub_btn2" type="submit" class="btn btn-link">
<i class="fab fa-telegram-plane opacity-50"></i>
<span class="d-none d-sm-inline ms-1 ">Send</span>
</button>
</div>
</form>
</div>
</div>
</main>
</div>
<script src="assets/js/dashmix.app.min-5.4.js"></script>
<script src="assets/js/pages/be_comp_chat.min.js"></script>
<script src="assets/js/lib/jquery.min.js"></script>
<script src="assets/loader/waitMe.js"></script>
<script src="assets/js/forms.js"></script>
<script>
Dashmix.onLoad(function(){
<?php
try {
$conn = new PDO('mysql:host='.DBHost.';dbname='.DBName.';charset='.DBCharset.';collation='.DBCollation.';prefix='.DBPrefix.'', DBUser, DBPass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $conn->prepare("SELECT * FROM tbl_tickets_replies WHERE ticket = ? ORDER BY id ASC");
$stmt->execute([$ticket]);
$result = $stmt->fetchAll();

foreach($result as $row)
{

$setEndDate1 = DateTime::createFromFormat('Y-m-d H:i:s A', $row[4]);
$setEndDate1 = $setEndDate1->format('M d, y h:i:s');
if ($row[2] == $account_id) {
?>
Chat.addHeader(5, '<?php echo $setEndDate1; ?>', 'self');
Chat.addMessage(5, '<?php echo $row[3]; ?>', 'self');
<?php
}else{
?>
Chat.addHeader(5, '<?php echo $setEndDate1; ?>');
Chat.addMessage(5, '<?php echo $row[3]; ?>');
<?php
}
}

}catch(PDOException $e)
{
echo "Connection failed: " . $e->getMessage();
}
?>


});
</script>
<?php
try {
$conn = new PDO('mysql:host='.DBHost.';dbname='.DBName.';charset='.DBCharset.';collation='.DBCollation.';prefix='.DBPrefix.'', DBUser, DBPass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $conn->prepare("UPDATE tbl_notifications SET status = '1' WHERE ticket = ? AND user = ?");
$stmt->execute([$ticket, $account_id]);

}catch(PDOException $e)
{
echo "Connection failed: " . $e->getMessage();
}
?>
</body>
</html>
