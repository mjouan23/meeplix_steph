// Fonction pour générer un entier aléatoire entre 1 et 6
function rollDices() {
   for (let i = 1; i <= 3; i++) {
        const value = Math.floor(Math.random() * 6) + 1;
        const ol = document.getElementById(`mycityrb-die-${i}`);

        // Alterner les classes d'animation
        if (ol.classList.contains("odd-roll")) {
            ol.classList.remove("odd-roll");
            ol.classList.add("even-roll");
        } else {
            ol.classList.remove("even-roll");
            ol.classList.add("odd-roll");
        }

        ol.setAttribute("data-roll", value);
    }
}

document.getElementById("rollButton").addEventListener("click", function(e) {
    e.preventDefault();
    rollDices();
});