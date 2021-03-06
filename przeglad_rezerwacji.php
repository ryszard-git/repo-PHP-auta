<?php
session_start();
if ($_SESSION['zalogowany']!="tak") {
	echo "<html><body><script>window.location.href = 'zaloguj.php';</script></body></html>";
	exit;
}
require_once("Strona.php");
$stronka=new Strona();
$stronka->tytul="Przeglądanie rezerwacji";
$stronka->WyswietlNaglowek();
$stronka->nazwaokna="Przeglądanie rezerwacji";
$stronka->WyswietlMenu("MenuAdmina");
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

$sql="SELECT uzytkownicy.imie_kli, uzytkownicy.nazwisko_kli, uzytkownicy.telefon_kli, auta.marka_auta, wynajem.data_wynajmu, wynajem.data_zwrotu FROM uzytkownicy, auta, wynajem WHERE uzytkownicy.id_klienta=wynajem.id_klienta AND auta.id_auta=wynajem.id_auta AND auta.czy_wynajete=\"TAK\" AND wynajem.czy_wynajete=\"TAK\" ORDER BY wynajem.data_zwrotu";

$result=$mysqli->query($sql);
if (!$result) {
	echo "Błąd zapytania SELECT.<br/>";
	$stronka->poexicie1();
	exit;
}
// wyznaczanie liczby wierszy w tabeli
$liczba_klientow = $result->num_rows;

echo "<p>Lista klientów zawiera ";
echo $liczba_klientow . " pozycji.</p>";

if ($liczba_klientow!=0) {
	echo '<div class="przeglad-rezerwacji przeglad">'; //poczatek diva - pojemnika
	echo "<div style='background-color:#444; font-weight:bold;'><div> Imię </div><div> Nazwisko </div><div> Nr telefonu </div><div> Marka auta </div><div> Data wynajmu </div><div> Data zwrotu </div></div>";
// wyświetlenie zestawienia wypożyczonych aut
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
echo "</div>"; // koniec diva pojemnika
}

$mysqli->close();
$stronka->DomknijBlok();
$stronka->WyswietlStopke();
?>
