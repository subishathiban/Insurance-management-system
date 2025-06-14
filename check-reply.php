<?php
if (isset($_SESSION['reply'])) {
$alert_type = $_SESSION['reply'][0][0];
$alert_msg = $_SESSION['reply'][0][1];

?>
<div class="alert alert-<?php echo $alert_type; ?> alert-dismissible" role="alert">
<p class="mb-0"><?php echo $alert_msg; ?></p>
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php
unset($_SESSION['reply']);
}
?>
