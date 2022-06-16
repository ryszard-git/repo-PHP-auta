<?php
session_start();
if ($_SESSION['zalogowany']!="tak") {
	echo "<html><body><script>window.location.href = 'zaloguj.php';</script></body></html>";
	exit;
}
require_once("Strona.php");
$stronka=new Strona();
$stronka->tytul="Dodanie auta";
$stronka->WyswietlNaglowek();
$stronka->nazwaokna="Dodanie auta";
$stronka->WyswietlMenu("MenuAdmina");
$stronka->WyswietlZawartosc();
?>


	<div class="kontakt">

		<form enctype="multipart/form-data" method="post" action="">
		<table>
		<tr><td>Wpisz markę auta:</td><td><input type="text" name="marka_auta" size="30" maxlength="70"/></td><tr>
		<tr><td>Cena:</td><td><input type="text" name="cena" size="5" maxlength="5" /></td></tr>
		<tr><td>Zdjęcie:</td><td><input type="file" name="zdjecie" /></td></tr>
		</table>
		<p><input type="submit" name="submit" value="Dodaj auto"/></p>
		</form>
		<br/><br/><br/>

<?php
if (isset($_POST['submit'])) {
	require "config.php";
	$marka_auta=addslashes(trim($_POST["marka_auta"]));
//	$zdjecie=basename($_POST['zdjecie']);

	if (!$marka_auta) {
		echo "Wpisz markę auta";
		$stronka->poexicie();
		exit;
	}

	$cena=intval(trim($_POST["cena"]));
	if (!$cena) {
		if (empty($cena)) {
			echo '<br />Wpisz poprawną cenę auta !!!';
			$stronka->poexicie();
			exit;
		}
	}

	if (!is_numeric($cena)) {
		echo '<br />Cena nie jest liczbą - wprowadż wartość numeryczną !!!';
		$stronka->poexicie();
		exit;
	}

	if (empty($_FILES['zdjecie']['name'])) //badanie czy zostało wskazane zdjęcie auta
	{
		echo 'Wprowadź zdjęcie auta.<br />';
		$stronka->poexicie();
		exit;
	}
// początek obsługi wysyłania pliku

	if ($_FILES['zdjecie']['error'] >0)
	{
		echo 'Problem: ';
		switch ($_FILES['zdjecie']['error'])
		{
			case 1: echo 'Rozmiar pliku przekroczył wartość upload_max_filesize.<br />'; break;
			case 2: echo 'Rozmiar pliku przekroczył wartość max_file_size.<br />'; break;
			case 3: echo 'Plik wysłany tylko częściowo.<br />'; break;
			case 4: echo 'Nie wysłano żadnego pliku ze zdjęciem auta.<br />'; break;
			case 6: echo 'Nie można wysłać pliku: Nie wskazano katalogu tymczasowego.<br />'; break;
			case 7: echo 'Wysłanie pliku nie powiodło się: Nie zapisano pliku na dysku.<br />'; break;
		}
		$stronka->poexicie();
		exit;
	}
	if ($_FILES['zdjecie']['type'] !='image/jpeg')
	{
		echo 'Plik nie zawiera grafiki<br />';
		$stronka->poexicie();
		exit;
	}
	$lokalizacja_pliku=$dir_name.$_FILES['zdjecie']['name'];
	if (is_uploaded_file($_FILES['zdjecie']['tmp_name']))
	{
		if (!move_uploaded_file($_FILES['zdjecie']['tmp_name'],$lokalizacja_pliku))
		{
			echo 'Plik nie może być skopiowany do katalogu.<br />';
			$stronka->poexicie();
			exit;
		}
	}
	else
	{
		echo 'Możliwy atak podczas wysyłania pliku: '.$_FILES['zdjecie']['name'].'<br />';
		$stronka->poexicie();
		exit;
	}
	echo 'Plik ze zdjęciem auta wysłany.<br />';
// koniec obsługi wysyłania pliku

	$zdjecie=addslashes($_FILES['zdjecie']['name']);

	@ $mysqli = new mysqli($host,$db_user,$db_passwd,$db_name);
	if ($mysqli->connect_error) {
		echo 'Próba połączenia z bazą nie powiodła się.<br />';
		echo $mysqli->connect_error;
		$stronka->poexicie();
		exit;
	}

	$result=$mysqli->set_charset("utf8");
	if (!$result) {
		echo "Błąd ustawienia kodowania.<br />";
		$stronka->poexicie();
		exit;
	}
	// sprawdzenie czy istnieje auto o takiej samej nazwie co wprowadzane ($ilosc=0 - nie istnieje)
	$sql="SELECT * FROM auta WHERE marka_auta=\"$marka_auta\" AND czy_usuniete=\"NIE\"";
	$result=$mysqli->query($sql);
	if (!$result) {
		echo "Błąd zapytania SELECT.<br />";
		$stronka->poexicie();
		exit;
	}
	$ilosc=$result->num_rows;

	if ($ilosc === 0) {
		$czy_wynajete="NIE";
		$czy_usuniete="NIE";
		$sql="INSERT INTO auta (marka_auta, czy_wynajete, czy_usuniete, cena_auta, zdjecie_auta)
		VALUES (\"$marka_auta\", \"$czy_wynajete\", \"$czy_usuniete\", \"$cena\", \"$zdjecie\")";
		$result=$mysqli->query($sql);
		if (!$result) {
			echo "Błąd zapytania INSERT.<br />";
			$stronka->poexicie();
			exit;
		}
		echo "Dodano auto do bazy danych<br />";
	} else {
		echo "Marka auta o podanej nazwie już istnieje<br />";
		$stronka->poexicie();
		exit;
	}

	$mysqli->close();
} // if isset

$stronka->DomknijBlok(); // div kontakt
$stronka->DomknijBlok();
$stronka->WyswietlStopke();
?>
