<?php
    require("connect_db.php");

    if(isset($_GET["email"])){
        $email = $_GET["email"];
    }

    if(isset($_GET["user"])){
        $user = $_GET["user"];
    }

    if(isset($_GET["doc"])){
        $doc = $_GET["doc"];
    }

    //Controllo Email

    if(!empty($email)){
        $email = strtolower($email);

        //Controllo se l'email non è già stata utilizzata

        $leggere = mysqli_query($connessioneDB, "SELECT email FROM utente") or die(mysqli_error($connessioneDB));
        while($datiRiga = mysqli_fetch_assoc($leggere)){
            $nome = $datiRiga["email"];
            if($email==$nome){
                echo "email già presente";
            }
        }
    }

    //Controllo Username

    if(!empty($user)){
        $user = strtolower($user);

        //Controllo se l'username non è già stato utilizzato

        $leggere = mysqli_query($connessioneDB, "SELECT nome FROM utente") or die(mysqli_error($connessioneDB));
        while($datiRiga = mysqli_fetch_assoc($leggere)){
            $nome = $datiRiga["nome"];
            if($user==$nome){
                echo "username già presente";
            }
        }
    }

    //Controllo Documento

    if(!empty($doc)){
        $doc = strtolower($doc);

        //Controllo se il documento non è già stato utilizzato

        $leggere = mysqli_query($connessioneDB, "SELECT documento FROM utente") or die(mysqli_error($connessioneDB));
        while($datiRiga = mysqli_fetch_assoc($leggere)){
            $nome = $datiRiga["documento"];
            if($doc==$nome){
                echo "documento già presente";
            }
        }
    }
?>