<?php
session_start();
require_once('../db/config.php');
require_once('../const/organization.php');
require_once('../const/check_session.php');
if ($res == 1 && $level == 1) {
require_once('../const/staff_dashboard.php');
if (isset($_GET['page'])) {
require_once('pages/'.$_GET['page'].'.php');
}else{
header("location:../");
}
}else{
header("location:../");
}
?>
