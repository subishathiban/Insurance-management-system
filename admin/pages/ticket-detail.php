<?php
require_once('../const/admin_dashboard.php');

if (isset($_GET['id'])) {
$ticket = $_GET['id'];

try {
$conn = new PDO('mysql:host='.DBHost.';dbname='.DBName.';charset='.DBCharset.';collation='.DBCollation.';prefix='.DBPrefix.'', DBUser, DBPass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $conn->prepare("SELECT * FROM tbl_tickets LEFT JOIN tbl_ticket_categories ON tbl_tickets.category = tbl_ticket_categories.id LEFT JOIN tbl_users ON tbl_tickets.member_id = tbl_users.id WHERE tbl_tickets.id = ? ORDER BY tbl_tickets.id");
$stmt->execute([$ticket]);
$result = $stmt->fetchAll();

if (count($result) < 1) {
header("location:?page=tickets");
}else{

foreach($result as $row)
{
$ticket_id = ''.$row[1].'-'.$row[0].'';
$author = $row[1];
$customer_name = ''.$row[14].' '.$row[15].'';
$customer_contact = $row[17];
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
<title><?php echo WBName; ?> - Active Tickets</title>
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
<div id="page-container" class="sidebar-o <?php echo Header; ?> enable-page-overlay side-scroll <?php echo Sidebar; ?> <?php echo PageHeader; ?> <?php echo Sidebar_Min; ?> <?php echo Sidebar_Pos; ?> <?php echo Header; ?> <?php echo MainContent; ?>">
<?php require_once('main_nav.php'); ?>

<main id="main-container">

<div class="content">
<?php require_once('../const/check-reply.php'); ?>
<div class="block block-rounded">
<div class="block-header block-header-default">
<h3 class="block-title">
Ticket : <?php echo $ticket_id; ?> RE: <?php echo $ticket_subject; ?>
</h3>
</div>
<div class="block-content block-content-full">

<div class="block-content">
<div class="col-xl-12">
<div class="block block-rounded block-bordered block-mode-loading-refresh h-100 mb-0">
<div class="block-content">
<table class="table table-striped table-hover table-borderless table-vcenter fs-sm">
<tbody>
<tr>
<td>
<span class="">Customer Name : </span>
</td>
<td class="d-none d-sm-table-cell">
<span class="fs-sm text-muted"><?php echo $customer_name; ?></span>
</td>

</tr>
<tr>
<td>
<span class="">Customer Contact : </span>
</td>
<td class="d-none d-sm-table-cell">
<span class="fs-sm text-muted"><?php echo $customer_contact; ?></span>
</td>

</tr>
<tr>
<td>
<span class="">Ticket Category : </span>
</td>
<td class="d-none d-sm-table-cell">
<span class="fs-sm text-muted"><?php echo $ticket_category; ?></span>
</td>

</tr>
<tr>
<td>
<span class="">Ticket Subject : </span>
</td>
<td class="d-none d-sm-table-cell">
<span class="fs-sm text-muted"><?php echo $ticket_subject; ?></span>
</td>

</tr>
<tr>
<td>
<span class="">Ticket Description : </span>
</td>
<td class="d-none d-sm-table-cell">
<span class="fs-sm text-muted"><?php echo $ticket_description; ?></span>
</td>

</tr>
<tr>
<td>
<span class="">Ticket Status : </span>
</td>
<td class="d-none d-sm-table-cell">

<?php
switch ($st) {
case '0':
?><span class="badge bg-warning">Pending</span><?php
break;

case '1':
?><span class="badge bg-success">Active</span><?php
break;

case '2':
?><span class="badge bg-danger">Closed</span><?php
break;
}
?>
</td>

</tr>
<tr>
<td>
<span class="">Open Date : </span>
</td>
<td class="d-none d-sm-table-cell">
<span class="fs-sm text-muted"><?php echo $open_date; ?></span>
</td>

</tr>
<tr>
<td>
<span class="">Close Date : </span>
</td>
<td class="d-none d-sm-table-cell">
<span class="fs-sm text-muted"><?php echo $close_date; ?></span>
</td>

</tr>
<tr>
<td>
<span class="">Remark : </span>
</td>
<td class="d-none d-sm-table-cell">
<span class="fs-sm text-muted"><?php echo $remark; ?></span>
</td>

</tr>

</tbody>
</table>

<?php
switch ($st) {
case '0':
?>
<a class="btn  disabled rounded-0  btn-primary me-1 mb-3">
<i class="fa fa-fw fa-check me-1"></i> Remark and Close
</a>
<?php
break;

case '1':
?>
<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modal-default-fadein2" data-bs-keyboard="false" data-bs-backdrop="static" class="btn rounded-0  btn-primary me-1 mb-3">
<i class="fa fa-fw fa-check me-1"></i> Remark and Close
</a>
<?php
break;

case '2':
?>
<a class="btn  disabled rounded-0  btn-primary me-1 mb-3">
<i class="fa fa-fw fa-check me-1"></i> Remark and Close
</a>
<?php
break;
}
?>



</div>
</div>
</div>
</div>





</div>
</div>
</div>


</main>


<div class="modal fade" id="modal-default-fadein2" tabindex="-1" role="dialog" aria-labelledby="modal-default-fadein2" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
<div class="modal-content">
<form id="app_frm3" action="admin/core/add_remark" method="POST" autocomplete="off">
<div class="modal-header">
<h5 class="modal-title">Remark and Close Ticket</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body pb-1">

<div class="list-group push">
<a class="list-group-item list-group-item-action" href="javascript:void(0)">
<h5 class="fs-base mb-1">Add Remark</h5>
<textarea name="remark" rows="4"  required class="form-control form-control-alt" placeholder="Enter remark here"></textarea>
</a>
</div>

</div>
<input type="hidden" name="submit" value="1">
<input id="id" type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
<input id="author" type="hidden" name="author" value="<?php echo $author; ?>">
<input  type="hidden" name="src" value="<?php echo $_GET['page']; ?>">
<div class="modal-footer">
<button type="button" class="btn btn-alt-secondary" data-bs-dismiss="modal">Close</button>
<button id="sub_btn3" type="submit" class="btn  btn-primary">Save changes</button>
</div>
</form>
</div>
</div>
</div>
</div>
<script src="assets/js/lib/jquery.min.js"></script>
<script src="assets/js/dashmix.app.min-5.4.js"></script>
<script src="assets/loader/waitMe.js"></script>
<script src="assets/js/forms.js"></script>
<script src="assets/js/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="assets/js/plugins/datatables-bs5/js/dataTables.bootstrap5.min.js"></script>
<script src="assets/js/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/js/plugins/datatables-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
<script src="assets/js/plugins/datatables-buttons/dataTables.buttons.min.js"></script>
<script src="assets/js/plugins/datatables-buttons-bs5/js/buttons.bootstrap5.min.js"></script>
<script src="assets/js/plugins/datatables-buttons-jszip/jszip.min.js"></script>
<script src="assets/js/plugins/datatables-buttons-pdfmake/pdfmake.min.js"></script>
<script src="assets/js/plugins/datatables-buttons-pdfmake/vfs_fonts.js"></script>
<script src="assets/js/plugins/datatables-buttons/buttons.print.min.js"></script>
<script src="assets/js/plugins/datatables-buttons/buttons.html5.min.js"></script>
<script src="assets/js/pages/be_tables_datatables.min.js"></script>
<script src="assets/js/footer-mod.js"></script>
</body>
</html>
