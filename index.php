<?php
require_once("Strona.php");
$stronka=new Strona();
$stronka->tytul="Strona główna";
$stronka->nazwaokna="Strona powitalna";
$stronka->WyswietlNaglowek();
$stronka->WyswietlMenu("MenuGlowne");
$stronka->WyswietlZawartosc();
echo '<div class="autoindex"></div>';
$stronka->DomknijBlok();
$stronka->WyswietlStopke();
?>

