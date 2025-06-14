<?php

?>
﻿<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title><?php echo WBName; ?> - Insurance Policy</title>
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
Insurance Policy
</h3>
</div>
<div class="block-content block-content-full">
<table class="table table-bordered table-vcenter js-dataTable-buttons">
<thead>
<tr>
<th>Name</th>
<th>Category</th>
<th>Sub-Category</th>
<th>Sum Assured</th>
<th>Premium</th>
<th>Tenure</th>
<th style="width: 5%;">Status</th>
</tr>
</thead>
<tbody>

<?php
try {
$conn = new PDO('mysql:host='.DBHost.';dbname='.DBName.';charset='.DBCharset.';collation='.DBCollation.';prefix='.DBPrefix.'', DBUser, DBPass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $conn->prepare("SELECT * FROM tbl_insuarance_policy LEFT JOIN tbl_insuarance_category ON tbl_insuarance_policy.category = tbl_insuarance_category.id LEFT JOIN tbl_insuarance_sub_category ON tbl_insuarance_policy.sub_category = tbl_insuarance_sub_category.id ORDER BY tbl_insuarance_policy.name");
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


<td class=" text-center">
<?php
switch ($row[7]) {
case '1':
?><span class="badge bg-success">Active</span><?php
break;

default:
?><span class="badge bg-danger">Inactive</span><?php
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
<script>

$("#category").on("change", function(){
var category_id = $(this).val();
document.getElementById('subcategory').value = "";
$('#subcategory').find('option:not(:first)').remove();

$.ajax({
type: 'POST',
url: 'const/ajax/fetch_subcategories.php',
data: 'category=' + category_id + '&submit=1',
success: function (category_list) {
$('#subcategory').append(category_list);
}
});

}
);

$("#category2").on("change", function(){
var category_id = $(this).val();
document.getElementById('subcategory2').value = "";
$('#subcategory2').find('option:not(:first)').remove();

$.ajax({
type: 'POST',
url: 'const/ajax/fetch_subcategories.php',
data: 'category=' + category_id + '&submit=1',
success: function (category_list) {
$('#subcategory2').append(category_list);
}
});

}
);

function set_policy(id, name, category, sub_category, sum_assured, premium, tenture, status) {
document.getElementById('category2').value = category;
$('#subcategory2').find('option:not(:first)').remove();
$.ajax({
type: 'POST',
url: 'const/ajax/fetch_subcategories.php',
data: 'category=' + category + '&submit=1',
success: function (category_list) {
$('#subcategory2').append(category_list);
}
});

document.getElementById('subcategory2').value = sub_category;
document.getElementById('id').value = id;
document.getElementById('policy').value = name;
document.getElementById('sum').value = sum_assured;
document.getElementById('premium').value = premium;
document.getElementById('tenture').value = tenture;
document.getElementById('status').value = status;
}
</script>
</body>
</html>
