// créer une span (inséer au bon endroit avec le bon message d'erreur)

class ErrorSpan
{
// constructeur 

displaySpan(idRecup,message)
{
    let span = document.createElement('span');
    // ou insérer cette span ??? 
    // on a besoin de l'id de l'input ??? 
    // ajouter la classe 
    span.classList.add("form-error");
    // contenu textuel 
    span.textContent = message
    document.getElementById(idRecup).after(span);
}
}

export default ErrorSpan;