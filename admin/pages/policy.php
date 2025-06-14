<?php
require_once('../const/admin_dashboard.php');
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
<button type="button" class="btn btn-sm btn-alt-secondary js-bs-tooltip-enabled" data-bs-toggle="modal" data-bs-target="#modal-default-fadein" data-bs-keyboard="false" data-bs-backdrop="static">
<i class="fa fa-plus"></i> New
</button>
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
<th style="width: 5%;"></th>
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


<td class="text-center">
<div class="btn-group">
<button onclick="set_policy('<?php echo $row[0]; ?>','<?php echo $row[1]; ?>','<?php echo $row[2]; ?>','<?php echo $row[3]; ?>','<?php echo $row[4]; ?>','<?php echo $row[5]; ?>','<?php echo $row[6]; ?>','<?php echo $row[7]; ?>');" type="button" class="btn btn-sm btn-alt-secondary js-bs-tooltip-enabled" data-bs-toggle="modal" data-bs-target="#modal-default-fadein2" data-bs-keyboard="false" data-bs-backdrop="static">
<i class="fa fa-pencil-alt"></i>
</button>
<a class="btn btn-sm btn-alt-secondary js-bs-tooltip-enabled" onclick="return confirm('Are you sure you want to delete <?php echo $row[1]; ?> ?');" href="admin/core/drop-policy?id=<?php echo $row[0]; ?>">
<i class="fa fa-trash-can"></i>
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

<div class="modal fade" id="modal-default-fadein" tabindex="-1" role="dialog" aria-labelledby="modal-default-fadein" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
<div class="modal-content">
<form id="app_frm" action="admin/core/new_policy" method="POST" autocomplete="off">
<div class="modal-header">
<h5 class="modal-title">New Insurance Policy</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body pb-1">
<div class="row mb-2">
<label class="col-sm-4 col-form-label">Category</label>
<div class="col-sm-8">
<select id="category" name="category" required class="form-control form-control-alt">
<option selected disabled value="">Choose</option>
<?php
try {
$conn = new PDO('mysql:host='.DBHost.';dbname='.DBName.';charset='.DBCharset.';collation='.DBCollation.';prefix='.DBPrefix.'', DBUser, DBPass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$stmt = $conn->prepare("SELECT * FROM tbl_insuarance_category WHERE status = '1'ORDER BY name");
$stmt->execute();
$result = $stmt->fetchAll();

foreach($result as $row)
{
?>
<option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>
<?php
}
}catch(PDOException $e)
{
echo "Connection failed: " . $e->getMessage();
}
?>
</select>
</div>
</div>

<div class="row mb-2">
<label class="col-sm-4 col-form-label">Sub-Category</label>
<div class="col-sm-8">
<select id="subcategory" name="subcategory" required class="form-control form-control-alt">
<option selected disabled value="">Choose</option>
</select>
</div>
</div>

<div class="row mb-2">
<label class="col-sm-4 col-form-label">Policy Name</label>
<div class="col-sm-8">
<input name="pname" required type="text" class="form-control form-control-alt" placeholder="Enter policy name">
</div>
</div>
<div class="row mb-2">
<label class="col-sm-4 col-form-label">Sum Assured (<?php echo WBCurrency; ?>)</label>
<div class="col-sm-8">
<input name="sum_ass" required type="number" class="form-control form-control-alt" placeholder="Enter sum assured in <?php echo WBCurrency; ?>">
</div>
</div>
<div class="row mb-2">
<label class="col-sm-4 col-form-label">Premium (<?php echo WBCurrency; ?>)</label>
<div class="col-sm-8">
<input name="premium" required type="number" class="form-control form-control-alt" placeholder="Enter premium in <?php echo WBCurrency; ?>">
</div>
</div>
<div class="row mb-2">
<label class="col-sm-4 col-form-label">Tenure (Months)</label>
<div class="col-sm-8">
<input name="tenure" required type="number" class="form-control form-control-alt" placeholder="Enter tenure in months">
</div>
</div>

</div>
<input type="hidden" name="submit" value="1">
<div class="modal-footer">
<button type="button" class="btn btn-alt-secondary" data-bs-dismiss="modal">Close</button>
<button id="sub_btn" type="submit" class="btn  btn-primary">Save changes</button>
</div>
</form>
</div>
</div>
</div>


<div class="modal fade" id="modal-default-fadein2" tabindex="-1" role="dialog" aria-labelledby="modal-default-fadein2" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
<div class="modal-content">
<form id="app_frm3" action="admin/core/update_policy" method="POST" autocomplete="off">
<div class="modal-header">
<h5 class="modal-title">Edit Insurance Policy</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body pb-1">
<div class="row mb-2">
<label class="col-sm-4 col-form-label">Category</label>
<div class="col-sm-8">
<select id="category2" name="category" required class="form-control form-control-alt">
<option selected disabled value="">Choose</option>
<?php
try {
$conn = new PDO('mysql:host='.DBHost.';dbname='.DBName.';charset='.DBCharset.';collation='.DBCollation.';prefix='.DBPrefix.'', DBUser, DBPass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$stmt = $conn->prepare("SELECT * FROM tbl_insuarance_category WHERE status = '1'ORDER BY name");
$stmt->execute();
$result = $stmt->fetchAll();

foreach($result as $row)
{
?>
<option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>
<?php
}
}catch(PDOException $e)
{
echo "Connection failed: " . $e->getMessage();
}
?>
</select>
</div>
</div>

<div class="row mb-2">
<label class="col-sm-4 col-form-label">Sub-Category</label>
<div class="col-sm-8">
<select id="subcategory2" name="subcategory" required class="form-control form-control-alt">
<option selected disabled value="">Choose</option>
</select>
</div>
</div>

<div class="row mb-2">
<label class="col-sm-4 col-form-label">Policy Name</label>
<div class="col-sm-8">
<input id="policy" name="pname" required type="text" class="form-control form-control-alt" placeholder="Enter policy name">
</div>
</div>
<div class="row mb-2">
<label class="col-sm-4 col-form-label">Sum Assured (<?php echo WBCurrency; ?>)</label>
<div class="col-sm-8">
<input id="sum" name="sum_ass" required type="number" class="form-control form-control-alt" placeholder="Enter sum assured in <?php echo WBCurrency; ?>">
</div>
</div>
<div class="row mb-2">
<label class="col-sm-4 col-form-label">Premium (<?php echo WBCurrency; ?>)</label>
<div class="col-sm-8">
<input id="premium" name="premium" required type="number" class="form-control form-control-alt" placeholder="Enter premium in <?php echo WBCurrency; ?>">
</div>
</div>
<div class="row mb-2">
<label class="col-sm-4 col-form-label">Tenure (Months)</label>
<div class="col-sm-8">
<input id="tenture" name="tenure" required type="number" class="form-control form-control-alt" placeholder="Enter tenure in months">
</div>
</div>

<div class="row mb-2">
<label class="col-sm-4 col-form-label">Status</label>
<div class="col-sm-8">
<select id="status" name="status" required class="form-control form-control-alt">
<option selected disabled value="">Choose</option>
<option value="1">Active</option>
<option value="0">Inactive</option>
</select>
</div>
</div>

</div>
<input type="hidden" name="submit" value="1">
<input id="id" type="hidden" name="id" value="">
<div class="modal-footer">
<button type="button" class="btn btn-alt-secondary" data-bs-dismiss="modal">Close</button>
<button id="sub_btn3" type="submit" class="btn  btn-primary">Save changes</button>
</div>
</form>
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
