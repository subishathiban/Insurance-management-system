<?php
if (isset($_GET['page'])) {
require_once('pages/'.$_GET['page'].'.php');
}else{
require_once('pages/login.php');
}
?>
