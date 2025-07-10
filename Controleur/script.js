// Sélection du plateau de jeu
const gameBoard = document.getElementById('game-board');
let cartesSelection = []; // Tableau temporaire

// Création des paires
function double(cartes) {
  let jeudouble = [];
  cartes.forEach(url => {
    jeudouble.push(url);
    jeudouble.push(url);
  });
  return jeudouble;
}

// Mélange le jeu de cartes
 
function melange(jeu) {
  return jeu.sort(() => 0.5 - Math.random());
}

// Crée l’élément HTML d'une carte
 
function createCard(url) {
  const card = document.createElement('div');
  card.classList.add('card');
  card.dataset.value = url;
  card.addEventListener("click", click);

  const img = document.createElement('img');
  img.classList.add('card-content');
  img.src = url;
  card.appendChild(img);

  return card;
}

// Gestion du clic
 
function click(e) {
  const card = e.target.closest('.card');

  // Ne rien faire si déjà retournée ou trouvée
  if (card.classList.contains('flip') || card.classList.contains('matched')) return;

  // Retourne la carte
  card.classList.add("flip");
  cartesSelection.push(card);

  //Si deux cartes sont retournées
  if (cartesSelection.length === 2) {
    setTimeout(() => {
      const [c1, c2] = cartesSelection;

      if (c1.dataset.value === c2.dataset.value) {
        // Marque comme trouvée
        c1.classList.add("matched");
        c2.classList.add("matched");
        // Supprime l'écouteur de clic
        c1.removeEventListener("click", click);
        c2.removeEventListener("click", click);

        // Vérifier s'il reste des cartes
        const reste = document.querySelectorAll('.card:not(.matched)');
        if (reste.length === 0) {
          arreterTimer();
          enregistrerTempsSiRecord();

          // Affiche message
          let message = document.createElement('h1');
          message.textContent = "Bravo !";
          document.body.prepend(message);
        }
      } 
      // Si ce n'est pas une paire
      else {
        c1.classList.remove("flip");
        c2.classList.remove("flip");
      }

      cartesSelection = [];
    }, 500);
  }
}

// Charge les images depuis la base de données et initialise le jeu
 
function chargerImagesDepuisBDD() {
  fetch('Modele/get_images.php')
    .then(res => res.json())
    .then(data => {
      if (data.success && data.images.length > 0) {
        const urls = data.images.map(img => img.url);
        const jeu = melange(double(urls));

        jeu.forEach(url => {
          const carte = createCard(url);
          gameBoard.appendChild(carte);
        });

        chargerMeilleurTemps(); // Affiche meilleur score
        demarrerTimer();        // Lance le chrono
      } else {
        console.error("Aucune image reçue.");
      }
    })
    .catch(err => console.error("Erreur AJAX :", err));
}

// Au chargement de la page
document.addEventListener('DOMContentLoaded', chargerImagesDepuisBDD);
