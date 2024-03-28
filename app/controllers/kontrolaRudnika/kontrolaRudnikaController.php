<?php

use Klase\Autentifikator;
use Klase\Bezbednost;
use Klase\Database;
use Klase\Debug;
use Klase\ErrorHandler;
use Klase\Redirekt;
use Modeli\Rudnik;

Autentifikator::autentifikujAdmina();

$databaseConfig = "../config/database-config.xml";

$title = "Kontrola rudnika";
$js = ["main.js"];
$css = "tabela.css";

$db = new Database($databaseConfig);
$rudnik = new Rudnik($db->getConnection());

// Debug::dd(isset($_GET["poljePretrage"]));

if (isset($_GET["poljePretrage"])) {
    $filterVrednost = Bezbednost::sanitacijaInputa($_GET["poljePretrage"]);
    if (!empty($filterVrednost)) {
        try {
            $filterVrednost = Bezbednost::validacijaUnosa($filterVrednost, "txt");
            $redovi = $rudnik->ucitajFilterisaneRudnikePoImenu($filterVrednost);
        } catch (\InvalidArgumentException $e) {
            ErrorHandler::logError("Greška u validaciji", $e->getMessage(), __FILE__, __LINE__);
            Redirekt::redirektNaErrorStr(400);
        }
    } else $redovi = $rudnik->ucitajSveRudnike();
} else {
    $redovi = $rudnik->ucitajSveRudnike();
}
require "../app/views/partials/head.php";
require "../app/views/partials/nav.php";
require "../app/views/kontrolaRudnika/kontrolaRudnikaView.php";
require "../app/views/partials/scripts.php";
