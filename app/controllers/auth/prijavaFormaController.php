<?php

use Klase\Autentifikator;

Autentifikator::autentifikujNeprijavljenogKorisnika();

$title = "Prijava";
$css = "forma.css";

require "../app/views/partials/head.php";
require "../app/views/auth/prijavaView.php";

// ispisuje gresku pri logovanju ako dodje do nje
if (isset($_SESSION['loginFailed']) && $_SESSION["loginFailed"] === 1) {
    echo '<script>alert("Uneli ste netačne podatke")</script>';
    $_SESSION["loginFailed"] = 0;
}
