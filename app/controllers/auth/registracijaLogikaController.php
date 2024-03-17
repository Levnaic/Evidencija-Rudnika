<?php

use Klase\Autentifikator;
use Klase\Database;
use Klase\Bezbednost;
use Klase\Debug;
use Klase\ErrorHandler;
use Klase\Redirekt;
use Modeli\Auth;

Autentifikator::autentifikujNeprijavljenogKorisnika();

$databaseConfig = "../config/database-config.xml";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["email"], $_POST['korisnickoIme'], $_POST['sifra'])) {
        // sanitacija unosa
        $email =  Bezbednost::sanitacijaInputa($_POST['email']);
        $korisnickoIme = Bezbednost::sanitacijaInputa($_POST['korisnickoIme']);
        $sifra = Bezbednost::sanitacijaInputa($_POST['sifra']);

        try {
            // validacija unosa
            $email = Bezbednost::validacijaUnosa($email, "email");
            $korisnickoIme = Bezbednost::validacijaUnosa($korisnickoIme, "korisnickoIme");
            $sifra = Bezbednost::validacijaUnosa($sifra, "sifra");
            $uloga = "kjnigovođa";

            $db = new Database($databaseConfig);
            $user = new Auth($db->getConnection());

            $user->registracija($email, $korisnickoIme, $sifra, $uloga);

            header("Location: /prijava");
            // greska pri validaciji
        } catch (\InvalidArgumentException $e) {
            ErrorHandler::logError("Greska u validaciji", $e->getMessage(), __FILE__, __LINE__);
            Redirekt::redirektNaErrorStr(400);
        }
    }
}
