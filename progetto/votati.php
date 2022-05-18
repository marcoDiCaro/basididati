<?php
    session_start();
    
    require("connect_db.php");

    //$leggere = mysqli_query($connessioneDB, "SELECT SUM(punteggio) AS tot, post.id, post.titolo, post.foto FROM post, punteggio_post WHERE post = post.id AND punteggio>0 GROUP BY post.id ORDER BY tot DESC LIMIT 6") or die(mysqli_error($connessioneDB));

    // Gestione dell'attributo ridondante somma_punti_post  della tabella post

    $leggere = mysqli_query($connessioneDB, "SELECT somma_punti_post, id, titolo, foto FROM post WHERE somma_punti_post!='NULL' ORDER BY somma_punti_post DESC LIMIT 6") or die(mysqli_error($connessioneDB));
    if($leggere){
        if(mysqli_num_rows($leggere)<1){
            $post_results = "Nessun post presente";
        }
    }
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Votati</title>
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
            <li><a href="index.php">Home</a></li>
        </ul>
    </div>

    <!-- Post -->

    <p>
        <?php
            if(isset($post_results)){
                echo $post_results;
            }
        ?>                        
    </p> 

    <div class="container">
        <div class="grid-container" id="show-post">
        <?php while($datiRiga = mysqli_fetch_assoc($leggere)){
            $post_id = $datiRiga["id"];
        ?>
            <div class="card" id="show-card">
                <h2>
                    <?php
                        echo $datiRiga["titolo"];
                    ?>
                </h2>
                <p>
                    Totale punti: <?php echo $datiRiga["somma_punti_post"];?>
                </p>
                <img src="images/<?php echo $datiRiga["foto"]; ?>" alt="card-img">
                <button><a href="single_votati.php?id=<?php echo $datiRiga["id"];?>">Maggiori informazioni</a></button>
            </div>
        <?php
              }
        ?>
        </div>
    </div>

<!-- Footer -->

<?php
    include("footer.php");
?>

</body>
</html>