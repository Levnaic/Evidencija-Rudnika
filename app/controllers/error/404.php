<?php
// error stranica 404 - stranica nije pronadjena
$title = "404 nije pronađeno";
$css = "error.css";
$errorCode = "404";
$errorMsg = "stranica nije pronađena";

require "../app/views/partials/head.php";
require "../app/views/partials/nav.php";
require "../app/views/error/errorView.php";
