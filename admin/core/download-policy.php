<?php
require_once('../../tcpdf/tcpdf.php');
require_once('../../db/config.php');
require_once('../../const/check_session.php');
require_once('../../const/organization.php');


if ($res == 1 && $level == 0) {

if (isset($_GET['id'])) {
$policy_number = $_GET['id'];

try {
$conn = new PDO('mysql:host='.DBHost.';dbname='.DBName.';charset='.DBCharset.';collation='.DBCollation.';prefix='.DBPrefix.'', DBUser, DBPass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $conn->prepare("SELECT * FROM tbl_policy_applications LEFT JOIN tbl_insuarance_policy ON tbl_policy_applications.policy_id = tbl_insuarance_policy.id LEFT JOIN tbl_insuarance_category ON tbl_insuarance_policy.category = tbl_insuarance_category.id LEFT JOIN tbl_insuarance_sub_category ON tbl_insuarance_policy.sub_category = tbl_insuarance_sub_category.id LEFT JOIN tbl_users ON tbl_policy_applications.member_id = tbl_users.id WHERE tbl_policy_applications.id = ? ORDER BY tbl_policy_applications.id");
$stmt->execute([$policy_number]);
$result = $stmt->fetchAll();

if (count($result) < 1) {
header("location:../?page=dashboard");
}
foreach($result as $row)
{
$category = $row[18];
$subcategory = $row[22];
$pname = $row[10];
$sum_ass = $row[3];
$premium = $row[4];
$tenure = $row[5];

$active_date = $row[6];
$date=date_create($active_date);
$new_d = date_format($date,"d F Y");

$active_date2 = $row[6];
$date2=date_create($active_date2);
date_add($date2,date_interval_create_from_date_string("$tenure months"));
$new_d2 = date_format($date2,"d F Y");

$fname = $row[25];
$lname = $row[26];
$gender = $row[27];
$phone = $row[28];
$city = $row[29];
$street = $row[30];
}

}catch(PDOException $e)
{
echo "Connection failed: " . $e->getMessage();
}


$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor(WBName);
$pdf->SetTitle('('.$policy_number.') '.$subcategory.' : '.$fname.' '.$lname.'');
$pdf->SetSubject('Policy Details');
$pdf->SetKeywords('Policy Details - '.$policy_number.'');

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);


$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
require_once(dirname(__FILE__).'/lang/eng.php');
$pdf->setLanguageArray($l);
}

$pdf->setFontSubsetting(true);
$pdf->SetFont('helvetica', '', 14, '', true);

$pdf->AddPage();

$html = '<table width="100%" cellpadding="3">
<tr>
<td ><img width="80" src="../../assets/media/logo/'.WBLogo.'">
<h5><b style="font-size:18pt;">'.WBName.'</b>
<br><b style="font-size:10pt;">'.WBCity.', '.WBStreet.', '.WBCountry.'</b><br>
<b style="font-size:10pt;" class="report_head">Phone : '.WBPhone.', Email : '.WBEmail.'</b><br>
<b style="font-size:11pt;">Policy Details</b></h5>
</td>

</tr>
</table>';

$pdf->SetFont('helvetica', '', 10, '', true);
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

$html = '<br><br><b style="font-size:10pt;">1. Policy Holder Details</b><br>
<table  width="100%" border="1" cellpadding="3">
<tr>
<td>First Name</td>
<td style="text-align:right;">
'.$fname.'
</td>
</tr>
<tr>
<td>Last Name</td>
<td style="text-align:right;">
'.$lname.'
</td>
</tr>

<tr>
<td>Gender</td>
<td style="text-align:right;">
'.$gender.'
</td>
</tr>
<tr>
<td>Mobile Phone</td>
<td style="text-align:right;">
'.$phone.'
</td>
</tr>
<tr>
<td>City</td>
<td style="text-align:right;">
'.$city.'
</td>
</tr>
<tr>
<td>Street</td>
<td style="text-align:right;">
'.$street.'
</td>
</tr>
</table><br>';
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);


$html = '<br><br><b style="font-size:10pt;">2. Policy Details</b><br>
<table  width="100%" border="1" cellpadding="3">
<tr>
<td>Policy Name</td>
<td style="text-align:right;">
'.$pname.'
</td>
</tr>
<tr>
<td>Policy Number</td>
<td style="text-align:right;">
'.$policy_number.'
</td>
</tr>

<tr>
<td>Category</td>
<td style="text-align:right;">
'.$category.'
</td>
</tr>
<tr>
<td>Sub-Category</td>
<td style="text-align:right;">
'.$subcategory.'
</td>
</tr>
<tr>
<td>Sum Assured</td>
<td style="text-align:right;">
'.number_format($sum_ass).' '.WBCurrency.'
</td>
</tr>
<tr>
<td>Premium</td>
<td style="text-align:right;">
'.number_format($premium).' '.WBCurrency.'
</td>
</tr>
<tr>
<td>Tenure</td>
<td style="text-align:right;">
'.$tenure.' Month(s)
</td>
</tr>
<tr>
<td>Active Date</td>
<td style="text-align:right;">
'.$new_d.'
</td>
</tr>
<tr>
<td>Valid Through</td>
<td style="text-align:right;">
'.$new_d2.'
</td>
</tr>
</table><br>';
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
$style = array(
'border' => 2,
'vpadding' => 'auto',
'hpadding' => 'auto',
'fgcolor' => array(0,0,0),
'bgcolor' => false,
'module_width' => 1,
'module_height' => 1
);


$pdf->write2DBarcode($policy_number, 'QRCODE,L', 180, 30, 50, 50, $style, 'N');


ob_end_clean();

$pdf->Output('('.$policy_number.') '.$subcategory.' : '.$fname.' '.$lname.'.pdf', 'I');


}else{
header("location:../?page=dashboard");
}

}else{
header("location:../../");
}

?>
