<?php 
    session_start();

    require("connect_db.php");

    if(isset($_GET["id"])){
        $post_id = $_GET["id"];
        $leggere = mysqli_query($connessioneDB, "SELECT * FROM post WHERE id='$post_id'") or die(mysqli_error($connessioneDB));
    }
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Single votati</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css"> <!-- Font Awesome -->
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="js/hamburger.js"></script>
</head>
<body>

    <!-- Header -->

    <div class="header">
        <div class="user-icon">
            <a href="admin/user_dashboard.php">
            <?php
                if(isset($_SESSION["user"])){
                    $nome = $_SESSION["user"];
                    $leggere5 = mysqli_query($connessioneDB, "SELECT foto FROM utente WHERE nome='$nome' AND foto IS NOT NULL") or die(mysqli_error($connessioneDB));
                    $datiRiga5 = mysqli_fetch_assoc($leggere5);
                    if(mysqli_num_rows($leggere5)>0){
            ?>
                        <img  id="user-image" src="admin/user_image/<?php echo $datiRiga5["foto"] ?>" alt="user-img">
            <?php
                    }
                    else{
            ?>          
                        <i class="far fa-user"></i>
            <?php
                    }
                }
                else{
            ?>
                    <i class="far fa-user"></i>
            <?php
                }
            ?>
            </a>
            <h3>
                <?php
                    if(isset($_SESSION["user"])){
                        echo $_SESSION["user"];
                    }
                    else{
                        echo "visitatore";
                    }
                ?>
            </h3>
        </div>
        <button id="hamburger"><i class="fas fa-bars"></i></button>
        <ul class="navbar">
            <li><a href="votati.php">Votati</a></li>
            <li><a href="index.php">Home</a></li>
        </ul>
    </div>

    <!-- Single -->

    <div class="single-card">
    <?php while($datiRiga = mysqli_fetch_assoc($leggere)){
    ?>
        <img src="images/<?php echo $datiRiga["foto"]; ?>" alt="single-card-img">
        <h1>
            <?php
                echo $datiRiga["titolo"];
            ?>
        </h1>
        <i class="far fa-calendar-alt"></i>
        <h4>
        <?php
            echo $datiRiga["data"];
        ?>
        </h4>
        <p>
        <?php
            echo $datiRiga["testo"];
        ?>
        </p>
    <?php
            }
    ?>
    </div>

    <!-- Footer -->

    <?php
        include("footer.php");
    ?>

</body>
</html>