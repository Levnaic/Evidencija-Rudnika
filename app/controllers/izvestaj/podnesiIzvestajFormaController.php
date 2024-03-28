<?php

use Klase\Autentifikator;
use Klase\Database;
use Modeli\Rudnik;

Autentifikator::autentifikujKorisnikaIliAdmina();

$databaseConfig = "../config/database-config.xml";

$title = "Podnei izveštaj";
$js = ["validacijaIzvestaja.js"];
$css = "forma.css";

// ucitava sve rudnike sa dozvolama za prikaz 
$db = new Database($databaseConfig);
$rudnik = new Rudnik($db->getConnection());

$redovi = $rudnik->ucitajRudnikeSaDozvolomImenaId();

require "../app/views/partials/head.php";
require "../app/views/izvestaj/podnesiIzvestajView.php";
require "../app/views/partials/scripts.php";
