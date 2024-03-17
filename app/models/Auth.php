<?php

namespace Modeli;

use PDO;
use Klase\ErrorHandler;
use Klase\Redirekt;

class Auth extends OsnovniModel
{
    // GET
    public function prijava($email, $sifra)
    {
        $upit = "SELECT id, korisnickoIme, uloga, sifra FROM korisnici WHERE email = :email";
        $parametri = [":email" => $email];
        $izjava = $this->izvrsiUpit($upit, $parametri);

        $korisnik = $izjava->fetch(PDO::FETCH_ASSOC);

        $izjava->closeCursor();

        if ($korisnik && password_verify($sifra, $korisnik['sifra'])) {

            $_SESSION['korisnik_id'] = $korisnik['id'];
            $_SESSION['korisnickoIme'] = $korisnik['korisnickoIme'];
            $_SESSION['uloga'] = $korisnik['uloga'];
            return true;
        } else {
            ErrorHandler::logError("Greška pri prijavi", "Loše akreditacije tokom prijave", __CLASS__, __LINE__);
            return false;
        }
    }

    // POST

    public function registracija($email, $korisnickoIme, $sifra, $uloga)
    {
        if (!$this->proveriDaLiPostojiEmail($email)) {
            if (!$this->proveriDaLiPostojiKorisnickoIme($korisnickoIme)) {
                $hashovanaSifra = password_hash($sifra, PASSWORD_DEFAULT);

                $upit = "INSERT INTO korisnici (email, korisnickoIme, sifra, uloga) VALUES (:email, :korisnickoIme, :sifra, :uloga)";
                $parametri = [
                    ":email" => $email,
                    ":korisnickoIme" => $korisnickoIme,
                    ":sifra" => $hashovanaSifra,
                    ":uloga" => $uloga
                ];
                $izjava = $this->izvrsiUpit($upit, $parametri);

                $izjava->closeCursor();
            } else {
                $_SESSION["registracija_greska"] = "Korisničko ime: '$korisnickoIme' je zauzeto";
                Redirekt::redirektNaRegistraciju();
            }
        } else {
            $_SESSION["registracija_greska"] = "Korisnički email: '$email' je zauzet";
            Redirekt::redirektNaRegistraciju();
        }
    }

    // odjava
    public static function odjava()
    {
        session_start();
        $_SESSION = array();

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        session_destroy();
    }

    // pomocne
    protected function proveriDaLiPostojiEmail($email)
    {
        $upit = "SELECT email FROM korisnici WHERE email = :email";
        $parametri = [":email" => $email];
        $izjava = $this->izvrsiUpit($upit, $parametri);

        $rezultat = $izjava->fetch(PDO::FETCH_ASSOC);

        $izjava->closeCursor();

        return !empty($rezultat);
    }

    protected function proveriDaLiPostojiKorisnickoIme($korisnickoIme)
    {

        $upit = "SELECT korisnickoIme FROM korisnici WHERE korisnickoIme = :korisnickoIme";
        $parametri = [":korisnickoIme" => $korisnickoIme];
        $izjava = $this->izvrsiUpit($upit, $parametri);

        $rezultat = $izjava->fetch(PDO::FETCH_ASSOC);

        $izjava->closeCursor();

        return !empty($rezultat);
    }
}
