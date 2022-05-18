<?php
    session_start();
    
    require("connect_db.php");

    if((isset($_GET["blog_id"]))&&(isset($_GET["nome"]))){
        $blog_id = $_GET["blog_id"];
        $nome = $_GET["nome"];
    }

    //Mostra Post

    $limit = 3;
    $leggere3 = mysqli_query($connessioneDB, "SELECT COUNT(*) FROM post WHERE blog=$blog_id") or die(mysqli_error($connessioneDB));
    $datiRiga3 = mysqli_fetch_row($leggere3);
    $total_records = $datiRiga3[0];
    $total_pages = ceil($total_records / $limit);
    
    if(isset($_GET["page"])){
        $page = $_GET["page"];
    }
    else{
        $page = 1;
    }
    $start_from = ($page-1) * $limit;
    $leggere = mysqli_query($connessioneDB, "SELECT * FROM post WHERE blog=$blog_id ORDER BY data DESC LIMIT $start_from, $limit") or die(mysqli_error($connessioneDB));
    
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
    <title>Show Post</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css"> <!-- Font Awesome -->
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="js/hamburger.js"></script>
</head>
<body>

    <!-- Header -->

    <div class="header">

        <!-- Mostra foto di utente loggato -->

        <div class="user-icon">
            <a href="admin/user_dashboard.php">
            <?php
                if(isset($_SESSION["user"])){
                    $utente = $_SESSION["user"];
                    $leggere5 = mysqli_query($connessioneDB, "SELECT foto FROM utente WHERE nome='$utente' AND foto IS NOT NULL") or die(mysqli_error($connessioneDB));
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

    <h1 id="show-title">
        <?php 
            if(isset($nome)){
                echo $nome;
            } 
        ?>
    </h1>

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
                <img src="images/<?php echo $datiRiga["foto"]; ?>" alt="card-img">
                <button><a href="single.php?id=<?php echo $datiRiga["id"];?>&blog_id=<?php echo $blog_id;?>&nome=<?php echo $nome;?>&page=<?php echo $page;?>">Maggiori informazioni</a></button>
            </div>
        <?php
              }
        ?>
        </div>
    </div>

    <!-- Impaginazione post -->

    <?php 
        if(!empty($total_pages)){
    ?>
            <ul class="pagination_post">
                <?php 
                for($i=1; $i<=$total_pages; $i++){
                ?>
                    <li><a href="show_post.php?blog_id=<?php echo $blog_id;?>&nome=<?php echo $nome;?>&page=<?php echo $i;?>"><?php echo $i;?></a></li>
                <?php
                }
                ?>
            </ul>
        <?php
        }
        ?>

<!-- Footer -->

<?php
    include("footer.php");
?>

</body>
</html>