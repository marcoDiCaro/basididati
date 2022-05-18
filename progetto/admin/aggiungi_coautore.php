<?php
    session_start();

    require("../connect_db.php");

    if(isset($_SESSION["user"])){
        $utente = $_SESSION["user"];
        $utente_id = $_SESSION["id"];

        //Controllo se  l'utente ha già aggiunto un coautore

        $leggere = mysqli_query($connessioneDB, "SELECT * FROM blog WHERE autore=$utente_id AND nome_c!='NULL'") or die(mysqli_error($connessioneDB));
        if(mysqli_num_rows($leggere)>0){
            if(isset($_GET["message"])){
                $result_message = $_GET["message"];
            }
            else{
                $result_message = "coautore già aggiunto";
            }
            header("Location: user_dashboard.php?message=$result_message");
        }
        else{

            //Mostra Utenti disponibili

            $leggere2 = mysqli_query($connessioneDB, "SELECT * FROM utente WHERE id!=$utente_id") or die(mysqli_error($connessioneDB));

            //Mostra Blog disponibili

            $leggere3 = mysqli_query($connessioneDB, "SELECT * FROM blog WHERE autore=$utente_id") or die(mysqli_error($connessioneDB));
            if(isset($_POST["submit"])){

                //Controllo Nome Utente

                if(!empty($_POST["nome"])){
                    $nome = $_POST["nome"];

                    /*  Controllo che l'utente che si vuole aggiungere come coautore  
                        Non sia già coautore di un altro blog */

                    $leggere4 = mysqli_query($connessioneDB, "SELECT * FROM blog WHERE nome_c='$nome'") or die(mysqli_error($connessioneDB));
                    if(mysqli_num_rows($leggere4)>0){
                        $result_message = "impossiblie aggiungere ".$nome." come coautore perchè già coautore di un altro blog";
                        header("Location: aggiungi_coautore.php?message=$result_message");
                    }
                    else{
                        $nome2 = $_POST["nome"];
                    }
                }

                //Controllo Blog

                if(!empty($_POST["blog"])){
                    $blog = $_POST["blog"];
                }
                else{
                    $blog_error = "inserisci blog";
                }

                //Aggiungi Coautore

                if((!empty($nome2))&&(!empty($blog))){
                    $aggiornare = mysqli_query($connessioneDB, "UPDATE blog SET nome_c='$nome2' WHERE id=$blog") or die(mysqli_error($connessioneDB));
                    if($aggiornare){
                        $update_message = "coautore aggiunto con successo";
                        header("Location: aggiungi_coautore.php?message=$update_message");
                    }
                }
            }
        }
    }
    else{
        header("Location: ../index.php");
    }
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css"> <!-- Font Awesome -->
    <link rel="stylesheet" href="../css/styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="../js/hamburger_admin.js"></script>
</head>
<body>

    <!-- Mostra Messaggi -->

    <p id="update_message">
        <?php
            if(isset($_GET["message"])){
                echo $_GET["message"];
            }
        ?>
    </p>

    <div class="dashboard-container">
        <button id="hamburger"><i class="fas fa-bars"></i></button>

        <!-- Dahboard User -->

        <ul class="dashboard-navbar">
            <li><a href="../index.php"><i class="fas fa-home"></i>Home</a></li>
            <li><a href="user_dashboard.php"><i class="fab fa-blogger"></i>Blog</a></li>
            <li><a href="new_blog.php"><i class="far fa-edit"></i>Nuovo Blog</a></li>
            <li><a href="posts.php"><i class="fas fa-folder-open"></i>Post</a></li>
            <li><a href="new_post.php?user=<?php echo $utente; ?>&user_id=<?php echo $utente_id; ?>"><i class="far fa-edit"></i>Nuovo Post</a></li>
            <li><a href="categories.php"><i class="fas fa-tags"></i>Categorie</a></li>
            <li><a href="new_category.php"><i class="far fa-edit"></i>Nuova Categoria</a></li>
            <li><a href="sub_categoria.php"><i class="far fa-edit"></i>Nuova Sotto Categoria</a></li>
            <li><a href="modifica_utente.php"><i class="far fa-address-card"></i>Modifica Utente</a></li>
            <li><a href="immagine_profilo.php"><i class="fas fa-portrait"></i>Immagine Profilo</a></li>
            <li><a href="aggiungi_coautore.php"><i class="fas fa-user-plus"></i>Aggiungi coautore</a></li>
            <li><a href="rimuovi_coautore.php"><i class="fas fa-user-minus"></i>Rimuovi coautore</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a></li>
        </ul>

        <!-- New Coautore -->

        <div class="post-container">
            <form action="aggiungi_coautore.php" method="POST">

                <!-- Campo Nome Utente -->

                <label for="nome">Nome:</label>
                <select name="nome" id="nome">
                <?php while($datiRiga = mysqli_fetch_assoc($leggere2)){
                ?>
                         <option value="<?php echo $datiRiga["nome"];?>"><?php echo $datiRiga["nome"];?></option>
                <?php
                      }
                ?>
                </select>

                <!-- Campo Blog -->

                <label for="blog">Blog:</label>
                <select name="blog" id="blog">
                <?php while($datiRiga2 = mysqli_fetch_assoc($leggere3)){
                ?>
                         <option value="<?php echo $datiRiga2["id"];?>"><?php echo $datiRiga2["nome"];?></option>
                <?php
                      }
                ?>
                </select>

                <!-- messaggio di errore relativo al blog -->

                <p>
                    <?php 
                        if(isset($blog_error)){
                            echo $blog_error;
                        } 
                    ?>
                </p>

                <button type="submit" name="submit">Invia</button>

            </form>
        </div>

    </div>

<!-- Footer -->

<?php
    include("../footer.php");
?>

</body>
</head>