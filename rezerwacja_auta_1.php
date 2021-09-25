<?php
session_start();
if ($_SESSION['zalogowany']!="tak") {
	echo "<script>window.location.href = 'zaloguj.php';</script>";
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

$imie=addslashes(trim($_POST["imie"]));
$nazwisko=addslashes(trim($_POST["nazwisko"]));
$adres=addslashes(trim($_POST["adres"]));
$miasto=addslashes(trim($_POST["miasto"]));
$telefon=addslashes(trim($_POST["telefon"]));
$email=addslashes(trim($_POST["email"]));
$nr_prawa_jazdy=addslashes(trim($_POST["nr_prawa_jazdy"]));
$data_wynajmu=$_POST['dwrr'].'-'.$_POST['dwmm'].'-'.$_POST['dwdd'];
$data_zwrotu=$_POST['dzrr'].'-'.$_POST['dzmm'].'-'.$_POST['dzdd'];
$login_name=$_SESSION['login_name'];

$id_auta=$_POST["idauta"];

if ((!$id_auta) || (!$imie) || (!$nazwisko) || (!$adres) || (!$miasto) || (!$telefon) || (!$email) || (!$nr_prawa_jazdy) || (!$data_wynajmu) || (!$data_zwrotu)) {
	echo "Proszę wypełnić wszystkie pola formularza<br/>";
	$stronka->poexicie();	
	exit;
}

$data_w_rr=$_POST['dwrr'];
$data_w_mm=$_POST['dwmm'];
$data_w_dd=$_POST['dwdd'];
$data_z_rr=$_POST['dzrr'];
$data_z_mm=$_POST['dzmm'];
$data_z_dd=$_POST['dzdd'];

if (($data_w_rr==="puste") || ($data_w_mm==="puste") || ($data_w_dd==="puste") || ($data_z_rr==="puste") || ($data_z_mm==="puste") || ($data_z_dd==="puste"))
	{
		echo 'Błąd w wyborze daty.';
		$stronka->poexicie();
		exit;
	}
// sprawdzenie czy podana data wynajmu istnieje
if (checkdate($data_w_mm,$data_w_dd,$data_w_rr)===false)
	{
		echo 'Podana data wynajmu nie istnieje';
		$stronka->poexicie();
		exit;
	}

// sprawdzenie czy podana data zwrotu istnieje
if (checkdate($data_z_mm,$data_z_dd,$data_z_rr)===false)
	{
		echo 'Podana data zwrotu nie istnieje';
		$stronka->poexicie();
		exit;
	}
// sprawdzenie czy data zwrotu jest późniejsza od daty wynajmu
$data_w = new DateTime($data_wynajmu);
$data_z = new DateTime($data_zwrotu);
$roznica = $data_w->diff($data_z);
if ($roznica->format('%R') ==="-") {
	echo "Błąd - data zwrotu jest wcześniejsza od daty wynajmu";
	$stronka->poexicie();
	exit;
}

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
// zapytanie sprawdzające czy wybrane auto jest dostępne
$sql="SELECT czy_wynajete FROM auta WHERE id_auta=\"$id_auta\"";
$result=$mysqli->query($sql);
if (!$result) {
	echo "Błąd zapytania SELECT czy auto jest dostępne.<br/>";
	$stronka->poexicie();
	exit;
}
$wolneauto=$result->fetch_object();
$czywynajete=$wolneauto->czy_wynajete;
if ($czywynajete==="TAK") {
	echo "Wybrane auto nie jest już dostępne.<br/>";
	$stronka->poexicie();
	exit;
}

// zapytanie w celu ustalenia ID_KLIENTA na podstawie LOGIN_NAME
$sql="SELECT id_klienta FROM uzytkownicy WHERE login_name=\"$login_name\"";
$result=$mysqli->query($sql);
if (!$result) {
	echo "Błąd zapytania SELECT.<br/>";
	$stronka->poexicie();
	exit;
}
$wiersz=$result->fetch_object();
$idklienta=$wiersz->id_klienta;

$mysqli->autocommit(FALSE);

// wpisywanie do tabeli WYNAJEM dat wynajmu i zwrotu oraz informacji o wypożyczeniu auta
$czy_wynajete="TAK";
$sql="INSERT INTO wynajem
(id_auta, id_klienta, data_wynajmu, data_zwrotu, czy_wynajete) 
VALUES 
(\"$id_auta\", \"$idklienta\", \"$data_wynajmu\", \"$data_zwrotu\", \"$czy_wynajete\")";
$result=$mysqli->query($sql);
if (!$result) {
	echo "Błąd zapytania INSERT.<br/>";
	$mysqli->rollback();
	$stronka->poexicie();
	exit;
}

// wpisywanie do tabeli UZYTKOWNICY danych osobowych klienta
$sql="UPDATE uzytkownicy SET imie_kli=\"$imie\",
nazwisko_kli=\"$nazwisko\",
adres_kli=\"$adres\",
miasto_kli=\"$miasto\",
telefon_kli=\"$telefon\",
email_kli=\"$email\",
nr_prawa_jazdy_kli=\"$nr_prawa_jazdy\"
 WHERE login_name=\"$login_name\"";
$result=$mysqli->query($sql);
if (!$result) {
	echo "Błąd zapytania UPDATE.<br/>";
	$mysqli->rollback();
	$stronka->poexicie();
	exit;
}

// wpisywanie do tabeli AUTA informacji o wypożyczeniu auta
$sql="UPDATE auta SET czy_wynajete=\"TAK\" WHERE id_auta=\"$id_auta\"";
$result=$mysqli->query($sql);
if (!$result) {
	echo "Błąd zapytania UPDATE.<br/>";
	$mysqli->rollback();
	$stronka->poexicie();
	exit;
}
$mysqli->commit();
echo "Auto zostało zarezerwowane";

$mysqli->close();
$stronka->DomknijBlok(); // div kontakt
$stronka->DomknijBlok();
$stronka->WyswietlStopke();
?>
