<?php

namespace Klase;

class ErrorHandler
{
    public static function logError($tipGreske, $errorMsg, $fajl, $linija)
    {
        $logMsg = date('d-m-Y H:i:s') . ' [' . $tipGreske . '] ' . $errorMsg . ' in ' . $fajl . ' on line ' . $linija . PHP_EOL;
        $logPutanja = dirname(__DIR__) . "/logs/error.log";

        file_put_contents($logPutanja, $logMsg, FILE_APPEND);
    }
}
