// * PROMENJIVE
const prihodi = document.getElementById("prihodi");
const rashodi = document.getElementById("rashodi");

// * FUNKCIJE
function ukljuciInput(input) {
  input.disabled = false;
  input.classList.remove("nedozvoljeniInput");
}

function iskljuciInput(input) {
  input.disabled = true;
  input.classList.add("nedozvoljeniInput");
}

// * APP
prihodi.addEventListener("input", function () {
  this.value ? iskljuciInput(rashodi) : ukljuciInput(rashodi);
});

rashodi.addEventListener("input", function () {
  this.value ? iskljuciInput(prihodi) : ukljuciInput(prihodi);
});
