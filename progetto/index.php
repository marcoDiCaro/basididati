<?php
    session_start();

    require("connect_db.php");

    //Ricerca Blog per Nome o per Autore

    if(isset($_GET["search"])){
        if(empty($_GET['search'])){
            header("Location: index.php");
        }
        else{
            $search = mysqli_real_escape_string($connessioneDB, $_GET['search']);
            $limit = 3;
            $leggere3 = mysqli_query($connessioneDB, "SELECT COUNT(*) FROM blog, utente  WHERE autore=utente.id AND blog.nome LIKE'%$search%' OR autore=utente.id AND utente.nome LIKE'%$search%' ORDER BY data DESC") or die(mysqli_error($connessioneDB));
            $datiRiga3 = mysqli_fetch_row($leggere3);
            $total_records = $datiRiga3[0];
            $total_pages = ceil($total_records / $limit);

            if(isset($_GET["page_search"])){
                $page_search = $_GET["page_search"];
            }
            else{
                $page_search = 1;
            }
            $start_from = ($page_search-1) * $limit;
            $leggere = mysqli_query($connessioneDB, "SELECT blog.id, blog.autore, blog.nome, blog.foto, blog.categoria, blog.data, blog.nome_c FROM blog, utente  WHERE autore=utente.id AND blog.nome LIKE'%$search%' OR autore=utente.id AND utente.nome LIKE'%$search%' ORDER BY data DESC LIMIT $start_from, $limit") or die(mysqli_error($connessioneDB));
        }

        if($leggere){
            if(mysqli_num_rows($leggere)<1){
                echo "<p style='color:red'>nessun Blog trovato</p>";
            }
        }
    }

    //Ricerca Blog per Categoria

    else if(isset($_GET["category"])){
        $category = $_GET["category"];
        $limit = 3;
        $leggere3 = mysqli_query($connessioneDB, "SELECT COUNT(*) FROM blog WHERE categoria = '$category'") or die(mysqli_error($connessioneDB));
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

        //Ricerca Blog per Sotto Categoria

        $leggere_sub = mysqli_query($connessioneDB, "SELECT * FROM sub WHERE cat2 = '$category'")or die(mysqli_error($connessioneDB));
        if(mysqli_num_rows($leggere_sub)>=1){
            $limit_sub = 3;
            $leggere_sub2 = mysqli_query($connessioneDB, "SELECT COUNT(*) FROM blog, sub WHERE cat2=$category AND cat1=categoria")or die(mysqli_error($connessioneDB));
            $datiRiga_sub = mysqli_fetch_row($leggere_sub2);
            $total_records_sub = $datiRiga_sub[0];
            $total_pages_sub = ceil($total_records_sub / $limit_sub);

            if(isset($_GET["page_sub"])){
                $page_sub = $_GET["page_sub"];
            }
            else{
                $page_sub = 1;
            }
            $start_from_sub = ($page_sub-1) * $limit_sub;

            $leggere = mysqli_query($connessioneDB, "SELECT * FROM blog, sub WHERE cat2=$category AND cat1=categoria ORDER BY data DESC LIMIT $start_from_sub, $limit_sub")or die(mysqli_error($connessioneDB));
        }
        else{
            $leggere = mysqli_query($connessioneDB, "SELECT * FROM blog  WHERE categoria = '$category' ORDER BY data DESC LIMIT $start_from, $limit") or die(mysqli_error($connessioneDB));
            if($leggere){
                if(mysqli_num_rows($leggere)<1){
                    $blog_results = "Nessun blog presente";
                }
            }
        }
    }

    //Mostra Blog più recenti

    else{
        $leggere = mysqli_query($connessioneDB, "SELECT * FROM blog ORDER BY data DESC LIMIT 3") or die(mysqli_error($connessioneDB));
    }

    //Mostra Categorie

    $limit2 = 3;
    $leggere4 = mysqli_query($connessioneDB, "SELECT COUNT(*) FROM categoria") or die(mysqli_error($connessioneDB));
    $datiRiga4 = mysqli_fetch_row($leggere4);
    $total_records2 = $datiRiga4[0];
    $total_pages2 = ceil($total_records2 / $limit2);

    if(isset($_GET["page2"])){
        $page2= $_GET["page2"];
    }
    else{
        $page2 = 1;
    }
    $start_from2 = ($page2-1) * $limit2;
    $leggere2 = mysqli_query($connessioneDB, "SELECT * FROM categoria LIMIT $start_from2, $limit2") or die(mysqli_error($connessioneDB));
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css">  <!-- Font Awesome -->
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="js/hamburger.js"></script>

    <!-- Ajax -->

    <script src="autocompletamento.js"></script>
</head>
<body>

    <!-- Mostra messaggi -->

    <p id="update_message">
        <?php
            if(isset($_GET["user_message"])){
                echo $_GET["user_message"];
            }
        ?>
    </p>

    <!-- Header -->

    <div class="header">

        <!-- Mostra foto di utente loggato -->

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
            <li><a href="registrazione.php">Registrati</a></li>
            <li><a href="login.php">Login</a></li>
        </ul>

        <!-- Barra di ricerca -->

        <form class="search-navbar" action="" method="GET">
            <input type="text" name="search"  id="search" placeholder="search">
            <button type="submit"><i class="fas fa-search"></i></button>
        </form>

    </div>
    
    <p>Suggerimenti: <span id="span"></span></p>

    <p>
        <?php
            if(isset($blog_results)){
                echo $blog_results;
            }
        ?>                        
    </p>

    <!-- BLOG -->

    <div class="container">
        <div class="grid-container">
        <?php while($datiRiga = mysqli_fetch_assoc($leggere)){
            $autore = $datiRiga["autore"];
        ?>
            <div class="card">
                <h2>
                    <?php
                        echo $datiRiga["nome"];
                    ?>
                </h2>
                <img src="images/<?php echo $datiRiga["foto"]; ?>" alt="card-img">
                <?php
                    $leggere6 = mysqli_query($connessioneDB, "SELECT utente.nome FROM blog, utente WHERE utente.id=$autore");
                    $datiRiga6 = mysqli_fetch_assoc($leggere6);
                ?>
                <p>
                    Autore: <?php echo $datiRiga6["nome"];?>
                </p>

                <!-- Mostra coautore del blog se è presente -->

                <?php
                if($datiRiga["nome_c"]!=null){
                ?>
                    <p>
                        Coautore: <?php echo $datiRiga["nome_c"];?>
                    </p>
                <?php
                }
                ?>

                <button><a href="show_post.php?blog_id=<?php echo $datiRiga["id"];?>&nome=<?php echo $datiRiga["nome"];?>">Maggiori informazioni</a></button>
            </div>
        <?php
              }
        ?>
        </div>

        <div class="categories">

           <!-- Post più votati --> 

            <ul class="side-navbar">
                <li id="votati"><a href="votati.php">Post più votati</a></li>
            </ul>

            <!-- Categorie -->

            <h2>Categorie</h2>
            <ul class="side-navbar">
            <?php while($datiRiga = mysqli_fetch_assoc($leggere2)){
            ?>
                <li><a href="index.php?category=<?php echo $datiRiga["id"]; ?>"><?php echo $datiRiga["nome"]; ?></a></li>
            <?php
                  }
            ?>
            </ul>

            <!-- Impaginazione categorie -->

            <?php 
                if(!empty($total_pages2)){
            ?>
                    <ul class="pagination_post">
                        <?php 
                        for($i=1; $i<=$total_pages2; $i++){
                        ?>
                            <li><a href="index.php?<?php if(isset($_GET["search"])){ ?>search=<?php echo $search; ?><?php } ?><?php if(isset($_GET["category"])){ ?>&category=<?php echo $category; ?><?php } ?><?php if(isset($_GET["page_search"])){ ?>&page_search=<?php echo $page_search; ?><?php } ?><?php if(isset($_GET["page"])){ ?>&page=<?php echo $page; ?><?php } ?><?php if(isset($_GET["page_sub"])){ ?>&page_sub=<?php echo $page_sub; ?><?php } ?>&page2=<?php echo $i;?>"><?php echo $i;?></a></li>
                        <?php
                        }
                        ?>
                    </ul>
                <?php
                }
                ?>
        </div>
    </div>

    <!-- Impaginazione Barra di ricerca -->

<?php
    if(isset($_GET["search"])){
?>
    <?php 
        if(!empty($total_pages)){
    ?>
            <ul class="pagination_post">
                <?php 
                for($i=1; $i<=$total_pages; $i++){
                ?>
                    <li><a href="index.php?page_search=<?php echo $i;?>&search=<?php echo $search;?>"><?php echo $i;?></a></li>
                <?php
                }
                ?>
            </ul>
        <?php
        }
        ?>
<?php
    }
?>

    <!-- Impaginazione Ricerca Blog per Categoria -->

<?php
    if(isset($_GET["category"])){
?>
    <?php 
        if(!empty($total_pages)){
    ?>
            <ul class="pagination_post">
                <?php 
                for($i=1; $i<=$total_pages; $i++){
                ?>
                    <li><a href="index.php?category=<?php echo $category;?>&page=<?php echo $i;?>"><?php echo $i;?></a></li>
                <?php
                }
                ?>
            </ul>
        <?php
        }
        ?>
<?php
    }
?>

    <!-- Impaginazione Ricerca Blog per Sotto Categoria -->

    <?php
    if(isset($_GET["category"])){
?>
    <?php 
        if(!empty($total_pages_sub)){
    ?>
            <ul class="pagination_post">
                <?php 
                for($i=1; $i<=$total_pages_sub; $i++){
                ?>
                    <li><a href="index.php?category=<?php echo $category;?>&page_sub=<?php echo $i;?>"><?php echo $i;?></a></li>
                <?php
                }
                ?>
            </ul>
        <?php
        }
        ?>
<?php
    }
?>

<!-- Footer -->

<?php
    include("footer.php");
?>

</body>
</html>