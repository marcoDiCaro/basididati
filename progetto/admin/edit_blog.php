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

    //Mostra Categorie Disponibili

    $leggere2 = mysqli_query($connessioneDB, "SELECT * FROM categoria") or die(mysqli_error($connessioneDB));
    
    if(isset($_GET["edit"])){
        $blog_id = $_GET["edit"];
        $leggere = mysqli_query($connessioneDB, "SELECT * FROM blog WHERE id=$blog_id") or die(mysqli_error($connessioneDB));
        if(isset($_POST["submit"])){

            //Controllo Titolo Blog

            if(!empty($_POST["title"])){

                //Gestione SQL Injection con mysqli_real_escape_string

                $title = mysqli_real_escape_string($connessioneDB, $_POST["title"]);

                //Gestione XSS Cross Site Scripting

                if(stripos($title,"<script>")!==false){
                    $title_error = "titolo blog non valido";
                }
                else{
                    $title2 = $title;
                }

            }
            else{
                $title_error = "inserire titolo blog";
            }

            //Controllo Categoria Blog

            if(!empty($_POST["category"])){
                $category = $_POST["category"];
            }

            //Controllo Immagine Blog

            if(!empty($_FILES['file']['name'])){
                $upload_path = "../images/";
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

            //Aggiorna Blog

            if((!empty($title2))&&(!empty($category))&&(!empty($image2))){
                date_default_timezone_set('Europe/Rome');
                $time = time();
                $dateTime = strftime('%Y-%m-%d %H:%M:%S ', $time);
                $aggiornare = mysqli_query($connessioneDB, "UPDATE blog SET data = '$dateTime', nome = '$title2', categoria = $category, foto = '$image2' WHERE id = $blog_id") or die(mysqli_error($connessioneDB));
                if($aggiornare){
                    move_uploaded_file($_FILES['file']['tmp_name'], $target_file);
                    $blog_message = "blog aggiornato con successo";
                    header("Location: user_dashboard.php?page=$page&blog_message=$blog_message");
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
    <title>Edit Blog</title>
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
            <li><a href="modifica_utente.php"><i class="far fa-address-card"></i>Modifica utente</a></li>
            <li><a href="immagine_profilo.php"><i class="fas fa-portrait"></i>Immagine Profilo</a></li>
            <li><a href="aggiungi_coautore.php"><i class="fas fa-user-plus"></i>Aggiungi coautore</a></li>
            <li><a href="rimuovi_coautore.php"><i class="fas fa-user-minus"></i>Rimuovi coautore</a></li>
            <li><a href="sub_categoria.php"><i class="far fa-edit"></i>Nuova Sotto Categoria</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a></li>
        </ul>

        <!-- Edit Blog -->

        <div class="post-container">
            <form action="edit_blog.php?edit=<?php echo $blog_id; ?>&page=<?php echo $page; ?>" method="POST"  enctype="multipart/form-data">
                <?php while($datiRiga = mysqli_fetch_assoc($leggere)){
                ?>

                <!-- Campo Titolo Blog -->

                <label for="title">Nome:</label>
                <input type="text" name="title" id="title" value="<?php echo $datiRiga["nome"]; ?>">

                <!-- messaggio di errore relativo al titolo del blog -->

                <p>
                <?php 
                    if(isset($title_error)){
                        echo $title_error;
                    }
                ?>
                </p>

                <!-- Campo Immagine Blog -->

                <label for="image">Foto:</label>
                <input type="file" name="file" id="image">

                <!-- messaggio di errore relativo all' immagine del blog -->

                <p>
                <?php 
                    if(isset($image_error)){
                        echo $image_error;
                      }
                ?>
                </p>

                <!-- Campo Categoria Blog -->

                <label for="category">Categoria:</label>
                <select name="category" id="category">
                <?php   
                        while($datiRiga2 = mysqli_fetch_assoc($leggere2)){
                ?>
                            <option value="<?php echo $datiRiga2["id"];?>"><?php echo $datiRiga2["nome"];?></option>
                <?php
                        }
                ?>
                </select>
                
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