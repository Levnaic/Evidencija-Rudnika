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


if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (isset($_POST["imeRudnika"], $_POST["vrstaRude"])) {
        $imeRudnika = Bezbednost::sanitacijaInputa($_POST["imeRudnika"]);
        $vrstaRude = Bezbednost::sanitacijaInputa($_POST["vrstaRude"]);
        $imaDozvolu = isset($_POST["imaDozvolu"]) && $_POST["imaDozvolu"] === "on";
        $imaDozvolu = $imaDozvolu ? true : false;
        $id = Bezbednost::sanitacijaInputa($_GET["id"]);

        try {
            $imeRudnika = Bezbednost::validacijaUnosa($imeRudnika, "txt");
            $vrstaRude = Bezbednost::validacijaUnosa($vrstaRude, "txt");
            $id = Bezbednost::validacijaUnosa($id, "int");

            $db = new Database($databaseConfig);
            $rudnik = new Rudnik($db->getConnection());
            $rudnik->azurirajRudnik($id, $imeRudnika, $imaDozvolu, $vrstaRude);

            header("Location: /kontrola-rudnika");
            exit;
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
