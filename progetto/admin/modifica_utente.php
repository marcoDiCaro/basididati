<?php 
    session_start();

    require("../connect_db.php");

    if(isset($_SESSION["user"])){
        $utente = $_SESSION["user"];
        $utente_id = $_SESSION["id"];
        $leggere = mysqli_query($connessioneDB, "SELECT * FROM utente WHERE id=$utente_id") or die(mysqli_error($connessioneDB));
    }
    else{
        header("Location: ../index.php");
    }

    if(isset($_POST["submit"])){

        //Controllo Username

        if(!empty($_POST["username"])){

            //Gestione SQL Injection con mysqli_real_escape_string

            $username = mysqli_real_escape_string($connessioneDB, $_POST["username"]);
            if(!preg_match('/^[a-z0-9_-]{3,15}$/', $username)){
                $user_error3 = "username non valido";
            }
            else{

                //Controllo se l'username non è già stato utilizzato

                $leggere2 = mysqli_query($connessioneDB, "SELECT * FROM utente WHERE nome='$username' AND id!=$utente_id");
                if(mysqli_num_rows($leggere2)>=1){
                    $user_error2 = "username già presente";
                }            
                else{

                    //Gestione SQL Injection con mysqli_real_escape_string

                    $username2 = mysqli_real_escape_string($connessioneDB, $_POST["username"]);
                }
            }
        }
        else{
            $user_error = "inserire l'username";
        }

        //Controllo Password

        if(!empty($_POST["password"])){
            $password = $_POST["password"];
            if(!preg_match('/^[a-zA-Z0-9_-]{6,18}$/', $password)){
                $pass_error2 = "password non valida";
            }
            else{

                //Gestione SQL Injection con mysqli_real_escape_string

                $password2 = mysqli_real_escape_string($connessioneDB, $_POST["password"]);
            }
        }
        else{
            $pass_error = "inserire password";
        }

        //Controllo Email

        if(!empty($_POST["email"])){

            //Gestione SQL Injection con mysqli_real_escape_string

            $email = mysqli_real_escape_string($connessioneDB, $_POST["email"]);
            if(!preg_match('/^([a-z0-9_.-]+)@([a-z0-9.-]+)\.([a-z.]{2,6})$/', $email)){
                $email_error3 = "email non valida";
            }
            else{

                //Controllo se l'email non è già stata utilizzata

                $leggere2 = mysqli_query($connessioneDB, "SELECT * FROM utente WHERE email='$email' AND id!=$utente_id");
                if(mysqli_num_rows($leggere2)>=1){
                    $email_error2 = "email già presente";
                }
                else{

                    //Gestione SQL Injection con mysqli_real_escape_string

                    $email2 = mysqli_real_escape_string($connessioneDB, $_POST["email"]);
                }
            }
        }
        else{
            $email_error = "inserire email";
        }

        //Controllo Numero di Telefono

        if(!empty($_POST["tel"])){
            $telefono = $_POST["tel"];
            if(!preg_match('/^([0-9]{3}[0-9]{3}[0-9]{4})$/', $telefono)){
                $tel_error2 = "numero di telefono non valido";
            }
            else{

                //Gestione SQL Injection con mysqli_real_escape_string

                $telefono2 = mysqli_real_escape_string($connessioneDB, $_POST["tel"]);
            }
        }
        else{
            $tel_error = "inserire numero di telefono";
        }

        //Controllo Documento

        if(!empty($_POST["doc"])){

            //Gestione SQL Injection con mysqli_real_escape_string

            $documento = mysqli_real_escape_string($connessioneDB, $_POST["doc"]);
            if(!preg_match('/^[A-Z]{6}[0-9]{2}[A-Z][0-9]{2}[A-Z][0-9]{3}[A-Z]$/', $documento)){
                $doc_error3 = "codice fiscale non valido";
            }
            else{

                //Controllo se il documento non è già stato utilizzato

                $leggere2 = mysqli_query($connessioneDB, "SELECT * FROM utente WHERE documento='$documento' AND id!=$utente_id");
                if(mysqli_num_rows($leggere2)>=1){
                    $doc_error2 = "documento già presente";
                }
                else{

                    //Gestione SQL Injection con mysqli_real_escape_string

                    $documento2 = mysqli_real_escape_string($connessioneDB, $_POST["doc"]);
                }
            }
        }
        else{
            $doc_error = "inserire codice fiscale";
        }
    }

    //Aggiorna Utente

    if((!empty($username2))&&(!empty($password2))&&(!empty($email2))&&(!empty($telefono2))&&(!empty($documento2))){
        $aggiornare = mysqli_query($connessioneDB, "UPDATE utente SET email = '$email2', nome = '$username2', pass = '$password2', tel = '$telefono2', documento = '$documento2' WHERE id = '$utente_id'") or die(mysqli_error($connessioneDB));
        if($aggiornare){
            $update_message = "utente aggiornato con successo";
            header("Location: modifica_utente.php?message=$update_message");
        }
    }

    //Elimina utente

    if(isset($_GET["delete"])){
        $delete = $_GET["delete"];
        $eliminare = mysqli_query($connessioneDB, "DELETE FROM utente WHERE id='$delete'") or die(mysqli_error($connessioneDB));
        if($eliminare){
            session_unset();
            session_destroy();
            $user_message = "utente eliminato con successo";
            header("Location: ../index.php?user_message=$user_message");
        }
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

    <!-- Mostra messaggi -->

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

        <!-- Modifica utente -->

        <div class="post-container">
            <form action="modifica_utente.php" method="POST">
            <?php while($datiRiga = mysqli_fetch_assoc($leggere)){
            ?>

                <!-- Campo Username -->

                <label for="username">username:</label>
                <input type="text" name="username" id="username" value="<?php echo $datiRiga["nome"]; ?>">

                <!-- messaggi di errore relativi all'username -->

                <p id="user_error">
                    <?php
                        if(isset($user_error)){
                            echo $user_error;
                        }
                        if(isset($user_error2)){
                            echo $user_error2;
                        }
                        if(isset($user_error3)){
                            echo $user_error3;
                        }
                    ?>
                </p>

                <!-- Campo Password -->

                <label for="password">password:</label>
                <input type="password" name="password" id="password" value="<?php echo $datiRiga["pass"]; ?>">

                <!-- messaggi di errore relativi alla password -->

                <p>
                    <?php
                        if(isset($pass_error)){
                            echo $pass_error;
                        }
                        if(isset($pass_error2)){
                            echo $pass_error2;
                        }
                    ?>
                </p>

                <!-- Campo Email -->

                <label for="email">email:</label>
                <input type="text" name="email" id="email" value="<?php echo $datiRiga["email"]; ?>">

                <!-- messaggi di errore relativi all' email -->

                <p id="email_error">
                    <?php
                        if(isset($email_error)){
                            echo $email_error;
                        }
                        if(isset($email_error2)){
                            echo $email_error2;
                        }
                        if(isset($email_error3)){
                            echo $email_error3;
                        }
                    ?>
                </p>

                <!-- Campo Numero di telefono -->

                <label for="tel">telefono:</label>
                <input type="text" name="tel" id="tel" value="<?php echo $datiRiga["tel"]; ?>">

                <!-- messaggi di errore relativi al numero di telefono -->

                <p>
                    <?php
                        if(isset($tel_error)){
                            echo $tel_error;
                        }
                        if(isset($tel_error2)){
                            echo $tel_error2;
                        }
                    ?>
                </p>

                <!-- Campo Codice fiscale -->

                <label for="doc">codice fiscale:</label>
                <input type="text" name="doc" id="doc" value="<?php echo $datiRiga["documento"]; ?>">

                <!-- messaggi di errore relativi al documento -->

                <p id="doc_error">
                    <?php
                        if(isset($doc_error)){
                            echo $doc_error;
                        }
                        if(isset($doc_error2)){
                            echo $doc_error2;
                        }
                        if(isset($doc_error3)){
                            echo $doc_error3;
                        }
                    ?>
                </p>

                <button type="submit" name="submit">INVIA</button>

                <!-- Elimina Utente -->

                <button id="delete_user"><a href="modifica_utente.php?delete=<?php echo $datiRiga["id"]; ?>">ELIMINA</a></button>
                
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