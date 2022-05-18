<?php
    session_start();

    require("../connect_db.php");

    if(!isset($_SESSION["user"])){
        header("Location: ../index.php");
    }
    
    if(isset($_GET["user"])){
        $user = $_GET["user"];
    }

    if(isset($_GET["user_id"])){
        $user_id = $_GET["user_id"];
    }

    //Mostra Blog Disponibili

    $leggere = mysqli_query($connessioneDB, "SELECT * FROM blog WHERE autore=$user_id") or die(mysqli_error($connessioneDB));
    $leggere2 = mysqli_query($connessioneDB, "SELECT * FROM blog WHERE nome_c='$user'") or die(mysqli_error($connessioneDB));
    
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

        //Controllo Selezione del blog

        if(!empty($_POST["blog"])){
            $blog = $_POST["blog"];
        }
        else{
            $blog_error = "inserire blog";
        }
    }

    //Aggiungi Post

    if((!empty($title2))&&(!empty($image2))&&(!empty($content2))&&(!empty($blog))){
        date_default_timezone_set('Europe/Rome');
        $time = time();
        $dateTime = strftime('%Y-%m-%d %H:%M:%S ', $time);
        $user_id = $_SESSION["id"];
        $creare = mysqli_query($connessioneDB, "INSERT INTO post(data, titolo, foto, testo, blog) VALUES('$dateTime', '$title2', '$image2', '$content2', $blog)") or die(mysqli_error($connessioneDB));
        if($creare){
            move_uploaded_file($_FILES['file']['tmp_name'], $target_file);
            $update_message = "post creato con successo";
            header("Location: new_post.php?user=$user&user_id=$user_id&message=$update_message");
        }
    }
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Post</title>
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
            <li><a href="new_post.php?user=<?php echo $user; ?>&user_id=<?php echo $user_id; ?>"><i class="far fa-edit"></i>Nuovo Post</a></li>
            <li><a href="categories.php"><i class="fas fa-tags"></i>Categorie</a></li>
            <li><a href="new_category.php"><i class="far fa-edit"></i>Nuova Categoria</a></li>
            <li><a href="sub_categoria.php"><i class="far fa-edit"></i>Nuova Sotto Categoria</a></li>
            <li><a href="modifica_utente.php"><i class="far fa-address-card"></i>Modifica Utente</a></li>
            <li><a href="immagine_profilo.php"><i class="fas fa-portrait"></i>Immagine Profilo</a></li>
            <li><a href="aggiungi_coautore.php"><i class="fas fa-user-plus"></i>Aggiungi coautore</a></li>
            <li><a href="rimuovi_coautore.php"><i class="fas fa-user-minus"></i>Rimuovi coautore</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a></li>
        </ul>

        <!-- New Post -->

        <div class="post-container">
            <form action="new_post.php?user=<?php echo $user;?>&user_id=<?php echo $user_id;?>" method="POST" enctype="multipart/form-data">

                 <!-- Campo Titolo Post -->

                <label for="title">Titolo:</label>
                <input type="text" name="title" id="title" value="<?php if(isset($title2)){echo $title2;} ?>">

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

                <!-- Campo Selezione del Blog -->

                <label for="blog">Scegli un blog:</label>
                <select name="blog" id="blog">
                <?php while($datiRiga = mysqli_fetch_assoc($leggere)){
                ?>
                        <option value="<?php echo $datiRiga["id"];?>"><?php echo $datiRiga["nome"];?></option>
                <?php
                      }

                      while($datiRiga2 = mysqli_fetch_assoc($leggere2)){
                ?>
                        <option value="<?php echo $datiRiga2["id"];?>"><?php echo $datiRiga2["nome"];?></option>
                <?php
                      }
                ?>
                </select>

                <!-- messaggio di errore relativo alla selezione del blog -->

                <p>
                <?php 
                    if(isset($blog_error)){
                        echo $blog_error;
                    }
                ?>
                </p>

                <!-- Campo Testo Post -->

                <label for="content">Contenuto:</label>
                <textarea name="content" id="content" cols="70" rows="10"><?php if(isset($content2)){echo $content2;} ?></textarea>

                <!-- messaggio di errore relativo al testo del Post -->

                <p>
                <?php 
                    if(isset($content_error)){
                        echo $content_error;
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