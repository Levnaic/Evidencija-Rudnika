<?php

namespace Klase;

class Redirekt
{
    public static function redirektNaPocetnu()
    {
        header("Location: /");
        exit;
    }

    public static function redirektNaErrorStr($errorCode = 404)
    {
        http_response_code($errorCode);

        if (file_exists(dirname(__DIR__) . "/app/controllers/error/$errorCode.php")) {
            //!PRODUKCIJA izbaciti liniju ispod
            // Debug::dd("greska u ruteru " . $_SERVER['REQUEST_URI']);
            header("Location: /error$errorCode");
            exit;
        } else {
            die("Error $errorCode");
        }
    }

    public static function redirektNaRegistraciju()
    {
        header("Location: /register");
        exit;
    }
}
