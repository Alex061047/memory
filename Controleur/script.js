// --- Liste des cartes utilisées (8 paires uniques) ---
const cards = [
  'https://picsum.photos/id/237/100/100', 
  'https://picsum.photos/id/238/100/100',
  'https://picsum.photos/id/239/100/100',
  'https://picsum.photos/id/240/100/100',
  'https://picsum.photos/id/241/100/100',
  'https://picsum.photos/id/242/100/100',
  'https://picsum.photos/id/243/100/100',
  'https://picsum.photos/id/244/100/100'
];

// Récupère le conteneur du plateau de jeu
const gameBoard = document.getElementById('game-board');

// Tableau temporaire des cartes sélectionnées
let cartesSelection = [];

/**
 * Crée une carte à partir d'une URL d'image.
 */
function createCard(CardUrl) {
  const card = document.createElement('div');
  card.classList.add('card');
  card.dataset.value = CardUrl;
  card.addEventListener("click", click);

  const cardContent = document.createElement('img');
  cardContent.classList.add('card-content');
  cardContent.src = `${CardUrl}`;
  card.appendChild(cardContent);

  return card;
}

/**
 * Duplique le tableau de cartes pour avoir des paires.
 */
function double(simple) {
  let jeudouble = [];
  jeudouble.push(...simple);
  jeudouble.push(...simple);
  return jeudouble;
}

/**
 * Mélange les cartes aléatoirement.
 */
function melange(carteMelange) {
  const jeuMelange = carteMelange.sort(() => 0.5 - Math.random());
  return jeuMelange;
}

/**
 * Gère le clic sur une carte.
 */
function click(e) {
  const card = e.target.parentElement;
  card.classList.add("flip");

  cartesSelection.push(card);

  // Lorsqu'on a sélectionné 2 cartes, on les compare
  if (cartesSelection.length == 2) {
    setTimeout(() => {
      if (cartesSelection[0].dataset.value === cartesSelection[1].dataset.value) {
        // Bonne paire
        cartesSelection[0].classList.add("matched");
        cartesSelection[1].classList.add("matched");
        cartesSelection[0].removeEventListener('click', click);
        cartesSelection[1].removeEventListener('click', click);

        // Vérifie s’il reste des cartes à retourner
        const reste = document.querySelectorAll('.card:not(.matched)');
        if (reste.length === 0) {
          // Fin de partie
          let body = document.body;
          let message = document.createElement('h1');
          message.textContent = "Bravo !";
          body.prepend(message);

          // Stoppe le chronomètre
          arreterTimer();

          // Envoie du score uniquement si connecté
          enregistrerTempsSiRecord(); // ← Appelle le timer.js
        }
      } else {
        // Mauvaise paire → retourne les cartes
        cartesSelection[0].classList.remove("flip");
        cartesSelection[1].classList.remove("flip");
      }

      // Réinitialise la sélection
      cartesSelection = [];
    }, 500);
  }
}

// Création du jeu
let ensemble = melange(double(cards));

// Ajoute les cartes sur le plateau
ensemble.forEach(card => {
  const cardHtml = createCard(card);
  gameBoard.appendChild(cardHtml);
});

// Lance le jeu si connecté
chargerMeilleurTemps();  // Affiche le meilleur temps (depuis timer.js)
demarrerTimer();          // Démarre le chronomètre
