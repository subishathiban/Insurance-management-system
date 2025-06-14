<nav id="sidebar" aria-label="Main Navigation">
<div class="bg-header-dark">
<div class="content-header bg-white-5">
<a class=" text-white tracking-wide" href="staff?page=dashboard">
<span style="font-size:21px;" class="smini-hidden">
E-Insurance
</span>
</a>
<div>
</div>
</div>
</div>
<div class="js-sidebar-scroll">
<div class="content-side">
<ul class="nav-main">
<li class="nav-main-item">
<a class="nav-main-link <?php if ($_GET['page'] == "dashboard") { print ' active ';} ?>" href="staff?page=dashboard">
<i class="nav-main-link-icon fa fa-location-arrow"></i>
<span class="nav-main-link-name">Dashboard</span>
</a>
</li>
<li class="nav-main-item">
<a class="nav-main-link <?php if ($_GET['page'] == "categories") { print ' active ';} ?>" href="staff?page=categories">
<i class="nav-main-link-icon fa fa-folder"></i>
<span class="nav-main-link-name">Categories</span>
</a>
</li>
<li class="nav-main-item">
<a class="nav-main-link <?php if ($_GET['page'] == "sub-categories") { print ' active ';} ?>" href="staff?page=sub-categories">
<i class="nav-main-link-icon fa fa-bookmark"></i>
<span class="nav-main-link-name">Sub-Categories</span>
</a>
</li>
<li class="nav-main-item">
<a class="nav-main-link <?php if ($_GET['page'] == "ticket_categories") { print ' active ';} ?>" href="staff?page=ticket_categories">
<i class="nav-main-link-icon fa fa-comments"></i>
<span class="nav-main-link-name">Ticket Categories</span>
</a>
</li>
<li class="nav-main-item">
<a class="nav-main-link <?php if ($_GET['page'] == "users") { print ' active ';} ?>" href="staff?page=users">
<i class="nav-main-link-icon fa fa-users"></i>
<span class="nav-main-link-name">Users</span>
</a>
</li>
<li class="nav-main-item">
<a class="nav-main-link <?php if ($_GET['page'] == "policy") { print ' active ';} ?>" href="staff?page=policy">
<i class="nav-main-link-icon fa fa-life-ring"></i>
<span class="nav-main-link-name">Insurance Policy</span>
</a>
</li>
<li class="nav-main-item">
<a class="nav-main-link <?php if ($_GET['page'] == "applications") { print ' active ';} ?>" href="staff?page=applications">
<i class="nav-main-link-icon fa fa-person"></i>
<span class="nav-main-link-name">Policy Holders</span>
</a>
</li>
<li class="nav-main-item">
<a class="nav-main-link <?php if ($_GET['page'] == "tickets") { print ' active ';} ?>" href="staff?page=tickets">
<i class="nav-main-link-icon fa fa-file-lines"></i>
<span class="nav-main-link-name">Support Tickets</span>
</a>
</li>
</ul>
</div>
</div>
</nav>

<header id="page-header">
<div class="content-header">
<div class="space-x-1">
<button type="button" class="btn btn-alt-secondary" data-toggle="layout" data-action="sidebar_toggle">
<i class="fa fa-fw fa-bars"></i>
</button>
</div>
<div class="space-x-1">

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
<a class="d-flex text-dark py-2" href="staff?page=notifications">
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
<a class="d-flex text-dark py-2" href="staff?page=message_center&id=<?php echo $row[3]; ?>">
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
<a class="btn btn-alt-primary w-100 text-center" href="staff?page=notifications">
<i class="fa fa-fw fa-eye opacity-50 me-1"></i> View All
</a>
</div>
</div>
</div>


<div class="dropdown d-inline-block">

<button type="button" class="btn btn-alt-secondary" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
<img class="img-avatar img-avatar32 img-avatar-thumb" src="assets/media/avatars/<?php echo $gender; ?>.png" alt="">
<span class="d-none d-sm-inline-block"><?php echo $fname; ?> <?php echo $lname; ?></span>
<i class="fa fa-fw fa-angle-down opacity-50 ms-1 d-none d-sm-inline-block"></i>
</button>

<div class="dropdown-menu dropdown-menu-end p-0" aria-labelledby="page-header-user-dropdown">
<div class="p-2">
<a class="dropdown-item" href="staff?page=profile">
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
