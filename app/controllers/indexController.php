<?php

use Klase\Autentifikator;
use Klase\Bezbednost;
use Klase\Database;
use Klase\Debug;
use Klase\ErrorHandler;
use Klase\Redirekt;
use Modeli\Rudnik;

$databaseConfig = "../config/database-config.xml";

$title = "Rudnici";
$js = ["main.js", "stampa.js"];
$css = "tabela.css";
$stampaCss = "stampaCss.css";

$db = new Database($databaseConfig);
$rudnik = new Rudnik($db->getConnection());

if (isset($_GET["poljePretrage"])) {
    $filterVrednost = Bezbednost::sanitacijaInputa($_GET["poljePretrage"]);
    if (!empty($filterVrednost)) {
        try {
            $filterVrednost = Bezbednost::validacijaUnosa($filterVrednost, "txt");
            $redovi = $rudnik->ucitajFilterisaneRudnikeSaDozvolom($filterVrednost);
        } catch (\InvalidArgumentException $e) {
            ErrorHandler::logError("Greška u validaciji", $e->getMessage(), __FILE__, __LINE__);
            Redirekt::redirektNaErrorStr(400);
        }
    } else $redovi = $rudnik->ucitajRudnikeSaDozvolom();
} else {
    $redovi = $rudnik->ucitajRudnikeSaDozvolom();
}

require "../app/views/partials/head.php";
require "../app/views/partials/nav.php";
require "../app/views/indexView.php";
require "../app/views/partials/scripts.php";
