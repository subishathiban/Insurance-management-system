<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title><?php echo WBName; ?> - Apply Insurance Policy</title>
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
<h3 class="block-title">Apply Insurance Policy</h3>
</div>
<div class="block-content">
<table class="table table-bordered table-vcenter js-dataTable-buttons">
<thead>
<tr>
<th>Name</th>
<th>Category</th>
<th>Sub-Category</th>
<th>Sum Assured</th>
<th>Premium</th>
<th>Tenture</th>
<th style="width: 5%;">Apply</th>
</tr>
</thead>
<tbody>

<?php
try {
$conn = new PDO('mysql:host='.DBHost.';dbname='.DBName.';charset='.DBCharset.';collation='.DBCollation.';prefix='.DBPrefix.'', DBUser, DBPass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $conn->prepare("SELECT * FROM tbl_insuarance_policy LEFT JOIN tbl_insuarance_category ON tbl_insuarance_policy.category = tbl_insuarance_category.id LEFT JOIN tbl_insuarance_sub_category ON tbl_insuarance_policy.sub_category = tbl_insuarance_sub_category.id WHERE tbl_insuarance_policy.status = '1' AND tbl_insuarance_category.status = '1' AND tbl_insuarance_sub_category.status = '1' ORDER BY tbl_insuarance_policy.name");
$stmt->execute();
$result = $stmt->fetchAll();

foreach($result as $row)
{
?>
<tr>
<td class="">
<?php echo $row[1]; ?>
</td>
<td class="">
<?php echo $row[9]; ?>
</td>
<td class="">
<?php echo $row[13]; ?>
</td>
<td class="" align="right">
<?php echo number_format($row[4]); ?> <?php echo WBCurrency; ?>
</td>
<td class="" align="right">
<?php echo number_format($row[5]); ?> <?php echo WBCurrency; ?>
</td>
<td class="">
<?php echo $row[6]; ?> Month(s)
</td>


<td class="text-center">
<div class="btn-group">
<a class="btn btn-sm btn-alt-secondary js-bs-tooltip-enabled" onclick="return confirm('Are you sure you want to apply?');" href="user/core/apply-policy?id=<?php echo $row[0]; ?>">
Apply
</a>
</div>
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
