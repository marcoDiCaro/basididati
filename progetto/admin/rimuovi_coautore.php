<?php 
    session_start();

    require("../connect_db.php");

    if(isset($_SESSION["user"])){
        $utente_id = $_SESSION["id"];
        $leggere = mysqli_query($connessioneDB, "SELECT * FROM blog WHERE autore=$utente_id AND nome_c!='NULL'") or die(mysqli_error($connessioneDB));
        if(mysqli_num_rows($leggere)>0){
            $eliminare = mysqli_query($connessioneDB, "UPDATE blog SET nome_c=NULL WHERE autore=$utente_id") or die(mysqli_error($connessioneDB));
            if($eliminare){
                $update_message = "coautore rimosso con successo";
                header("Location: user_dashboard.php?message=$update_message");
            }
        }
        else{
            $update_message = "nessun coautore da rimuovere";
            header("Location: user_dashboard.php?message=$update_message");
        }
    }
    else{
        header("Location: ../index.php");
    }
?>