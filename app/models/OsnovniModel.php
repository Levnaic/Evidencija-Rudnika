<?php

namespace Modeli;

use PDOException;
use Klase\ErrorHandler;
use Klase\Redirekt;

class OsnovniModel
{
    protected $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    protected function izvrsiUpit($upit, $bindings = [])
    {
        try {
            $izjava = $this->conn->prepare($upit);

            foreach ($bindings as $param => $value) {
                $izjava->bindValue($param, $value);
            }

            $izjava->execute();

            return $izjava;
        } catch (PDOException $e) {
            $errorMsg = $e->getMessage();
            $sqlIzjava = $upit;
            ErrorHandler::logError("Greška u bazi podataka", $errorMsg . "|" . $sqlIzjava, get_called_class(), __LINE__);
            Redirekt::redirektNaErrorStr(500);
        }
    }
}
