<?php

namespace Klase;

use Klase\ErrorHandler;
use Klase\Redirekt;

Bezbednost::inicijalizcija();

class Bezbednost
{

    //loading configuration files
    protected static $config;



    static function inicijalizcija()
    {
        self::$config = include(__DIR__ . "/../config/bezbednost-config.php");
    }

    public static function sanitacijaInputa($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);

        return $data;
    }

    public static function validacijaUnosa($data, $tip, $customPatern = null)
    {
        try {
            if (empty($data)) {
                throw new \InvalidArgumentException("Nema unosa.");
            }

            switch ($tip) {
                case 'str':
                    $patern = self::$config['regexStrPatern'];
                    $erorPoruka = 'Pogresan format stringa';
                    break;

                case 'int':
                    $patern = self::$config['regexIntPatern'];
                    $erorPoruka = 'Pogresan forma intidzera';
                    break;

                case 'email':
                    $patern = self::$config['regexEmailPatern'];
                    $erorPoruka = 'Pogresan forma email-a';
                    break;

                case 'txt':
                    $patern = self::$config['regexTxtPatern'];
                    $erorPoruka = 'Pogresan format teksta';
                    break;

                    //username is 1-20 characters long, no _ or . at the beginning, no __ or _. or ._ or .. inside, no _ or . at the end
                    // /^(?=.{1,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$/
                case 'korisnickoIme':
                    $patern = self::$config['regexKorisnickoImePatern'];
                    $erorPoruka = "Pogresan format korisnickog imena";
                    break;

                case 'datum':
                    $patern = self::$config['regexDatumPatern'];
                    $erorPoruka = "Pogresan format datuma";
                    break;

                case 'float':
                    $patern = self::$config['regexFloatPatern'];
                    $erorPoruka = "Pogresan float format";
                    break;

                case 'sifra':
                    // !PRODUKCIJA promeniti ovo
                    // $patern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d@$!%*#?&]{8,}$/";
                    $patern = self::$config['regexSifraPatern'];
                    $erorPoruka = "Pogresan format sifre";
                    break;

                default:
                    $patern = $customPatern;
                    $erorPoruka = 'Pogresan format';
            }

            if (!preg_match($patern, $data)) {
                ErrorHandler::logError("Greska u validaciji:", $erorPoruka, __CLASS__, __LINE__);
                throw new \InvalidArgumentException($erorPoruka);
            }

            return $data;
        } catch (\InvalidArgumentException $e) {
            ErrorHandler::logError("Greska u validaciji:", $e->getMessage(), __CLASS__, __LINE__);
            Redirekt::redirektNaErrorStr(400);
        }
    }
}
