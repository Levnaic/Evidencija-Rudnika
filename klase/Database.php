<?php

namespace Klase;

use PDO;
use PDOException;
use SimpleXMLElement;
use Klase\ErrorHandler;
use Klase\Redirekt;

class Database
{
    private $conn;

    public function __construct($config)
    {
        try {
            $config = new SimpleXMLElement(file_get_contents($config));
            $host = (string) $config->host;
            $dbname = (string) $config->dbname;
            $user = (string) $config->user;
            $pass = (string) $config->pass;

            $this->conn = new PDO("mysql:host={$host};dbname={$dbname}", $user, $pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            ErrorHandler::logError("Falied to connect to database", $e->getMessage(), "Database", "22");
            Redirekt::redirektNaErrorStr(500);
        }
    }

    public function getConnection()
    {
        return $this->conn;
    }
}
