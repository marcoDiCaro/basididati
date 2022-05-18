<?php
    require("connect_db.php");

    if(isset($_GET["stringa"])){
        $stringa = $_GET["stringa"];
    }

    $suggerimento = "";

    if(!empty($stringa)){
        $stringa = strtolower($stringa);
        $len_stringa = strlen($stringa);
        $leggere = mysqli_query($connessioneDB, "SELECT nome FROM utente") or die(mysqli_error($connessioneDB));
        while($datiRiga = mysqli_fetch_assoc($leggere)){
            $nome = $datiRiga["nome"];
            if(stristr($stringa, substr($nome, 0, $len_stringa))){
                if($suggerimento == ""){
                    $suggerimento = $nome;
                }
                else{
                    $suggerimento .= " , $nome";
                }
            }
        }
    }

    if(!empty($suggerimento)){
        echo $suggerimento;
    }
    else{
        echo "No suggestion";
    }
?>