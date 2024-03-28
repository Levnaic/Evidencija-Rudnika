<?php

use Klase\Autentifikator;
use Klase\Bezbednost;
use Klase\Database;
use Klase\Debug;
use Klase\ErrorHandler;
use Klase\Redirekt;
use Modeli\Izvestaj;
use Modeli\Rudnik;

Autentifikator::autentifikujKorisnikaIliAdmina();

$databaseConfig = "../config/database-config.xml";

$title = "Azuriranje rudnika";
$css = "forma.css";
$js = ["validacijaIzvestaja.js"];

if (isset($_GET["id"])) {
    // sanitacija unosa
    $id = Bezbednost::sanitacijaInputa($_GET["id"]);
    try {
        // validacija uinosa
        $id = Bezbednost::validacijaUnosa($id, "int");

        $db = new Database($databaseConfig);
        $izvestaj = new Izvestaj($db->getConnection());
        $red = $izvestaj->ucitajIzvestajPoId($id);

        if ($red->prihodi == 0) $red->prihodi = "";
        if ($red->rashodi == 0) $red->rashodi = "";
        // Debug::dd($red->rashodi);

        $rudnik = new Rudnik($db->getConnection());
        $rudnici = $rudnik->ucitajRudnikeSaDozvolomImenaId();
        // greska pri validaciji
    } catch (\InvalidArgumentException $e) {
        ErrorHandler::logError("Validation Error", $e->getMessage(), __FILE__, __LINE__);
        Redirekt::redirektNaErrorStr(400);
    }
}

require "../app/views/partials/head.php";
require "../app/views/izvestaj/azurirajIzvestajView.php";
require "../app/views/partials/scripts.php";
