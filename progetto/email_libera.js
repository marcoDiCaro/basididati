document.addEventListener("DOMContentLoaded", function(){
    var email = document.getElementById("email");
    var user = document.getElementById("username");
    var doc = document.getElementById("doc");

    // Definire un'istanza dell'oggetto XMLHttpRequest

    var ajax = new XMLHttpRequest();

    // Chiamata ajax per controllo email

    email.addEventListener("keyup", function(){
        if(email.value.length!=0){

            /* Aprire la chiamata ajax specificandone il metodo, la risorsa e
            se  si vuole effettuare una chiamata asincrona oppure no attraverso un valore booleano */

            ajax.open("GET", "read_email.php?email=" + email.value, true);

            // Gestione della risposta inviata dal server

            ajax.onload = function(){

                // Gestione dello stato HTTP 200 con Richiesta andata a buon fine e risorsa trovata

                if(this.status == 200){
                document.getElementById("email_error").innerHTML = this.responseText;
                }

                // Gestione dello stato HTTP 404 con Richiesta non andata a buon fine e risorsa non trovata

                else if(this.status == 404){
                document.getElementById("email_error").innerHTML = "risorsa non trovata";
                }
            }

            // Spedire la richiesta

            ajax.send();
        }
    })

    // Chiamata ajax per controllo username

    user.addEventListener("keyup", function(){
        if(user.value.length!=0){

            /* Aprire la chiamata ajax specificandone il metodo, la risorsa e
            se  si vuole effettuare una chiamata asincrona oppure no attraverso un valore booleano */

            ajax.open("GET", "read_email.php?user=" + user.value, true);

            // Gestione della risposta inviata dal server

            ajax.onload = function(){

                // Gestione dello stato HTTP 200 con Richiesta andata a buon fine e risorsa trovata

                if(this.status == 200){
                document.getElementById("user_error").innerHTML = this.responseText;
                }

                // Gestione dello stato HTTP 404 con Richiesta non andata a buon fine e risorsa non trovata

                else if(this.status == 404){
                document.getElementById("user_error").innerHTML = "risorsa non trovata";
                }
            }

            // Spedire la richiesta

            ajax.send();
        }
    })

    // Chiamata ajax per controllo documento

    doc.addEventListener("keyup", function(){
        if(doc.value.length!=0){

            /* Aprire la chiamata ajax specificandone il metodo, la risorsa e
            se  si vuole effettuare una chiamata asincrona oppure no attraverso un valore booleano */

            ajax.open("GET", "read_email.php?doc=" + doc.value, true);

            // Gestione della risposta inviata dal server

            ajax.onload = function(){

                // Gestione dello stato HTTP 200 con Richiesta andata a buon fine e risorsa trovata

                if(this.status == 200){
                document.getElementById("doc_error").innerHTML = this.responseText;
                }

                // Gestione dello stato HTTP 404 con Richiesta non andata a buon fine e risorsa non trovata

                else if(this.status == 404){
                document.getElementById("doc_error").innerHTML = "risorsa non trovata";
                }
            }

            // Spedire la richiesta

            ajax.send();
        }
    })
})