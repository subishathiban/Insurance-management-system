<nav id="sidebar" aria-label="Main Navigation">
<div class="bg-header-dark">
<div class="content-header bg-white-5">
<a class=" text-white tracking-wide" href="admin?page=dashboard">
<span style="font-size:21px;" class="smini-hidden">
Subish-Insurance
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
<a class="nav-main-link <?php if ($_GET['page'] == "dashboard") { print ' active ';} ?>" href="admin?page=dashboard">
<i class="nav-main-link-icon fa fa-location-arrow"></i>
<span class="nav-main-link-name">Dashboard</span>
</a>
</li>
<li class="nav-main-item">
<a class="nav-main-link <?php if ($_GET['page'] == "categories") { print ' active ';} ?>" href="admin?page=categories">
<i class="nav-main-link-icon fa fa-folder"></i>
<span class="nav-main-link-name">Categories</span>
</a>
</li>
<li class="nav-main-item">
<a class="nav-main-link <?php if ($_GET['page'] == "sub-categories") { print ' active ';} ?>" href="admin?page=sub-categories">
<i class="nav-main-link-icon fa fa-bookmark"></i>
<span class="nav-main-link-name">Sub-Categories</span>
</a>
</li>
<li class="nav-main-item">
<a class="nav-main-link <?php if ($_GET['page'] == "ticket_categories") { print ' active ';} ?>" href="admin?page=ticket_categories">
<i class="nav-main-link-icon fa fa-comments"></i>
<span class="nav-main-link-name">Ticket Categories</span>
</a>
</li>
<li class="nav-main-item">
<a class="nav-main-link <?php if ($_GET['page'] == "policy") { print ' active ';} ?>" href="admin?page=policy">
<i class="nav-main-link-icon fa fa-life-ring"></i>
<span class="nav-main-link-name">Insurance Policy</span>
</a>
</li>
<li class="nav-main-item">
<a class="nav-main-link <?php if ($_GET['page'] == "staff") { print ' active ';} ?>" href="admin?page=staff">
<i class="nav-main-link-icon fa fa-user-group"></i>
<span class="nav-main-link-name">Staff</span>
</a>
</li>
<li class="nav-main-item">
<a class="nav-main-link <?php if ($_GET['page'] == "users") { print ' active ';} ?>" href="admin?page=users">
<i class="nav-main-link-icon fa fa-users"></i>
<span class="nav-main-link-name">Users</span>
</a>
</li>
<li class="nav-main-item">
<a class="nav-main-link <?php if ($_GET['page'] == "applications") { print ' active ';} ?>" href="admin?page=applications">
<i class="nav-main-link-icon fa fa-person"></i>
<span class="nav-main-link-name">Policy Holders</span>
</a>
</li>
<li class="nav-main-item">
<a class="nav-main-link <?php if ($_GET['page'] == "tickets") { print ' active ';} ?>" href="admin?page=tickets">
<i class="nav-main-link-icon fa fa-file-lines"></i>
<span class="nav-main-link-name">Support Tickets</span>
</a>
</li>

<li class="nav-main-item">
<a class="nav-main-link <?php if ($_GET['page'] == "report_tools") { print ' active ';} ?>" href="admin?page=report_tools">
<i class="nav-main-link-icon fa fa-chart-simple"></i>
<span class="nav-main-link-name">Report Tools</span>
</a>
</li>

<li class="nav-main-item">
<a class="nav-main-link <?php if ($_GET['page'] == "settings") { print ' active ';} ?>" href="admin?page=settings">
<i class="nav-main-link-icon fa fa-cog"></i>
<span class="nav-main-link-name">System Settings</span>
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

<button type="button" class="btn btn-alt-secondary" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
<img class="img-avatar img-avatar32 img-avatar-thumb" src="assets/media/avatars/<?php echo $gender; ?>.png" alt="">
<span class="d-none d-sm-inline-block"><?php echo $fname; ?> <?php echo $lname; ?></span>
<i class="fa fa-fw fa-angle-down opacity-50 ms-1 d-none d-sm-inline-block"></i>
</button>

<div class="dropdown-menu dropdown-menu-end p-0" aria-labelledby="page-header-user-dropdown">
<div class="p-2">
<a class="dropdown-item" href="admin?page=profile">
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
