<?php
require("header.php");
require("../../../config.php");

$userName = "Mart Ambur";
$fullTimeNow = date("d.m.Y H:i:s");
$hourNow = date("H");
$partOfDay = " aeg";
$weekdayNamesET = [
	"esmaspäev",
	"teisipäev",
	"kolmapäev",
	"neljapäev",
	"reede",
	"laupäev",
	"pühapäev"
];
$monthNamesET = [
	"jaanuar",
	"veebruar",
	"märts",
	"aprill",
	"mai",
	"juuni",
	"juuli",
	"august",
	"september",
	"oktoober",
	"november",
	"detsember"
];

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
$fromsemesterStartDays = $semesterStart->diff($today)->format("%r%a");
$weekDayNow = date("N");
$picFiles = array_slice(scandir("../vp_pics"), 2);
$imgHTMLs = [];
$i = 0;
foreach($picFiles as $picFile) {
	$i++;
    $imgHTML = '<img src="../vp_pics/' . $picFile . '" alt="TLU pilt number ' . $i .'">';
	array_push($imgHTMLs, $imgHTML);
}

$db = 'if20_ambur_2';
$con = new mysqli($serverhost, $serverusername, $serverpassword, $db);
$stmt = $con->prepare('INSERT INTO my_ideas (idea) VALUES (?)');

if (isset($_POST['ideaSubmit']) && !empty($_POST['ideaInput'])) {
	echo "POST'i sees on midagi <br>";
    print_r($_POST['ideaInput']);
    echo $con->error;
    $stmt->bind_param('s', $_POST['ideaInput']);
    $stmt->execute();
    $stmt->close();
    $con->close();
}

$ideaHTML = "";
$con = new mysqli($serverhost, $serverusername, $serverpassword, $db);
$stmt = $con->prepare('SELECT idea FROM my_ideas');
$stmt->bind_result($ideaFromDB);
$stmt->execute();
while ($stmt->fetch()) {
	$ideaHTML .= '<p>' . $ideaFromDB . '</p>';
}
$stmt->close();
$con->close();
?>




<div>
	<img src="../img/vp_banner.png" alt="Veebiprogrammerimise kursuse logo">
	<h1><?php echo $userName; ?></h1>
	<p>See veebileht on loodud õppetöö käigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
	<p>Leht on loodud veebiprogrammeerimise kursuse raames <a href="http://www.tlu.ee">Tallinna Ülikooli</a>
		Digitehnoloogiate instituudis.</p>
	<p>Lehe avamise hetkel oli: <?php echo $weekdayNamesET[$weekDayNow - 1] . ", " . $fullTimeNow; ?>.</p>
	<p><?php echo "Parajasti on " . $partOfDay . " tegemise aeg."; ?></p>
	<p><?php echo "Semestri pikkus on " . $semesterDurationDays . " päeva."; ?></p>
	<p><?php echo "Semestri algusest on möödunud " . $fromsemesterStartDays . " päeva."; ?></p>
	<p><?php echo "Semestrist on läbitud " . $semesterPercent . "%"; ?></p>
	<p><?php echo $ideaHTML ?></p>
	<form method="POST">
		<label>Kirjutage esmimene pähe tulnud mõte!"</label>
		<input type="text" name="ideaInput" placeholder="mõttekoht">
		<input type="submit" name="ideaSubmit" value="saada mõte teele" >
	</form>
	<hr>
	<?php
    foreach($imgHTMLs as $imgHTML) {
        echo $imgHTML;
    }	 ?>
</div>
</body>
</html>