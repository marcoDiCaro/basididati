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
        $post_id = $_GET["edit"];
        $leggere = mysqli_query($connessioneDB, "SELECT * FROM post WHERE id=$post_id") or die(mysqli_error($connessioneDB));
        if(isset($_POST["submit"])){

            //Controllo Titolo Post

            if(!empty($_POST["title"])){

                //Gestione SQL Injection con mysqli_real_escape_string

                $title = mysqli_real_escape_string($connessioneDB, $_POST["title"]);

                //Gestione XSS Cross Site Scripting

                if(stripos($title,"<script>")!==false){
                    $title_error = "titolo post non valido";
                }
                else{
                    $title2 = $title;
                }

            }
            else{
                $title_error = "inserire titolo post";
            }

            //Controllo Immagine Post

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

            //Controllo Testo Post

            if(!empty($_POST["content"])){

                //Gestione SQL Injection con mysqli_real_escape_string

                $content = mysqli_real_escape_string($connessioneDB, $_POST["content"]);

                //Gestione XSS Cross Site Scripting

                if(stripos($content,"<script>")!==false){
                    $content_error = "testo post non valido";
                }
                else{
                    $content2 = $content;
                }

            }
            else{
                $content_error = "inserire testo post";
            }

            //Aggiorna Post

            if((!empty($title2))&&(!empty($image2))&&(!empty($content2))){
                date_default_timezone_set('Europe/Rome');
                $time = time();
                $dateTime = strftime('%Y-%m-%d %H:%M:%S ', $time);
                $aggiornare = mysqli_query($connessioneDB, "UPDATE post SET data = '$dateTime', titolo = '$title2', foto = '$image2', testo = '$content2' WHERE id = '$post_id'") or die(mysqli_error($connessioneDB));
                if($aggiornare){
                    move_uploaded_file($_FILES['file']['tmp_name'], $target_file);
                    $post_message = "post aggiornato con successo";
                    header("Location: posts.php?page=$page&post_message=$post_message");
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
    <title>Edit Post</title>
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

        <!-- Edit Post -->

        <div class="post-container">
            <form action="edit_post.php?edit=<?php echo $post_id; ?>&page=<?php echo $page; ?>" method="POST" enctype="multipart/form-data">
                <?php while($datiRiga = mysqli_fetch_assoc($leggere)){
                ?>

                <!-- Campo Titolo Post -->

                <label for="title">Titolo:</label>
                <input type="text" name="title" id="title" value="<?php echo $datiRiga["titolo"]; ?>">

                <!-- messaggio di errore relativo al titolo del post -->

                <p>
                <?php 
                    if(isset($title_error)){
                        echo $title_error;
                    }
                ?>
                </p>

                <!-- Campo Immagine Post -->

                <label for="image">Foto:</label>
                <input type="file" name="file" id="image">

                <!-- messaggio di errore relativo all' immagine del post -->

                <p>
                <?php 
                    if(isset($image_error)){
                        echo $image_error;
                      }
                ?>
                </p>

                <!-- Campo Testo Post -->

                <label for="content">Contenuto:</label>
                <textarea name="content" id="content" cols="70" rows="10"><?php echo $datiRiga["testo"]; ?></textarea>

                <!-- messaggio di errore relativo al testo del Post -->

                <p>
                <?php 
                    if(isset($content_error)){
                        echo $content_error;
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