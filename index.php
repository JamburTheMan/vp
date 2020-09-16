<?php
$userName = "Mart Ambur";
$fullTimeNow = date("d.m.Y H:i:s");
$hourNow = date("H");
$partOfDay = " aeg";
if ($hourNow < 7) {
    $partOfDay = "keha puhanuks";
}
if ($hourNow >= 8 and $hourNow < 16) {
    $partOfDay = "pea targaks";
}
if ($hourNow >= 16 and $hourNow < 18) {
    $partOfDay = "keha võimsaks";
}
if ($hourNow >= 18 and $hourNow < 20) {
    $partOfDay = "elu mõnusaks";
}
if ($hourNow >= 22 and $hourNow < 23) {
    $partOfDay = "keha puhtaks";
}

$semesterStart = new DateTime("2020-8-31");
$semesterEnd = new DateTime("2020-12-13");
//get diff
$semesterDuration = $semesterStart->diff($semesterEnd);
$semesterDurationDays = $semesterDuration->format("%r%a");
// % semster has passed
$today = new DateTime("now");
$semesterPassed = $semesterStart->diff($today)->format("%r%a");
$semesterPercent = $semesterPassed * 100 / $semesterDurationDays;
//today
$today = new DateTime("now");
$fromsemesterStartDays = $semesterStart->diff($today)->format("%r%a")
?>

<!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="utf-8">
	<title><?php echo $userName; ?> programmeerib veebi</title>

</head>
<body>
<div>
	<h1><?php echo $userName; ?></h1>
	<p>See veebileht on loodud õppetöö käigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
	<p>Leht on loodud veebiprogrammeerimise kursuse raames <a href="http://www.tlu.ee">Tallinna Ülikooli</a>
		Digitehnoloogiate instituudis.</p>
	<p>Lehe avamise hetkel oli: <?php echo $fullTimeNow; ?>.</p>
	<p><?php echo "Parajasti on " . $partOfDay . " tegemise aeg."; ?></p>
	<p><?php echo "Semestri pikkus on " . $semesterDurationDays . " päeva."; ?></p>
	<p><?php echo "Semestri algusest on möödunud " . $fromsemesterStartDays . " päeva."; ?></p>
	<p><?php echo "Semestrist on läbitud " . $semesterPercent . "%"; ?></p>
</div>
</body>
</html>