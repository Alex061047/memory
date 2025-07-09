
//Sélection de photos 
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


//Permet de se placer dans la balisehtml <div></div>
const gameBoard = document.getElementById('game-board');

//Tableau vide pour insérer cartes sélectionnées
let cartesSelection = [];

//Fonction pour créer les cartes avec l'URL
function createCard (CardUrl) {
const card = document.createElement('div');
  card.classList.add ( 'card' );
  card.dataset.value = CardUrl;
  card.addEventListener ("click", click);

  const cardContent = document.createElement('img');
  cardContent.classList.add ( 'card-content' );
  cardContent.src = `${CardUrl}`;
  card.appendChild(cardContent);
  return card;
  
}

//Fonction pour créer les paires de cartes
function double (simple) {
  let jeudouble = [];
  jeudouble.push (...simple);
  jeudouble.push (...simple);
  return jeudouble;
  
}


//Fonction de mélange 
function melange (carteMelange) {
 const jeuMelange = carteMelange.sort( () => 0.5 - Math.random() );
  return jeuMelange;
}


//Fonction pour gerer le click sur les cartes 
function click (e) {
  const card = e.target.parentElement;
card.classList.add("flip");

//Dans la fonction, on ajoute dans le tableau la cartes sélectionnée et on compare les cartes une fois 2 éléments choisis
    cartesSelection.push(card);
  
if(cartesSelection.length == 2){

  setTimeout( () => {
      if(cartesSelection[0].dataset.value == cartesSelection[1].dataset.value){
//on a trouvé une paire
        cartesSelection[0].classList.add("matched");   cartesSelection[1].classList.add("matched"); cartesSelection[0].removeEventListener('click', click);  cartesSelection[1].removeEventListener('click', click);

const gagne = document.querySelectorAll('.card:not(.matched)');
        if(gagne.length == 0){
          //C'est gagné
          let body=document.body;
          let message = document.createElement('h1');
          message.textContent = "Bravo!";
          body.prepend(message);
        }
      }

else{
//on s'est trompé
          cartesSelection[0].classList.remove("flip"); cartesSelection[1].classList.remove("flip");
      }
  
  cartesSelection = [];
}, 500)
}
}


//On double les cartes grâce à la fonction double
let ensemble = double(cards);


//On melange le paquet de carte grâce à la fonction mélange 
ensemble = melange (ensemble);

//Pour chaque url on crée une carte
ensemble.forEach(card => {
  const cardHtml = createCard(card);
  gameBoard.appendChild(cardHtml);

})