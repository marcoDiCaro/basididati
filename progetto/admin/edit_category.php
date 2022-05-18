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

    if(isset($_GET["page"])){
        $page = $_GET["page"];
    }
    
    if(isset($_GET["edit"])){
        $category_id = $_GET["edit"];
        $leggere = mysqli_query($connessioneDB, "SELECT * FROM categoria WHERE id=$category_id") or die(mysqli_error($connessioneDB));
        if(isset($_POST["submit"])){

            //Controllo Nome Categoria

            if(!empty($_POST["title"])){

                //Gestione SQL Injection con mysqli_real_escape_string

                $title = mysqli_real_escape_string($connessioneDB, $_POST["title"]);

                //Controllo se la categoria non è già presente

                $leggere = mysqli_query($connessioneDB, "SELECT * FROM categoria WHERE nome='$title' AND id!=$category_id") or die(mysqli_error($connessioneDB));
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

            //Aggiorna Categoria

            if((!empty($title3))){
                $aggiornare = mysqli_query($connessioneDB, "UPDATE categoria SET nome = '$title3' WHERE id = $category_id") or die(mysqli_error($connessioneDB));
                if($aggiornare){
                    $update_message = "categoria aggiornata con successo";
                    header("Location: categories.php?page=$page&message=$update_message");
                }
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
    <title>Edit Category</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css"> <!-- Font Awesome -->
    <link rel="stylesheet" href="../css/styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="../js/hamburger_admin.js"></script>
</head>
<body>
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
            <li><a href="modifica_utente.php"><i class="far fa-address-card"></i>Modifica Utente</a></li>
            <li><a href="immagine_profilo.php"><i class="fas fa-portrait"></i>Immagine Profilo</a></li>
            <li><a href="aggiungi_coautore.php"><i class="fas fa-user-plus"></i>Aggiungi coautore</a></li>
            <li><a href="rimuovi_coautore.php"><i class="fas fa-user-minus"></i>Rimuovi coautore</a></li>
            <li><a href="sub_categoria.php"><i class="far fa-edit"></i>Nuova Sotto Categoria</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a></li>
        </ul>

        <!-- Edit Category -->

        <div class="post-container">
            <form action="edit_category.php?edit=<?php echo $category_id;?>&page=<?php echo $page; ?>" method="POST">
                <?php while($datiRiga = mysqli_fetch_assoc($leggere)){
                ?>

                <!-- Campo Nome Categoria -->

                <label for="title">Nome:</label>
                <input type="text" name="title" id="title" value="<?php echo $datiRiga["nome"]; ?>">

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

                <?php
                     }
                ?>
            </form>
        </div>
    </div>

<!-- Footer -->

<?php
    include("../footer.php");
?>

</body>
</html>