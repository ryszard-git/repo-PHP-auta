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

$id_auta=$_POST["idauta"];
if (!$id_auta) {
	echo '<br/>Wpisz markę auta';
	$stronka->poexicie1();
	exit;
}

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
	echo '<table class="tabela" border="0" cellspacing="1" cellpadding="5">';
	echo "<tr style=background-color:#444;><th>Imię</th><th>Nazwisko</th><th>Nr telefonu</th><th>Data wynajmu</th><th>Data zwrotu</th></tr>";

	// wyświetlenie zestawienia klientów
	for ($nr_wiersza = 0; $nr_wiersza < $liczba_klientow; $nr_wiersza++)
	  {
// ***** ustawianie naprzemiennego koloru wierszy tabeli
		$tr_wiersz=$nr_wiersza % 2;
		if ($tr_wiersz===0) { $kolor='#777' ; }
		else { $kolor='#888' ; }
    		echo "<tr style=background-color:$kolor;>";
// ******************************************************
	    // odczytanie kolejnego wiersza tabeli
	    $wiersz = $result->fetch_row();
	    $tekst="";

	    	for ($nr_kolumny = 0; $nr_kolumny < count($wiersz); $nr_kolumny++)
	    	{
	      	$tekst .= "<td>".$wiersz[$nr_kolumny]." </td>";
	    	}
	    echo $tekst;
	    echo "</tr>";
	  }
	echo "</table>";
}
$mysqli->close();
$stronka->DomknijBlok();
$stronka->WyswietlStopke();
?>
