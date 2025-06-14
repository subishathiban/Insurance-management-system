<?php
session_start();
require_once('../db/config.php');
require_once('../const/uniques.php');
require_once('../const/mail.php');
require_once('../const/organization.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../mail/src/Exception.php';
require '../mail/src/PHPMailer.php';
require '../mail/src/SMTP.php';


if (isset($_POST['submit'])) {
$_username = $_POST['username'];

try {
$conn = new PDO('mysql:host='.DBHost.';dbname='.DBName.';charset='.DBCharset.';collation='.DBCollation.';prefix='.DBPrefix.'', DBUser, DBPass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $conn->prepare("SELECT * FROM tbl_users WHERE email = ?");
$stmt->execute([$_username]);
$result = $stmt->fetchAll();

if (count($result) < 1) {
$_SESSION['reply'] = array (array("danger","Account was not found"));
header("location:../?page=forgot-pw");
}else{

foreach($result as $row)
{
$_account_id = $row[0];
$_name = ''.$row[1].' '.$row[2].'';
$_email = $row[3];
$new_pass_plain = get_rand_alphanumeric(8);
$new_pass = password_hash($new_pass_plain, PASSWORD_DEFAULT);
$msg = 'Hello '.$_name.',<br>Your new password is <b style="background-color:black; color:white; padding:3px;">'.$new_pass_plain.'</b> <br><br>Account ID : '.$_account_id.'';
}

$mail = new PHPMailer;
$mail->SMTPOptions = array(
'ssl' => array(
'verify_peer' => false,
'verify_peer_name' => false,
'allow_self_signed' => true
)
);

$mail->isSMTP();
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Host = $mymail_server;
$mail->SMTPAuth = true;
$mail->Username = $mymail_user;
$mail->Password = $mymail_password;
$mail->SMTPSecure = $mymail_sec;
$mail->Port = $mymail_port;

$mail->setFrom($mymail_user, WBName);
$mail->addAddress($_email, $_name);

$mail->isHTML(true);

$mail->Subject = 'Reset Password';
$mail->Body    = $msg;
$mail->AltBody = $msg;

if(!$mail->send()) {
$_SESSION['reply'] = array (array("warning",'Mailer Error : ' . str_replace("https://github.com/PHPMailer/PHPMailer/wiki/Troubleshooting","",$mail->ErrorInfo).''));
header("location:../?page=forgot-pw");
} else {

$stmt = $conn->prepare("UPDATE tbl_users SET login = ? WHERE email = ?");
$stmt->execute([$new_pass, $_username]);
$result = $stmt->fetchAll();

$_SESSION['reply'] = array (array("success","New password was sent to <strong>$_email</strong>"));
header("location:../?page=forgot-pw");
}


}

}catch(PDOException $e)
{
echo "Connection failed: " . $e->getMessage();
}

}else{
header("location:../");
}
?>
