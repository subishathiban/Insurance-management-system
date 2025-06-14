<?php
require_once('../const/mail.php');
?>
﻿<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title><?php echo WBName; ?> - System Settings</title>
<meta name="description" content="Insurance Management System">
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
System Settings
</h3>
</div>
<div class="block-content block-content-full">

<div class="col-12">
<div class="block block-rounded row g-0">
<ul class="nav nav-tabs nav-tabs-block flex-md-column col-md-4 col-xxl-2" role="tablist">
<li class="nav-item d-md-flex flex-md-column" role="presentation">
<button class="nav-link text-md-start active" id="btabs-basic-settings-tab" data-bs-toggle="tab" data-bs-target="#btabs-basic-settings" role="tab" aria-controls="btabs-basic-settings" aria-selected="true">
<i class="fa fa-fw fa-building opacity-50 me-1 d-none d-sm-inline-block"></i>
<span>Basic Settings</span>
<span class="d-none d-md-block fs-xs fw-medium opacity-75 mt-md-2">
Update organization information
</span>
</button>
</li>
<li class="nav-item d-md-flex flex-md-column" role="presentation">
<button class="nav-link text-md-start" id="btabs-smtp-settings-tab" data-bs-toggle="tab" data-bs-target="#btabs-smtp-settings" role="tab" aria-controls="btabs-smtp-settings" aria-selected="false" tabindex="-1">
<i class="fa fa-fw fa-envelope opacity-50 me-1 d-none d-sm-inline-block"></i>
<span>SMTP Settings</span>
<span class="d-none d-md-block fs-xs fw-medium opacity-75 mt-md-2">
Update email server information
</span>
</button>
</li>
<li class="nav-item d-md-flex flex-md-column" role="presentation">
<button class="nav-link text-md-start" id="btabs-appearance-tab" data-bs-toggle="tab" data-bs-target="#btabs-appearance" role="tab" aria-controls="btabs-appearance" aria-selected="false" tabindex="-1">
<i class="fa fa-fw fa-brush opacity-50 me-1 d-none d-sm-inline-block"></i>
<span>Theme and Appearance</span>
<span class="d-none d-md-block fs-xs fw-medium opacity-75 mt-md-2">
Update theme and appearance
</span>
</button>
</li>
</ul>
<div class="tab-content col-md-8 col-xxl-10">
<div class="block-content tab-pane active" id="btabs-basic-settings" role="tabpanel" aria-labelledby="btabs-basic-settings-tab" tabindex="0">
<h4 class="">Basic Settings</h4>

<form id="app_frm" enctype="multipart/form-data" action="admin/core/update_settings" method="POST" autocomplete="off">

<div class="modal-body pb-1">
<div class="row mb-2">
<div class="row mb-2">
<label class="col-sm-3 col-form-label">Organization</label>
<div class="col-sm-9">
<input class="form-control form-control-alt" value="<?php echo WBName; ?>" name="org" required type="text" placeholder="Enter organization name">
</div>
</div>

<div class="row mb-2">
<label class="col-sm-3 col-form-label">Email</label>
<div class="col-sm-9">
<input class="form-control form-control-alt" value="<?php echo WBEmail; ?>" name="email" required type="text" placeholder="Enter organization email">
</div>
</div>

<div class="row mb-2">
<label class="col-sm-3 col-form-label">Phone</label>
<div class="col-sm-9">
<input name="phone" required type="text" value="<?php echo WBPhone; ?>" class="form-control form-control-alt" placeholder="Enter phone">
</div>
</div>

<div class="row mb-2">
<label class="col-sm-3 col-form-label">Phone 2</label>
<div class="col-sm-9">
<input name="phone2" type="text" value="<?php echo WBPhoneAlt; ?>" class="form-control form-control-alt" placeholder="*Optional* Enter phone 2">
</div>
</div>

<div class="row mb-2">
<label class="col-sm-3 col-form-label">Country</label>
<div class="col-sm-9">
<select name="country" required class="form-control form-control-alt" >
<option selected disabled value="">Choose</option>
<?php
try {
$conn = new PDO('mysql:host='.DBHost.';dbname='.DBName.';charset='.DBCharset.';collation='.DBCollation.';prefix='.DBPrefix.'', DBUser, DBPass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$stmt = $conn->prepare("SELECT * FROM tbl_countries ORDER BY countryname");
$stmt->execute();
$result = $stmt->fetchAll();

foreach($result as $row)
{
?>
<option <?php if (WBCountry == $row[1]) { print ' selected '; } ?> value="<?php echo $row[1]; ?>"><?php echo $row[1]; ?></option>
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
<label class="col-sm-3 col-form-label">Timezone</label>
<div class="col-sm-9">
<select name="timezone" required class="form-control form-control-alt" >
<option selected disabled value="">Choose</option>
<?php
try {
$conn = new PDO('mysql:host='.DBHost.';dbname='.DBName.';charset='.DBCharset.';collation='.DBCollation.';prefix='.DBPrefix.'', DBUser, DBPass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$stmt = $conn->prepare("SELECT * FROM tbl_timezones ORDER BY timezone");
$stmt->execute();
$result = $stmt->fetchAll();

foreach($result as $row)
{
?>
<option <?php if (WBTimezone == $row[2]) { print ' selected '; } ?> value="<?php echo $row[2]; ?>"><?php echo $row[2]; ?></option>
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
<label class="col-sm-3 col-form-label">City</label>
<div class="col-sm-9">
<input name="city" value="<?php echo WBCity; ?>" required type="text" class="form-control form-control-alt" placeholder="Enter city">
</div>
</div>

<div class="row mb-2">
<label class="col-sm-3 col-form-label">Street</label>
<div class="col-sm-9">
<input name="street" value="<?php echo WBStreet; ?>" required type="text" class="form-control form-control-alt" placeholder="Enter street">
</div>
</div>

<div class="row mb-2">
<label class="col-sm-3 col-form-label">Currency</label>
<div class="col-sm-9">
<input name="currency" value="<?php echo WBCurrency; ?>" required type="text" class="form-control form-control-alt" placeholder="Enter currency">
</div>
</div>

<div class="row mb-2">
<label class="col-sm-3 col-form-label">Logo (Leave blank if no change)</label>
<div class="col-sm-9">
<input name="logo" type="file" class="form-control form-control-alt" accept=".png,.jpg,.jpeg">
</div>
</div>

</div>

</div>
<input type="hidden" name="submit" value="1">

<button id="sub_btn" type="submit" class="btn btn-primary">Save changes</button>

</form>
</div>
<div class="block-content tab-pane" id="btabs-smtp-settings" role="tabpanel" aria-labelledby="btabs-smtp-settings-tab" tabindex="0">
<h4 class="">SMTP Settings</h4>

<form id="app_frm2" enctype="multipart/form-data" action="admin/core/update_smtp" method="POST" autocomplete="off">

<div class="modal-body pb-1">
<div class="row mb-2">
<div class="row mb-2">
<label class="col-sm-3 col-form-label">SMTP Server</label>
<div class="col-sm-9">
<input required type="text" name="mail_server" value="<?php echo $mymail_server; ?>" class="form-control form-control-alt" placeholder="Enter SMTP Server">
</div>
</div>

<div class="row mb-2">
<label class="col-sm-3 col-form-label">SMTP Username</label>
<div class="col-sm-9">
<input required type="text" name="mail_username" value="<?php echo $mymail_user; ?>" class="form-control form-control-alt" placeholder="Enter SMTP Username">
</div>
</div>

<div class="row mb-2">
<label class="col-sm-3 col-form-label">SMTP Password</label>
<div class="col-sm-9">
<input required type="text" name="mail_password" value="<?php echo $mymail_password; ?>" class="form-control form-control-alt" placeholder="Enter SMTP Password">
</div>
</div>

<div class="row mb-2">
<label class="col-sm-3 col-form-label">SMTP Port</label>
<div class="col-sm-9">
<input required type="text" name="mail_port" value="<?php echo $mymail_port; ?>" class="form-control form-control-alt" placeholder="Enter SMTP Port">
</div>
</div>

<div class="row mb-2">
<label class="col-sm-3 col-form-label">SMTP Encryption</label>
<div class="col-sm-9">
<select name="mail_encryption" required class="form-control form-control-alt" >
<option <?php if ($mymail_sec == "tls") { print ' selected '; } ?> value="tls">TLS</option>
<option <?php if ($mymail_sec == "ssl") { print ' selected '; } ?> value="ssl">SSL</option>
</select>
</div>
</div>

</div>

</div>
<input type="hidden" name="submit" value="1">

<button id="sub_btn2" type="submit" class="btn btn-primary">Save changes</button>

</form>
</div>
<div class="block-content tab-pane" id="btabs-payment-gateways" role="tabpanel" aria-labelledby="btabs-payment-gateways-tab" tabindex="0">
<h4 class="">Payment Gateways</h4>


<ul class="nav nav-tabs nav-tabs-alt" role="tablist">
<li class="nav-item" role="presentation">
<button class="nav-link active" id="btabs-stripe-tab" data-bs-toggle="tab" data-bs-target="#btabs-stripe" role="tab" aria-controls="btabs-stripe" aria-selected="true">STRIPE</button>
</li>
<li class="nav-item" role="presentation">
<button class="nav-link" id="btabs-paypal-tab" data-bs-toggle="tab" data-bs-target="#btabs-paypal" role="tab" aria-controls="btabs-paypal" aria-selected="false" tabindex="-1">PAYPAL</button>
</li>
<li class="nav-item" role="presentation">
<button class="nav-link" id="btabs-flutterwave-tab" data-bs-toggle="tab" data-bs-target="#btabs-flutterwave" role="tab" aria-controls="btabs-flutterwave" aria-selected="false" tabindex="-1">FLUTTERWAVE</button>
</li>

</ul>
<div class="block-content tab-content">
<div class="tab-pane active" id="btabs-stripe" role="tabpanel" aria-labelledby="btabs-stripe-tab" tabindex="0">
<form id="app_frm3" enctype="multipart/form-data" action="admin/core/update_stripe" method="POST" autocomplete="off">
<div class="row mb-2">
<label class="col-sm-3 col-form-label">Public Key</label>
<div class="col-sm-9">
<input required type="text" name="pub_key" value="<?php echo $public_key_live; ?>" class="form-control form-control-alt">
</div>
</div>
<div class="row mb-2">
<label class="col-sm-3 col-form-label">Secret Key</label>
<div class="col-sm-9">
<input required type="text" name="sec_key" value="<?php echo $secret_key_live; ?>" class="form-control form-control-alt">
</div>
</div>

<div class="row mb-2">
<label class="col-sm-3 col-form-label">Public Key (Sandbox)</label>
<div class="col-sm-9">
<input required type="text" name="pub_key_0" value="<?php echo $public_key_test; ?>" class="form-control form-control-alt">
</div>
</div>
<div class="row mb-2">
<label class="col-sm-3 col-form-label">Secret Key (Sandbox)</label>
<div class="col-sm-9">
<input required type="text" name="sec_key_0" value="<?php echo $secret_key_test; ?>" class="form-control form-control-alt">
</div>
</div>

<div class="mb-2">
<div class="space-x-2">
<div class="form-check form-switch form-check-inline">
<input <?php if ($stripe_switch == "1") { print ' checked '; } ?> name="en" class="form-check-input" type="checkbox" id="example-switch-inline1" name="example-switch-inline1">
<label class="form-check-label" for="example-switch-inline1">Enable Stripe Payments</label>
</div>
<div class="form-check form-switch form-check-inline">
<input <?php if ($stripe_status == "1") { print ' checked '; } ?> name="status" class="form-check-input" type="checkbox" value="" id="example-switch-inline2" name="example-switch-inline2">
<label class="form-check-label" for="example-switch-inline2">Collect Live Payments</label>
</div>
</div>
</div>

<input type="hidden" name="submit" value="1">

<button id="sub_btn3" type="submit" class="btn btn-primary">Save changes</button>

</form>

</div>
<div class="tab-pane" id="btabs-paypal" role="tabpanel" aria-labelledby="btabs-paypal-tab" tabindex="0">
<form id="app_frm4" enctype="multipart/form-data" action="admin/core/update_paypal" method="POST" autocomplete="off">
<div class="row mb-2">
<label class="col-sm-3 col-form-label">API Username</label>
<div class="col-sm-9">
<input required type="text" name="username" value="<?php echo $pp_api_user; ?>" class="form-control form-control-alt">
</div>
</div>
<div class="row mb-2">
<label class="col-sm-3 col-form-label">API Password</label>
<div class="col-sm-9">
<input required type="text" name="password" value="<?php echo $pp_api_pass; ?>" class="form-control form-control-alt">
</div>
</div>
<div class="row mb-2">
<label class="col-sm-3 col-form-label">API Signature</label>
<div class="col-sm-9">
<input required type="text" name="signature" value="<?php echo $pp_api_sign; ?>" class="form-control form-control-alt">
</div>
</div>

<div class="row mb-2">
<label class="col-sm-3 col-form-label">API Username (Sandbox)</label>
<div class="col-sm-9">
<input required type="text" name="username_test" value="<?php echo $pp_api_user_test; ?>" class="form-control form-control-alt">
</div>
</div>
<div class="row mb-2">
<label class="col-sm-3 col-form-label">API Password (Sandbox)</label>
<div class="col-sm-9">
<input required type="text" name="password_test" value="<?php echo $pp_api_pass_test; ?>" class="form-control form-control-alt">
</div>
</div>
<div class="row mb-2">
<label class="col-sm-3 col-form-label">API Signature (Sandbox)</label>
<div class="col-sm-9">
<input required type="text" name="signature_test" value="<?php echo $pp_api_sign_test; ?>" class="form-control form-control-alt">
</div>
</div>

<div class="mb-2">
<div class="space-x-2">
<div class="form-check form-switch form-check-inline">
<input <?php if ($paypal_switch == "1") { print ' checked '; } ?> name="en" class="form-check-input" type="checkbox" id="example-switch-inline1" name="example-switch-inline1">
<label class="form-check-label" for="example-switch-inline1">Enable PayPal Payments</label>
</div>
<div class="form-check form-switch form-check-inline">
<input <?php if ($paypal_status == "1") { print ' checked '; } ?> name="status" class="form-check-input" type="checkbox" value="" id="example-switch-inline2" name="example-switch-inline2">
<label class="form-check-label" for="example-switch-inline2">Collect Live Payments</label>
</div>
</div>
</div>

<input type="hidden" name="submit" value="1">

<button id="sub_btn4" type="submit" class="btn btn-primary">Save changes</button>

</form>
</div>
<div class="tab-pane" id="btabs-flutterwave" role="tabpanel" aria-labelledby="btabs-flutterwave-tab" tabindex="0">
<form id="app_frm5" enctype="multipart/form-data" action="admin/core/update_flutterwave" method="POST" autocomplete="off">
<div class="row mb-2">
<label class="col-sm-3 col-form-label">Public Key</label>
<div class="col-sm-9">
<input required type="text" name="pub_key" value="<?php echo $fw_public_key_live; ?>" class="form-control form-control-alt">
</div>
</div>
<div class="row mb-2">
<label class="col-sm-3 col-form-label">Secret Key</label>
<div class="col-sm-9">
<input required type="text" name="sec_key" value="<?php echo $fw_secret_key_live; ?>" class="form-control form-control-alt">
</div>
</div>
<div class="row mb-2">
<label class="col-sm-3 col-form-label">Encryption Key</label>
<div class="col-sm-9">
<input required type="text" name="enc_key" value="<?php echo $fw_encryption_key_live; ?>" class="form-control form-control-alt">
</div>
</div>

<div class="row mb-2">
<label class="col-sm-3 col-form-label">Public Key (Sandbox)</label>
<div class="col-sm-9">
<input required type="text" name="pub_key_test" value="<?php echo $fw_public_key_live; ?>" class="form-control form-control-alt">
</div>
</div>
<div class="row mb-2">
<label class="col-sm-3 col-form-label">Secret Key (Sandbox)</label>
<div class="col-sm-9">
<input required type="text" name="sec_key_test" value="<?php echo $fw_secret_key_live; ?>" class="form-control form-control-alt">
</div>
</div>
<div class="row mb-2">
<label class="col-sm-3 col-form-label">Encryption Key (Sandbox)</label>
<div class="col-sm-9">
<input required type="text" name="enc_key_test" value="<?php echo $fw_encryption_key_live; ?>" class="form-control form-control-alt">
</div>
</div>

<div class="mb-2">
<div class="space-x-2">
<div class="form-check form-switch form-check-inline">
<input <?php if ($fw_switch == "1") { print ' checked '; } ?> name="en" class="form-check-input" type="checkbox" id="example-switch-inline1" name="example-switch-inline1">
<label class="form-check-label" for="example-switch-inline1">Enable Flutterwave Payments</label>
</div>
<div class="form-check form-switch form-check-inline">
<input <?php if ($fw_status == "1") { print ' checked '; } ?> name="status" class="form-check-input" type="checkbox" value="" id="example-switch-inline2" name="example-switch-inline2">
<label class="form-check-label" for="example-switch-inline2">Collect Live Payments</label>
</div>
</div>
</div>

<input type="hidden" name="submit" value="1">

<button id="sub_btn5" type="submit" class="btn btn-primary">Save changes</button>

</form>
</div>
</div>



</div>

<div class="block-content tab-pane" id="btabs-appearance" role="tabpanel" aria-labelledby="btabs-appearance-tab" tabindex="0">
<h4 class="">Theme and Appearance</h4>

<form id="app_frm6" action="admin/core/update_theme" method="POST" autocomplete="off">

<div class="modal-body pb-1">
<div class="row mb-2">
<div class="row mb-2">
<label class="col-sm-3 col-form-label">Sidebar Color</label>
<div class="col-sm-9">
<select class="form-control form-control-alt"  name="sidebar_color" required>
<option <?php if (Sidebar == "sidebar-light") { print ' selected '; } ?> value="sidebar-light">Light</option>
<option <?php if (Sidebar == "sidebar-dark") { print ' selected '; } ?> value="sidebar-dark">Dark</option>
</select>
</div>
</div>

<div class="row mb-2">
<label class="col-sm-3 col-form-label">Sidebar Position</label>
<div class="col-sm-9">
<select class="form-control form-control-alt"  name="sidebar_position" required>
<option <?php if (Sidebar_Pos == "sidebar-l") { print ' selected '; } ?> value="sidebar-l">Left</option>
<option <?php if (Sidebar_Pos == "sidebar-r") { print ' selected '; } ?> value="sidebar-r">Right</option>
</select>
</div>
</div>

<div class="row mb-2">
<label class="col-sm-3 col-form-label">Sidebar Mode</label>
<div class="col-sm-9">
<select class="form-control form-control-alt"  name="sidebar_mode" required>
<option <?php if (Sidebar_Min == "sidebar-mini") { print ' selected '; } ?> value="sidebar-mini">Minimized</option>
<option <?php if (Sidebar_Min == "") { print ' selected '; } ?> value="">Maxmized</option>
</select>
</div>
</div>

<div class="row mb-2">
<label class="col-sm-3 col-form-label">Header Color</label>
<div class="col-sm-9">
<select class="form-control form-control-alt"  name="header_color" required>
<option <?php if (Header == "page-header-light") { print ' selected '; } ?> value="page-header-light">Light</option>
<option <?php if (Header == "page-header-dark") { print ' selected '; } ?> value="page-header-dark">Dark</option>
</select>
</div>
</div>

<div class="row mb-2">
<label class="col-sm-3 col-form-label">Header Mode</label>
<div class="col-sm-9">
<select class="form-control form-control-alt"  name="header_mode" required>
<option <?php if (PageHeader == "page-header-static") { print ' selected '; } ?> value="page-header-static">Static</option>
<option <?php if (PageHeader == "page-header-fixed") { print ' selected '; } ?> value="page-header-fixed">Fixed</option>
</select>
</div>
</div>

<div class="row mb-2">
<label class="col-sm-3 col-form-label">Body Content</label>
<div class="col-sm-9">
<select class="form-control form-control-alt"  name="body_content" required>
<option <?php if (MainContent == "main-content-narrowed") { print ' selected '; } ?> value="main-content-narrowed">Narrowed</option>
<option <?php if (MainContent == "main-content-boxed") { print ' selected '; } ?> value="main-content-boxed">Boxed</option>
</select>
</div>
</div>


<div class="row mb-2">
<label class="col-sm-3 col-form-label">Theme</label>
<div class="col-sm-9">
<select class="form-control form-control-alt"  name="theme">
<option <?php if (Theme == "") { print ' selected '; } ?> value="">Default</option>
<option <?php if (Theme == "xwork.min-5.7.css") { print ' selected '; } ?> value="xwork.min-5.7.css">Blue v1</option>
<option <?php if (Theme == "xmodern.min-5.7.css") { print ' selected '; } ?> value="xmodern.min-5.7.css">Blue v2</option>
<option <?php if (Theme == "xdream.min-5.7.css") { print ' selected '; } ?> value="xdream.min-5.7.css">Blue v3</option>
<option <?php if (Theme == "xpro.min-5.7.css") { print ' selected '; } ?> value="xpro.min-5.7.css">Blue v4</option>
<option <?php if (Theme == "xeco.min-5.7.css") { print ' selected '; } ?> value="xeco.min-5.7.css">Green v1</option>
<option <?php if (Theme == "xinspire.min-5.7.css") { print ' selected '; } ?> value="xinspire.min-5.7.css">Green v2</option>
<option <?php if (Theme == "xsmooth.min-5.7.css") { print ' selected '; } ?> value="xsmooth.min-5.7.css">Purple</option>
<option <?php if (Theme == "xplay.min-5.7.css") { print ' selected '; } ?> value="xplay.min-5.7.css">Red</option>
</select>
</div>
</div>


</div>

</div>
<input type="hidden" name="submit" value="1">

<button id="sub_btn6" type="submit" class="btn btn-primary">Save changes</button>
<a onclick="return confirm('Use factory settings on theme and appearance?');" class="btn btn-primary" href="admin/core/factory-reset">Factory Settings</a>

</form>
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
