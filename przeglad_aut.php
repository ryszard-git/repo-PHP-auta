<?php
session_start();
if ($_SESSION['zalogowany']!="tak") {
	echo "<html><body><script>window.location.href = 'zaloguj.php';</script></body></html>";
	exit;
}
require_once("Strona.php");
$stronka=new Strona();
$stronka->tytul="Przeglądanie aut";
$stronka->WyswietlNaglowek();
$stronka->nazwaokna="Przeglądanie aut do wynajęcia";
$stronka->WyswietlMenu("MenuUsera");
$stronka->WyswietlZawartosc();

require "config.php";

@ $mysqli = new mysqli($host,$db_user,$db_passwd,$db_name);
if ($mysqli->connect_error) {
	echo 'Próba połączenia z bazą nie powiodła się.<br/>';
	echo $mysqli->connect_error;
	$stronka->poexicie1();
	exit;
}

$result=$mysqli->set_charset("utf8");
if (!$result) {
	echo "Błąd ustawienia kodowania.<br/>";
	$stronka->poexicie1();
	exit;
}

$sql="SELECT marka_auta, zdjecie_auta, cena_auta, id_auta FROM auta WHERE czy_usuniete=\"NIE\" AND czy_wynajete=\"NIE\" ORDER BY marka_auta";

$result=$mysqli->query($sql);
if (!$result) {
	echo "Błąd zapytania SELECT.<br/>";
	$stronka->poexicie1();
	exit;
}
$ilosc_aut=$result->num_rows;
if ($ilosc_aut===0) {
	echo '<p style=text-align:center;<br/><br/><br/>Brak aut do wynajęcia</p>';
}
echo '<table cellpadding="15" class="tabela">';
//wyświetlenie dostępnych aut
while ($wiersz=$result->fetch_object()) {
	$id_auta=$wiersz->id_auta;
	$marka_auta=$wiersz->marka_auta;
	$zdjecie=$dir_name.$wiersz->zdjecie_auta;
	$cena=$wiersz->cena_auta;
	echo "<tr><td><span style=\"font-size: 18px;\">$marka_auta</span><br/></td></tr>";
	echo "<tr><td><img src=\"$zdjecie\" alt=\"auto\" width=\"250px\" height=\"150px\" /></td>";
	echo "<td>Opłata za wypożyczenie auta: <strong>$cena</strong> PLN za dobę</td>";
	echo "<td><a href=\"rezerwacja_auta.php?idauta=$id_auta\"><button type=\"button\" class=\"button-rezerwuj\">Rezerwuj auto</button></a></td></tr>";
	echo '<tr><td colspan="3"><hr/><br/></td></tr>';

}
echo '</table>';
$mysqli->close();
$stronka->DomknijBlok();
$stronka->WyswietlStopke();
?>
