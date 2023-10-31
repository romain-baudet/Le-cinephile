'use strict';

import Request from './modules/Request.js';
// variables 
let form;

// fnct 
function validerForm(event)
{
    // Récupérer toutes les balises <span>
    let spans = document.getElementsByTagName("span");

    // Convertir la collection HTML en tableau
    let spansArray = Array.from(spans);

    // Parcourir le tableau et supprimer chaque balise <span>
    spansArray.forEach(function(span)
    {
        span.parentNode.removeChild(span);
    });
    
    //  event.preventDefault();
    
    // console.log("coucou");
    
    // récuperer = selectionner  les champs du form 
    let inputs = document.querySelectorAll('input');
    // let selects = document. querySelectorAll('select')
    console.log(inputs);
    let textarea = document.querySelectorAll('textarea')
    //console.log(inputs[1].value);
    let request = new Request();
    request.getInputs(inputs);
    request.getInputs(textarea);
   

    // si une des props est vide veut dire que ya une erreur sur un input 
    if(request._nameError == true || request._birthdateError == true || request._emailError == true || request._passwordError == true || request._generalAddFilmError == true || request._dateError == true || request._optionsVerifyError == true)
    {
        event.preventDefault();
        console.log("coucou");
    }
}


// code principal

document.addEventListener("DOMContentLoaded",function()
{
    form = document.querySelector('form');
    form.addEventListener('submit',validerForm);  
})





