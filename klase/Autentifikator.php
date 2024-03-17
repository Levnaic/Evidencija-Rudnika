<?php

namespace Klase;

class Autentifikator
{
    public static function autentifikujAdmina()
    {
        if (!isset($_SESSION['uloga']) || $_SESSION['uloga'] != 'admin') {
            header("Location: /prijava");
            exit;
        }
    }

    public static function autentifikujKorisnika()
    {
        if (!isset($_SESSION['uloga']) || $_SESSION['uloga'] != 'knjigovodja') {
            header("Location: /prijava");
            exit;
        }
    }

    public static function autentifikujKorisnikaIliAdmina()
    {
        if (!isset($_SESSION['uloga']) || ($_SESSION['uloga'] != 'knjigovodja' && $_SESSION['uloga'] != 'admin')) {
            header("Location: /prijava");
            exit;
        }
    }

    public static function autentifikujNeprijavljenogKorisnika()
    {
        if (isset($_SESSION['korisnickoIme'])) {
            header("Location: /");
            exit;
        }
    }
}
