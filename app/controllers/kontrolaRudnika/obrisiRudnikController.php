<?php

use Klase\Database;
use Klase\Bezbednost;
use Klase\ErrorHandler;
use Klase\Redirekt;
use Modeli\Rudnik;

$databaseConfig = "../config/database-config.xml";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_GET["id"])) {
        $id = Bezbednost::sanitacijaInputa($_GET["id"]);
        try {
            $id = Bezbednost::validacijaUnosa($id, "int");

            $db = new Database($databaseConfig);
            $rudnik = new Rudnik($db->getConnection());

            $rudnik->obrisiRudnik($id);

            header("location: /kontrola-rudnika");
        } catch (\InvalidArgumentException $e) {
            ErrorHandler::logError("Greška u validaciji", $e->getMessage(), __FILE__, __LINE__);
            Redirekt::redirektNaErrorStr(400);
        }
    } else {
        ErrorHandler::logError("Nepotpun zahtev", "Nisu popunja sva input polja", __FILE__, __LINE__);
        Redirekt::redirektNaErrorStr(400);
    }
} else {
    ErrorHandler::logError("Pogrešan metod", "Server Request Metod nije POST", __FILE__, __LINE__);
    Redirekt::redirektNaErrorStr(400);
}
