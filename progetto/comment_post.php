<?php
    session_start();

    require("connect_db.php");

    if((isset($_GET["blog_id"]))&&(isset($_GET["nome"]))){
        $blog_id = $_GET["blog_id"];
        $nome = $_GET["nome"];
    }

    if(isset($_GET["page"])){
        $page = $_GET["page"];
    }

    if(isset($_POST["id"])){
        $post_id = $_POST["id"];
    }

    if(isset($_SESSION["id"])){
        $user = $_SESSION["id"];
    }
    

    //Lasciare commento

    if(isset($_POST["submit"])){
        if(isset($user)){
            if(!empty($_POST["comment"])){

                //Gestione SQL Injection con mysqli_real_escape_string

                $comment = mysqli_real_escape_string($connessioneDB, $_POST["comment"]);
                date_default_timezone_set('Europe/Rome');
                $time = time();
                $dateTime = strftime('%Y-%m-%d %H:%M:%S ', $time);

                //Gestione XSS Cross Site Scripting

                if(stripos($comment,"<script>")!==false){
                    $comment_error = "Commento non valido";
                    header("location: single.php?id=$post_id&error=$comment_error&blog_id=$blog_id&nome=$nome&page=$page");
                }
                else{
                    $creare = mysqli_query($connessioneDB, "INSERT INTO commento(data, nota, utente, post) VALUES('$dateTime', '$comment', '$user', $post_id)") or die(mysqli_error($connessioneDB));
                }

                if($creare){
                    header("location: single.php?id=$post_id&blog_id=$blog_id&nome=$nome&page=$page");
                }
            }
            else{
                $comment_error = "Inserire commento";
                header("location: single.php?id=$post_id&error=$comment_error&blog_id=$blog_id&nome=$nome&page=$page");
            }
        }
        else{
            $user_error = "effettuare login per lasciare commento";
            header("location: single.php?id=$post_id&error=$user_error&blog_id=$blog_id&nome=$nome&page=$page");
        }
    }

    //Votare commento

    if(isset($_POST["submit_c"])){
        if(isset($user)){
            $commento_id = $_POST["id_c"];
            $leggere = mysqli_query($connessioneDB, "SELECT * FROM punteggio WHERE utente=$user AND commento=$commento_id") or die(mysqli_error($connessioneDB));
            if(mysqli_num_rows($leggere)>0){
                $c_user_error = "Impossibile votare commento perchè l'utente ha già votato";
                header("location: single.php?id=$post_id&c_error=$c_user_error&blog_id=$blog_id&nome=$nome&page=$page");
            }
            $leggere2 = mysqli_query($connessioneDB, "SELECT * FROM commento WHERE utente=$user AND id=$commento_id") or die(mysqli_error($connessioneDB));
            if(mysqli_num_rows($leggere2)>0){
                $c_user_error = "Impossibile votare il proprio commento";
                header("location: single.php?id=$post_id&c_error=$c_user_error&blog_id=$blog_id&nome=$nome&page=$page");
            }
            else{
                $voto = $_POST["voto_c"];
                $creare = mysqli_query($connessioneDB, "INSERT INTO punteggio VALUES($user, $commento_id, $voto)") or die(mysqli_error($connessioneDB));
                if($creare){

                    // Gestione dell'attributo ridondante somma_punti  della tabella commento

                    $leggere_rid = mysqli_query($connessioneDB, "SELECT somma_punti FROM commento WHERE id=$commento_id") or die(mysqli_error($connessioneDB));
                    $datiRiga_rid = mysqli_fetch_assoc($leggere_rid);

                    if($datiRiga_rid["somma_punti"]==NULL){
                        $aggiornare_rid = mysqli_query($connessioneDB, "UPDATE commento SET somma_punti=$voto WHERE id=$commento_id") or die(mysqli_error($connessioneDB));
                        if($aggiornare_rid){
                            $c_positivo = "Voto Commento aggiunto con successo";
                            header("location: single.php?id=$post_id&blog_id=$blog_id&nome=$nome&page=$page&c_positivo=$c_positivo");
                        }
                    }
                    else{
                        $voto_rid = $datiRiga_rid["somma_punti"];
                        $voto_rid += $voto;
                        $aggiornare_rid = mysqli_query($connessioneDB, "UPDATE commento SET somma_punti=$voto_rid WHERE id=$commento_id") or die(mysqli_error($connessioneDB));
                        if($aggiornare_rid){
                            $c_positivo = "Voto Commento aggiunto con successo";
                            header("location: single.php?id=$post_id&blog_id=$blog_id&nome=$nome&page=$page&c_positivo=$c_positivo");
                        }
                    }
                }
            }
        }
        else{
            $c_user_error = "effettuare login per votare commento";
            header("location: single.php?id=$post_id&c_error=$c_user_error&blog_id=$blog_id&nome=$nome&page=$page");
        }
    }

    //Votare post

    if(isset($_POST["submit_p"])){
        if(isset($user)){
            $leggere = mysqli_query($connessioneDB, "SELECT * FROM punteggio_post WHERE utente=$user AND post=$post_id") or die(mysqli_error($connessioneDB));
            if(mysqli_num_rows($leggere)>0){
                $p_user_error = "Impossibile votare post perchè l'utente ha già votato";
                header("location: single.php?id=$post_id&p_error=$p_user_error&blog_id=$blog_id&nome=$nome&page=$page");
            }
            $leggere2 = mysqli_query($connessioneDB, "SELECT * FROM post, blog WHERE post.id=$post_id AND post.blog=blog.id AND blog.autore=$user") or die(mysqli_error($connessioneDB));
            if(mysqli_num_rows($leggere2)>0){
                $p_user_error = "Impossibile votare il proprio post";
                header("location: single.php?id=$post_id&p_error=$p_user_error&blog_id=$blog_id&nome=$nome&page=$page");
            }
            else{
                $voto = $_POST["voto_p"];
                $creare = mysqli_query($connessioneDB, "INSERT INTO punteggio_post VALUES($user, $post_id, $voto)") or die(mysqli_error($connessioneDB));
                if($creare){

                    // Gestione dell'attributo ridondante somma_punti_post  della tabella post

                    $leggere_rid = mysqli_query($connessioneDB, "SELECT somma_punti_post FROM post WHERE id=$post_id") or die(mysqli_error($connessioneDB));
                    $datiRiga_rid = mysqli_fetch_assoc($leggere_rid);

                    if($datiRiga_rid["somma_punti_post"]==NULL){
                        $aggiornare_rid = mysqli_query($connessioneDB, "UPDATE post SET somma_punti_post=$voto WHERE id=$post_id") or die(mysqli_error($connessioneDB));
                        if($aggiornare_rid){
                            $p_positivo = "Voto Post aggiunto con successo";
                            header("location: single.php?id=$post_id&blog_id=$blog_id&nome=$nome&page=$page&p_positivo=$p_positivo");
                        }
                    }
                    else{
                        $voto_rid = $datiRiga_rid["somma_punti_post"];
                        $voto_rid += $voto;
                        $aggiornare_rid = mysqli_query($connessioneDB, "UPDATE post SET somma_punti_post=$voto_rid WHERE id=$post_id") or die(mysqli_error($connessioneDB));
                        if($aggiornare_rid){
                            $p_positivo = "Voto Post aggiunto con successo";
                            header("location: single.php?id=$post_id&blog_id=$blog_id&nome=$nome&page=$page&p_positivo=$p_positivo");
                        }
                    }
                }
            }
        }
        else{
            $p_user_error = "effettuare login per votare post";
            header("location: single.php?id=$post_id&p_error=$p_user_error&blog_id=$blog_id&nome=$nome&page=$page");
        }
    }
?>