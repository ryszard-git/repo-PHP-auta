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
			<input type="text" name="telefon" value="<?php echo $telefon; ?>" size="20" maxlength="20"/>
		</div>
		<div>
			<label>E-mail:</label>
			<input type="text" name="email" value="<?php echo $email; ?>" size="20" maxlength="30" />
		</div>
		<div>
			<label>Nr prawa jazdy:</label>
			<input type="text" name="nr_prawa_jazdy" value="<?php echo $nr_prawa_jazdy; ?>" size="20" />
		</div>
		<p>Data wynajmu:<select name="dwdd"><?php echo $data_wynajmu_option_dd; ?></select>
		<select name="dwmm"><?php echo $data_wynajmu_option_mm; ?></select>
		<select name="dwrr"><?php echo $data_wynajmu_option_rr; ?></select>
		</p>
		<br>

		<p>Data zwrotu:&nbsp;&nbsp;&nbsp;&nbsp;<select name="dzdd"><?php echo $data_zwrotu_option_dd; ?></select>
		<select name="dzmm"><?php echo $data_zwrotu_option_mm; ?></select>
		<select name="dzrr"><?php echo $data_zwrotu_option_rr; ?></select>
		</p>
		<br>

		<p>Wybór auta:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name="idauta"><?php echo $option_block; ?></select>
			<br>
			<input type="submit" name="submit" value="Zarezerwuj auto" />
		</p>
	</form>
</div>

<?php
//***************************************************************************************************
if (isset($_POST['submit']))
{
	
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

}
//***************************************************************************************************
$mysqli->close();
$stronka->DomknijBlok(); // div kontakt
$stronka->DomknijBlok();
$stronka->WyswietlStopke();
?>
