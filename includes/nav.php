<!--header-->
<header>
    
    <?php if (isset($_GET['deconnexion'])){
        if($_GET['deconnexion']==true){
            session_unset();
            session_destroy();
            header('Location: index.php');
        } 
    } ?>

    <!-- Si aucune Session n'est ouverte -->
    <?php if(!isset($_SESSION['login'])) { ?>
      
        <div id="box1">
            <a  href=index.php id="logo_text">Réservation de salle</a>
        </div>
        <div id="box2">
            <a href="index.php">Accueil</a>
            <a href="planning-!con.php">Planning</a>
            <a href="connexion.php"class="no_active" >Connexion</a>
            <a href="inscription.php"class="no_active" >Inscription</a>
        </div>
    
    <!-- Si une Session user est ouverte -->
        <?php } else { ?>
            <div id="box1">
                <a  href=index.php id="logo_text">Réservation de salle</a>
            </div>

            <div id="connected"> <?php echo $login ?> </div>
            <div id="box2">
                
                <a href="index_con.php">Accueil</a>
                <a href="planning.php">Planning</a>
                <a href="reservation-form.php">Réservez ici</a>
                
                <a href="profil.php">Profil</a>
                <a href="deconnexion.php"class="no_active" >Déconnexion</a>
                
            </div>
        <?php } ?>
        
    </div>
</header>
<!--header end-->