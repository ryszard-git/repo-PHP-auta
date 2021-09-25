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

$id_klienta=$_POST["id_klienta"];
if (!$id_klienta) {
	echo 'Wpisz imię i nazwisko klienta<br/>';
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
// zapytanie o imię i nazwisko klienta
$sql="SELECT imie_kli, nazwisko_kli, telefon_kli FROM uzytkownicy WHERE id_klienta=\"$id_klienta\"";
$result=$mysqli->query($sql);
if (!$result) {
	echo "Błąd zapytania select o personalia klienta.<br/>";
	$stronka->poexicie1();
	exit;
}
$wiersz=$result->fetch_object();
$imie_kli=$wiersz->imie_kli;
$nazwisko_kli=$wiersz->nazwisko_kli;
$telefon_kli=$wiersz->telefon_kli;
echo "<p>Klient: $nazwisko_kli $imie_kli, telefon: $telefon_kli</p>";

// ustawianie zapytania o historię wypożyczeń aut przez danego klienta
$sql="SELECT auta.marka_auta, wynajem.data_wynajmu, wynajem.data_zwrotu FROM uzytkownicy, auta, wynajem WHERE uzytkownicy.id_klienta=wynajem.id_klienta AND auta.id_auta=wynajem.id_auta AND wynajem.id_klienta=\"$id_klienta\" AND wynajem.czy_wynajete=\"NIE\" ORDER BY wynajem.data_zwrotu";

$result=$mysqli->query($sql);
if (!$result) {
	echo "Błąd zapytania select.<br/>";
	$stronka->poexicie1();
	exit;
}

// wyznaczanie liczby wierszy w tabeli
$liczba_aut = $result->num_rows;

echo "<p>Lista aut zawiera ";
echo $liczba_aut . " pozycji.</p>";

if ($liczba_aut > 0) {
	echo '<table border="0" class="tabela" cellspacing="1" cellpadding="5">';
	echo "<tr style=background-color:#444;><th>Marka auta</th><th>Data wynajmu</th><th>Data zwrotu</th></tr>";

// wyświetlenie zestawienia wypożyczonych aut
	for ($nr_wiersza = 0; $nr_wiersza < $liczba_aut; $nr_wiersza++)
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
