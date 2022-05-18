document.addEventListener("DOMContentLoaded", function(){
    document.getElementById("search").addEventListener("keyup", caricaContenuto);
    function caricaContenuto(){ 
        var nome = document.getElementById("search");
        if(nome.value.length!=0){

            // Definire un'istanza dell'oggetto XMLHttpRequest

            var ajax = new XMLHttpRequest();

            /* Aprire la chiamata ajax specificandone il metodo, la risorsa e
            se  si vuole effettuare una chiamata asincrona oppure no attraverso un valore booleano */

            ajax.open("GET", "read_autocompletamento.php?stringa=" + nome.value, true);

            // Gestione della risposta inviata dal server

            ajax.onload = function(){

                // Gestione dello stato HTTP 200 con Richiesta andata a buon fine e risorsa trovata

                if(this.status == 200){
                document.getElementById("span").innerHTML = this.responseText;
                }

                // Gestione dello stato HTTP 404 con Richiesta non andata a buon fine e risorsa non trovata

                else if(this.status == 404){
                document.getElementById("span").innerHTML = "risorsa non trovata";
                }
            }

            // Spedire la richiesta

            ajax.send();
        }
    }
})