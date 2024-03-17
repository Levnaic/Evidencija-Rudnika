<?php

use Klase\Autentifikator;
use Klase\Bezbednost;
use Klase\Database;
use Klase\ErrorHandler;
use Klase\Redirekt;
use Klase\PoslovnaLogika;
use Modeli\Izvestaj;
use Modeli\Rudnik;

Autentifikator::autentifikujKorisnikaIliAdmina();

$databaseConfig = "../config/database-config.xml";
$poslovnLogikaConfig = "../config/poslovna-logika.xml";

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (isset($_POST["idRudnika"], $_POST["prihodi"], $_POST["rashodi"], $_SESSION["korisnickoIme"])) {
        // sanitacija unosa
        $idRudnika = Bezbednost::sanitacijaInputa($_POST["idRudnika"]);
        $prihodi = Bezbednost::sanitacijaInputa($_POST["prihodi"]);
        $rashodi = Bezbednost::sanitacijaInputa($_POST["rashodi"]);
        $podnesilac = Bezbednost::sanitacijaInputa($_SESSION["korisnickoIme"]);
        try {
            // validacija unosa
            $idRudnika = Bezbednost::validacijaUnosa($idRudnika, "int");
            $prihodi = Bezbednost::validacijaUnosa($prihodi, "int");
            $rashodi = Bezbednost::validacijaUnosa($rashodi, "int");
            $podnesilac = Bezbednost::validacijaUnosa($podnesilac, "korisnickoIme");

            // unosi novi izvestaj u bazu
            $db = new Database($databaseConfig);
            $izvestaj = new Izvestaj($db->getConnection());
            $izvestaj->dodajIzvestaj($idRudnika, $prihodi, $rashodi, $podnesilac);

            // ucitava profit rudnika posle unosa novog izvestaja
            $rudnik = new Rudnik($db->getConnection());
            $profitIRuda = $rudnik->ucitajProfitIRuduRudnikaPrekoId($idRudnika);

            // provera da li rudnik zadovoljava uslove rada posle unosa izvestaja
            $poslovnaLogika = new PoslovnaLogika($poslovnLogikaConfig);

            $daLiIspunjavaUslove = $poslovnaLogika->daLiRudnikIspunjavaUslove($profitIRuda->profit, $profitIRuda->vrstaRude);

            // ukida rudniku dozvolu o radnu ako ne zadovoljava uslove za rad
            if (!$daLiIspunjavaUslove) {
                $rudnik->ukiniDozvoluRudniku($idRudnika);

                header("Location: /pregled-izvestaja?dozvola_ponistena=1");
                exit;
            }

            header("Location: /pregled-izvestaja");
            exit;
            // greska u validaciji
        } catch (\InvalidArgumentException $e) {
            ErrorHandler::logError("Greška u validaciji", $e->getMessage(), __FILE__, __LINE__);
            Redirekt::redirektNaErrorStr(400);
        }
        // nepotpun zahtev
    } else {
        ErrorHandler::logError("Nepotpun zahtev", "Nisu popunja sva input polja", __FILE__, __LINE__);
        Redirekt::redirektNaErrorStr(400);
    }
    // pogresan server request
} else {
    ErrorHandler::logError("Pogrešan metod", "Server Request Metod nije POST", __FILE__, __LINE__);
    Redirekt::redirektNaErrorStr(400);
}
