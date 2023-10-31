"use strict";



let btnSelect;
let panier = [];
let btnAjoutPanier;

// Fonctions qui gèrent l'affichage de la div avec les détails selon la séance choisie

function onClickBtnSelect()
{
    let choix = btnSelect.value;
    // console.log(choix);
    // une requete ajax pour récupérer les détails d'une session 
    $.get("index.php?action=detailsSession","session_id="+choix,displayDetails);
}

function displayDetails(details)
{
    console.log(details);
    let div = document.getElementById("detailsSelection");
    div.innerHTML = details;
    
    // le bouton Réserver une séance est crée ici 
     // séléctionner tous les boutons ajouter au panier 
    btnAjoutPanier = document.getElementsByClassName('buttonResa');
    //console.log(btnAjoutPanier);
    btnAjoutPanier[0].addEventListener('click',onClickBtnAjoutPanier);
}



// Fonctions qui gèrent l'ajout du panier via localstorage

function onClickBtnAjoutPanier(event)
{
    
    // console.log("click!");
    // récupérer l'id de ce btn (le bouton sur lequel l'utilisateur vient de cliquer !!)
    let idBtn = this.id;
    console.log(idBtn);
    // une requete ajax 
    $.getJSON("index.php?action=ajaxAddPanier","session_id="+idBtn,recupDetailsSession);
}

function recupDetailsSession(session)
{
    // console.log(session)
    // le remplissage de notre panier 
    let id = session.session_id;
    // console.log(id);
    let movie_id = session.movie_id;//
    // console.log(movie_id);
    let room_id = session.room_id;
    // console.log(room_id);
    let date = session.date;
    let time = session.time;
    let price = session.price;
    let poster = session.poster;
    let title = session.title;
    let quantityInput = document.querySelector('.inputNumber');
    let quantity = parseInt(quantityInput.value);
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
        panier.push([id,movie_id,room_id,date,time, quantity, price, poster,title]);
    }
    else
    {
        panier[indice][5] = parseInt(panier[indice][5]) + quantity;
    }
    
    onSaveLocalStorage();
    onLoadLocalStorage();
    // redirect("index.php?action=displayPanier");
    window.location.href = "index.php?action=displayPanier";
}

// function redirect(URL)
// {
//     window.location.href = URL;
// }

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



// *** code princiapl 
document.addEventListener("DOMContentLoaded",function(){
    onLoadLocalStorage();// pour ne pas perdre des données 
    
    btnSelect = document.getElementById('sessionSelect');
    btnSelect.addEventListener("change",onClickBtnSelect);
    
    // // séléctionner tous les boutons ajouter au panier 
    // btnAjoutPanier = document.getElementsByClassName('buttonResa');
    // //console.log(btnAjoutPanier);
    // btnAjoutPanier.addEventListener('click',onClickBtnAjoutPanier);
    
})

