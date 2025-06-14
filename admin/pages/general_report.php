<?php
require_once('../tcpdf/tcpdf.php');
if (isset($_SESSION['report'])) {
$min_date = $_SESSION['report'][0][0];
$max_date = $_SESSION['report'][0][1];
$myDateTime = DateTime::createFromFormat('Y-m-d', $min_date);
$min_date_1 = $myDateTime->format('F d, Y');
$myDateTime = DateTime::createFromFormat('Y-m-d', $max_date);
$max_date_1 = $myDateTime->format('F d, Y');

$applied_policy = 0;
$approved_policy = 0;
$denied_policy = 0;
$active_policy = 0;
$expired_policy = 0;
$pending_policy = 0;

$opened_tickets = 0;
$pending_tickets = 0;
$active_tickets = 0;
$closed_tickets = 0;

try {
$conn = new PDO('mysql:host='.DBHost.';dbname='.DBName.';charset='.DBCharset.';collation='.DBCollation.';prefix='.DBPrefix.'', DBUser, DBPass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $conn->prepare("SELECT * FROM tbl_policy_applications WHERE active_date BETWEEN ? AND ?");
$stmt->execute([$min_date, $max_date]);
$result = $stmt->fetchAll();
$applied_policy = count($result);

foreach ($result as $row) {
$months = $row[5];
switch ($row[8]) {
case '0':
$pending_policy++;
break;

case '1':
$approved_policy++;

$active_date = $row[6];
$date=date_create($active_date);
date_add($date,date_interval_create_from_date_string("$months months"));
$new_d = date_format($date,"Y-m-d");

if (new DateTime() > new DateTime($new_d)) {
$expired_policy++;
} else {
$active_policy++;
}

break;
case '2':
$denied_policy++;
break;
}

}


$stmt = $conn->prepare("SELECT * FROM tbl_tickets WHERE open_date BETWEEN ? AND ?");
$stmt->execute([$min_date, $max_date]);
$result = $stmt->fetchAll();
$opened_tickets = count($result);

foreach ($result as $row) {
switch ($row[8]) {
case '0':
$pending_tickets++;
break;

case '1':
$active_tickets++;
break;

case '2':
$closed_tickets++;
break;
}

}
}catch(PDOException $e)
{
echo "Connection failed: " . $e->getMessage();
}

$tit = 'General Report As From '.$min_date_1.' to '.$max_date_1.'';
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor(WBName);
$pdf->SetTitle($tit);
$pdf->SetSubject('General Report');
$pdf->SetKeywords('General Report');

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
<td ><img width="80" src="../assets/media/logo/'.WBLogo.'">
<h5><b style="font-size:18pt;">'.WBName.'</b>
<br><b style="font-size:10pt;">'.WBCity.', '.WBStreet.', '.WBCountry.'</b><br>
<b style="font-size:10pt;" class="report_head">Phone : '.WBPhone.', Email : '.WBEmail.'</b><br>
<b style="font-size:11pt;">'.$tit.'</b></h5>
</td>

</tr>
</table>';

$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);


$pdf->SetFont('helvetica', '', 10, '', true);

$html = '<br><br><b style="font-size:10pt;">1. Insurance Policies Summary</b><br><br>
<table  width="55%" border="1" cellpadding="3">
<tr>
<td>Applied Insurance Policies</td>
<td style="text-align:right;">
'.number_format($applied_policy).'
</td>
</tr>
<tr>
<td>Pending Insurance Policies</td>
<td style="text-align:right;">
'.number_format($pending_policy).'
</td>
</tr>
<tr>
<td>Approved Insurance Policies</td>
<td style="text-align:right;">
'.number_format($approved_policy).'
</td>
</tr>

<tr>
<td>Denied Insurance Policies</td>
<td style="text-align:right;">
'.number_format($denied_policy).'
</td>
</tr>
<tr>
<td>Active Insurance Policies</td>
<td style="text-align:right;">
'.number_format($active_policy).'
</td>
</tr>
<tr>
<td>Expired Insurance Policies</td>
<td style="text-align:right;">
'.number_format($expired_policy).'
</td>
</tr>
</table><br>';
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

$html = '<br><br><b style="font-size:10pt;">2. Support Tickets Summary</b><br><br>
<table  width="55%" border="1" cellpadding="3">
<tr>
<td>Opened Tickets</td>
<td style="text-align:right;">
'.number_format($opened_tickets).'
</td>
</tr>
<tr>
<td>Pending Tickets</td>
<td style="text-align:right;">
'.number_format($pending_tickets).'
</td>
</tr>

<tr>
<td>Active Tickets</td>
<td style="text-align:right;">
'.number_format($active_tickets).'
</td>
</tr>
<tr>
<td>Closed Tickets</td>
<td style="text-align:right;">
'.number_format($closed_tickets).'
</td>
</tr>
</table><br>';
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

$html = '<b>Report generated on : '.date('F d, Y H:i:s A').'</b>';
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

ob_end_clean();
$pdf->Output(''.$tit.'.pdf', 'I');
}else{
header("location:./?page=dashboard");
}
