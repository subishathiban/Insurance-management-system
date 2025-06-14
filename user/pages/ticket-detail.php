<?php
if (isset($_GET['id'])) {
$ticket = $_GET['id'];

try {
$conn = new PDO('mysql:host='.DBHost.';dbname='.DBName.';charset='.DBCharset.';collation='.DBCollation.';prefix='.DBPrefix.'', DBUser, DBPass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $conn->prepare("SELECT * FROM tbl_tickets LEFT JOIN tbl_ticket_categories ON tbl_tickets.category = tbl_ticket_categories.id LEFT JOIN tbl_users ON tbl_tickets.assigned_to = tbl_users.id WHERE tbl_tickets.member_id = ? AND tbl_tickets.id = ? ORDER BY tbl_tickets.id");
$stmt->execute([$account_id, $ticket]);
$result = $stmt->fetchAll();

if (count($result) < 1) {
header("location:?page=history2");
}else{

foreach($result as $row)
{
$ticket_id = ''.$row[1].'-'.$row[0].'';
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
header("location:?page=history2");
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title><?php echo WBName; ?> - Submitted Tickets</title>
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
<div id="page-container" class="<?php echo Header; ?> <?php echo PageHeader; ?> <?php echo Header; ?> <?php echo MainContent; ?>">
<?php require_once('pages/main_nav.php'); ?>
</div>
</div>
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
<span class="">Assigned Staff : </span>
</td>
<td class="d-none d-sm-table-cell">
<span class="fs-sm text-muted"><?php echo $customer_name; ?></span>
</td>

</tr>
<tr>
<td>
<span class="">Customer Name : </span>
</td>
<td class="d-none d-sm-table-cell">
<span class="fs-sm text-muted"><?php echo $fname; ?> <?php echo $lname; ?></span>
</td>

</tr>
<tr>
<td>
<span class="">Customer Contact : </span>
</td>
<td class="d-none d-sm-table-cell">
<span class="fs-sm text-muted"><?php echo $phone; ?></span>
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
<a class="btn  disabled rounded-0 btn-primary me-1 mb-3">
<i class="fa fa-fw fa-message me-1"></i> Message Center
</a>
<?php
break;

case '1':
?>
<a target="_blank" href="user?page=message_center&id=<?php echo $ticket; ?>" class="btn rounded-0 btn-primary me-1 mb-3">
<i class="fa fa-fw fa-message me-1"></i> Message Center
</a>
<?php
break;

case '2':
?>
<a class="btn  disabled rounded-0 btn-primary me-1 mb-3">
<i class="fa fa-fw fa-message me-1"></i> Message Center
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
