<?php

namespace Klase;

use SimpleXMLElement;
use Klase\ErrorHandler;
use Klase\Redirekt;

class PoslovnaLogika
{
    private $xml;

    public function __construct($xmlPutanja)
    {
        try {
            $xmlConfig = new SimpleXMLElement(file_get_contents($xmlPutanja));
            $this->xml = $xmlConfig;
        } catch (\Exception $e) {
            ErrorHandler::logError("Neuspesno ucitavanje XML konfiguracionog fajla", $e->getMessage(), __CLASS__, __LINE__);
            Redirekt::redirektNaErrorStr(500);
        }
    }

    public function daLiRudnikIspunjavaUslove($profit, $ruda)
    {
        $ogranicenjeRuda = $this->ucitajOgranicenja($ruda);

        return ($profit >= $ogranicenjeRuda);
    }

    private function ucitajOgranicenja($ruda)
    {
        if (isset($this->xml->$ruda)) {
            return (int)$this->xml->$ruda;
        } else {
            ErrorHandler::logError("Greska u logici", "Ne postoji ogranicenje za odabranu rudu", __CLASS__, __LINE__);
            Redirekt::redirektNaErrorStr(500);
        }
    }
}
