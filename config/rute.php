<?php

// stranice
$rutiraj->get("/", "indexController");

// izvestaj
$rutiraj->get("/pregled-izvestaja", "izvestaj/pregledIzvestajaController");
$rutiraj->get("/pregled-izvestaja/podnesi-izvestaj", "izvestaj/podnesiIzvestajFormaController");
$rutiraj->post("/pregled-izvestaja/podnesi-izvestaj", "izvestaj/podnesiIzvestajLogikaController");
$rutiraj->get("/pregled-izvestaja/azuriraj-izvestaj", "izvestaj/azurirajIzvestajFormaController");
$rutiraj->patch("/pregled-izvestaja/azuriraj-izvestaj", "izvestaj/azurirajIzvestajLogikaController");
$rutiraj->delete("/pregled-izvestaja/obrisi-izvestaj", "izvestaj/obrisiIzvestajController");


// kontrola rudnika
$rutiraj->get("/kontrola-rudnika", "kontrolaRudnika/kontrolaRudnikaController");
$rutiraj->get("/kontrola-rudnika/dodaj-rudnik", "kontrolaRudnika/dodajRudnikFormaController");
$rutiraj->post("/kontrola-rudnika/dodaj-rudnik", "kontrolaRudnika/dodajRudnikLogikaController");
$rutiraj->get("/kontrola-rudnika/azuriraj-rudnik", "kontrolaRudnika/azurirajRudnikFormaController");
$rutiraj->patch("/kontrola-rudnika/azuriraj-rudnik", "kontrolaRudnika/azurirajRudnikLogikaController");
$rutiraj->delete("/kontrola-rudnika/obrisi-rudnik", "kontrolaRudnika/obrisiRudnikController");

// auth
$rutiraj->get("/prijava", "auth/prijavaFormaController");
$rutiraj->post("/prijava", "auth/prijavaLogikaController");
$rutiraj->get("/odjava", "auth/odjavaController");
$rutiraj->get("/registracija", "auth/registracijaFormaController");
$rutiraj->post("/registracija", "auth/registracijaLogikaController");
$rutiraj->get("/dashboard/users", "auth/usersCMSController");
$rutiraj->delete("/dashboard/users/delete", "auth/deleteUserController");

// errors
$rutiraj->get("/error404", "/error/404");
$rutiraj->get("/error500", "/error/500");
$rutiraj->get("/error400", "/error/400");
