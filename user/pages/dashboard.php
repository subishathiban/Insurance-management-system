<?php
require_once('../const/user_dashboard.php');
function number_abbr($number)
{
$abbrevs = [12 => 'T', 9 => 'B', 6 => 'M', 3 => 'K', 0 => ''];

foreach ($abbrevs as $exponent => $abbrev) {
if (abs($number) >= pow(10, $exponent)) {
$display = $number / pow(10, $exponent);
$decimals = ($exponent >= 3 && round($display) < 100) ? 1 : 0;
$number = number_format($display, $decimals).$abbrev;
break;
}
}

return $number;
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title><?php echo WBName; ?> - Dashboard</title>
<meta name="description" content="Insurance Management System">
<meta name="author" content="Bwire Mashauri">
<base href="../">
<link rel="icon" href="assets/media/favicons/favicon.ico" type="image/x-icon">

<link rel="stylesheet" id="css-main" href="assets/css/dashmix.min-5.4.css">
<link type="text/css" rel="stylesheet" href="assets/loader/waitMe.css">
<?php if (Theme !== "") { print '<link rel="stylesheet" id="css-theme" href="assets/css/themes/'.Theme.'">'; } ?>
</head>
<body>
<div id="page-container" class="<?php echo Header; ?> <?php echo PageHeader; ?> <?php echo Header; ?> <?php echo MainContent; ?>">
<?php require_once('pages/main_nav.php'); ?>
</div>
</div>
<div class="content">
<div class="alert alert-info d-flex align-items-center" role="alert">
<div class="flex-shrink-0">
<i class="fa fa-fw fa-info-circle"></i>
</div>
<div class="flex-grow-1 ms-3">
<p class="mb-0">
<?php
$h = date('G');

if($h>=5 && $h<=11)
{
echo "Good morning ".$fname."";
}
else if($h>=12 && $h<=15)
{
echo "Good afternoon ".$fname."";
}
else
{
echo "Good evening ".$fname."";
}
?>! Welcome back.
</p>
</div>
</div>

<div class="row">
<div class="col-md-3">
<a class="block block-rounded block-link-shadow" href="user?page=history">
<div class="block-content block-content-full">
<div class="py-4 text-center">
<div class="mb-3">
<i class="fa fa-person fa-3x text-primary"></i>
</div>
<div class="fs-4 "><?php echo number_abbr($policy_holders); ?></div>
<div class="text-muted">My Policy Applications</div>
</div>
</div>
</a>
</div>
<div class="col-md-3">
<a class="block block-rounded block-link-shadow" href="user?page=pending_applications">
<div class="block-content block-content-full">
<div class="py-4 text-center">
<div class="mb-3">
<i class="fa fa-person-circle-question fa-3x text-warning"></i>
</div>
<div class="fs-4 "><?php echo number_abbr($pending_policy_holders); ?></div>
<div class="text-muted">My Pending Policy Applications</div>
</div>
</div>
</a>
</div>
<div class="col-md-3">
<a class="block block-rounded block-link-shadow" href="user?page=approved_applications">
<div class="block-content block-content-full">
<div class="py-4 text-center">
<div class="mb-3">
<i class="fa fa-person-circle-check fa-3x text-success"></i>
</div>
<div class="fs-4 "><?php echo number_abbr($active_policy_holders); ?></div>
<div class="text-muted">My Approved Policy Applications</div>
</div>
</div>
</a>
</div>
<div class="col-md-3">
<a class="block block-rounded block-link-shadow" href="user?page=denied_applications">
<div class="block-content block-content-full">
<div class="py-4 text-center">
<div class="mb-3">
<i class="fa fa-person-circle-xmark fa-3x text-danger"></i>
</div>
<div class="fs-4 "><?php echo number_abbr($denied_policy_holders); ?></div>
<div class="text-muted">My Denied Policy Applications</div>
</div>
</div>
</a>
</div>

</div>

<div class="row">
<div class="col-md-3">
<a class="block block-rounded block-link-shadow" href="user?page=history2">
<div class="block-content block-content-full">
<div class="py-4 text-center">
<div class="mb-3">
<i class="fa fa-file fa-3x text-primary"></i>
</div>
<div class="fs-4 "><?php echo number_abbr($tickets); ?></div>
<div class="text-muted">My Support Tickets</div>
</div>
</div>
</a>
</div>
<div class="col-md-3">
<a class="block block-rounded block-link-shadow" href="user?page=pending_tickets">
<div class="block-content block-content-full">
<div class="py-4 text-center">
<div class="mb-3">
<i class="fa fa-file-circle-question fa-3x text-warning"></i>
</div>
<div class="fs-4 "><?php echo number_abbr($pending_tickets); ?></div>
<div class="text-muted">My Submitted Tickets</div>
</div>
</div>
</a>
</div>
<div class="col-md-3">
<a class="block block-rounded block-link-shadow" href="user?page=active_tickets">
<div class="block-content block-content-full">
<div class="py-4 text-center">
<div class="mb-3">
<i class="fa fa-file-circle-check fa-3x text-success"></i>
</div>
<div class="fs-4 "><?php echo number_abbr($active_tickets); ?></div>
<div class="text-muted">My Active Tickets</div>
</div>
</div>
</a>
</div>
<div class="col-md-3">
<a class="block block-rounded block-link-shadow" href="user?page=closed_tickets">
<div class="block-content block-content-full">
<div class="py-4 text-center">
<div class="mb-3">
<i class="fa fa-file-circle-xmark fa-3x text-danger"></i>
</div>
<div class="fs-4 "><?php echo number_abbr($closed_tickets); ?></div>
<div class="text-muted">My Closed Tickets</div>
</div>
</div>
</a>
</div>
</div>
</div>

</main>

</div>
<script src="assets/js/lib/jquery.min.js"></script>
<script src="assets/js/dashmix.app.min-5.4.js"></script>
<script src="assets/loader/waitMe.js"></script>
<script src="assets/js/forms.js"></script>
<script src="assets/js/footer-mod.js"></script>
</body>
</html>
