<?php
session_start();
require_once('../../db/config.php');
require_once('../../const/organization.php');

if (isset($_POST['submit'])) {
$min_date = $_POST['min'];
$max_date = $_POST['max'];
$_SESSION['report'] = array (array($min_date,$max_date));
header("location:../?page=general_report");
}else{
header("location:../?page=dashboard");
}
?>
