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
            if(mysqli_num_rows($leggere)>=1){
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
    }

    //Aggiungi Categoria

    if((!empty($title3))){
        $user = $_SESSION["id"];
        $creare = mysqli_query($connessioneDB, "INSERT INTO categoria(nome, utente) VALUES('$title3', $user)") or die(mysqli_error($connessioneDB));
        if($creare){
            $update_message = "categoria creata con successo";
            header("Location: new_category.php?message=$update_message");
        }
    }
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Category</title>
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

        <!-- New Category -->

        <div class="post-container">
            <form action="new_category.php" method="POST">

                <!-- Campo Nome Categoria -->

                <label for="title">Nome:</label>
                <input type="text" name="title" id="title">

                <!-- messaggi di errore relativi al nome della categoria -->

                <p>
                <?php 
                    if(isset($title_error)){
                        echo $title_error;
                    }
                    if(isset($title_error2)){
                        echo $title_error2;
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
</html>