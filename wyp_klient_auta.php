<?php
session_start();
if ($_SESSION['zalogowany']!="tak") {
	echo "<html><body><script>window.location.href = 'zaloguj.php';</script></body></html>";
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
$option_block='<option value="">-- Wybierz klienta --</option>';
while ($wiersz=$result->fetch_object()) {
	$id_klienta=$wiersz->id_klienta;
	$imie_kli=$wiersz->imie_kli;
	$nazwisko_kli=$wiersz->nazwisko_kli;
	if ((!$imie_kli=="") || (!$nazwisko_kli==""))
		$option_block.="<option value=\"$id_klienta\">$nazwisko_kli $imie_kli</option>";
}

$display_block="
<form method=\"post\" action=\"\">
<select name=\"id_klienta\">
$option_block
</select>
<br><br><br>
<input type=\"submit\" name=\"submit\" value=\"Wykonaj zapytanie\"/>
</form>
";
echo "$display_block";

if (isset($_POST['submit']))
{
	$id_klienta=$_POST["id_klienta"];
if (!$id_klienta) {
	echo 'Wybierz klienta<br/>';
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
echo $liczba_aut . " pozycji.</p><br>";

if ($liczba_aut > 0) {
	echo '<div class="przeglad-klient-auto przeglad">';
	echo "<div style='background-color:#444; font-weight:bold;'><div>Marka auta</div><div>Data wynajmu</div><div>Data zwrotu</div></div>";

// wyświetlenie zestawienia wypożyczonych aut
	for ($nr_wiersza = 0; $nr_wiersza < $liczba_aut; $nr_wiersza++)
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
