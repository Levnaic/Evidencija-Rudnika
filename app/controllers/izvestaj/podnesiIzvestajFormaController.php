<?php

use Klase\Autentifikator;
use Klase\Database;
use Modeli\Rudnik;

Autentifikator::autentifikujKorisnikaIliAdmina();

$databaseConfig = "../config/database-config.xml";

// ucitava sve rudnike sa dozvolama za prikaz 
$db = new Database($databaseConfig);
$rudnik = new Rudnik($db->getConnection());

$redovi = $rudnik->ucitajRudnikeSaDozvolomImenaId();

$title = "Podnei izveštaj";
$css = "forma.css";

require "../app/views/partials/head.php";
require "../app/views/izvestaj/podnesiIzvestajView.php";
