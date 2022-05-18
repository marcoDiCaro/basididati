<?php
    session_start();

    require("../connect_db.php");

    //Mostra Categorie di utente loggato

    if(isset($_SESSION["user"])){
        $utente = $_SESSION["user"];
        $utente_id = $_SESSION["id"];
        $limit = 2;
        $leggere2 = mysqli_query($connessioneDB, "SELECT COUNT(*) FROM categoria WHERE utente='$utente_id'") or die(mysqli_error($connessioneDB));
        $datiRiga2 = mysqli_fetch_row($leggere2);
        $total_records = $datiRiga2[0];
        $total_pages = ceil($total_records / $limit);

        if(isset($_GET["page"])){
            $page = $_GET["page"];
        }
        else{
            $page = 1;
        }
        $start_from = ($page-1) * $limit;
        $leggere = mysqli_query($connessioneDB, "SELECT * FROM categoria WHERE utente='$utente_id' LIMIT $start_from, $limit") or die(mysqli_error($connessioneDB));
    }
    else{
        header("Location: ../index.php");
    }

    //Elimina Categoria

    if(isset($_GET["delete"])){
        $delete = $_GET["delete"];
        $eliminare = mysqli_query($connessioneDB, "DELETE FROM categoria WHERE id='$delete'") or die(mysqli_error($connessioneDB));
        if($eliminare){
            $delete_message = "categoria eliminata con successo";
            header("Location: categories.php?page=$page&delete_message=$delete_message");
        }
    }
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories</title>
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

            if(isset($_GET["delete_message"])){
                echo $_GET["delete_message"];
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
            <li><a href="modifica_utente.php"><i class="far fa-address-card"></i>Modifica utente</a></li>
            <li><a href="immagine_profilo.php"><i class="fas fa-portrait"></i>Immagine Profilo</a></li>
            <li><a href="aggiungi_coautore.php"><i class="fas fa-user-plus"></i>Aggiungi coautore</a></li>
            <li><a href="rimuovi_coautore.php"><i class="fas fa-user-minus"></i>Rimuovi coautore</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a></li>
        </ul>

        <!-- Mostra Categorie di utente loggato -->

        <table>
            <thead>
                <tr>
                    <th>id</th>
                    <th>nome</th>
                    <th>Modifica</th>
                    <th>Elimina</th>
                </tr>
            </thead>
            <tbody>
                <?php while($datiRiga = mysqli_fetch_assoc($leggere)){
                ?>
                <tr>
                    <td><?php echo $datiRiga["id"]; ?></td>
                    <td><?php echo $datiRiga["nome"]; ?></td>

                    <!-- Modifica ed elimina Categoria -->

                    <td><a href="edit_category.php?edit=<?php echo $datiRiga["id"]; ?>&page=<?php echo $page;?>"><i class="far fa-edit" id="edit"></i></a></td>
                    <td><a href="categories.php?delete=<?php echo $datiRiga["id"]; ?>&page=<?php echo $page;?>"><i class="fas fa-trash-alt"></i></a></td>
                    
                </tr>
                <?php
                      }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Impaginazione categorie -->

    <?php 
        if(!empty($total_pages)){
    ?>
            <ul class="pagination_post">
                <?php 
                for($i=1; $i<=$total_pages; $i++){
                ?>
                    <li><a href="categories.php?page=<?php echo $i;?>"><?php echo $i;?></a></li>
                <?php
                }
                ?>
            </ul>
        <?php
        }
        ?>

<!-- Footer -->

<?php
    include("../footer.php");
?>

</body>
</html>