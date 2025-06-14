
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title><?php echo WBName; ?> - My Profile</title>
<meta name="description" content="Insurance Management System">
<meta name="author" content="Bwire Mashauri">
<base href="../">
<link rel="icon" href="assets/media/favicons/favicon.ico" type="image/x-icon">

<link rel="stylesheet" id="css-main" href="assets/css/dashmix.min-5.4.css">
<?php if (Theme !== "") { print '<link rel="stylesheet" id="css-theme" href="assets/css/themes/'.Theme.'">'; } ?>
<link type="text/css" rel="stylesheet" href="assets/loader/waitMe.css">
</head>
<body>
<div id="page-container" class="sidebar-o <?php echo Header; ?> enable-page-overlay side-scroll <?php echo Sidebar; ?> <?php echo PageHeader; ?> <?php echo Sidebar_Min; ?> <?php echo Sidebar_Pos; ?> <?php echo Header; ?> <?php echo MainContent; ?>">
<?php require_once('main_nav.php'); ?>

<main id="main-container">

<div class="content">
<?php require_once('../const/check-reply.php'); ?>

<div class="block block-rounded">
<div class="block-content">
<h2 class="content-heading pt-0">
<i class="fa fa-fw fa-user text-muted me-1"></i> User Profile
</h2>

<div class="row">

<div class="col-lg-12 col-xl-12">
<div class="row mb-2">
<div class="col-md-4">
<label class="form-label">First Name</label>
<input disabled required value="<?php echo $fname; ?>" name="fname"  type="text" class="form-control form-control-alt">
</div>
<div class="col-md-4">
<label class="form-label">Last Name</label>
<input disabled required value="<?php echo $lname; ?>" name="lname"  type="text" class="form-control form-control-alt">
</div>
<div class="col-md-4">
<label class="form-label">Gender</label>
<select disabled required name="gender"  class="form-control form-control-alt">
<option <?php if ($gender == "Male") { print ' selected '; } ?> value="Male">Male</option>
<option <?php if ($gender == "Female") { print ' selected '; } ?> value="Female">Female</option>
</select>
</div>
</div>


<div class="row">
<div class="mb-3 col-md-4">
<label class="form-label">Phone</label>
<input disabled required value="<?php echo $phone; ?>" name="phone"  type="text" class="form-control form-control-alt">
</div>

<div class="mb-3 col-md-4">
<label class="form-label">Email</label>
<input disabled required value="<?php echo $email; ?>" name="email"  type="email" class="form-control form-control-alt">
</div>


</div>

</div>
</div>
<h2 class="content-heading pt-20">
<i class="fa fa-fw fa-lock text-muted me-1"></i> Change Password
</h2>
<form id="load100" action="staff/core/update_password" method="POST" autocomplete="off">
<div class="row push">
<div class="col-lg-12">
<p class="text-muted">
Changing your sign in password is an easy way to keep your account secure.
</p>
</div>
<div class="col-lg-12 col-xl-12">
<div class="mb-2">
<label class="form-label">Current Password</label>
<input type="password" placeholder="Enter your current password" class="form-control form-control-alt" id="cpass" name="cpassword">
</div>
<div class="row mb-2">
<div class="col-12">
<label class="form-label">New Password</label>
<input type="password" placeholder="Enter your new password" class="form-control form-control-alt" id="npass" name="npassword">
</div>
</div>
<div class="row mb-2">
<div class="col-12">
<label class="form-label">Confirm New Password</label>
<input type="password" placeholder="Confirm your new password" class="form-control form-control-alt" id="cnpass">
</div>
</div>
</div>
</div>

<div class="row push">
<div class="col-lg-12 col-xl-12">
<div class="mb-4">
<input type="hidden" name="submit" value="1">
<button id="sub_btnp" type="submit" class="btn  btn-primary">Change Password</button>
</div>
</div>
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
</body>
</html>
