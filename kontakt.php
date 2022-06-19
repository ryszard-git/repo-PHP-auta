<?php
session_start();

require_once("Strona.php");
$stronka=new Strona();
$stronka->tytul="Dane adresowe firmy";
$stronka->WyswietlNaglowek();
$stronka->nazwaokna="Dane adresowe firmy";
$stronka->WyswietlMenu("MenuCenyKontakt");
$stronka->WyswietlZawartosc();
?>
	<div class="kontakt">
<p>KOMIS I WYPOŻYCZALNIA AUT<br/><br/>
AUTO-RYSZARD S.C. Ryszard Kowalski<br/><br/>
ul. Prosta 21<br/><br/>
80-609 Gdańsk<br/><br/><br/>

NIP: 1234567890<br/>
REGON: 987654321<br/><br/>

tel: 500 600 700 i 500 800 900<br/>
Internet: www.autoryszard.pl<br/>
e-mail: autoryszard@abc.pl
</p>

	</div>

<?php
$stronka->DomknijBlok();
$stronka->WyswietlStopke();
?>
