<?php
require_once("Strona.php");
$stronka=new Strona();
$stronka->tytul="Zakładanie konta dla klienta";
$stronka->WyswietlNaglowek();
$stronka->nazwaokna="Zakładanie konta - klient";
$stronka->WyswietlMenu("Menu_Glowne");
$stronka->WyswietlZawartosc();
?>
	<div class="kontakt">

		<form method="post" action="">
		<table>
		<tr><td>login:</td><td><input type="text" name="login_name" size="25"/></td></tr>
		<tr><td>hasło:</td><td><input type="password" name="haslo" size="25"/></td></tr>
		</table>
		<p><input type="submit" name="submit" value="Załóż konto"/></p>
		</form>
		<br/><br/><br/>
<?php
if (isset($_POST['submit'])) {
	$login_name=addslashes(trim($_POST["login_name"]));
	if (strlen($_POST["haslo"])<5)
	{
		echo 'Hasło powinno mieć conajmniej 5 znaków. Spróbuj ponownie.<br />';
		$stronka->poexicie();
		exit;
	}
	$haslo=sha1(trim($_POST["haslo"]));

	if ((!$login_name) || (!$haslo)) {
		echo "Proszę podać login i hasło";
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

	// sprawdzenie czy istnieje konto o podanej nazwie. Gdy $ilosc=0 to nie istnieje
	$sql="SELECT login_name FROM uzytkownicy WHERE login_name=\"$login_name\"";
	$result=$mysqli->query($sql);
	if (!$mysqli->query($sql)) {
		echo "Błąd zapytania o login.<br/>";
		$stronka->poexicie();
		exit;
	}
	$ilosc=$result->num_rows;
	if ($ilosc === 0) {
		$is_admin="NIE";
		$sql="INSERT INTO uzytkownicy (login_name, haslo, is_admin, imie_kli, nazwisko_kli, adres_kli, miasto_kli, telefon_kli, email_kli, nr_prawa_jazdy_kli)
		VALUES (\"$login_name\", \"$haslo\", \"$is_admin\", \"\", \"\", \"\", \"\", \"\", \"\", \"\")";
		$wynik=$mysqli->query($sql);
		if (!$wynik)
			echo 'Konto nie zostało założone<br/><br/>'.$mysqli->error;
		else
			echo "Konto zostało założone<br/>";
	} else {
		echo "Konto o podanej nazwie już istnieje<br/>";
		$stronka->poexicie();
		exit;
	}

	$mysqli->close();
} // if isset
$stronka->DomknijBlok(); // div kontakt
$stronka->DomknijBlok();
$stronka->WyswietlStopke();
?>
