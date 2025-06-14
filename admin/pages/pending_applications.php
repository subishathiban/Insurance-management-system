<?php
require_once('../const/admin_dashboard.php');
?>
﻿<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title><?php echo WBName; ?> - Pending Policy Holders</title>
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
Pending Policy Holders
</h3>
<a class="btn btn-sm btn-alt-secondary js-bs-tooltip-enabled" href="admin?page=applications">All</a>&nbsp;
<a class="btn btn-sm btn-alt-secondary js-bs-tooltip-enabled" href="admin?page=pending_applications">Pending</a>&nbsp;
<a class="btn btn-sm btn-alt-secondary js-bs-tooltip-enabled" href="admin?page=approved_applications">Approved</a>&nbsp;
<a class="btn btn-sm btn-alt-secondary js-bs-tooltip-enabled" href="admin?page=denied_applications">Denied</a>&nbsp;
</div>
<div class="block-content block-content-full">
<table class="table table-bordered table-vcenter js-dataTable-buttons">
<thead>
<tr>
<th>Policy Holder Name</th>
<th>Policy Holder Contact</th>
<th>Policy Name</th>
<th>Policy Category</th>
<th>Policy Sub-Category</th>
<th>Sum Assured</th>
<th>Premium</th>
<th>Tenure</th>
<th style="width: 5%;">Status</th>
<th style="width: 5%;"></th>
</tr>
</thead>
<tbody>

<?php
try {
$conn = new PDO('mysql:host='.DBHost.';dbname='.DBName.';charset='.DBCharset.';collation='.DBCollation.';prefix='.DBPrefix.'', DBUser, DBPass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $conn->prepare("SELECT * FROM tbl_policy_applications LEFT JOIN tbl_insuarance_policy ON tbl_policy_applications.policy_id = tbl_insuarance_policy.id LEFT JOIN tbl_insuarance_category ON tbl_insuarance_policy.category = tbl_insuarance_category.id LEFT JOIN tbl_insuarance_sub_category ON tbl_insuarance_policy.sub_category = tbl_insuarance_sub_category.id LEFT JOIN tbl_users ON tbl_policy_applications.member_id = tbl_users.id WHERE tbl_policy_applications.status = '0' ORDER BY tbl_policy_applications.id");
$stmt->execute();
$result = $stmt->fetchAll();

foreach($result as $row)
{
$months = $row[5];
?>
<tr>
<td class="">
<?php echo $row[25]; ?>   <?php echo $row[26]; ?>
</td>
<td class="">
<?php echo $row[28]; ?>
</td>
<td class="">
<?php echo $row[10]; ?>
</td>
<td class="">
<?php echo $row[18]; ?>
</td>
<td class="">
<?php echo $row[22]; ?>
</td>
<td class="" align="right">
<?php echo number_format($row[3]); ?> <?php echo WBCurrency; ?>
</td>
<td class="" align="right">
<?php echo number_format($row[4]); ?> <?php echo WBCurrency; ?>
</td>
<td class="">
<?php echo $row[5]; ?> Month(s)
</td>


<td class="" align="center">
<?php
$download = 0;
switch ($row[8]) {
case '0':
?><span class="badge bg-warning">Pending</span><?php
break;

case '2':
?><span class="badge bg-danger">Denied</span><?php
break;

case '1':
$active_date = $row[6];
$date=date_create($active_date);
date_add($date,date_interval_create_from_date_string("$months months"));
$new_d = date_format($date,"Y-m-d");

if (new DateTime() > new DateTime($new_d)) {
$download = 0;
?><span class="badge bg-danger">Expired</span><?php
} else {
$download = 1;
?><span class="badge bg-success">Active</span><?php
}

break;
}
?>
</td>


<td class=" text-center">
<?php
$download = 0;
switch ($row[8]) {
case '0':
?>

<div class="btn-group">

<a class="btn btn-sm btn-alt-success js-bs-tooltip-enabled" onclick="return confirm('Are you sure you want to approve policy?');" href="admin/core/approve_policy?id=<?php echo $row[0]; ?>&auth=<?php echo $row[1]; ?>&src=<?php echo $_GET['page']; ?>&tit=<?php echo $row[10]; ?>">
<i class="fa fa-check"></i>
</a>
&nbsp;
<a class="btn btn-sm btn-alt-danger js-bs-tooltip-enabled" onclick="return confirm('Are you sure you want to deny policy?');" href="admin/core/deny_policy?id=<?php echo $row[0]; ?>&auth=<?php echo $row[1]; ?>&src=<?php echo $_GET['page']; ?>&tit=<?php echo $row[10]; ?>">
<i class="fa fa-times"></i>
</a>
</div>

<?php
break;

case '2':


break;

case '1':
$active_date = $row[6];
$date=date_create($active_date);
date_add($date,date_interval_create_from_date_string("$months months"));
$new_d = date_format($date,"Y-m-d");

$expire__date = DateTime::createFromFormat('Y-m-d', $new_d);
$currentDate = new DateTime('now');
$interval = $currentDate->diff($expire__date);

if ( $interval->invert == 1 ) {
$download = 0;
?><span class="badge bg-danger">Expired</span><?php
}else{
$download = 1;
?>
<a class="btn btn-sm btn-alt-secondary js-bs-tooltip-enabled" href="admin/core/download-policy?id=<?php echo $row[0]; ?>">
Download
</a>
<?php
}
break;
}
?>
</td>
</tr>
<?php
}

}catch(PDOException $e)
{
echo "Connection failed: " . $e->getMessage();
}
?>



</tbody>
</table>
</div>
</div>
</div>

</main>

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
