<?php
require_once('../const/admin_dashboard.php');
?>
﻿<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title><?php echo WBName; ?> - Users</title>
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
Users
</h3>
</div>
<div class="block-content block-content-full">
<table class="table table-bordered table-vcenter js-dataTable-buttons">
<thead>
<tr>
<th>First Name</th>
<th>Last Name</th>
<th>Email</th>
<th>Gender</th>
<th>Phone</th>
<th>City</th>
<th>Street</th>
<th>Level</th>
<th style="width: 5%;">Status</th>
<th style="width: 5%;"></th>
</tr>
</thead>
<tbody>

<?php
try {
$conn = new PDO('mysql:host='.DBHost.';dbname='.DBName.';charset='.DBCharset.';collation='.DBCollation.';prefix='.DBPrefix.'', DBUser, DBPass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $conn->prepare("SELECT * FROM tbl_users WHERE level = '2' ORDER BY first_name");
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
<?php echo $row[2]; ?>
</td>
<td class="">
<?php echo $row[7]; ?>
</td>
<td class="">
<?php echo $row[3]; ?>
</td>
<td class="">
<?php echo $row[4]; ?>
</td>

<td class="">
<?php echo $row[5]; ?>
</td>
<td class="">
<?php echo $row[6]; ?>
</td>

<td class="">
<?php
switch ($row[9]) {
case '2':
?>User<?php
break;

default:
?>Staff<?php
}
?>
</td>

<td class=" text-center">
<?php
switch ($row[10]) {
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
<button onclick="set_user('<?php echo $row[0]; ?>','<?php echo $row[1]; ?>','<?php echo $row[2]; ?>','<?php echo $row[7]; ?>','<?php echo $row[3]; ?>','<?php echo $row[4]; ?>','<?php echo $row[10]; ?>','<?php echo $row[5]; ?>','<?php echo $row[6]; ?>');" type="button" class="btn btn-sm btn-alt-secondary js-bs-tooltip-enabled" data-bs-toggle="modal" data-bs-target="#modal-default-fadein2" data-bs-keyboard="false" data-bs-backdrop="static">
<i class="fa fa-pencil-alt"></i>
</button>
<a class="btn btn-sm btn-alt-secondary js-bs-tooltip-enabled" onclick="return confirm('Are you sure you want to delete <?php echo $row[1]; ?>?');" href="admin/core/drop-user?id=<?php echo $row[0]; ?>">
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

<div class="modal fade" id="modal-default-fadein2" tabindex="-1" role="dialog" aria-labelledby="modal-default-fadein2" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<form id="app_frm3" action="admin/core/update_user" method="POST" autocomplete="off">
<div class="modal-header">
<h5 class="modal-title">Edit User</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body pb-1">
<div class="row mb-2">
<label class="col-sm-4 col-form-label">First Name</label>
<div class="col-sm-8">
<input id="fname" name="fname" required type="text" class="form-control form-control-alt" placeholder="Enter first name">
</div>
</div>
<div class="row mb-2">
<label class="col-sm-4 col-form-label">Last Name</label>
<div class="col-sm-8">
<input id="lname" name="lname" required type="text" class="form-control form-control-alt" placeholder="Enter last name">
</div>
</div>
<div class="row mb-2">
<label class="col-sm-4 col-form-label">Email</label>
<div class="col-sm-8">
<input id="email" name="email" required type="email" class="form-control form-control-alt" placeholder="Enter email address">
</div>
</div>
<div class="row mb-2">
<label class="col-sm-4 col-form-label">Gender</label>
<div class="col-sm-8">
<select id="gender" name="gender" required class="form-control form-control-alt">
<option selected disabled value="">Choose</option>
<option value="Male">Male</option>
<option value="Female">Female</option>
</select>
</div>
</div>
<div class="row mb-2">
<label class="col-sm-4 col-form-label">Phone</label>
<div class="col-sm-8">
<input id="phone" name="phone" required type="text" class="form-control form-control-alt" placeholder="Enter mobile phone">
</div>
</div>

<div class="row mb-2">
<label class="col-sm-4 col-form-label">City</label>
<div class="col-sm-8">
<input id="city" name="city" required type="text" class="form-control form-control-alt" placeholder="Enter city">
</div>
</div>

<div class="row mb-2">
<label class="col-sm-4 col-form-label">Street</label>
<div class="col-sm-8">
<input id="street" name="street" required type="text" class="form-control form-control-alt" placeholder="Enter street">
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
<input id="user_id" type="hidden" name="id" value="">
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

function set_user(id, fname, lname, email, gender, phone, status, city, street) {
document.getElementById('user_id').value = id;
document.getElementById('fname').value = fname;
document.getElementById('lname').value = lname;
document.getElementById('email').value = email;
document.getElementById('gender').value = gender;
document.getElementById('phone').value = phone;
document.getElementById('status').value = status;
document.getElementById('city').value = city;
document.getElementById('street').value = street;
}
</script>
</body>
</html>
