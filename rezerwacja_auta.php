<?php
session_start();
if ($_SESSION['zalogowany']!="tak") {
	echo "<html><body><script>window.location.href = 'zaloguj.php';</script></body></html>";
	exit;
}
require_once("Strona.php");
$stronka=new Strona();
$stronka->tytul="Rezerwacja auta";
$stronka->WyswietlNaglowek();
$stronka->nazwaokna="Rezerwacja auta";
$stronka->WyswietlMenu("MenuUsera");
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
// budowanie rozwijanej listy zawierającej dostępne auta
$sql="SELECT id_auta, marka_auta FROM auta WHERE czy_wynajete=\"NIE\" AND czy_usuniete=\"NIE\" ORDER BY marka_auta";
$result=$mysqli->query($sql);
if (!$result) {
	echo "Błąd zapytania SELECT.<br/>";
	$stronka->poexicie();
	exit;
}
$option_block="";

if (isset($_GET["idauta"])) {
	$idauta=$_GET["idauta"];
}

// *** tworzenie listy rozwijanej dostępnych aut ***
while ($wiersz=$result->fetch_object()) {
	$id_auta=$wiersz->id_auta;
	$marka_auta=$wiersz->marka_auta;
	if (isset($idauta) && ($idauta===$id_auta)) {
		$option_block.="<option selected=\"selected\" value=\"$id_auta\">$marka_auta</option>";
	} else {
	$option_block.="<option value=\"$id_auta\">$marka_auta</option>";
	}
}

// *** pobieranie danych użytkownika z bazy ***
$login_name=$_SESSION['login_name'];
$sql="SELECT * FROM uzytkownicy WHERE login_name=\"$login_name\"";
$result=$mysqli->query($sql);
if (!$result) {
	echo "Błąd zapytania o dane klienta.<br/>";
	$stronka->poexicie();
	exit;
}

$wiersz=$result->fetch_object();
	$imie=$wiersz->imie_kli;
	$nazwisko=$wiersz->nazwisko_kli;
	$adres=$wiersz->adres_kli;
	$miasto=$wiersz->miasto_kli;
	$telefon=$wiersz->telefon_kli;
	$email=$wiersz->email_kli;
	$nr_prawa_jazdy=$wiersz->nr_prawa_jazdy_kli;

//przygotowanie listy rozwijanej dla daty wynajmu
// $dw_dd - dzień daty wynajmu
// $dw_mm - miesiąc daty wynajmu
// $dw_rr - rok daty wynajmu

$data_wynajmu_option_dd='<option value="puste">- dzień -</option>';
$data_wynajmu_option_mm='<option value="puste">- miesiąc -</option>';
$data_wynajmu_option_rr='<option value="puste">- rok -</option>';

for ($dw_dd=1; $dw_dd<=31; $dw_dd++) {
	if ($dw_dd<10) {
		$dw_dd="0".$dw_dd;
	}
	$data_wynajmu_option_dd.="<option value=\"$dw_dd\">$dw_dd</option>";
}

for ($dw_mm=1; $dw_mm<=12; $dw_mm++) {
	if ($dw_mm<10) {
		$dw_mm="0".$dw_mm;
	}
	$data_wynajmu_option_mm.="<option value=\"$dw_mm\">$dw_mm</option>";
}

for ($dw_rr=2012; $dw_rr<=2025; $dw_rr++) {
	$data_wynajmu_option_rr.="<option value=\"$dw_rr\">$dw_rr</option>";
}


//przygotowanie listy rozwijanej dla daty zwrotu
// $dz_dd - dzień daty zwrotu
// $dz_mm - miesiąc daty zwrotu
// $dz_rr - rok daty zwrotu

$data_zwrotu_option_dd='<option value="puste">- dzień -</option>';
$data_zwrotu_option_mm='<option value="puste">- miesiąc -</option>';
$data_zwrotu_option_rr='<option value="puste">- rok -</option>';

for ($dz_dd=1; $dz_dd<=31; $dz_dd++) {
	if ($dz_dd<10) {
		$dz_dd="0".$dz_dd;
	}
	$data_zwrotu_option_dd.="<option value=\"$dz_dd\">$dz_dd</option>";
}

for ($dz_mm=1; $dz_mm<=12; $dz_mm++) {
	if ($dz_mm<10) {
		$dz_mm="0".$dz_mm;
	}
	$data_zwrotu_option_mm.="<option value=\"$dz_mm\">$dz_mm</option>";
}

for ($dz_rr=2012; $dz_rr<=2025; $dz_rr++) {
	$data_zwrotu_option_rr.="<option value=\"$dz_rr\">$dz_rr</option>";
}

$display_block="
<form method=\"post\" action=\"rezerwacja_auta_1.php\">
<table>
<p><tr><td>Imię:</td><td><input type=\"text\" name=\"imie\" value=\"$imie\" size=\"20\" maxlength=\"30\" /></td></tr></p>
<p><tr><td>Nazwisko:</td><td><input type=\"text\" name=\"nazwisko\" value=\"$nazwisko\" size=\"20\" maxlength=\"50\" /></td></tr></p>
<p><tr><td>Adres:</td><td><input type=\"text\" name=\"adres\" value=\"$adres\" size=\"20\" maxlength=\"30\" /></td></tr></p>
<p><tr><td>Miasto:</td><td><input type=\"text\" name=\"miasto\" value=\"$miasto\" size=\"20\" maxlength=\"30\"/></td></tr></p>
<p><tr><td>Telefon:</td><td><input type=\"text\" name=\"telefon\" value=\"$telefon\" size=\"20\" maxlength=\"20\"/></td></tr></p>
<p><tr><td>E-mail:</td><td><input type=\"text\" name=\"email\" value=\"$email\" size=\"20\" maxlength=\"30\" /></td></tr></p>
<p><tr><td>Nr prawa jazdy:</td><td><input type=\"text\" name=\"nr_prawa_jazdy\" value=\"$nr_prawa_jazdy\" size=\"20\" /></td></tr></p>
<p><tr><td>Data wynajmu:</td><td><select name=\"dwdd\">
$data_wynajmu_option_dd
</select>
<select name=\"dwmm\">
$data_wynajmu_option_mm
</select>
<select name=\"dwrr\">
$data_wynajmu_option_rr
</select></td></tr></p>

<p><tr><td>Data zwrotu:</td><td><select name=\"dzdd\">
$data_zwrotu_option_dd
</select>
<select name=\"dzmm\">
$data_zwrotu_option_mm
</select>
<select name=\"dzrr\">
$data_zwrotu_option_rr
</select></td></tr></p>

</table>
<p>Wybór auta:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<select name=\"idauta\">
$option_block
</select>
<br>
<input type=\"submit\" name=\"submit\" value=\"Zarezerwuj auto\"/></p>
</form>
";
echo "$display_block";
$mysqli->close();
$stronka->DomknijBlok(); // div kontakt
$stronka->DomknijBlok();
$stronka->WyswietlStopke();
?>
