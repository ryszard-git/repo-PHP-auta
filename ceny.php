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
		<div>
			<div>
				<img src="grafika/corsa.jpeg" alt="osobowy" width="150px" height="100px" />
				<p>Osobowe - od 90 pln za dobę</p>
			</div>

			<div>
				<img src="grafika/sprinter-bus.jpeg" alt="mikrobus" width="150px" height="100px" />
				<p>Mikrobusy - od 200 pln za dobę</p>
			</div>
			<div>
				<img src="grafika/vw-transporter.jpeg" alt="dostawczy" width="150px" height="100px" />
				<p>Dostawcze - od 150 pln za dobę</p>
			</div>
		</div>
		
	</div>

<?php 
$stronka->DomknijBlok();
$stronka->WyswietlStopke();
?>
