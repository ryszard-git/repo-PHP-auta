<?php
session_start();
if ($_SESSION['zalogowany']!="tak") {
	echo "<html><body><script>window.location.href = 'zaloguj.php';</script></body></html>";
	//header( "Location: zaloguj.php");
	exit;
}

require_once("Strona.php");
$stronka=new Strona();
$stronka->tytul="Menu admina";
$stronka->WyswietlNaglowek();
$stronka->nazwaokna="Menu główne administratora";
$stronka->WyswietlMenu("MenuGlowneAdmina");
$stronka->WyswietlZawartosc();

$login=stripslashes($_SESSION['login_name']);
echo '<p class="wyloguj">Zalogowany: <span>'.$login.'</span> &nbsp;&nbsp;[ <a class="logout" href="wyloguj.php">Wyloguj</a> ]</p>';
?>

	<div class="kontakt"><br/><br/>

<p>Witamy na stronie firmy AUTO-RYSZARD <br/><br/> i zapraszamy do korzystania<br/><br/> z naszego serwisu internetowego.</p>

	</div>
<?php	
$stronka->DomknijBlok();
$stronka->WyswietlStopke();
?>
