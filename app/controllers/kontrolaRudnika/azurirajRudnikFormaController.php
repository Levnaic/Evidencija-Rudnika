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

$title = "Azuriranje rudnika";
$css = "forma.css";

if (isset($_GET["id"])) {
    $id = Bezbednost::sanitacijaInputa($_GET["id"]);
    try {
        $id = Bezbednost::validacijaUnosa($id, "int");

        $db = new Database($databaseConfig);
        $rudnik = new Rudnik($db->getConnection());

        $red = $rudnik->ucitajRudnikPoId($id);
    } catch (\InvalidArgumentException $e) {
        ErrorHandler::logError("Validation Error", $e->getMessage(), __FILE__, __LINE__);
        Redirekt::redirektNaErrorStr(400);
    }
}

require "../app/views/partials/head.php";
require "../app/views/kontrolaRudnika/azurirajRudnikView.php";
