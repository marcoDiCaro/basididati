<?php
    session_start();

    require("../connect_db.php");

    if(isset($_SESSION["user"])){
        $utente = $_SESSION["user"];
        $utente_id = $_SESSION["id"];
    }
    else{
        header("Location: ../index.php");
    }

    if(isset($_POST["submit"])){

        //Controllo Immagine del profilo

        if(!empty($_FILES['file']['name'])){
            $upload_path = "user_image/";
            $image = basename($_FILES['file']['name']);
            $img_check = getimagesize($_FILES['file']['tmp_name']);
            if($img_check){
                $image2 = basename($_FILES['file']['name']);
                $target_file = $upload_path.$image2;
            }
            else{
                $image_error = "Questo file non è un'immagine valida";
            }
        }
        else{
            $image_error = "inserire immagine";
        }

        //Aggiungi immagine del profilo

        if(!empty($image2)){
            $aggiornare = mysqli_query($connessioneDB, "UPDATE utente  set foto='$image2' WHERE id=$utente_id") or die(mysqli_error($connessioneDB));
            if($aggiornare){
                move_uploaded_file($_FILES['file']['tmp_name'], $target_file);
                $update_message = "Immagine profilo aggiunta con successo";
                header("Location: immagine_profilo.php?message=$update_message");
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
    <title>Immagine profilo</title>
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

        <!-- Immagine profilo -->

        <div class="post-container">
            <form action="immagine_profilo.php" method="POST" enctype="multipart/form-data">

                <!-- Campo immagine del profilo -->

                <label for="foto">Foto:</label>
                <input type="file" name="file" id="foto">

                <!-- Mostra messaggio di errore relativo all'immagine del profilo -->

                <p>
                <?php 
                    if(isset($image_error)){
                        echo $image_error;
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