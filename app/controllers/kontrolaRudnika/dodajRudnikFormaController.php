<?php

use Klase\Autentifikator;

Autentifikator::autentifikujAdmina();

$title = "Dodavanje rudnika";
$css = "forma.css";

require "../app/views/partials/head.php";
require "../app/views/kontrolaRudnika/dodajRudnikView.php";
