<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title><?php echo WBName; ?> - Ticket History</title>
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

<div class="block block-rounded">
<div class="block-header block-header-default">
<h3 class="block-title">Ticket History</h3>
</div>
<div class="block-content">
<table class="table table-bordered table-vcenter js-dataTable-buttons">
<thead>
<tr>
<th>Ticket ID</th>
<th>Category</th>
<th>Subject</th>
<th>Create Date</th>
<th style="width: 5%;">Status</th>
<th style="width: 5%;"></th>
</tr>
</thead>
<tbody>

<?php
try {
$conn = new PDO('mysql:host='.DBHost.';dbname='.DBName.';charset='.DBCharset.';collation='.DBCollation.';prefix='.DBPrefix.'', DBUser, DBPass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $conn->prepare("SELECT * FROM tbl_tickets LEFT JOIN tbl_ticket_categories ON tbl_tickets.category = tbl_ticket_categories.id WHERE tbl_tickets.member_id = ? ORDER BY tbl_tickets.id DESC");
$stmt->execute([$account_id]);
$result = $stmt->fetchAll();

foreach($result as $row)
{
?>
<tr>
<td class="">
<?php echo $account_id; ?>-<?php echo $row[0]; ?>
</td>
<td class="">
<?php echo $row[11]; ?>
</td>
<td class="">
<?php echo $row[3]; ?>
</td>
<td class="">
<?php echo $row[5]; ?>
</td>
<td class="" align="center">
<?php
switch ($row[8]) {
case '0':
?><span class="badge bg-warning">Submitted</span><?php
break;

case '1':
?><span class="badge bg-primary">Active</span><?php
break;

case '2':
?><span class="badge bg-success">Closed</span><?php
break;

}
?>
</td>


<td class="" align="center">
<?php
switch ($row[8]) {
case '0':
?>
<div class="btn-group">
<a onclick="return confirm('Cancel Ticket?');" class="btn btn-sm btn-alt-danger js-bs-tooltip-enabled" href="user/core/cancel-ticket?id=<?php echo $row[0]; ?>">
Cancel
</a>
</div>
<?php
break;

case '1':
?>
<div class="btn-group">
<a class="btn btn-sm btn-alt-primary js-bs-tooltip-enabled" href="user?page=ticket-detail&id=<?php echo $row[0]; ?>">
View
</a>
</div>
<?php
break;

case '2':

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
