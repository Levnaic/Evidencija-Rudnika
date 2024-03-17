//nav
const korisnikIkonica = document.getElementById("korisnikIkonica");
const padajuciMeni = document.querySelector(".padajuciMeni");

korisnikIkonica.addEventListener("click", () => {
  padajuciMeni.classList.toggle("padajuciMeniAktivan");
});
