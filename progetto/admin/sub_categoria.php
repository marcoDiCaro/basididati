<?php
    session_start();

    require("../connect_db.php");

    if(!isset($_SESSION["user"])){
        header("Location: ../index.php");
    }
    else{
        $utente = $_SESSION["user"];
        $utente_id = $_SESSION["id"];
    }

    if(isset($_POST["submit"])){

         //Controllo Nome Categoria

        if(!empty($_POST["title"])){

            //Gestione SQL Injection con mysqli_real_escape_string

            $title = mysqli_real_escape_string($connessioneDB, $_POST["title"]);

            //Controllo se la categoria non è già presente

            $leggere = mysqli_query($connessioneDB, "SELECT * FROM categoria WHERE nome='$title'") or die(mysqli_error($connessioneDB));
            if(mysqli_num_rows($leggere)==1){
                $title_error2 = "categoria già presente";
            }
            else{

                 //Gestione SQL Injection con mysqli_real_escape_string

                $title2 = mysqli_real_escape_string($connessioneDB, $_POST["title"]);

                //Gestione XSS Cross Site Scripting

                if(stripos($title2,"<script>")!==false){
                    $title_error = "nome categoria non valido";
                }
                else{
                    $title3 = $title2;
                }

            }
        }
        else{
            $title_error = "Inserisci nome categoria";
        }

        //Aggiungi Categoria

        if(!empty($title3)){
            $creare = mysqli_query($connessioneDB, "INSERT INTO categoria(nome, utente) VALUES('$title3', $utente_id)") or die(mysqli_error($connessioneDB));
            if($creare){
                header("Location: sub_categoria.php");
            }
        }
    }


    //Mostra Categorie disponibili

    $leggere2 = mysqli_query($connessioneDB, "SELECT * FROM categoria") or die(mysqli_error($connessioneDB));
    $leggere3 = mysqli_query($connessioneDB, "SELECT * FROM categoria") or die(mysqli_error($connessioneDB));

    if(isset($_POST["submit2"])){

        //Controllo sotto categoria

        if(!empty($_POST["categoria1"])){
            $categoria1 = $_POST["categoria1"];
        }
        else{
            $cat1_error = "Inserisci Sotto Categoria";
        }

        //Controllo categoria

        if(!empty($_POST["categoria2"])){
            $categoria2 = $_POST["categoria2"];

            $leggere4 = mysqli_query($connessioneDB, "SELECT * FROM sub WHERE cat1=$categoria2 AND cat2=$categoria1") or die(mysqli_error($connessioneDB));
            $leggere5 = mysqli_query($connessioneDB, "SELECT * FROM sub WHERE cat1=$categoria1 AND cat2=$categoria2") or die(mysqli_error($connessioneDB));
            $leggere6 = mysqli_query($connessioneDB, "SELECT * FROM sub WHERE cat1=$categoria1") or die(mysqli_error($connessioneDB));

            //Controllo 1

            if($categoria1==$categoria2){
                $cat2_error = "Impossibile aggiungere Sotto Categoria come Sotto Categoria di se stessa";
            }

            //Controllo 2

            else if(mysqli_num_rows($leggere4)>=1){
                $cat2_error = "Impossibile aggiungere Sotto Categoria";
            }

            //Controllo 3

            else if(mysqli_num_rows($leggere5)>=1){
                $cat2_error = "Impossibile aggiungere Sotto Categoria perchè Sotto Categoria già presente";
            }

            //Controllo 4

            else if(mysqli_num_rows($leggere6)>=1){
                $cat2_error = "Impossibile aggiungere Sotto Categoria";
            }

            else{
                $cat2 = $_POST["categoria2"];
            }
        }

        //Aggiungi sotto categoria

        if((!empty($categoria1))&&(!empty($cat2))){
            $creare2 = mysqli_query($connessioneDB, "INSERT INTO sub VALUES($categoria1, $cat2)") or die(mysqli_error($connessioneDB));
            if($creare2){
                $update_message = "sotto categoria creata con successo";
                header("Location: sub_categoria.php?message=$update_message");
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sotto Categoria</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css"> <!-- Font Awesome -->
    <link rel="stylesheet" href="../css/styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="../js/hamburger_admin.js"></script>
</head>
<body>

    <!-- Mostra messaggi -->

    <p id="update_message">
        <?php
            if(isset($_GET["message"])){
                echo $_GET["message"];
            }
        ?>
    </p>

    <div class="new-post-container">
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

        <!-- Nuova Sotto Categoria -->

        <div class="post-container">
            <form action="sub_categoria.php" method="POST">

                <!-- Campo Nome Categoria -->

                <label for="title">Nome:</label>
                <input type="text" name="title" id="title">

                <!-- messaggi di errore relativi al nome della categoria -->

                <?php
                    if(isset($title_error)){
                ?>  
                        <p><?php echo $title_error; ?></p>
                <?php
                    }
                ?>
                <?php
                    if(isset($title_error2)){
                ?>  
                        <p><?php echo $title_error2; ?></p>
                <?php
                    }
                ?>

                <button type="submit" name="submit">Invia</button>

            </form>

            <form action="sub_categoria.php" method="POST">

                <!-- Campo Nome Sotto Categoria -->

                <label for="categoria1">Sotto Categoria:</label>
                <select name="categoria1" id="categoria1">
                <?php while($datiRiga = mysqli_fetch_assoc($leggere2)){
                ?>
                    <option value="<?php echo $datiRiga["id"];?>"><?php echo $datiRiga["nome"];?></option>
                <?php
                      }
                ?>
                </select>

                <!-- messaggio di errore relativo al nome della sotto categoria -->

                <?php
                    if(isset($cat1_error)){
                ?>  
                        <p><?php echo $cat1_error; ?></p>
                <?php
                    }
                ?>

                <!-- Campo Nome Categoria -->

                <label for="categoria2">Categoria:</label>
                <select name="categoria2" id="categoria2">
                <?php while($datiRiga2 = mysqli_fetch_assoc($leggere3)){
                ?>
                    <option value="<?php echo $datiRiga2["id"];?>"><?php echo $datiRiga2["nome"];?></option>
                <?php
                      }
                ?>
                </select>

                <!-- messaggio di errore relativo al nome della categoria -->

                <?php
                    if(isset($cat2_error)){
                ?>  
                        <p><?php echo $cat2_error; ?></p>
                <?php
                    }
                ?>

                <button type="submit" name="submit2">Invia</button>
                
            </form>
        </div>
    </div>

    <!-- Footer -->

    <?php
        include("../footer.php");
    ?>

</body>
</html>