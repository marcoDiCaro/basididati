<?php
    session_start();

    require("connect_db.php");

    if((isset($_GET["blog_id"]))&&(isset($_GET["nome"]))){
        $blog_id = $_GET["blog_id"];
        $nome = $_GET["nome"];
    }

    if(isset($_GET["id"])){
        $post_id = $_GET["id"];
        $leggere = mysqli_query($connessioneDB, "SELECT * FROM post WHERE id='$post_id'") or die(mysqli_error($connessioneDB));

        $limit = 3;
        $leggere4 = mysqli_query($connessioneDB, "SELECT COUNT(*) FROM commento WHERE post=$post_id") or die(mysqli_error($connessioneDB));
        $datiRiga3 = mysqli_fetch_row($leggere4);
        $total_records = $datiRiga3[0];
        $total_pages = ceil($total_records / $limit);

        if(isset($_GET["page2"])){
            $page2 = $_GET["page2"];
        }
        else{
            $page2 = 1;
        }
        $start_from = ($page2-1) * $limit;
        $leggere2 = mysqli_query($connessioneDB, "SELECT * FROM commento WHERE post='$post_id' ORDER BY data DESC LIMIT $start_from, $limit") or die(mysqli_error($connessioneDB));
    }

    if(isset($_GET["error"])){
        $comment_error = $_GET["error"];
    }

    if(isset($_GET["page"])){
        $page = $_GET["page"];
    }

    //Elimina Commento

    if(isset($_GET["delete"])){
        $commento_id = $_GET["delete"];
        $eliminare = mysqli_query($connessioneDB, "DELETE FROM commento WHERE id=$commento_id") or die(mysqli_error($connessioneDB));
        if($eliminare){
            $delete_commento = "Commento eliminato con successo";
            header("Location: single.php?id=$post_id&blog_id=$blog_id&nome=$nome&page=$page&delete_commento=$delete_commento");
        }
    }
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Single</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css"> <!-- Font Awesome -->
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="js/hamburger.js"></script>
</head>
<body>

    <!-- Mostra messaggi -->

    <p id="update_message">
    <?php
        if(isset($_GET["delete_commento"])){
            echo $_GET["delete_commento"];
        }

        if(isset($_GET["commento_message"])){
            echo $_GET["commento_message"];
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
            <li><a href="show_post.php?blog_id=<?php echo $blog_id;?>&nome=<?php echo $nome;?>&page=<?php echo $page;?>">Post</a></li>
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
              
              //Mostra voto post

              // Gestione dell'attributo ridondante somma_punti_post  della tabella post

              $leggere_punteggio_p = mysqli_query($connessioneDB, "SELECT somma_punti_post FROM post WHERE id=$post_id") or die(mysqli_error($connessioneDB));

        ?>

              <?php
                  $datiRiga_p = mysqli_fetch_assoc($leggere_punteggio_p);
                  if($datiRiga_p["somma_punti_post"]!=NULL){
              ?>
                    <p id="voto_tot_c">Voto tot Post:
                    <?php
                        echo $datiRiga_p["somma_punti_post"];
                    ?>
                    </p>
                  <?php
                  }
              ?>
        
        <!-- Commenti -->

        <h2>Lascia un commento</h2>
        <p style="color:red" id="comment_error">
            <?php
                if(isset($comment_error)){
                    echo $comment_error;
                }

                if(isset($user_error)){
                    echo $user_error;
                } 
            ?>
        </p>
        <form method="POST" action="comment_post.php?blog_id=<?php echo $blog_id;?>&nome=<?php echo $nome;?>&page=<?php echo $page;?>">
            <textarea name="comment" rows="5" cols="50"></textarea>
            <input type="hidden" name="id" value="<?php echo $post_id ?>">
            <button type="submit" name="submit">Invia</button>
        </form>

        <!-- Punteggio post -->

        <form method="POST" action="comment_post.php?blog_id=<?php echo $blog_id;?>&nome=<?php echo $nome;?>&page=<?php echo $page;?>">
            <label for="voto_p">Vota Post</label>
            <select name="voto_p" id="voto_p">
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
            <input type="hidden" name="id" value="<?php echo $post_id ?>">
            <button type="submit" name="submit_p" id="submit_p">Invia</button>
        </form>

        <!-- Mostra commenti -->

        <?php while($datiRiga = mysqli_fetch_assoc($leggere2)){
             $utente_id = $datiRiga["utente"];
             $commento_id = $datiRiga["id"];
        ?>
        <div class="comment-user">
        <?php
            $leggere4 = mysqli_query($connessioneDB, "SELECT foto FROM utente WHERE id=$utente_id AND foto IS NOT NULL") or die(mysqli_error($connessioneDB));
            $datiRiga4 = mysqli_fetch_assoc($leggere4);
            if(mysqli_num_rows($leggere4)>0){
        ?>
                <img  id="user-image" src="admin/user_image/<?php echo $datiRiga4["foto"] ?>" alt="user-img">
        <?php
            }
            else{
        ?>
                <i class="far fa-user-circle"></i>
        <?php
            }
        ?>
            <?php
                    $leggere3 = mysqli_query($connessioneDB, "SELECT nome FROM utente WHERE id=$utente_id") or die(mysqli_error($connessioneDB));
                    while($datiRiga2 = mysqli_fetch_assoc($leggere3)){
            ?>
            <h3>
                <?php
                    echo $datiRiga2["nome"];
                ?>
            </h3>
            <?php
                    }
            ?>
            <i class="far fa-calendar-alt"></i>
            <h4>
                <?php
                    echo $datiRiga["data"];
                ?>
            </h4>
            <p>
                <?php
                    echo $datiRiga["nota"];
                ?>
            </p>

            <!-- Modifica ed elimina commento -->

            <?php
                if(isset($_SESSION["id"])){
                    if($_SESSION["id"]==$utente_id){
            ?>
                        <a href="edit_commento.php?id=<?php echo $post_id;?>&blog_id=<?php echo $blog_id;?>&nome=<?php echo $nome;?>&page=<?php echo $page;?>&edit=<?php echo $datiRiga["id"];?>"><i class="far fa-edit" id="edit"></i></a>
                        <a href="single.php?id=<?php echo $post_id;?>&blog_id=<?php echo $blog_id;?>&nome=<?php echo $nome;?>&page=<?php echo $page;?>&delete=<?php echo $datiRiga["id"];?>"><i class="fas fa-trash-alt" id="elimina-commento"></i></a>
            <?php
                    }
                }

                //Mostra voto commento

                // Gestione dell'attributo ridondante somma_punti  della tabella commento

                $leggere_punteggio_c = mysqli_query($connessioneDB, "SELECT somma_punti FROM commento WHERE id=$commento_id") or die(mysqli_error($connessioneDB));

            ?>
            <?php
                $datiRiga_c = mysqli_fetch_assoc($leggere_punteggio_c);
                if($datiRiga_c["somma_punti"]!=NULL){
            ?>
                    <p id="voto_tot_c">Voto tot Commento:
                    <?php
                        echo $datiRiga_c["somma_punti"];
                    ?>
                    </p>
            <?php
                    }
            ?>
        </div>

        <!-- Punteggio commento -->

        <form method="POST" action="comment_post.php?blog_id=<?php echo $blog_id;?>&nome=<?php echo $nome;?>&page=<?php echo $page;?>">
            <label for="voto_c">Vota Commento</label>
            <select name="voto_c" id="voto_c">
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
            <input type="hidden" name="id" value="<?php echo $post_id ?>">
            <input type="hidden" name="id_c" value="<?php echo $commento_id ?>">
            <button type="submit" name="submit_c" id="submit_c">Invia</button>
        </form>
        <?php
              }
        ?>

        <p style="color:red" id="comment_error">
            <?php

                //Mostra errore voto commento

                if(isset($_GET["c_error"])){
                    echo $_GET["c_error"];
                }

                //Mostra errore voto post

                if(isset($_GET["p_error"])){
                    echo $_GET["p_error"];
                }

            ?>
        </p>

        <p style="color:green" id="comment_error">
            <?php

                //Mostra esito positivo voto commento

                if(isset($_GET["c_positivo"])){
                    echo $_GET["c_positivo"];
                }

                //Mostra esito positivo voto post

                if(isset($_GET["p_positivo"])){
                    echo $_GET["p_positivo"];
                }

            ?>
        </p>

    </div>

    <!-- Impaginazione commenti -->

    <?php 
        if(!empty($total_pages)){
    ?>
            <ul class="pagination_post">
                <?php 
                for($i=1; $i<=$total_pages; $i++){
                ?>
                    <li><a href="single.php?blog_id=<?php echo $blog_id;?>&nome=<?php echo $nome;?>&page=<?php echo $page;?>&id=<?php echo $post_id;?>&page2=<?php echo $i;?>"><?php echo $i;?></a></li>
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