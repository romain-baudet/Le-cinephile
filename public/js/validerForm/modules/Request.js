// récupérer les champs du formulaire 
// vérifier les valeurs saisie par l'utilisateur (de chaque champs)

import ErrorSpan from './ErrorSpan.js';

class Request
{
    // constructeur
    constructor()
    {
        this._name = "";
        this._surname = "";
        this._birthdate = "";
        this._email = "";
        this._password = "";
        this._generalAddFilm = "";
        this._date = "";
        this._optionsVerify ="";
        
        this._nameError = false;
        // this._surnameError = false;
        this._birthdateError = false;
        this._emailError = false;
        this._passwordError = false;
        this._generalAddFilmError = false;
        this._dateError = false;
        this._optionsVerifyError =false;
        
        this.errorSpan = new ErrorSpan();
    }
    
    getInputs(inputs)
    {
        // console.log(inputs);
        for(let i=0;i<inputs.length;i++)
        {
            if(inputs[i].id == "name" || inputs[i].id == "surname")
            {
               this.name = inputs[i]; 
               console.log(inputs[i].value);
            }
            else if (inputs[i].id == "birthdate")
            {
               this.birthdate = inputs[i]; 
            }
            else if (inputs[i].id == "email")
            {
               this.email = inputs[i]; 
            }
            else if (inputs[i].id == "password")
            {
               this.password = inputs[i]; 
            }
            else if(inputs[i].id == "title" || inputs[i].id == "type" || inputs[i].id == "duration" || inputs[i].id == "realisator" || inputs[i].id == "actors" || inputs[i].id == "resume" || inputs[i].id == "teaser" || inputs[i].id == "status" || inputs[i].id == "time" || inputs[i].id == "price" || inputs[i].id == "room_id")
            {
                this.regroupeInputAddFilm = inputs[i]; 
            }
            else if(inputs[i].id == "date")
            {
                this.date = inputs[i];
            }
            else if (inputs[i].tagName.toLowerCase() == "select") {
                this.regroupeInputOption = inputs[i];
            }
           
        }
        
    }
    

    
    get date()
    {
        return this._date;
    }
    
    set date(newDate)
    {
        if(newDate.value == "")
        {
            this.errorSpan.displaySpan(newDate.id,"Ce champ ne doit pas etre vide");
            this._dateError = true;
        }
        else
        {
            this._date = newDate.value;
        }
    }
    
    
    
    get regroupeInputAddFilm()
    {
        return this._generalAddFilm;
    }
    
    set regroupeInputAddFilm(newValue)
    {
        const regex = /^[\w\d\s?!@#$%^&*()\-+={}[\]|:;"'<>,.?/\\~_]{1,256}$/;
        
        if(newValue.value == "")
        {
            this.errorSpan.displaySpan(newValue.id,"Ce champ ne doit pas etre vide");
            this._generalAddFilmError = true;
        }
        else if(!regex.test(newValue.value))
        {
            this.errorSpan.displaySpan(newValue.id,"Veuillez respecter le bon format");
            this._generalAddFilmError = true;
        }
        else 
        {
            this._generalAddFilm = newValue.value;
        }
        
    }
    // les autres méthodes --> setter et des getters 
    get password()
    {
        return this._password;
    }

    set password(newPassword)
    {
        let motDePasseRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{8,}$/;

        if(newPassword.value == "")
        {
            this.errorSpan.displaySpan(newPassword.id,"Ce champ ne doit pas etre vide");
            this._passwordError = true;
        }
        else if(!motDePasseRegex.test(newPassword.value))
        {
            this.errorSpan.displaySpan(newPassword.id,"Veuillez respecter le bon format");
            this._passwordError = true;
            console.log(newPassword.value);
        }
        else 
        {
            this._password = newPassword.value;
        }
    }
    
    
    
    get birthdate()
    {
        return this._birthdate;
    }

    set birthdate(newBirthdate)
    {
        if(newBirthdate.value != "")
        {
            const dateBirthDay = new Date(newBirthdate.value);
            const dateNow = new Date();
            // calculer l'age de l'utilisateur 
            const age = dateNow.getFullYear() - dateBirthDay.getFullYear();
            // en fonction de l'age on affiche un message 
            if(age<18 || age > 150)
            {
                this.errorSpan.displaySpan(newBirthdate.id,"Vous n'avez pas l'age requis (entre 18 et 150 ans)");
                this._birthdateError = true;
            }
            else
            {
                this._birthdate = newBirthdate.value;
            }
        }
        else
        {
            // tester si c'est pas vide 
            this.errorSpan.displaySpan(newBirthdate.id,"Ce champ ne doit pas être vide ");
            this._birthdateError = true;
        }
    }
    get name()
    {
        return this._name;
    }
    
    set name(newName)
    {
        console.log(newName.value);
        //vérification
        const regex = new RegExp(/^[a-zA-Z- éèà]{3,50}$/);
        // ce n'est pas vide 
        if(newName.value == "")
        {
            // console.log('ce champ ne doit pas etre vide ');
            this.errorSpan.displaySpan(newName.id,"Ce champ ne doit pas être vide ");
            this._nameError = true;
        }
        // contient que de lettres  avec un min et max 
        else if(!(regex.test(newName.value)))
        {
            // console.log(newName);
            // console.log("ce champ doit contenir que des lettres");
            this.errorSpan.displaySpan(newName.id,"Ce champ ne doit contenir que des lettres (3-50) ");
            this._nameError = true;
        }
        else
        {
            this._name = newName.value;
        }
    }
    
    get email()
    {
        return this._email;
    }
    
    set email(newEmail)
    {
        // c'est pas vide 
        if(newEmail.value == "")
        {
            // console.log("ce champ ne doit pas etre vide ");
            this.errorSpan.displaySpan(newEmail.id,"Ce champ ne doit pas être vide ");
            this._emailError = false;
        }
        // contient un @
        else if(!newEmail.value.includes("@"))
        {
            // console.log("ce n'est pas le bon format de l'adresse mail")
            this.errorSpan.displaySpan(newEmail.id,"Le format ne correspond pas à celui attendu");
            this._emailError = true;
        }
        // si tout est OK 
        else
        {
           this._email = newEmail.value; 
        }
    }

}
export default Request;













