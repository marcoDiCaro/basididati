<?php
    session_start();

    require("connect_db.php");

    if(!isset($_SESSION["user"])){
        header("Location: index.php");
    }
    else{
        $utente = $_SESSION["user"];
        $utente_id = $_SESSION["id"];
    }

    if(isset($_GET["id"])){
        $post_id = $_GET["id"];
    }

    if((isset($_GET["blog_id"]))&&(isset($_GET["nome"]))){
        $blog_id = $_GET["blog_id"];
        $nome = $_GET["nome"];
    }

    if(isset($_GET["page"])){
        $page = $_GET["page"];
    }

    if(isset($_GET["edit"])){
        $commento_id = $_GET["edit"];
        $leggere = mysqli_query($connessioneDB, "SELECT * FROM commento WHERE id=$commento_id") or die(mysqli_error($connessioneDB));

        //Edit Commento

        if(isset($_POST["submit"])){
            if(!empty($_POST["nota"])){

                //Gestione SQL Injection con mysqli_real_escape_string

                $nota = mysqli_real_escape_string($connessioneDB, $_POST["nota"]);
            }
            else{
                $nota_error = "inserire nota";
            }
            if(!empty($nota)){

                //Gestione XSS Cross Site Scripting

                if(stripos($nota,"<script>")!==false){
                    $commento_message = "Commento non valido";
                    header("Location: edit_commento.php?id=$post_id&blog_id=$blog_id&nome=$nome&page=$page&edit=$commento_id&commento_message=$commento_message");
                }
                else{
                $aggiornare = mysqli_query($connessioneDB, "UPDATE commento SET nota='$nota' WHERE id=$commento_id") or die(mysqli_error($connessioneDB));
                }

                if($aggiornare){
                    $commento_message = "commento aggiornato con successo";
                    header("Location: single.php?id=$post_id&blog_id=$blog_id&nome=$nome&page=$page&commento_message=$commento_message");
                }
            }    
        }

        if(isset($_POST["annulla"])){
            header("Location: single.php?id=$post_id&blog_id=$blog_id&nome=$nome&page=$page");
        }
    }
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Commento</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css"> <!-- Font Awesome -->
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="js/hamburger_admin.js"></script>
</head>
<body>

    <!-- Mostra messaggio di errore -->

    <p id="update_message">
    <?php
        if(isset($_GET["commento_message"])){
            echo $_GET["commento_message"];
        }
    ?>
    </p>

    <div class="new-post-container">

        <!-- Edit commento -->

        <div class="post-container" id="edit-comment">
            <form action="edit_commento.php?id=<?php echo $post_id;?>&blog_id=<?php echo $blog_id;?>&nome=<?php echo $nome;?>&page=<?php echo $page;?>&edit=<?php echo $commento_id;?>" method="POST">
            <?php 
                while($datiRiga = mysqli_fetch_assoc($leggere)){
            ?>
                <label for="nota">Nota:</label>
                <textarea name="nota" id="nota" rows="5" cols="50"><?php echo $datiRiga["nota"]; ?></textarea>
                <p>
                <?php 
                    if(isset($nota_error)){
                        echo $nota_error;
                    }
                ?>
                </p>
                <div class="button-edit-comment">
                    <button type="submit" name="submit" id="aggiorna">Aggiorna</button>
                    <button type="submit" name="annulla" id="annulla">Annulla</button>
                </div>
            <?php
                }
            ?>
            </form>
        </div>
    </div>

<!-- Footer -->

<?php
    include("footer.php");
?>

</body>
</html>