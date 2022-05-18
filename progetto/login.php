<?php
    session_start();

    require("connect_db.php");

    if(isset($_POST["submit"])){

        //Controllo Email

        if(!empty($_POST["email"])){

            //Gestione SQL Injection con mysqli_real_escape_string

            $email = mysqli_real_escape_string($connessioneDB, $_POST["email"]);
        }
        else{
            $email_error = "inserire email";
        }

        //Controllo Password

        if(!empty($_POST["password"])){

            //Gestione SQL Injection con mysqli_real_escape_string

            $password = mysqli_real_escape_string($connessioneDB, $_POST["password"]);
        }
        else{
            $pass_error = "inserire password";
        }
    }

    //Gestione Login

    if((!empty($email))&&(!empty($password))){
        $leggere = mysqli_query($connessioneDB, "SELECT * FROM utente WHERE pass='$password' AND email='$email'") or die(mysqli_error($connessioneDB));
        if(mysqli_num_rows($leggere)==1){
            $row = mysqli_fetch_assoc($leggere);
            $_SESSION["user"] = $row["nome"];
            $_SESSION["id"] = $row["id"];
        }
        else{
            $update_message = "password o email non valida";
            header("Location: login.php?message=$update_message");
        }
    }

    if(isset($_SESSION["user"])){
        header("Location: index.php");
    }
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css"> <!-- Font Awesome -->
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="js/hamburger.js"></script>
</head>
<body>

    <!-- messaggio di errore relativo alla login -->

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

    <!-- Login -->

    <div class="login-container">

        <form method="POST" action="login.php">

            <!-- Campo Email -->

            <label for="email">email:</label>
            <input type="text" name="email" id="email" value="<?php if(isset($email)){echo $email;} ?>">

            <!-- messaggio di errore relativo all'email -->

            <p style="text-align:center; color:red;">
                <?php
                    if(isset($email_error)){
                        echo $email_error;
                    }
                ?>
            </p>

            <!-- Campo Password -->

            <label for="password">password:</label>
            <input type="password" name="password" id="password" value="<?php if(isset($password)){echo $password;} ?>">

            <!-- messaggio di errore relativo alla password -->

            <p style="text-align:center; color:red;">
                <?php
                    if(isset($pass_error)){
                        echo $pass_error;
                    }
                ?>
            </p>

            <button type="submit" name="submit" id="submit">Login</button>

        </form>
        
    </div>

<!-- Footer -->

<?php
    include("footer.php");
?>

</body>
</html>