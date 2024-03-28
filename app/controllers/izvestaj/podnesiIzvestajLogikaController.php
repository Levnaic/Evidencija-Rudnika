<?php

use Klase\Autentifikator;
use Klase\Bezbednost;
use Klase\Database;
use Klase\Debug;
use Klase\ErrorHandler;
use Klase\Redirekt;
use Klase\PoslovnaLogika;
use Modeli\Izvestaj;
use Modeli\Rudnik;

Autentifikator::autentifikujKorisnikaIliAdmina();

$databaseConfig = "../config/database-config.xml";
$poslovnLogikaConfig = "../config/poslovna-logika.xml";

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (
        isset($_POST["idRudnika"], $_SESSION["korisnickoIme"], $_POST["opisIzvestaja"]) &&
        (
            (isset($_POST["prihodi"]) && !isset($_POST["rashodi"])) ||
            (!isset($_POST["prihodi"]) && isset($_POST["rashodi"]))
        )
    ) {
        // sanitacija unosa
        if (isset($_POST["prihodi"])) {
            $prihodi = Bezbednost::sanitacijaInputa($_POST["prihodi"]);
            $rashodi = 0;
        } else {
            $prihodi = 0;
            $rashodi = Bezbednost::sanitacijaInputa($_POST["rashodi"]);
        }
        $idRudnika = Bezbednost::sanitacijaInputa($_POST["idRudnika"]);
        $podnesilac = Bezbednost::sanitacijaInputa($_SESSION["korisnickoIme"]);
        $opisIzvesataja = Bezbednost::sanitacijaInputa($_POST["opisIzvestaja"]);
        try {
            // validacija unosa
            $prihodi ? Bezbednost::validacijaUnosa($prihodi, "int") : Bezbednost::validacijaUnosa($rashodi, "int");
            $idRudnika = Bezbednost::validacijaUnosa($idRudnika, "int");
            $podnesilac = Bezbednost::validacijaUnosa($podnesilac, "korisnickoIme");
            $opisIzvesataja = Bezbednost::validacijaUnosa($opisIzvesataja, "txt");


            // unosi novi izvestaj u bazu
            $db = new Database($databaseConfig);
            $izvestaj = new Izvestaj($db->getConnection());
            $izvestaj->dodajIzvestaj($idRudnika, $prihodi, $rashodi, $podnesilac, $opisIzvesataja);

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
