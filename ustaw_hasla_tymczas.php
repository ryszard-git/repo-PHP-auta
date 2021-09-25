<?php
session_start();
if ($_SESSION['zalogowany']!="tak") {
	echo "<script>window.location.href = 'zaloguj.php';</script>";
	exit;
}
require_once("Strona.php");
$stronka=new Strona();
$stronka->tytul="Resetowanie hasła";
$stronka->WyswietlNaglowek();
$stronka->nazwaokna="Resetowanie hasła - administrator";
$stronka->WyswietlMenu("MenuAdmina");
$stronka->WyswietlZawartosc();
echo '<div class="kontakt">';
?>
<form method="post" action="">
<table>
<tr><td>login:</td><td><input type="text" name="login_name" size="25"/></td></tr>
<tr><td>nowe hasło:</td><td><input type="password" name="nowe_haslo" size="25"/></td></tr>
</table>
<p><input type="submit" name="submit" value="Ustaw hasło"/></p>
</form>
<br/><br/><br/>
<?php
if (isset($_POST["submit"])) {
	$login_name=addslashes(trim($_POST["login_name"]));

	if ((!$login_name) || (!$_POST['nowe_haslo'])) {
		echo "Prosze wypełnić wszystkie pola formularza";
		$stronka->poexicie();
		exit;
	}

	if (strlen($_POST["nowe_haslo"])<5)
	{
		echo 'Hasło powinno mieć conajmniej 5 znaków. Spróbuj ponownie.<br />';
		$stronka->poexicie();
		exit;
	}
	$nowe_haslo=sha1(trim($_POST["nowe_haslo"]));

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
	$sql="SELECT login_name FROM uzytkownicy WHERE login_name=\"$login_name\"";
	$result=$mysqli->query($sql);
	if (!$result) {
		echo "Błąd zapytania login.<br/>";
		$stronka->poexicie();
		exit;
	}
	$ilosc=$result->num_rows;

	if ($ilosc === 1) {
		echo "Konto zostało znalezione<br/>";
		$sql="UPDATE uzytkownicy SET haslo=\"$nowe_haslo\" WHERE login_name=\"$login_name\"";
		$result=$mysqli->query($sql);
		if (!$result) {
			echo "Błąd zapytania UPDATE.<br/>";
			$stronka->poexicie();
			exit;
	}
		echo "Hasło zostało ustawione<br/>";
	} else {
		echo "Konto nie zostało znalezione<br/>";
		$stronka->poexicie();
		exit;
	}

	$mysqli->close();
} // if isset
$stronka->DomknijBlok(); // div kontakt
$stronka->DomknijBlok();
$stronka->WyswietlStopke();
?>
