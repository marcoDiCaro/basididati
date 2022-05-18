<?php
    session_start();

    require("connect_db.php");

    if(isset($_SESSION["user"])){
        header("Location: index.php");
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

                $leggere = mysqli_query($connessioneDB, "SELECT * FROM utente WHERE nome='$username'") or die(mysqli_error($connessioneDB));
                if(mysqli_num_rows($leggere)==1){
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

                $leggere = mysqli_query($connessioneDB, "SELECT * FROM utente WHERE email='$email'") or die(mysqli_error($connessioneDB));
                if(mysqli_num_rows($leggere)==1){
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

                $leggere = mysqli_query($connessioneDB, "SELECT * FROM utente WHERE documento='$documento'") or die(mysqli_error($connessioneDB));
                if(mysqli_num_rows($leggere)==1){
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

    //Aggiungi Utente

    if((!empty($username2))&&(!empty($password2))&&(!empty($email2))&&(!empty($telefono2))&&(!empty($documento2))){
        $creare = mysqli_query($connessioneDB, "INSERT INTO utente(email, nome, pass, tel, documento) VALUES('$email2', '$username2', '$password2', '$telefono2', '$documento2')") or die(mysqli_error($connessioneDB));
        if($creare){
            $update_message = "utente inserito con successo";
            header("Location: registrazione.php?message=$update_message");
        }
    }
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrazione</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css"> <!-- Font Awesome -->
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="js/hamburger.js"></script>

    <!-- Ajax -->

    <script src="email_libera.js"></script>

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

    <!-- Header -->

    <div class="header">
        <button id="hamburger"><i class="fas fa-bars"></i></button>
        <ul class="navbar">
            <li><a href="index.php">Home</a></li>
            <li><a href="registrazione.php">Registrati</a></li>
            <li><a href="login.php">Login</a></li>
        </ul>
    </div>

    <!-- Registrazione -->

    <div class="login-container">

        <form action="registrazione.php" method="POST">

            <!-- Campo Username -->

            <label for="username">username:</label>
            <input type="text" name="username" id="username" value="<?php if(isset($username2)){echo $username2;} ?>">

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
            <input type="password" name="password" id="password" value="<?php if(isset($password2)){echo $password2;} ?>">

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
            <input type="text" name="email" id="email" value="<?php if(isset($email2)){echo $email2;} ?>">

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
            <input type="text" name="tel" id="tel" value="<?php if(isset($telefono2)){echo $telefono2;} ?>">

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
            <input type="text" name="doc" id="doc" value="<?php if(isset($documento2)){echo $documento2;} ?>">

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

        </form>

    </div>

<!-- Footer -->

<?php
    include("footer.php");
?>

</body>
</html>