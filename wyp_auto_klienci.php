<?php
session_start();
if ($_SESSION['zalogowany']!="tak") {
	echo "<html><body><script>window.location.href = 'zaloguj.php';</script></body></html>";
	exit;
}
require_once("Strona.php");
$stronka=new Strona();
$stronka->tytul="Historia wypożyczeń auta";
$stronka->WyswietlNaglowek();
$stronka->nazwaokna="Historia wypożyczeń auta";
$stronka->WyswietlMenu("MenuAdmina");
$stronka->WyswietlZawartosc();
echo '<div class="kontakt">';

require "config.php";

@ $mysqli = new mysqli($host,$db_user,$db_passwd,$db_name);
if ($mysqli->connect_error) {
	echo 'Próba połączenia z bazą nie powiodła się.<br/>';
	echo $mysqli->connect_error;
	$stronka->poexicie();
	exit;
}

$result=$mysqli->set_charset("utf8");
if (!$result) {
	echo "Błąd ustawienia kodowania.<br/>";
	$stronka->poexicie();
	exit;
}

$sql="SELECT id_auta, marka_auta FROM auta WHERE czy_usuniete=\"NIE\" AND czy_wynajete=\"NIE\" ORDER BY marka_auta";
$result=$mysqli->query($sql);
if (!$result) {
	echo "Błąd zapytania select.<br/>";
	$stronka->poexicie();
	exit;
}
// tworzenie listy rozwijanej zawierającej auta do wyboru
$option_block="";
while ($wiersz=$result->fetch_object()) {
	$id_auta=$wiersz->id_auta;
	$marka_auta=$wiersz->marka_auta;
	$option_block.="<option value=\"$id_auta\">$marka_auta</option>";
}

$display_block="
<form method=\"post\" action=\"wyp_auto_klienci_1.php\">
<p>Wybierz auto:
<select name=\"idauta\">
$option_block
</select>
<br>
<input type=\"submit\" name=\"submit\" value=\"Wykonaj zapytanie\"/></p>
</form>
";
echo "$display_block";
$mysqli->close();
$stronka->DomknijBlok(); // div kontakt
$stronka->DomknijBlok();
$stronka->WyswietlStopke();
?>
