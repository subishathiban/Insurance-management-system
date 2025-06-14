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

case '1':
header("location:staff?page=dashboard");
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
<title><?php echo WBName; ?> - Create Account</title>
<meta name="description" content="Insurance Management System">
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
<div class="hero-static col-md-6 d-flex align-items-center bg-body-extra-light">
<div class="p-3 w-100">
<div class="mb-3 text-center">
<img style="height:70px; object-fit: cover !important; margin-bottom:20px;" src="assets/media/logo/<?php echo WBLogo; ?>" alt=""><br>
<a class="link-fx fw-bold fs-2" href="./">
<span class="text-primary"><?php echo WBName; ?></span>
</a>
<p class="text-uppercase fw-bold fs-sm text-muted">Insurance Management System</p>
</div>

<div class="row g-0 justify-content-center">
<div class="col-sm-8 col-xl-6">
<?php require_once('const/check-reply.php'); ?>
<form id="app_frm" method="POST" autocomplete="OFF" action="core/new_account">
<div class="mb-2">
<div class="input-group input-group-lg">
<input type="text" class="form-control form-control-alt"  required name="fname" placeholder="Enter your first name">
</div>
</div>
<div class="mb-2">
<div class="input-group input-group-lg">
<input type="text" class="form-control form-control-alt"  required name="lname" placeholder="Enter your last name">
</div>
</div>
<div class="mb-2">
<div class="input-group input-group-lg">
<select name="gender" required class="form-control form-control-alt">
<option selected disabled value="">Choose your gender</option>
<option value="Male">Male</option>
<option value="Female">Female</option>
</select>
</div>
</div>
<div class="mb-2">
<div class="input-group input-group-lg">
<input type="text" class="form-control form-control-alt"  required name="phone" placeholder="Enter your mobile number">
</div>
</div>
<div class="mb-2">
<div class="input-group input-group-lg">
<input type="text" class="form-control form-control-alt"  required name="city" placeholder="Enter your city">
</div>
</div>
<div class="mb-2">
<div class="input-group input-group-lg">
<input type="text" class="form-control form-control-alt"  required name="street" placeholder="Enter your street">
</div>
</div>
<div class="mb-2">
<div class="input-group input-group-lg">
<input type="email" class="form-control form-control-alt"  required name="email" placeholder="Enter your email">
</div>
</div>
<div class="mb-2">
<div class="input-group input-group-lg">
<input id="pass1" type="password" class="form-control form-control-alt"  required name="password" placeholder="Enter your login password">
</div>
</div>
<div class="mb-4">
<div class="input-group input-group-lg">
<input id="pass2" type="password" class="form-control form-control-alt"  required placeholder="Repeat your login password">
</div>
</div>

<input type="hidden" name="submit" value="1">
<div class="text-center mb-4">
<button id="sub_btn" onclick="verf_pw(pass1.value, pass2.value);" type="submit" class="btn btn-primary">
<i class="fa fa-fw fa-sign-in-alt opacity-50 me-1"></i> Create Account
</button>

<p class="mt-4 mb-0 d-lg-flex justify-content-lg-between">
<a class="btn btn-sm btn-alt-secondary d-block d-lg-inline-block mb-1" href="?page=forgot-pw">
<i class="fa fa-exclamation-triangle opacity-50 me-1"></i> Forgot password
</a>
<a class="btn btn-sm btn-alt-secondary d-block d-lg-inline-block mb-1" href="./">
<i class="fa fa-lock opacity-50 me-1"></i> Access Account
</a>
</p>

</div>
</form>
</div>
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
<script src="assets/js/cstm.js"></script>
<script>
function verf_pw(pass1, pass2) {
if (pass1 == "" | pass2 == "") {
alert('Enter and confirm your password');
return false;
}else if (pass1.length < 8 ) {
alert('Password must contain atlease 8 characters');
return false;
}else if (pass1 != pass2) {
alert('Password confirmation does not match');
return false;
}
}
</script>
</body>
</html>
