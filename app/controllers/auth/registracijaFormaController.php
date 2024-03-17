<?php

use Klase\Autentifikator;

Autentifikator::autentifikujNeprijavljenogKorisnika();

$title = "Registracija";
$css = "forma.css";

require "../app/views/partials/head.php";
require "../app/views/auth/registracijaView.php";

// ispisuje gresku pri registraciji ako dodje do nje
if (isset($_SESSION["registracija_greska"])) {
    $decodedErrorMessage = html_entity_decode($_SESSION["registracija_greska"], ENT_QUOTES, 'UTF-8');
    echo '<script>alert("' . htmlspecialchars_decode($decodedErrorMessage, ENT_QUOTES) . '")</script>';
    unset($_SESSION["registracija_greska"]);
}
