<?php
require_once("Strona.php");
$stronka=new Strona();
$stronka->tytul="Strona główna";
$stronka->nazwaokna="Menu powitalne";
$stronka->WyswietlNaglowek();
$stronka->WyswietlMenu("MenuGlowne");
$stronka->WyswietlZawartosc();
echo '<img class="autoindex" src="grafika/auto.jpg" alt="auto" />';
$stronka->DomknijBlok();
$stronka->WyswietlStopke();
?>

