Evidencija rudnika

Seminarski rad iz predmeta Softversko inženjerstvo 2

## Podešavanje Apache servera

Da bi aplikacija mogla da se pokrene potrebno je da naziv root foldera aplikacije koji se nalazi u htdocs-u bude Evidencija-Rudnika i da se promene podešavanja za Apache server u XAMPP-u, što će dovesti do toga da će Apache posmatrati public folder unutar Evidencija-Rudnika foldera kao root folder.

Najbolje bi bilo da se pre svega httpd.conf fajl iz xampp/apache/conf foldera sačuva negde radi ponovnog vraćanja na stara podešavanja. U slučaju da do sada nije ništa menjano na Apache serveru, u Evidencija-Rudnika/config/apache folderu postoji httpd-standard.conf fajl koji je standardni fajl za podešavanje Apache servera za 8.2.12 verziju XAMPP-a.

Nakon toga, potrebno je httpd.conf fajl iz Evidencija-Rudnika/config/apache foldera prekopirati u xammp/apache/conf folder, prepisati ga preko već postojećeg fajla i ponovo pokrenuti Apache pomoću XAMPP-a.

Na isti način se podešavanja vraćaju na prvobitna.

Ako ovaj način nije odgovarajući, dovoljno je u httpd.conf fajlu zameniti:

DocumentRoot "C:/xampp/htdocs"
<Directory "C:/xampp/htdocs">

za:

DocumentRoot "C:/xampp/htdocs/Evidencija-Rudnika/public"
<Directory "C:/xampp/htdocs/Evidencija-Rudnika/public">

Nakon svega toga, sajtu se pristupa preko sledećeg url linka: http://localhost/

## Kredencijali za prijavljivanje

Korisnik:
Korisničko ime: test@test.test
Šifra: 123
Admin:
Korisničko ime: admin@admin.admin
Šifra: 123

Postoji više korisničkih naloga, svi imaju šifru 123
