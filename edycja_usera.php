<?php
session_start();
if ($_SESSION['zalogowany']!="tak") {
	echo "<html><body><script>window.location.href = 'zaloguj.php';</script></body></html>";
	exit;
}
require_once("Strona.php");
$stronka=new Strona();
$stronka->tytul="Edycja danych użytkownika";
$stronka->WyswietlNaglowek();
$stronka->nazwaokna="Edycja danych użytkownika";
$stronka->WyswietlMenu("MenuAdmina-Usera");
$stronka->WyswietlZawartosc();

echo '<div class="kontakt">';

$login_name=$_SESSION['login_name'];

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

$sql="SELECT * FROM uzytkownicy WHERE login_name=\"$login_name\"";
$result=$mysqli->query($sql);
if (!$result) {
	echo "Błąd zapytania SELECT.<br/>";
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

$formularz="
<form method=\"post\" action=\"\">
<table>
<tr><td>Imię:</td><td><input type=\"text\" name=\"imie\" value=\"$imie\" size=\"20\" maxlength=\"30\" /></td></tr>
<tr><td>Nazwisko:</td><td><input type=\"text\" name=\"nazwisko\" value=\"$nazwisko\" size=\"20\" maxlength=\"50\" /></td></tr>
<tr><td>Adres:</td><td><input type=\"text\" name=\"adres\" value=\"$adres\" size=\"20\" maxlength=\"30\" /></td></tr>
<tr><td>Miasto:</td><td><input type=\"text\" name=\"miasto\" value=\"$miasto\" size=\"20\" maxlength=\"30\"/></td></tr>
<tr><td>Telefon:</td><td><input type=\"text\" name=\"telefon\" value=\"$telefon\" size=\"20\" /></td></tr>
<tr><td>E-mail:</td><td><input type=\"text\" name=\"email\" value=\"$email\" size=\"20\" maxlength=\"30\" /></td></tr>
<tr><td>Nr prawa jazdy:</td><td><input type=\"text\" name=\"nr_prawa_jazdy\" value=\"$nr_prawa_jazdy\" size=\"20\" /></td></tr>
</table>
<br/><br/>
<input type=\"submit\" name=\"submit\" value=\"Zmień dane\"/></p>
</form>
<br/><br/><br/>
";
echo "$formularz";

if (isset($_POST['submit'])) {
	$imie=addslashes(trim($_POST["imie"]));
	$nazwisko=addslashes(trim($_POST["nazwisko"]));
	$adres=addslashes(trim($_POST["adres"]));
	$miasto=addslashes(trim($_POST["miasto"]));
	$telefon=addslashes(trim($_POST["telefon"]));
	$email=addslashes(trim($_POST["email"]));
	$nr_prawa_jazdy=addslashes(trim($_POST["nr_prawa_jazdy"]));

	$login_name=$_SESSION['login_name'];

	if ((!$imie) || (!$nazwisko) || (!$adres) || (!$miasto) || (!$telefon) || (!$email) || (!$nr_prawa_jazdy)) {
		echo "Proszę wypełnić wszystkie pola formularza<br/>";
		$stronka->poexicie();	
		exit;
	}

	// aktualizacja w tabeli UZYTKOWNICY danych osobowych klienta
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
		$stronka->poexicie();
		exit;
	}
	echo "Dane użytkownika zostały zapisane<br/>";
} // if isset
$mysqli->close();

$stronka->DomknijBlok(); // div kontakt
$stronka->DomknijBlok();
$stronka->WyswietlStopke();
?>
