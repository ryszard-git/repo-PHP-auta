<?php
session_start();
if ($_SESSION['zalogowany']!="tak") {
	echo "<script>window.location.href = 'zaloguj.php';</script>";
	exit;
}
require_once("Strona.php");
$stronka=new Strona();
$stronka->tytul="Historia wypożyczeń przez klienta";
$stronka->WyswietlNaglowek();
$stronka->nazwaokna="Historia wypożyczeń aut przez klienta";
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

$sql="SELECT id_klienta, imie_kli, nazwisko_kli FROM uzytkownicy WHERE is_admin=\"NIE\" ORDER BY nazwisko_kli";
$result=$mysqli->query($sql);
if (!$result) {
	echo "Błąd zapytania select.<br/>";
	$stronka->poexicie();
	exit;
}
// tworzenie listy rozwijanej zawierającej klientów do wyboru
$option_block="";
while ($wiersz=$result->fetch_object()) {
	$id_klienta=$wiersz->id_klienta;
	$imie_kli=$wiersz->imie_kli;
	$nazwisko_kli=$wiersz->nazwisko_kli;
	if ((!$imie_kli=="") || (!$nazwisko_kli==""))
		$option_block.="<option value=\"$id_klienta\">$nazwisko_kli $imie_kli</option>";
}

$display_block="
<form method=\"post\" action=\"wyp_klient_auta_1.php\">
<table>
<p><tr><td>wybierz klienta:</td>
<td><select name=\"id_klienta\" size=\"3\">
$option_block
</select></td>
<td><input type=\"submit\" name=\"submit\" value=\"Wykonaj zapytanie\"/></td></tr></p>
</table>
</form>
";
echo "$display_block";
$mysqli->close();
$stronka->DomknijBlok(); // div kontakt
$stronka->DomknijBlok();
$stronka->WyswietlStopke();
?>
