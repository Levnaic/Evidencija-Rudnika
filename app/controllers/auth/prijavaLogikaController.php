<?php

use Klase\Autentifikator;
use Klase\Database;
use Klase\ErrorHandler;
use Klase\Redirekt;
use Klase\Bezbednost;
use Klase\Debug;
use Modeli\Auth;

Autentifikator::autentifikujNeprijavljenogKorisnika();

$databaseConfig = "../config/database-config.xml";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email'], $_POST['sifra'])) {

        $db = new Database($databaseConfig);
        $auth = new Auth($db->getConnection());

        // sanitacija unosa
        $email = Bezbednost::sanitacijaInputa($_POST['email']);
        $sifra = Bezbednost::sanitacijaInputa($_POST['sifra']);

        try {
            // validacija unosa
            Bezbednost::validacijaUnosa($email, "email");
            Bezbednost::validacijaUnosa($sifra, "sifra");

            // uspesan login
            if ($auth->prijava($email, $sifra)) {
                header("Location: /");
                exit;
                // neuspesan login
            } else {
                $_SESSION["loginFailed"] = 1;
                header("Location: /prijava");
            }
            // greska pri validaciji
        } catch (\InvalidArgumentException $e) {
            ErrorHandler::logError("Greška u validaciji", $e->getMessage(), __FILE__, __LINE__);
            Redirekt::redirektNaErrorStr(400);
        }
        // nisu popunjena sva input polja
    } else {
        ErrorHandler::logError("Nepotpun zahtev", "Nisu popunja sva input polja", __FILE__, __LINE__);
        Redirekt::redirektNaErrorStr(400);
    }
    // pogresan server request
} else {
    ErrorHandler::logError("Pogrešan metod", "Server Request Metod nije POST", __FILE__, __LINE__);
    Redirekt::redirektNaErrorStr(400);
}
