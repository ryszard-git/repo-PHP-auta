<?php
session_start();
if ($_SESSION['zalogowany']!="tak") {
	echo "<script>window.location.href = 'zaloguj.php';</script>";
	exit;
}
require_once("Strona.php");
$stronka=new Strona();
$stronka->tytul="Edycja danych auta";
$stronka->WyswietlNaglowek();
$stronka->nazwaokna="Edycja danych auta";
$stronka->WyswietlMenu("MenuAdmina");
$stronka->WyswietlZawartosc();

echo '<div class="kontakt">';

require "config.php";

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

$sql="SELECT id_auta, marka_auta FROM auta WHERE czy_usuniete=\"NIE\" AND czy_wynajete=\"NIE\" ORDER BY marka_auta";
$result=$mysqli->query($sql);
if (!$result) {
	echo "Błąd zapytania select.<br />";
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
<p>Wybierz markę auta:
<select name=\"idauta\">
$option_block
</select>
<input type=\"submit\" name=\"submit1\" value=\"Wybierz auto\"/></p>
</form>
";
echo "$display_block";

echo '<br /><br /><br />';

if (isset($_POST["submit1"])) {

	$idauta=$_POST["idauta"];
	//wczytanie z bazy ceny wybranego powyżej auta
	$sql="SELECT cena_auta, marka_auta FROM auta WHERE id_auta=\"$idauta\"";
	$result=$mysqli->query($sql);
	if (!$result) {
		echo "Błąd zapytania select o cenę auta.<br />";
		$stronka->poexicie();
		exit;
	}
	$wiersz=$result->fetch_object();
	$cena=$wiersz->cena_auta;
	$marka_auta1=$wiersz->marka_auta;

	echo "Wybrane auto: $marka_auta1 <br /><br />";

	$dane="
	<form enctype=\"multipart/form-data\" method=\"post\" action=\"\">
	<table>
	<tr><td>Cena:</td><td><input type=\"text\" name=\"cena\" value=\"$cena\" size=\"5\" /></td></tr>
	<tr><td>Zdjęcie:</td><td><input type=\"file\" name=\"zdjecie\" /></td></tr>
	</table>
	<input type=\"hidden\" name=\"idauta\" value=\"$idauta\" /><br/>
	<input type=\"submit\" name=\"submitedit\" value=\"Edytuj dane auta\"/>
	</form>
	<br /><br /><br />
	";
	echo $dane;
} //koniec if(isset)

//*****************************************************************

if (isset($_POST["submitedit"])) {
	$idauta=$_POST["idauta"];
	if (!$idauta) {
		echo '<br />Wpisz markę auta';
		$stronka->poexicie();
		exit;
	}
	// ustawianie zdjęcia i ceny przy aucie
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

	// początek obsługi wysyłania pliku
	if ($_FILES['zdjecie']['error'] !=4)
	{
		if ($_FILES['zdjecie']['error'] >0)
		{
			echo 'Problem: ';
			switch ($_FILES['zdjecie']['error'])
			{
				case 1: echo 'Rozmiar pliku przekroczył wartość upload_max_filesize.<br />'; break;
				case 2: echo 'Rozmiar pliku przekroczył wartość max_file_size.<br />'; break;
				case 3: echo 'Plik wysłany tylko częściowo.<br />'; break;
				//case 4: echo 'Nie wysłano żadnego pliku ze zdjęciem auta.<br />'; break;
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
		$zdjecie=addslashes($_FILES['zdjecie']['name']);
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
	}
// koniec obsługi wysyłania pliku

	if (!empty($_FILES['zdjecie']['name']))
	{
		$sql="UPDATE auta SET cena_auta=\"$cena\", zdjecie_auta=\"$zdjecie\" WHERE id_auta=\"$idauta\"";
	}
	else 
	{
		$sql="UPDATE auta SET cena_auta=\"$cena\" WHERE id_auta=\"$idauta\"";
	}
	$result=$mysqli->query($sql);
	if (!$result)
	{
		echo "Błąd zapytania update.<br />";
		$stronka->poexicie();
		exit;
	}
	echo "<br />Dane auta zostały zaktualizowane.<br />";
} //if(isset)
$mysqli->close();
$stronka->DomknijBlok(); // div kontakt
$stronka->DomknijBlok();
$stronka->WyswietlStopke();
?>
