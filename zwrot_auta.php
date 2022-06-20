<?php
session_start();
if ($_SESSION['zalogowany']!="tak") {
	echo "<html><body><script>window.location.href = 'zaloguj.php';</script></body></html>";
	exit;
}
require_once("Strona.php");
$stronka=new Strona();
$stronka->tytul="Zwrot auta";
$stronka->WyswietlNaglowek();
$stronka->nazwaokna="Zwrot auta";
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
$sql="SELECT id_auta, marka_auta FROM auta WHERE czy_wynajete=\"TAK\" ORDER BY marka_auta";
$result=$mysqli->query($sql);
if (!$result) {
	echo "Błąd zapytania.<br/>";
	$stronka->poexicie();
	exit;
}

// przygotowanie listy rozwijanej zawierającej wynajęte auta
$option_block="";
while ($wiersz=$result->fetch_object()) {
	$id_auta=$wiersz->id_auta;
	$marka_auta=$wiersz->marka_auta;
	$option_block.="<option value=\"$id_auta\">$marka_auta</option>";
}

$display_block="
<form method=\"post\" action=\"\">
<label>&nbsp;&nbsp;&nbsp;Wybierz auto:</label>
<br>
<select name=\"id_auta\">
$option_block
</select>
<br><br>
<input type=\"submit\" name=\"submit\" value=\"Zwrot auta\"/></p>
</form>
<br/><br/><br/>
";
echo "$display_block";

//***********************************************************************
if (isset($_POST['submit'])) {
	$id_auta=$_POST["id_auta"];
	if (!$id_auta) {
		echo "Wpisz markę auta<br/>";
		$stronka->poexicie();
		exit;
	}

	$mysqli->autocommit(FALSE);
	// zapisanie znacznika wskazującego wynajęcie auta do tabeli AUTA
	$sql="UPDATE auta SET czy_wynajete=\"NIE\" WHERE id_auta=\"$id_auta\"";
	$result=$mysqli->query($sql);
	if (!$result) {
		echo "Błąd zapytania AUT.<br/>";
		$stronka->poexicie();
		exit;
	}
	// zapisanie znacznika wskazującego wynajęcie auta do tabeli WYNAJEM
	$sql="UPDATE wynajem SET czy_wynajete=\"NIE\" WHERE id_auta=\"$id_auta\"";
	$result=$mysqli->query($sql);
	if (!$result) {
		echo "Błąd zapytania WYN.<br/>";
		$mysqli->rollback();
		$stronka->poexicie();
		exit;
	}
	$mysqli->commit();
	echo "Auto zostało zwrócone<br/>";
} // if isset
$mysqli->close();
$stronka->DomknijBlok(); // div kontakt
$stronka->DomknijBlok();
$stronka->WyswietlStopke();
?>
