<?php
// error stranica 500 - serverska greska
$title = "500 Serverska greška";
$css = "error.css";
$errorCode = "500";
$errorMsg = "serverska greška";

require "../app/views/partials/head.php";
require "../app/views/partials/nav.php";
require "../app/views/error/errorView.php";
