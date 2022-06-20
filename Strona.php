<?php
class Strona
{
  public $tytul;
  public $nazwaokna;


public function poexicie()
{
// funkcja zapewnia poprawne wyświetlenie szablonu strony przed przerwaniem skryptu funkcją exit
	$this->DomknijBlok();
	$this->DomknijBlok();
	$this->WyswietlStopke();
}

public function poexicie1()
{
// funkcja zapewnia poprawne wyświetlenie szablonu strony przed przerwaniem skryptu funkcją exit
	$this->DomknijBlok();
	$this->WyswietlStopke();
}

public function WyswietlNaglowek()
  {
?>
<!DOCTYPE html>
<html lang="pl">    
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/style.css">
<title><?php echo $this->tytul; ?></title>

</head>

<body>

<div class="all">

<div class="topleft">
       <img src="grafika/baner1.jpg" alt="BaneR" />
</div>

<?php
}

public function WyswietlMenu($menu)
{

switch ($menu)
	{
	case "MenuGlowne" :
		?>
		<div class="menulewe">

		<ul>
			 <li><a href="ceny.php">Ceny</a></li>
			 <li><a href="kontakt.php">Kontakt</a></li>
			 <li><a href="zaloguj.php">Zaloguj się</a></li>
		</ul>

		</div>
		<?php
	break;

	case "MenuCenyKontakt" :
		?>
		<div class="menulewe">
		<?php
		if (isset($_SESSION["zalogowany"])) {
			echo "<ul><li><a href=\"menu_usera.php\">Menu użytkownika</a></li></ul>";
			} else {
			echo '<ul><li><a href="index.php">Strona główna</a></li></ul>';
		}
		?>
		</div>
		<?php
	break;

	case "Menu_Glowne" :
		?>
		<div class="menulewe">
		<ul><li><a href="index.php">Strona główna</a></li></ul>
		</div>
		<?php
	break;

	case "MenuGlowneAdmina" :
		?>
		<div class="menulewe">

			<ul id="menu">
				<li><a href="#">Historia<br>wypożyczeń</a>
					<ul>
						<li><a href="wyp_auto_klienci.php">Auto - klienci</a></li>
						<li><a href="wyp_klient_auta.php">Klient - auta</a></li>
					</ul>
				</li>
				<li><a href="zwrot_auta.php">Zwrot<br>auta</a></li>
				<li><a href="dodanie_auta.php">Dodanie<br>auta</a></li>
				<li><a href="edycja_auta.php">Edycja<br>danych auta</a></li>
				<li><a href="usuniecie_auta.php">Usunięcie<br>auta</a></li>
				<li><a href="przeglad_rezerwacji.php">Przeglądanie<br>rezerwacji</a></li>
				<li><a href="dodaj_usera.php">Dodanie<br>użytkownika</a></li>
				<li><a href="edycja_usera.php">Edycja<br>danych użytkownika</a></li>
				<li><a href="zm_hasla_user.php">Zmiana<br>hasła</a></li>
				<li><a href="ustaw_hasla_tymczas.php">Reset<br>hasła</a></li>
			</ul>
		</div>
		<?php
	break;

	case "MenuGlowneUsera" :
		?>
		<div class="menulewe">

		<ul>
			 <li><a href="ceny.php">Ceny</a></li>
			 <li><a href="kontakt.php">Kontakt</a></li>
			 <li><a href="edycja_usera.php">Edycja<br>danych użytkownika</a></li>
			 <li><a href="przeglad_aut.php">Przeglądanie aut<br>do wypożyczenia</a></li>
			 <li><a href="rezerwacja_auta.php">Rezerwacja</a></li>
			 <li><a href="zm_hasla_user.php">Zmiana<br>hasła</a></li>
		</ul>

		</div>
		<?php
	break;

	case "MenuAdmina" :
		?>
		<div class="menulewe">
		<ul><li><a href="menu_admina.php">Menu administratora</a></li></ul>
		</div>
		<?php
	break;

	case "MenuAdmina-Usera" :
		?>
		<div class="menulewe">

		<?php
		$is_admin=$_SESSION['is_admin'];
		if ($is_admin=="NIE") {
			echo "<ul><li><a href=\"menu_usera.php\">Menu użytkownika</a></li></ul>";
		}
		if ($is_admin=="TAK") {
			echo "<ul><li><a href=\"menu_admina.php\">Menu administratora</a></li></ul>";
		}
		?>
		</div>
		<?php
	break;

	case "MenuUsera" :
		?>
		<div class="menulewe">
			<ul><li><a href="menu_usera.php">Menu użytkownika</a></li></ul>
		</div>
		<?php
	break;
	}
}

  public function WyswietlZawartosc()
  {
  ?>
  <div class="tresc">
	
  <p class="srodek"><?php echo $this->nazwaokna; ?></p>
  <?php
  }

public function DomknijBlok()
	{
	?>
	</div>
	<?php
	}

  public function WyswietlStopke()
  {
?>
<div class="foot">

	&copy; 2010-2022 Wszystkie prawa zastrzeżone<br/>
	<a href="mailto:ryszard@rkhost.strefa.pl">e-mail do administratora aplikacji</a>
</div>
</div>
</body>
</html>
<?php
  }
}
?>