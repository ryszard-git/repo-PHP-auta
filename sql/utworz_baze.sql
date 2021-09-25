create database test_auta character set 'utf8' collate 'utf8_polish_ci';
use test_auta;

create table uzytkownicy
(
id_klienta int unsigned not null auto_increment primary key,
imie_kli varchar(30) not null,
nazwisko_kli varchar(50) not null,
adres_kli varchar(30) not null,
miasto_kli varchar(30) not null,
telefon_kli varchar(20) not null,
email_kli varchar(30) not null,
nr_prawa_jazdy_kli varchar(20) not null,
login_name varchar(25) not null,
haslo char(40) not null,
is_admin char(3)
) type=InnoDB;

create table auta
(
id_auta int unsigned not null auto_increment primary key,
marka_auta varchar(70) not null,
czy_wynajete char(3) not null,
czy_usuniete char(3) not null,
cena_auta smallint unsigned not null,
zdjecie_auta varchar(60) not null
) type=InnoDB;

create table wynajem
(
id_wynajem int unsigned not null auto_increment primary key,
id_auta int unsigned not null references auta(id_auta),
id_klienta int unsigned not null references uzytkownicy(id_klienta),
data_wynajmu date not null,
data_zwrotu date not null,
czy_wynajete char(3) not null
) type=InnoDB;

grant all on test_auta.*
to 'ala'@'localhost';


INSERT INTO uzytkownicy (login_name, haslo, is_admin)
	VALUES ("admin", "d033e22ae348aeb5660fc2140aec35850c4da997", "TAK");

