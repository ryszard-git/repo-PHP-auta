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
<form method=\"post\" action=\"\">
<label>&nbsp;&nbsp;&nbsp;Wybierz auto:</label>
<br>
<select name=\"idauta\">
$option_block
</select>
<br><br><br>
<input type=\"submit\" name=\"submit\" value=\"Wykonaj zapytanie\"/></p>
</form>
";
echo "$display_block";

if (isset($_POST['submit']))
{
	$id_auta=$_POST["idauta"];
	if (!$id_auta) {
		echo '<br/>Wpisz markę auta';
		$stronka->poexicie1();
		exit;
	}

	require_once "config.php";

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
	// zapytanie o markę auta
	$sql="SELECT marka_auta FROM auta WHERE id_auta=\"$id_auta\"";
	$result=$mysqli->query($sql);
	if (!$result) {
		echo "Błąd zapytania select o markę auta.<br/>";
		$stronka->poexicie1();
		exit;
	}
	$wiersz=$result->fetch_object();
	$marka_auta=$wiersz->marka_auta;
	echo "<p>Auto: $marka_auta </p>";

	// ustawianie zapytania o historię wypożyczeń auta
	$sql="SELECT uzytkownicy.imie_kli, uzytkownicy.nazwisko_kli, uzytkownicy.telefon_kli, wynajem.data_wynajmu, wynajem.data_zwrotu FROM uzytkownicy, auta, wynajem WHERE uzytkownicy.id_klienta=wynajem.id_klienta AND auta.id_auta=wynajem.id_auta AND wynajem.id_auta=\"$id_auta\" AND auta.czy_wynajete=\"NIE\" AND wynajem.czy_wynajete=\"NIE\" ORDER BY wynajem.data_zwrotu";

	$result=$mysqli->query($sql);
	if (!$result) {
		echo "Błąd zapytania select.<br/>";
		$stronka->poexicie1();
		exit;
	}

	// wyznaczanie liczby wierszy w tabeli
	$liczba_klientow = $result->num_rows;

	echo "<p>Lista klientów zawiera ";
	echo $liczba_klientow . " pozycji.</p>";

	if ($liczba_klientow > 0) {
		echo '<div class="przeglad-auto-klient przeglad">';
		echo "<div style='background-color:#444; font-weight:bold;'><div>Imię</div><div>Nazwisko</div><div>Nr telefonu</div><div>Data wynajmu</div><div>Data zwrotu</div></div>";

		// wyświetlenie zestawienia klientów
		for ($nr_wiersza = 0; $nr_wiersza < $liczba_klientow; $nr_wiersza++)
		{
	// ***** ustawianie naprzemiennego koloru wierszy tabeli
			$tr_wiersz=$nr_wiersza % 2;
			if ($tr_wiersz===0) { $kolor='#777' ; }
			else { $kolor='#888' ; }
			echo "<div style=background-color:$kolor;>";
	// ******************************************************
			// odczytanie kolejnego wiersza tabeli
			$wiersz = $result->fetch_row();
			$tekst="";

			for ($nr_kolumny = 0; $nr_kolumny < count($wiersz); $nr_kolumny++)
			{
				$tekst .= "<div>".$wiersz[$nr_kolumny]." </div>";
			}
			echo $tekst;
			echo "</div>";
		}
		echo "</div>";
	}
}
$mysqli->close();
$stronka->DomknijBlok(); // div kontakt
$stronka->DomknijBlok();
$stronka->WyswietlStopke();
?>
