<header id="page-header">
<div class="content-header">
<div class="d-flex align-items-center">

<a class=" text-white tracking-wide" href="admin?page=dashboard">
<span style="font-size:21px;" class="smini-hidden">
E-Insurance
</span>
</a>
</div>
<div>

<div class="dropdown d-inline-block">
<button type="button" class="btn btn-alt-secondary" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
<i class="fa fa-fw fa-bell"></i>
<?php
if ($notifications > 0) {
?><span class="badge bg-black-50 rounded-pill"><?php echo $notifications; ?></span><?php
}
?>
</button>
<div class="dropdown-menu dropdown-menu-end dropdown-menu-lg p-0" aria-labelledby="page-header-notifications-dropdown">
<div class="bg-primary rounded-top  text-white text-center p-3">
Notifications
</div>
<ul class="nav-items my-2">

<?php
try {
$conn = new PDO('mysql:host='.DBHost.';dbname='.DBName.';charset='.DBCharset.';collation='.DBCollation.';prefix='.DBPrefix.'', DBUser, DBPass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $conn->prepare("SELECT * FROM tbl_notifications WHERE user = ? AND status = '0' ORDER BY id DESC LIMIT 5");
$stmt->execute([$account_id]);
$result = $stmt->fetchAll();

foreach ($result as $row) {

if ($row[3] == "") {
?>
<li>
<a class="d-flex text-dark py-2" href="user?page=notifications">
<div class="flex-shrink-0 mx-3">
<i class="fa fa-bell text-primary"></i>
</div>
<div class="flex-grow-1 fs-sm pe-2">
<div class=""><?php echo $row[2]; ?></div>
</div>
</a>
</li>
<?php
}else{
?>
<li>
<a class="d-flex text-dark py-2" href="user?page=message_center&id=<?php echo $row[3]; ?>">
<div class="flex-shrink-0 mx-3">
<i class="fa fa-bell text-primary"></i>
</div>
<div class="flex-grow-1 fs-sm pe-2">
<div class=""><?php echo $row[2]; ?></div>
</div>
</a>
</li>
<?php
}

}

}catch(PDOException $e)
{
echo "Connection failed: " . $e->getMessage();
}
?>
</ul>
<div class="p-2 border-top">
<a class="btn btn-alt-primary w-100 text-center" href="user?page=notifications">
<i class="fa fa-fw fa-eye opacity-50 me-1"></i> View All
</a>
</div>
</div>
</div>

<div class="dropdown d-inline-block">
<button type="button" class="btn btn-alt-secondary dropdown-toggle" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
<img class="img-avatar img-avatar32 img-avatar-thumb" src="assets/media/avatars/<?php echo $gender; ?>.png" alt="">
<span class="d-none d-sm-inline ms-1"><?php echo $fname; ?> <?php echo $lname; ?></span>
</button>
<div class="dropdown-menu dropdown-menu-end p-0" aria-labelledby="page-header-user-dropdown">
<div class="p-2">
<a class="dropdown-item" href="user?page=profile">
<i class="far fa-fw fa-user me-1"></i> My Profile
</a>
<div role="separator" class="dropdown-divider"></div>
<a class="dropdown-item" href="./logout">
<i class="far fa-fw fa-arrow-alt-circle-left me-1"></i> Sign Out
</a>
</div>
</div>
</div>


</div>
</div>
</header>
<main id="main-container">
<div class="bg-body-extra-light">
<div class="content py-3">
<div class="d-lg-none push">
<button type="button" class="btn w-100 btn-primary d-flex justify-content-between align-items-center" data-toggle="class-toggle" data-target="#main-navigation" data-class="d-none">
Menu
<i class="fa fa-bars"></i>
</button>
</div>

<div id="main-navigation" class="d-none d-lg-block push">
<ul class="nav-main nav-main-horizontal nav-main-hover">
<li class="nav-main-item">
<a class="nav-main-link <?php if ($_GET['page'] == "dashboard") { print ' active ';} ?>" href="user?page=dashboard">
<i class="nav-main-link-icon fa fa-location-arrow"></i>
<span class="nav-main-link-name">Dashboard</span>
</a>
</li>
<li class="nav-main-item">
<a class="nav-main-link nav-main-link-submenu <?php if ($_GET['page'] == "apply" || $_GET['page'] == "history") { print ' active ';} ?>" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="javascript:void(0);">
<i class="nav-main-link-icon fa fa-book"></i>
<span class="nav-main-link-name">Insurance</span>
</a>
<ul class="nav-main-submenu">
<li class="nav-main-item">
<a class="nav-main-link <?php if ($_GET['page'] == "apply") { print ' active ';} ?>" href="user?page=apply">
<span class="nav-main-link-name">Apply Insurance</span>
</a>
</li>
<li class="nav-main-item">
<a class="nav-main-link <?php if ($_GET['page'] == "history") { print ' active ';} ?>" href="user?page=history">
<span class="nav-main-link-name">Insurance History</span>
</a>
</li>
</ul>
</li>

<li class="nav-main-item">
<a class="nav-main-link nav-main-link-submenu <?php if ($_GET['page'] == "generate" || $_GET['page'] == "history2") { print ' active ';} ?>" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="javascript:void(0);">
<i class="nav-main-link-icon fa fa-file-lines"></i>
<span class="nav-main-link-name">Support Tickets</span>
</a>
<ul class="nav-main-submenu">
<li class="nav-main-item">
<a class="nav-main-link <?php if ($_GET['page'] == "generate") { print ' active ';} ?>" href="user?page=generate">
<span class="nav-main-link-name">Generate</span>
</a>
</li>
<li class="nav-main-item">
<a class="nav-main-link <?php if ($_GET['page'] == "history2") { print ' active ';} ?>" href="user?page=history2">
<span class="nav-main-link-name">Ticket History</span>
</a>
</li>
</ul>
</li>

</ul>
</div>
