<?php
session_start();
if ($_SESSION['zalogowany']!="tak") {
	echo "<html><body><script>window.location.href = 'zaloguj.php';</script></body></html>";
	exit;
}
require_once("Strona.php");
$stronka=new Strona();
$stronka->tytul="Usunięcie auta";
$stronka->WyswietlNaglowek();
$stronka->nazwaokna="Usunięcie auta";
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
// tworzenie listy rozwijanej zawierającej auta do usunięcia
$option_block="";
while ($wiersz=$result->fetch_object()) {
	$id_auta=$wiersz->id_auta;
	$marka_auta=$wiersz->marka_auta;
	$option_block.="<option value=\"$id_auta\">$marka_auta</option>";
}

$display_block="
<form method=\"post\" action=\"\">
<p>Wybierz markę auta:
<select name=\"idauta\">
$option_block
</select>
<br>
<input type=\"submit\" name=\"submit\" value=\"Usuń auto\"/></p>
</form>
<br/><br/><br/>
";
echo "$display_block";
//***************************************************************************
if (isset($_POST["submit"])) {
	$id_auta=$_POST["idauta"];
	if (!$id_auta) {
		echo 'Wpisz markę auta';
		$stronka->poexicie();
		exit;
	}
	// ustawianie flagi przy usuniętym aucie
	$sql="UPDATE auta SET czy_usuniete=\"TAK\" WHERE id_auta=\"$id_auta\"";
	$result=$mysqli->query($sql);
	if (!$result) {
		echo "Błąd zapytania update.<br/>";
		$stronka->poexicie();
		exit;
	}
	echo "Auto zostało usunięte<br/>";
} // if isset
$mysqli->close();
$stronka->DomknijBlok(); // div kontakt
$stronka->DomknijBlok();
$stronka->WyswietlStopke();
?>
