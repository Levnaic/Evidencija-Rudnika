<?php

use Klase\Autentifikator;
use Klase\Bezbednost;
use Klase\Database;
use Klase\ErrorHandler;
use Klase\Redirekt;
use Modeli\Rudnik;

Autentifikator::autentifikujAdmina();

$databaseConfig = "../config/database-config.xml";


if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (isset($_POST["imeRudnika"], $_POST["idRude"])) {
        $imeRudnika = Bezbednost::sanitacijaInputa($_POST["imeRudnika"]);
        $idRude = Bezbednost::sanitacijaInputa($_POST["idRude"]);
        $imaDozvolu = isset($_POST["imaDozvolu"]) && $_POST["imaDozvolu"] === "on";
        $imaDozvolu = $imaDozvolu ? true : false;
        try {
            $imeRudnika = Bezbednost::validacijaUnosa($imeRudnika, "txt");
            $idRude = Bezbednost::validacijaUnosa($idRude, "int");

            $db = new Database($databaseConfig);
            $rudnik = new Rudnik($db->getConnection());
            $rudnik->dodajRudnik($imeRudnika, $imaDozvolu, $idRude);

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
