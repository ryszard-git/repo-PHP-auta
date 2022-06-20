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
?>
<div class="box-input">
	<form method="post" action="">
		<div>
			<label>Imię:</label>
			<input type="text" name="imie" value="<?php echo $imie; ?>" size="20" maxlength="30" />
		</div>
		<div>
			<label>Nazwisko:</label>
			<input type="text" name="nazwisko" value="<?php echo $nazwisko; ?>" size="20" maxlength="50" />
		</div>
		<div>
			<label>Adres:</label>
			<input type="text" name="adres" value="<?php echo $adres; ?>" size="20" maxlength="30" />
		</div>
		<div>
			<label>Miasto:</label>
			<input type="text" name="miasto" value="<?php echo $miasto; ?>" size="20" maxlength="30"/>
		</div>
		<div>
			<label>Telefon:</label>
			<input type="text" name="telefon" value="<?php echo $telefon; ?>" size="20" />
		</div>
		<div>
			<label>E-mail:</label>
			<input type="text" name="email" value="<?php echo $email; ?>" size="20" maxlength="30" />
		</div>
		<div>
			<label>Nr prawa jazdy:</label>
			<input type="text" name="nr_prawa_jazdy" value="<?php echo $nr_prawa_jazdy; ?>" size="20" />
		</div>
		<br/><br/>
		<input type="submit" name="submit" value="Zmień dane"/></p>
	</form>
</div>
<br/><br/><br/>
<?php
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
