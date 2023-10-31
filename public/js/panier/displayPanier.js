"use strict";

let panier = [];
let total = 0;
let btnValiderCMD;

function onSaveLocalStorage()
{
    // js --> json 
    panier = JSON.stringify(panier);
    window.localStorage.setItem('monPanier',panier);
}

function onLoadLocalStorage()
{
    panier = window.localStorage.getItem('monPanier');
    // console.log(panier);
    if(panier == null)
    {
        // console.log("coucou");
        panier = [];
    }
    else
    {
        // console.log("coucou");
        panier = JSON.parse(panier);
    }
}

function display()
{
    // récupérer le panier depuis le localStorage 
    // tester si le panier est vide pour afficher un message d'erreur 
    let tbody = document.getElementById('panier');
    // il faut vider la tbody 
    tbody.innerHTML = "";
    total = 0;
    onLoadLocalStorage();
    // console.log(panier.length);
    if(panier.length == 0)
    {
        // console.log("coucou");
        let row1 = document.createElement('tr');
        let cell1 = document.createElement('td');
        cell1.innerHTML = "<p>Votre panier est vide </p>";
        row1.appendChild(cell1);
        tbody.appendChild(row1);
    }
    else
    {
        let i = 0;
        for(const item of panier)
        {
            
            total += (item[5]*item[6]);
            let row1 = document.createElement('tr');
            
            let cell1 = document.createElement('td');
            if(item[7] == "")
            {
                cell1.innerHTML = "<img src='public/images/no-photo.png'>";
            }
            else
            {
                cell1.innerHTML = "<img class='miniature' src='public/images/"+item[7]+"'>";
            }
            
            let cell2 = document.createElement('td');
            cell2.textContent = item[8];
            let cell3 = document.createElement('td');
            cell3.textContent = item[2];
            let cell4 = document.createElement('td');
            cell4.textContent = item[3];
            let cell5 = document.createElement('td');
            let time = item[4];
            let hoursMinutes = time.substring(0, 5); // Extraire les 5 premiers caractères (HH:ii)
            
            cell5.textContent = hoursMinutes;

            let cell6 = document.createElement('td');
            cell6.innerHTML = "<input class='moreOrLess' data-indice='"+i+"' type='number' min='1' max='30' value='"+item[5]+"'>";
            let cell7 = document.createElement('td');
            cell7.textContent = item[5]*item[6] +"€";
            let cell8 = document.createElement('td');
            cell8.innerHTML = "<button class='buttonResa' data-indice='"+i+"'>supprimer</button>";
            // insérer les td dans la tr 
            row1.appendChild(cell1);
            row1.appendChild(cell2);
            row1.appendChild(cell3);
            row1.appendChild(cell4);
            row1.appendChild(cell5);
            row1.appendChild(cell6);
            row1.appendChild(cell7);
            row1.appendChild(cell8);
            // insérer la tr dans le tbody 
            tbody.appendChild(row1);

            // incrémenter le compteur i 
            i++;
        }
        // afficher le prix total 
        let totalElt = document.getElementById("total");
        totalElt.textContent = "Le prix total de votre commande est de "+total.toFixed(2) +"€";
    }

    // séléctionner le input de type number 
    let inputNumber = document.querySelectorAll('input[type=number]');
    // console.log(inputNumber);
    for(const input of inputNumber)
    {
        input.addEventListener('input',onClickBtnNumber);
    }

    // installer un event clicl sur le bouton supprimer 
    let btnSuprimer = document.querySelectorAll("#panier button");
    // console.log(btnSuprimer);
    for(const button of btnSuprimer)
    {
        button.addEventListener("click",onDeletOneItem);
    }
}

function onDeletOneItem()
{
    let indice = this.getAttribute('data-indice');
    //console.log(indice);
    panier.splice(indice,1);
    onSaveLocalStorage();
    onLoadLocalStorage();
    display();
}

function onClickBtnNumber(event)
{
    let quantity = this.value;
    console.log(quantity);
    // l'indice de cet élément dans le localStorage 
    let indice = this.getAttribute('data-indice');
    // console.log(indice);
    console.log(panier);
    panier[indice][5] = quantity;// ecraser l'encienne valuer par la nouvelle valeur saisie par l'utilisateur
    // mettre à jour 
    onSaveLocalStorage();
    onLoadLocalStorage();
    mettreAjourPanier(indice);
}

function mettreAjourPanier(indice)
{
    console.log(indice);
    // Sélectionner le corps (tbody) du tableau
    let tr = document.querySelectorAll('#panier tr');
    // console.log(tr);
    // Sélectionner la cinquième cellule (td) enfant de la ligne
    //for(const tr of tbody)
    //{
        let sousTotal = tr[indice].children[6];

        // Utiliser la cellule sélectionnée
        sousTotal.textContent = panier[indice][5]*panier[indice][6];
    //}
    // séléctionner pour mettre a jour le prix total 
    total = 0;
    for(const basket of panier)
    {
        total += (basket[5]*basket[6]);
    }
    let totalElt = document.getElementById("total");
    totalElt.textContent = "Le prix total de votre commande est de "+total.toFixed(2);
}

function onClickBtnValiderCMD()
{
    // récupérer les données du localStorage
    onLoadLocalStorage();
    if(panier.length == 0 )
    {
        let tbody = document.getElementById('panier');
        tbody.innerHTML = "";
        let row1 = document.createElement('tr');
        let cell1 = document.createElement('td');
        cell1.innerHTML = "<p>Votre panier est vide, veuillez faire votre choix </p>";
        row1.appendChild(cell1);
        tbody.appendChild(row1);
        
    }
    else
    {
        // js --> json 
        panier = JSON.stringify(panier);
        // console.log(panier);
        // console.log(total);
        $.get('index.php?action=valideCmdAjax',"panier="+panier+"&total="+total,clearStorage);
    }
    
}

function clearStorage(test)
{
    //console.log(test);
    panier = JSON.parse(panier);
    if(test)
    {
        // tout vide
        let date = new Date();
        let message = "Votre commande à bien été passée le "+date.getDate()+"/"+(date.getMonth()+1)+"/"+date.getFullYear()+" pour un motant de "+total +"€";

        //panier.length = 0;
        //total = 0;
        window.localStorage.clear();
        //onSaveLocalStorage();
        //onSaveLocalStorage();
        display();
        let messageConfirm = document.getElementById("messageConfirm");
        messageConfirm.textContent = message;
        // Obtenez une référence à l'élément bouton par son ID
        let bouton = document.getElementById("validerCMD");

        // Vérifiez si le bouton existe avant de le supprimer
        if (bouton) {
        // Récupérez le parent de l'élément bouton
        let parent = bouton.parentNode;

        // Supprimez le bouton en utilisant removeChild()
        parent.removeChild(bouton);
        }
    }
}

document.addEventListener("DOMContentLoaded",function(){
    // console.log("coucou");
    onLoadLocalStorage();// pour ne pas perdre des données 
    display();

    // valider la commande 
    btnValiderCMD = document.getElementById("validerCMD");
    btnValiderCMD.addEventListener("click",onClickBtnValiderCMD);
})