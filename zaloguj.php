<?php
session_start();
require_once("Strona.php");
$stronka=new Strona();
$stronka->tytul="Zaloguj";
$stronka->WyswietlNaglowek();
$stronka->nazwaokna="Zaloguj się do aplikacji";
$stronka->WyswietlMenu("Menu_Glowne");
$stronka->WyswietlZawartosc();
?>
	<div class="kontakt">
		<div class="box-input">
			<form method="post" action="">
				<div>
					<label>Login:</label>
					<input type="text" name="login_name" size="25"/>
				</div>
				<div>
					<label>Hasło:</label>
					<input type="password" name="haslo" size="25"/>
				</div>
				<input type="submit" name="submit" value="Zaloguj"/>
			</form>
		</div>
		<a href="login1raz.php">Rejestracja</a><br/><br/>
		<br/><br/><br/>

<?php
if (isset($_POST['submit'])) {

	if ((!$_POST["login_name"]) || (!$_POST["haslo"])) {
		echo "Proszę wprowadzić login i hasło<br/>";
		$stronka->poexicie();
		exit;
	}

	$login_name=addslashes(trim($_POST["login_name"]));
	$haslo=sha1(trim($_POST["haslo"]));

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

	// szukanie pary login - hasło zgodnego z podanym w formularzu

	$sql="SELECT is_admin FROM uzytkownicy WHERE login_name=? AND haslo=?";
	$stmt=$mysqli->stmt_init();

	$stmt->prepare($sql); //Prepare an SQL statement for execution

	@ $result=$stmt->bind_param("ss",$login_name,$haslo); //Binds variables to a prepared statement as parameters
	if (!$result) {
		echo "Błąd instrukcji bind_param.<br/>";
		$stronka->poexicie();
		exit;
	}

	@ $result=$stmt->execute(); //Executes a prepared Query
	if (!$result) {
		echo "Błąd zapytania login - hasło.<br/>";
		$stronka->poexicie();
		exit;
	}

	$stmt->store_result(); //Transfers a result set from a prepared statement

	$stmt->bind_result($isadmin); //Binds variables to a prepared statement for result storage

	$ilosc=$stmt->num_rows;

		if ($ilosc === 1) {
			echo "Zostałeś uwierzytelniony<br/>";
			$_SESSION['login_name']=$login_name;
			$_SESSION['zalogowany']="tak";
		} else {
			echo "Nie zostałeś uwierzytelniony<br/>";
			$stronka->poexicie();
			exit;
		}

		// wybieranie kolumny z odczytanego z tabeli rekordu
		
	$wiersz=$stmt->fetch(); //Fetch results from a prepared statement into the bound variables

	$stmt->close();

	if ($isadmin=="NIE") {
		echo "<script>window.location.href = 'menu_usera.php';</script>";
	}
	if ($isadmin=="TAK") {
		echo "<script>window.location.href = 'menu_admina.php';</script>";
	}
	$_SESSION['is_admin']=$isadmin;
	$_SESSION['banerHref'] = ($_SESSION['is_admin'] === 'TAK') ? './menu_admina.php' : './menu_usera.php';

	$mysqli->close();
} //if isset
$stronka->DomknijBlok(); // div kontakt
$stronka->DomknijBlok();
$stronka->WyswietlStopke();
?>
