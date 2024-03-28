<?php

namespace Modeli;

use PDO;

class Rudnik extends OsnovniModel
{
    // GET
    public function ucitajSveRudnike()
    {
        $upit = "SELECT rudnik.*, vrsta_rude.nazivRude AS vrstaRude 
        FROM rudnik 
        JOIN vrsta_rude ON rudnik.idRude = vrsta_rude.id";
        $izjava = $this->izvrsiUpit($upit);

        $rudnici = $izjava->fetchAll(PDO::FETCH_OBJ);

        $izjava->closeCursor();

        return $rudnici;
    }

    public function ucitajRudnikeSaDozvolomImenaId()
    {
        $upit = "SELECT id, imeRudnika FROM rudnik WHERE imaDozvolu = 1";
        $izjava = $this->izvrsiUpit($upit);

        $rudnici = $izjava->fetchAll(PDO::FETCH_OBJ);

        $izjava->closeCursor();

        return $rudnici;
    }

    public function ucitajRudnikPoId($id)
    {
        $upit = "SELECT rudnik.*, vrsta_rude.nazivRude AS vrstaRude 
        FROM rudnik 
        JOIN vrsta_rude ON rudnik.idRude = vrsta_rude.id
        WHERE rudnik.id = :id";
        $parametri = [':id' => $id];
        $izjava = $this->izvrsiUpit($upit, $parametri);

        $rudnik = $izjava->fetch(PDO::FETCH_OBJ);

        $izjava->closeCursor();

        return $rudnik;
    }

    public function ucitajProfitIRuduRudnikaPrekoId($id)
    {
        $upit = "SELECT rudnik.profit, vrsta_rude.nazivRude AS vrstaRude 
        FROM rudnik 
        JOIN vrsta_rude ON rudnik.idRude = vrsta_rude.id
        WHERE rudnik.id = :id";
        $parametri = [":id" => $id];
        $izjava = $this->izvrsiUpit($upit, $parametri);

        $rudnik = $izjava->fetch(PDO::FETCH_OBJ);

        $izjava->closeCursor();

        return $rudnik;
    }

    public function ucitajFilterisaneRudnikePoImenu($filterVrednost)
    {
        $upit = "SELECT rudnik.*, vrsta_rude.nazivRude AS vrstaRude 
        FROM rudnik
        JOIN vrsta_rude ON rudnik.idRude = vrsta_rude.id 
        WHERE rudnik.imeRudnika LIKE :filterVrednost";
        $filterVrednost = "%" . $filterVrednost . "%";
        $parametri = [':filterVrednost' => $filterVrednost];
        $izjava = $this->izvrsiUpit($upit, $parametri);

        $rudnici = $izjava->fetchAll(PDO::FETCH_OBJ);

        $izjava->closeCursor();

        return $rudnici;
    }



    public function ucitajRudnikeSaDozvolom()
    {
        $upit = "SELECT * FROM rudnik_pogled";

        $izjava = $this->izvrsiUpit($upit);

        $rudnici = $izjava->fetchAll(PDO::FETCH_OBJ);

        $izjava->closeCursor();

        return $rudnici;
    }



    public function ucitajFilterisaneRudnikeSaDozvolom($filterVrednost)
    {
        $upit = "SELECT * FROM rudnik_pogled WHERE imeRudnika LIKE :filterVrednost";
        $filterVrednost = "%" . $filterVrednost . "%";
        $parametri = [':filterVrednost' => $filterVrednost];
        $izjava = $this->izvrsiUpit($upit, $parametri);

        $rudnici = $izjava->fetchAll(PDO::FETCH_OBJ);

        $izjava->closeCursor();

        return $rudnici;
    }

    // POST
    public function dodajRudnik($imeRudnika, $imaDozvolu, $idRude)
    {
        $upit = "INSERT INTO rudnik (imeRudnika, imaDozvolu, idRude) VALUES (:imeRudnika, :imaDozvolu, :idRude)";

        $parametri = [
            ':imeRudnika' => $imeRudnika,
            ':imaDozvolu' => $imaDozvolu,
            ':idRude' => $idRude
        ];

        $this->izvrsiUpit($upit, $parametri);
    }

    // PATCH
    public function azurirajRudnik($id, $imeRudnika, $imaDozvolu, $idRude)
    {
        $upit = "UPDATE rudnik SET imeRudnika = :imeRudnika, imaDozvolu = :imaDozvolu, idRude = :idRude WHERE id = :id";

        $parametri = [
            ':imeRudnika' => $imeRudnika,
            ':imaDozvolu' => $imaDozvolu,
            ':idRude' => $idRude,
            ':id' => $id,
        ];

        $this->izvrsiUpit($upit, $parametri);
    }

    public function ukiniDozvoluRudniku($id)
    {
        $upit = "UPDATE rudnik SET imaDozvolu = 0 WHERE id = :id";
        $parametri = ["id" => $id];

        $this->izvrsiUpit($upit, $parametri);
    }

    // DELETE
    public function obrisiRudnik($id)
    {
        $upit = "DELETE FROM rudnik WHERE id = :id";

        $parametri = [':id' => $id];

        $this->izvrsiUpit($upit, $parametri);
    }
}
