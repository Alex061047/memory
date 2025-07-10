// Variables globales du timer
let startTime = null;
let timerInterval = null;
let tempsFinal = 0;

// Démarre le chronomètre

function demarrerTimer() {
  startTime = Date.now(); // Stocke l'heure de début
  timerInterval = setInterval(() => {
    const elapsed = Math.floor((Date.now() - startTime) / 1000); // Temps écoulé en secondes
    const timerDisplay = document.getElementById("timer");
    if (timerDisplay) {
      timerDisplay.textContent = `Temps : ${elapsed}s`;
    }
  }, 1000);
}

// Arrête le chronomètre et stocke le temps final écoulé.
 
function arreterTimer() {
  clearInterval(timerInterval);
  tempsFinal = Math.floor((Date.now() - startTime) / 1000);
}

// Enregistre le score du joueur si c'est un nouveau record.
 
function enregistrerTempsSiRecord() {
  fetch('Modele/score.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ temps: tempsFinal })
  })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        console.log("Score enregistré !");
        chargerMeilleurTemps(); // Met à jour l'affichage du score
      } else {
        console.warn("Score non enregistré :", data.message);
      }
    })
    .catch(err => {
      console.error("Erreur lors de l'enregistrement du score :", err);
    });
}

// Recharge le meilleur score depuis le serveur et l'affiche.
 
function chargerMeilleurTemps() {
  fetch('Modele/get_meilleur_score.php')
    .then(response => response.json())
    .then(data => {
      if (data && data.meilleur_temps != null) {
        const scoreDisplay = document.getElementById("meilleur-score");
        if (scoreDisplay) {
          scoreDisplay.textContent = `Votre meilleur temps : ${data.meilleur_temps}s`;
        }
      }
    })
    .catch(err => {
      console.error("Erreur lors du chargement du meilleur score :", err);
    });
}
