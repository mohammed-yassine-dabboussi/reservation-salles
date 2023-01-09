<link rel="stylesheet" href="css/header.css"  /> 
                              
<?php   
    session_start();
    $login = $_SESSION['login'];
    include 'includes/header.php'; //insertion de header
    include 'includes/connect_db.php'; // connexion à la base de donnée
    include ('includes/nav.php');
    //var_dump ($_SESSION['login']);

    $login = $_SESSION['login'];
    if (isset($_POST['submit'])) {
        if (isset($_POST['titre']) && ($_POST['debut'] !== '---') && ($_POST['fin'] !== '---') ){
            
            $titre = $_POST['titre'];
            $debut = $_POST['debut'];
            $fin = $_POST['fin'];
            $date = $_POST['date'];
            $description = $_POST['description'];

            //récuperation de id_utilisateur de la db
            $requete = ("SELECT id FROM utilisateurs WHERE `login` = '$login' ") ;
            $exec_requete = $connect -> query($requete);
            $reponse_fetch_array = $exec_requete -> fetch_array();
            $user_id = $reponse_fetch_array['id'];
        
            //définition du format de la date et heure pour comparer dans la requete suivante
            $dateheure = ($date .' '. $debut );
            // var_dump($dateheure);

            //requete de Recherche de nombre de repetition de la valeur d'input dans la db 
            $requete3 = "SELECT count(debut) FROM reservations WHERE debut ='". $dateheure. "'";
            $exec_requete3 = $connect -> query($requete3);
            $reponse_fetch_array3 = mysqli_fetch_array($exec_requete3);
            $count1 = $reponse_fetch_array3['count(debut)'];

            //var_dump($count1);

            // définition de date et heure actuelle avec timezone EUROPE / PARIS
            $dt = new DateTime('now',new DateTimeZone('Europe/Paris'));
            //var_dump($dt);
            
            $date_heure_actuelle = $dt->format('Y/m/d H:i:s');
            //var_dump($date_heure_actuelle);
            //var_dump($date);
            //var_dump($debut);
            $date_heure_debut = date( "Y/m/d", strtotime($date)) . ' ' . date( "H:i:s", strtotime($debut));
            //var_dump($date_heure_debut);

            //définition de la date minimum autorisée à réserver
            $date_min = date("Y-m-d", strtotime("today"));
            //echo "date actuelle minimum possible : $date_min " . '<br>';
            //echo "date et heure actuelle : $date_heure_actuelle" . '<br>';
            //echo "date et heure de debut de POST : $date_heure_debut" . '<br>';
            

            
             //Vérification si l'utilisateur tente de réserver un samedi ou dimanche
             $date_debut = new DateTime($_POST['date']);
             $date_fin = new DateTime($_POST['date']);
             if($date_debut->format('D') == 'Sat' || $date_debut->format('D') == 'Sun' || $date_fin->format('D') == 'Sat' || $date_fin->format('D') == 'Sun') {  
                header('Location: reservation.php?message=4');  
                //echo "Nous sommes fermés les week-ends" .'<br>' ;
            }  else{
                        //verifaction de la date ou time du debut plus petit que la fin et si il n'est pas egale a la fin 
                       if($debut < $fin && $debut != $fin){

                            //condition pour verifier que la date de réservation n'est pas antérieure à la date actuelle
                            if ($date /*POST*/ >= $date_min /*actuelle*/) {

                                //vérification si le crénneau est déja prit
                                if($count1==0){ 

                                    if ($date_heure_debut /*POST*/ >= $date_heure_actuelle /*actuelle*/) {
                                        
                                        //echo 'réservation à bien été effectué';

                                            // requette insertion reservation dans bd
                                            $requete1 = ("INSERT INTO reservations (`titre`, `description`, `debut`, `fin`, `id_utilisateur`) VALUES ('$titre', '$description', '$date $debut', '$date $fin', '$user_id') ");
                                            $exec_requete1 = $connect -> query($requete1);
                                            var_dump($requete1);
                                            header('Location: reservation.php?message=2');  
                                            //echo 'Réservation à bien été effectué'.'<br>';

                                    } else {
                                        header('Location: reservation.php?message=5');  
                                        //echo "Pour des raisons d'organisation Vous ne pouvez pas reserver le même jour ". '<br>'. '<br>';
                                    }   


                                } else {
                                    header('Location: reservation.php?message=3');  
                                    //echo "Créaneau déjà pris" .'<br>';
                                }

                            } else {
                                header('Location: reservation.php?message=6'); 
                                //echo "erreur : Date de réservation est antérieure à la date actuelle" ; 
                            }
                    
                        } else {
                            header('Location: reservation.php?message=7'); 
                            //echo "erreur :Heure de la fin est inferieure ou égale à l'heure de debut " ; 
                        }

                    }
            } 
            }      
            ?>
         
      <!------------------------------------------------------- PARTIE HTML ------------------------------------------------------->
   
        <main id="main_reserv">
                <div id="background-reserv">

                    <div class="box_connexion_inscription">
                    
                    <div id="container">
                    <!-- zone d'inscription -->
                    <?php if(!isset($_GET['id'])): ?>

                    <form action="" method="POST" id="form_reserv" >
                        <h1>Formulaire de réservation</h1>
                    
                        <label for="titre">Titre de réservation</label>
                        <input name="titre" type="text" placeholder="titre de réservation ..." required>
                        <label for="debut">Heure de début</label>
                        <select name="debut" required>
                            <option >---</option>
                            <?php 
                            for($i=8; $i<=18; $i++) {
                                //operation ternaire pour ajouterun zéro avant l'heure si < 10h
                                $current_hour = $i >= 10 ? $i : '0'.$i ;
                                $is_selected = $current_hour == $_GET['heure'] ? 'selected' : '';

                                echo '<option '.$is_selected.' value="'.$current_hour.'">'.$current_hour.'h00</option>';
                            } ?>
                        </select>

                        <label for="fin">Heure de fin: </label>
                        <select   name="fin" required>
                            <option>---</option>
                            <?php 
                            for($i=9; $i<=19; $i++) {
                                $current_hour = $i >= 10 ? $i : '0'.$i ;
                                $is_selected = $current_hour == ($_GET['heure'] + 1) ? 'selected' : '';

                                echo '<option '.$is_selected.' value="'.$current_hour.'">'.$current_hour.'h00</option>';
                            } ?>
                        </select>
                        <label for="date" >Date</label>
                        <?php $selected_date = isset($_GET['date']) ? $_GET['date'] : ''?>
                        <input name="date" type="date" min="2022-12-13" max="2023-12-31" value='<?php echo $selected_date ?>' required>
                        <label for="description" >Description :</label>
                        <input name="description" type="text" required placeholder="une description pour votre réservation ...">
                        <input type="submit" name="submit" value='Réserver' class="button align_self red">
                    </form>
                    <?php
                            //affichage de messages
                            if(isset($_GET['message'])) {
                                $message = $_GET['message'];
                                if($message == 1){
                                    echo "<center><p style='color:red'>Choisissez l'heure svp</p></center>";                        
                                }
                                if($message == 2){
                                    echo "<center><STRONG><p style='color:green'>Réservation à bien été effectué</p></STRONG></center>";
                                }
                                if($message == 3){
                                    echo "<center><STRONG><p style='color:red'>Créneau déjà pris</p></STRONG></center>";
                                }
                                if($message == 4){
                                    echo "<center><STRONG><p style='color:red'>Nous sommes fermés les week-ends</p></STRONG></center>";
                                }
                                if($message == 5){
                                    echo "<center><STRONG><p style='color:red'>Pour des raisons d'organisation Vous ne pouvez pas reserver le même jour </p></STRONG></center>";  
                                }
                                if($message == 6){
                                    echo "<center><STRONG><p style='color:red'>Date de réservation est antérieure à la date actuelle</p></STRONG></center>";
                                }
                                if($message == 7){
                                    echo "<center><STRONG><p style='color:red'>Heure de la fin est inferieure ou égale à l'heure de debu</p></STRONG></center>";
                                }
                            } 
                        ?>    
                </div>

                <?php endif ?>
                <!-- Ci-dessous j'affiche le formulaire avec les infos de la résa. Accessible seulement si le visiteur est connecté. -->

                <?php if(isset($_SESSION['login']) && isset($_GET['id'])): 
                    //récuperation de id_utilisateur de la db
                    $reservation_id = $_GET['id'];
                    $requete_reservation = ("SELECT * FROM reservations WHERE `id` = '$reservation_id' ") ;
                    $exec_requete_reservation = $connect -> query($requete_reservation);
                    $reponse_fetch_array = $exec_requete_reservation -> fetch_array();
                    $titre = $reponse_fetch_array['titre'];
                    $description = $reponse_fetch_array['description'];
                    $debut = $reponse_fetch_array['debut'];
                    $fin = $reponse_fetch_array['fin'];
                    $fin = $reponse_fetch_array['fin'];
                ?>

                <form action="" method="POST" class ="formulaire">
                    <h1><?= $titre ?></h1>
                    <h2> Créé par :  <?= $login ?> </h2>
                    <h3>Description :</h3>                
                    <p> <?= $description ?> </p>
                    <h3>Début de réservation :</h3>
                    <p> <?= $debut ?> </p>
                    <h3>Fin de réservation:</h3>
                    <p> <?= $fin ?> </p>
                </form>

                <?php endif?>
            </div>
        </main> 

        <?php include("includes/footer.php") ?>
</body>
</html>

