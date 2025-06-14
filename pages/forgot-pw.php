<?php
session_start();
require_once('db/config.php');
require_once('const/organization.php');
require_once('const/check_session.php');
if ($res == 1) {
switch ($level) {
case '0':
header("location:admin?page=dashboard");
break;

default:
header("location:user?page=dashboard");
}
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title><?php echo WBName; ?> - Forgot Password</title>
<meta name="description" content="Insurance Management System">
<meta name="author" content="Bwire Mashauri">
<link rel="icon" href="assets/media/favicons/favicon.ico" type="image/x-icon">

<link rel="stylesheet" id="css-main" href="assets/css/dashmix.min-5.4.css">
<?php if (Theme !== "") { print '<link rel="stylesheet" id="css-theme" href="assets/css/themes/'.Theme.'">'; } ?>
<link type="text/css" rel="stylesheet" href="assets/loader/waitMe.css">
</head>
<body>
<div id="page-container">
<main id="main-container">
<div class="bg-image">
<div class="row g-0 justify-content-center bg-primary-dark-op">
<div class="hero-static col-sm-8 col-md-6 col-xl-4 d-flex align-items-center p-2 px-sm-0">
<div class="block block-transparent block-rounded w-100 mb-0 overflow-hidden">
<div class="block-content block-content-full px-lg-5 px-xl-6 py-4 py-md-5 py-lg-6 bg-body-extra-light">
<div class="mb-2 text-center">
<img style="height:100px; width:100px; object-fit: cover !important; margin-bottom:20px;" src="assets/media/logo/<?php echo WBLogo; ?>" alt=""><br>
<a class="link-fx fw-bold fs-2" href="./">
<span class="text-primary"><?php echo WBName; ?></span>
</a>
<p class="text-uppercase fw-bold fs-sm text-muted">Insurance Management System</p>
</div>
<?php require_once('const/check-reply.php'); ?>
<form id="app_frm" method="POST" autocomplete="OFF" action="core/reset-pw">
<div class="mb-4">
<label class="form-label" for="example-text-input">Enter your email, you will receive a new password.</label>
<div class="input-group input-group-lg">

<input type="text" class="form-control form-control-alt"  required name="username" placeholder="Enter your email address">
<span class="input-group-text">
<i class="fa fa-user-circle"></i>
</span>
</div>
</div>

<div class="d-sm-flex justify-content-sm-between align-items-sm-center text-center text-sm-start mb-4">
<div class="fw-semibold fs-sm py-1">
<a href="./">Back to login</a>
</div>
</div>
<input type="hidden" name="submit" value="1">
<div class="text-center mb-2">
<button id="sub_btn" type="submit" class="btn btn-primary">
<i class="fa fa-fw fa-paper-plane opacity-50 me-1"></i> Reset Password
</button>
</div>
</form>
</div>

</div>
</div>
</div>
</div>
</main>
</div>
<script src="assets/js/dashmix.app.min-5.4.js"></script>
<script src="assets/js/lib/jquery.min.js"></script>
<script src="assets/loader/waitMe.js"></script>
<script src="assets/js/forms.js"></script>

</body>
</html>
