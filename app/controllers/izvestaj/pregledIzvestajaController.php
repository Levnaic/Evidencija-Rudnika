<?php

use Klase\Autentifikator;
use Klase\Bezbednost;
use Klase\Database;
use Klase\ErrorHandler;
use Klase\Redirekt;
use Modeli\Izvestaj;

Autentifikator::autentifikujKorisnikaIliAdmina();

$databaseConfig = "../config/database-config.xml";

$title = "Pregled izveštaja";
$js = ["main.js"];
$css = "tabela.css";

$db = new Database($databaseConfig);
$izvestaj = new Izvestaj($db->getConnection());

// pregled izvestaja bez filtera
if (isset($_SESSION["uloga"], $_SESSION["korisnickoIme"])) {
    // sanitacija unosa
    $uloga = Bezbednost::sanitacijaInputa($_SESSION["uloga"]);
    $korisnickoIme = Bezbednost::sanitacijaInputa($_SESSION["korisnickoIme"]);
    try {
        // validacija unosa
        $uloga = Bezbednost::validacijaUnosa($uloga, "str");
        $korisnickoIme = Bezbednost::validacijaUnosa($korisnickoIme, "korisnickoIme");
        // greska u validaciji
    } catch (\InvalidArgumentException $e) {
        ErrorHandler::logError("Greška u validaciji", $e->getMessage(), __FILE__, __LINE__);
        Redirekt::redirektNaErrorStr(400);
    }
}

// pregled izvestaja sa filterom
if (isset($_GET["poljePretrage"])) {
    // sanitaicja unosa
    $filterVrednost = Bezbednost::sanitacijaInputa($_GET["poljePretrage"]);
    if (!empty($filterVrednost)) {

        try {
            $filterVrednost = Bezbednost::validacijaUnosa($filterVrednost, "txt");

            $redovi = $izvestaj->ucitajFilterisaneIzvestajePoPodnesiocu($filterVrednost);
        } catch (\InvalidArgumentException $e) {
            ErrorHandler::logError("Greška u validaciji", $e->getMessage(), __FILE__, __LINE__);
            Redirekt::redirektNaErrorStr(400);
        }
    } else {
        if ($uloga === "admin") {
            $redovi = $izvestaj->ucitajSveIzvestaje();
        } else {
            $redovi = $izvestaj->ucitajIzvestajePoPodnesiocu($korisnickoIme);
        }
    }
} else {
    if ($uloga === "admin") {
        $redovi = $izvestaj->ucitajSveIzvestaje();
    } else {
        $redovi = $izvestaj->ucitajIzvestajePoPodnesiocu($korisnickoIme);
    }
}

foreach ($redovi as $red) {
    $formatirajDatum = date("d. m. Y.", strtotime($red->datum));
    $red->datum = $formatirajDatum;
}

$redovi = array_reverse($redovi);

if (isset($_GET['dozvola_ponistena']) && $_GET['dozvola_ponistena'] == 1) {
    echo "<script>alert('Dozvola o rudarenju je poništena zbog nedovoljnog profita.');</script>";
}

require "../app/views/partials/head.php";
require "../app/views/partials/nav.php";
require "../app/views/izvestaj/pregledIzvestajaView.php";
require "../app/views/partials/scripts.php";
