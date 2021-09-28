<?php
session_start();
if ($_SESSION['zalogowany']!="tak") {
	echo "<html><body><script>window.location.href = 'zaloguj.php';</script></body></html>";
	exit;
}
require_once("Strona.php");
$stronka=new Strona();
$stronka->tytul="Zmiana hasła";
$stronka->WyswietlNaglowek();
$stronka->nazwaokna="Zmiana hasła - użytkownik";
$stronka->WyswietlMenu("MenuAdmina-Usera");
$stronka->WyswietlZawartosc();

?>
	<div class="kontakt">

		<form method="post" action="">
		<table>
		<tr><td>hasło dotychczasowe:</td><td><input type="password" name="haslo" size="25"/></td></tr>
		<tr><td>nowe hasło:</td><td><input type="password" name="nowe_haslo" size="25"/></td></tr>
		<tr><td>powtórz nowe hasło:</td><td><input type="password" name="powt_nowe_haslo" size="25"/></td></tr>
		</table>
		<p><input type="submit" name="submit" value="Zmień hasło"/></p>
		</form>
		<br/><br/><br/>
<?php
if (isset($_POST['submit'])) {
	$login_name=$_SESSION['login_name']; // $login_name jest przepuszczone przez funkcję 'addslashes' w pliku 'zaloguj.php'.

	if ((!$login_name) || (!$_POST['haslo']) || (!$_POST['nowe_haslo']) || (!$_POST['powt_nowe_haslo'])) {
		echo "Prosze wypełnić wszystkie pola formularza<br/>";
		echo 'Żadne z haseł nie może być puste.<br/>';
		$stronka->poexicie();
		exit;
	}

	$haslo=sha1(trim($_POST["haslo"]));
	$nowe_haslo=sha1(trim($_POST["nowe_haslo"]));
	$powt_nowe_haslo=sha1(trim($_POST["powt_nowe_haslo"]));

	if ($nowe_haslo==$powt_nowe_haslo) {
		echo "Hasło i powtórzenie hasła zgodne<br/>";
	} else {
		echo "Hasło i powtórzenie hasła niezgodne<br/>";
		$stronka->poexicie();
		exit;
	}

	if (strlen($_POST["nowe_haslo"])<5)
	{
		echo 'Hasło powinno mieć conajmniej 5 znaków. Spróbuj ponownie.<br />';
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

	// szukanie loginu, któremu odpowiadające hasło ma być zmienione
	$sql="SELECT login_name, haslo FROM uzytkownicy WHERE login_name=\"$login_name\" AND haslo=\"$haslo\"";
	$result=$mysqli->query($sql);

	if (!$result) {
		echo "Błąd zapytania login - hasło.<br/>";
		$stronka->poexicie();
		exit;
	}
	$ilosc=$result->num_rows;

	if ($ilosc === 1) {
		echo "Konto zostało znalezione<br/>";
		$sql="UPDATE uzytkownicy SET haslo=\"$nowe_haslo\" WHERE login_name=\"$login_name\"";
		$result=$mysqli->query($sql);
		if (!$result) {
			echo "Błąd zapytania do bazy - wpisanie nowego hasła.<br/>";
			$stronka->poexicie();
			exit;
		}
		echo "Hasło zostało zmienione<br/>";
	} else {
		echo "Niezgodność loginu i hasła dotychczasowego<br/>";
		$stronka->poexicie();
		exit;
		}
	$mysqli->close();
} // if isset

$stronka->DomknijBlok(); // div kontakt
$stronka->DomknijBlok();
$stronka->WyswietlStopke();
?>
