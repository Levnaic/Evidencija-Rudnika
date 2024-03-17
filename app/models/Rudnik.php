<?php

namespace Modeli;

use PDO;

class Rudnik extends OsnovniModel
{
    // GET
    public function ucitajSveRudnike()
    {
        $upit = "SELECT * FROM rudnik";
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
        $upit = "SELECT * FROM rudnik WHERE id = :id";
        $parametri = [':id' => $id];
        $izjava = $this->izvrsiUpit($upit, $parametri);

        $rudnik = $izjava->fetch(PDO::FETCH_OBJ);

        $izjava->closeCursor();

        return $rudnik;
    }

    public function ucitajProfitIRuduRudnikaPrekoId($id)
    {
        $upit = "SELECT profit, vrstaRude FROM rudnik WHERE id = :id";
        $parametri = [":id" => $id];
        $izjava = $this->izvrsiUpit($upit, $parametri);

        $rudnik = $izjava->fetch(PDO::FETCH_OBJ);

        $izjava->closeCursor();

        return $rudnik;
    }

    public function ucitajFilterisaneRudnikePoImenu($filterVrednost)
    {
        $upit = "SELECT * FROM rudnik WHERE imeRudnika LIKE :filterVrednost";
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
    public function dodajRudnik($imeRudnika, $imaDozvolu, $vrstaRude)
    {
        $upit = "INSERT INTO rudnik (imeRudnika, imaDozvolu, vrstaRude) VALUES (:imeRudnika, :imaDozvolu, :vrstaRude)";

        $parametri = [
            ':imeRudnika' => $imeRudnika,
            ':imaDozvolu' => $imaDozvolu,
            ':vrstaRude' => $vrstaRude
        ];

        $this->izvrsiUpit($upit, $parametri);
    }

    // PATCH
    public function azurirajRudnik($id, $imeRudnika, $imaDozvolu, $vrstaRude)
    {
        $upit = "UPDATE rudnik SET imeRudnika = :imeRudnika, imaDozvolu = :imaDozvolu, vrstaRude = :vrstaRude WHERE id = :id";

        $parametri = [
            ':imeRudnika' => $imeRudnika,
            ':imaDozvolu' => $imaDozvolu,
            ':vrstaRude' => $vrstaRude,
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
