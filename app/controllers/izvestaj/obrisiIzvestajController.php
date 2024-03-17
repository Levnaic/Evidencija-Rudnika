<?php

use Klase\Autentifikator;
use Klase\Database;
use Klase\Bezbednost;
use Klase\Debug;
use Klase\ErrorHandler;
use Klase\Redirekt;
use Klase\PoslovnaLogika;
use Modeli\Rudnik;
use Modeli\Izvestaj;

Autentifikator::autentifikujKorisnikaIliAdmina();

$databaseConfig = "../config/database-config.xml";
$poslovnLogikaConfig = "../config/poslovna-logika.xml";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_GET["id"])) {
        // sanitacija unosa
        $id = Bezbednost::sanitacijaInputa($_GET["id"]);
        try {
            // validacija unosa
            $id = Bezbednost::validacijaUnosa($id, "int");

            $db = new Database($databaseConfig);
            $izvestaj = new Izvestaj($db->getConnection());

            // brisanje izvestaja
            $idRudnika = $izvestaj->ucitajIdRudnikaPoIdIzvestaja($id);
            $izvestaj->obrisiIzvestaj($id);

            // ucitavanje profita posle brisanja
            $rudnik = new Rudnik($db->getConnection());
            $profitIRuda = $rudnik->ucitajProfitIRuduRudnikaPrekoId($idRudnika);

            // provera da li rudnik ispunjava uslove rada nakon brisanja izvestaja
            $poslovnaLogika = new PoslovnaLogika($poslovnLogikaConfig);

            $daLiIspunjavaUslove = $poslovnaLogika->daLiRudnikIspunjavaUslove($profitIRuda->profit, $profitIRuda->vrstaRude);

            // oduzima dozvolu rudniku ako ne ispunjava uslove
            if (!$daLiIspunjavaUslove) {
                $rudnik->ukiniDozvoluRudniku($idRudnika);

                header("Location: /pregled-izvestaja?dozvola_ponistena=1");
                exit;
            }

            header("location: /pregled-izvestaja");
            // greska pri validaciji
        } catch (\InvalidArgumentException $e) {
            ErrorHandler::logError("Greška u validaciji", $e->getMessage(), __FILE__, __LINE__);
            Redirekt::redirektNaErrorStr(400);
        }
        // nepotpun input zahtev
    } else {
        ErrorHandler::logError("Nepotpun zahtev", "Nisu popunja sva input polja", __FILE__, __LINE__);
        Redirekt::redirektNaErrorStr(400);
    }
    // pogresan server request
} else {
    ErrorHandler::logError("Pogrešan metod", "Server Request Metod nije POST", __FILE__, __LINE__);
    Redirekt::redirektNaErrorStr(400);
}
