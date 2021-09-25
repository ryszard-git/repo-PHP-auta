<?php
session_start();
require_once("Strona.php");
$stronka=new Strona();
$stronka->tytul="Ceny";
$stronka->WyswietlNaglowek();
$stronka->nazwaokna="Ceny aut przeznaczonych do wypożyczenia";
$stronka->WyswietlMenu("MenuCenyKontakt");
$stronka->WyswietlZawartosc();
?>
	<div class="test">
<table>
	<tr><td><img src="grafika/corsa.jpeg" alt="osobowy" width="150px" height="100px" /></td>
	<td>&nbsp;&nbsp;Samochody osobowe - cena od 90 pln za dobę</td></tr>

	<tr><td><img src="grafika/sprinter-bus.jpeg" alt="mikrobus" width="150px" height="100px" /></td>
	<td>&nbsp;&nbsp;Mikrobusy - cena od 200 pln za dobę</td></tr>

	<tr><td><img src="grafika/vw-transporter.jpeg" alt="dostawczy" width="150px" height="100px" /></td>
	<td>&nbsp;&nbsp;Samochody dostawcze - cena od 150 pln za dobę</td></tr>
</table>
	</div>

<?php 
$stronka->DomknijBlok();
$stronka->WyswietlStopke();
?>
