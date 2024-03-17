<?php

namespace Modeli;

use Klase\ErrorHandler;
use Klase\Redirekt;
use PDO;
use PDOException;

class Izvestaj extends OsnovniModel
{

    // GET
    public function ucitajSveIzvestaje()
    {
        $upit = "SELECT * FROM izvestaj";
        $izjava = $this->izvrsiUpit($upit);

        $izvestaji = $izjava->fetchAll(PDO::FETCH_OBJ);

        $izjava->closeCursor();

        $izvestajiZamenjeni = $this->zamenaIdZaImeRudnika($izvestaji);

        return $izvestajiZamenjeni;
    }

    public function ucitajIzvestajPoId($id)
    {
        $upit = "SELECT * FROM izvestaj WHERE id = :id";
        $parametri = [':id' => $id];
        $izjava = $this->izvrsiUpit($upit, $parametri);

        $izvestaj = $izjava->fetch(PDO::FETCH_OBJ);

        $izjava->closeCursor();

        return $izvestaj;
    }

    public function ucitajIzvestajePoPodnesiocu($podnesilac)
    {
        $upit = "SELECT * FROM izvestaj WHERE podnesilac = :podnesilac";
        $parametri = [":podnesilac" => $podnesilac];
        $izjava = $this->izvrsiUpit($upit, $parametri);

        $izvestaji = $izjava->fetchAll(PDO::FETCH_OBJ);

        $izjava->closeCursor();

        $izvestajiZamenjeni = $this->zamenaIdZaImeRudnika($izvestaji);

        return $izvestajiZamenjeni;
    }

    public function ucitajIdRudnikaPoIdIzvestaja($id)
    {
        $upit = "SELECT idRudnika FROM izvestaj WHERE id = :id";
        $parametri = [":id" => $id];
        $izjava = $this->izvrsiUpit($upit, $parametri);

        $idRudnika = $izjava->fetch(PDO::FETCH_COLUMN);

        $izjava->closeCursor();

        return $idRudnika;
    }

    public function ucitajFilterisaneIzvestajePoPodnesiocu($filterVrednost)
    {
        $upit = "SELECT * FROM izvestaj WHERE podnesilac LIKE :filterVrednost";
        $filterVrednost = "%" . $filterVrednost . "%";
        $parametri = [":filterVrednost" => $filterVrednost];
        $izjava = $this->izvrsiUpit($upit, $parametri);


        $izvestaji = $izjava->fetchAll(PDO::FETCH_OBJ);

        $izjava->closeCursor();

        $izvestajiZamenjeni = $this->zamenaIdZaImeRudnika($izvestaji);

        return $izvestajiZamenjeni;
    }

    // POST
    public function dodajIzvestaj($idRudnika, $prihodi, $rashodi, $podnesilac)
    {
        $upit = "INSERT INTO izvestaj (idRudnika, prihodi, rashodi, podnesilac) VALUES (:idRudnika, :prihodi, :rashodi, :podnesilac)";
        $parametri = [
            ":idRudnika" => $idRudnika,
            ":prihodi" => $prihodi,
            ":rashodi" => $rashodi,
            ":podnesilac" => $podnesilac
        ];

        $this->izvrsiUpit($upit, $parametri);
    }

    // PATCH
    public function azurirajIzvestaj($id, $idRudnika, $prihodi, $rashodi)
    {
        $upit = "UPDATE izvestaj SET idRudnika = :idRudnika, prihodi = :prihodi, rashodi = :rashodi WHERE id = :id";

        $parametri = [
            ':idRudnika' => $idRudnika,
            ':prihodi' => $prihodi,
            ':rashodi' => $rashodi,
            ':id' => $id,
        ];

        $this->izvrsiUpit($upit, $parametri);
    }

    // DELETE
    public function obrisiIzvestaj($id)
    {
        $upit = "DELETE FROM izvestaj WHERE id = :id";

        $parametri = [':id' => $id];

        $this->izvrsiUpit($upit, $parametri);
    }

    // pomocne
    protected function zamenaIdZaImeRudnika($izvestaji)
    {
        try {
            $upit = "SELECT id, imeRudnika FROM rudnik";
            $rudnici = $this->izvrsiUpit($upit)->fetchAll(PDO::FETCH_OBJ);

            $rudniciMapa = [];
            foreach ($rudnici as $rudnik) {
                $rudniciMapa[$rudnik->id] = $rudnik->imeRudnika;
            }

            foreach ($izvestaji as $izvestaj) {
                if (isset($izvestaj->idRudnika) && isset($rudniciMapa[$izvestaj->idRudnika])) {
                    $izvestaj->imeRudnika = $rudniciMapa[$izvestaj->idRudnika];
                } else {
                    ErrorHandler::logError("Bad input", "There is no matching id for name or vice versa", __CLASS__, __LINE__);
                    Redirekt::redirektNaErrorStr(500);
                }
            }
            return $izvestaji;
        } catch (PDOException $e) {
            $errorMsg = $e->getMessage();
            ErrorHandler::logError("Greška u bazi podataka", $errorMsg, __CLASS__, __LINE__);
            Redirekt::redirektNaErrorStr(500);
        }
    }
}
