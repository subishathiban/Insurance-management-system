<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title><?php echo WBName; ?> - Generate Ticket</title>
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
<div class="block block-rounded col-xl-6" style="margin:auto;"><?php require_once('../const/check-reply.php'); ?></div>
<div class="block block-rounded col-xl-6" style="margin:auto;">

<div class="block block-rounded ">
<div class="block-header block-header-default">
<h3 class="block-title">Generate Ticket</h3>
</div>

<div class="block-content mb-5">

<form id="app_frm" action="user/core/new_ticket" method="POST" autocomplete="off">
<div class="row mb-2">
<label class="col-sm-4 col-form-label">Category</label>
<div class="col-sm-8">
<select name="category" required class="form-control form-control-alt">
<option selected disabled value="">Choose</option>
<?php
try {
$conn = new PDO('mysql:host='.DBHost.';dbname='.DBName.';charset='.DBCharset.';collation='.DBCollation.';prefix='.DBPrefix.'', DBUser, DBPass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$stmt = $conn->prepare("SELECT * FROM tbl_ticket_categories WHERE status = '1' ORDER BY name");
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
<label class="col-sm-4 col-form-label">Subject</label>
<div class="col-sm-8">
<input name="subject" required type="text" class="form-control form-control-alt" placeholder="Enter ticket subject">
</div>
</div>
<div class="row mb-2">
<label class="col-sm-4 col-form-label">Description</label>
<div class="col-sm-8">
<textarea name="description" rows="7"  required class="form-control form-control-alt" placeholder="Enter ticket description here"></textarea>
</div>
</div>


<input type="hidden" name="submit" value="1">

<div class="row mb-4">
<label class="col-sm-4 col-form-label"></label>
<div class="col-sm-8">
<button id="sub_btn" type="submit" class="btn  btn-primary">Save changes</button>
</div>
</div>



</form>

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
