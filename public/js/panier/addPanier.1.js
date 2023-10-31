"use strict";

// *** déclaration des variables 
let panier = [];
let btnAjoutPanier;


// *** déclaration des fncts 
function onClickBtnAjoutPanier(event)
{
    // récupérer l'id de ce btn (le bouton sur lequel l'utilisateur vient de cliquer !!)
    let idBtn = this.id;
    console.log(idBtn);
    // une requete ajax 
    $.getJSON("index.php?action=ajaxAddPanier","session_id="+idBtn,recupDetailsSession);
}

function recupDetailsSession(session)
{
    //console.log(session);
    // le remplissage de notre panier 
    let id = session.session_id;
    let movie_id = session.movie_id;
    let room_id = session.room_id;
    let date = session.date;
    let time = session.time;
    let price = session.price;
    let quantity = 1;
    // vérifier est ce que le plat existe déja en localStorage 
    let indice = null;

    for(let i=0;i<panier.length;i++)
    {
        if(panier[i][0] == id)
        {
            // le produit existe déja je dois mettre uniquement la quantité à jour
            indice = i;
        }
    }

    if(indice == null)
    {
        panier.push([id,movie_id,room_id,date,time, quantity, price]);
    }
    else
    {
        panier[indice][5] = parseInt(panier[indice][5]) + 1;
    }
    onSaveLocalStorage();
    onLoadLocalStorage();
}

function onSaveLocalStorage()
{
    // js --> json 
    panier = JSON.stringify(panier);
    window.localStorage.setItem('monPanier',panier);
}

function onLoadLocalStorage()
{
    panier = window.localStorage.getItem('monPanier');

    if(panier == null)
    {
        panier = [];
    }
    else
    {
        panier = JSON.parse(panier);
    }
}

function recupSessionId() {
    event.preventDefault();

      const sessionSelect = document.getElementById('sessionSelect');
      const selectedValue = sessionSelect.value;
      
      // Utiliser la valeur sélectionnée pour effectuer d'autres actions si nécessaire
      console.log(selectedValue);
}

// *** code princiapl 
document.addEventListener("DOMContentLoaded",function(){
    onLoadLocalStorage();// pour ne pas perdre des données 
    // séléctionner tous les boutons ajouter au panier 
    btnAjoutPanier = document.querySelectorAll('.reservation');
    //console.log(btnAjoutPanier);
    for(const btn of btnAjoutPanier)
    {
        btn.addEventListener('click',onClickBtnAjoutPanier);
    }
    const reservationLink = document.getElementById('reservationLink');
    reservationLink.addEventListener('click', recupSessionId);

})