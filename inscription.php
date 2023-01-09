<?php
    include('includes/connect_db.php'); // connexion à la base de donnée

    if(isset($_POST['login']) && isset($_POST['password'])) {
        $login = mysqli_real_escape_string($connect, htmlspecialchars($_POST['login']));
        $password = mysqli_real_escape_string($connect, htmlspecialchars($_POST['password']));
        $password2 = mysqli_real_escape_string($connect, htmlspecialchars($_POST['password2']));


        if($login !== "" && $password !== "" && $password2 !== ""){
            if($password == $password2){
                $requete = "SELECT count(*) FROM utilisateurs where login = '" . $login . "'";
                $exec_requete = $connect -> query($requete);
                $reponse = mysqli_fetch_array($exec_requete);
                $count = $reponse['count(*)'];
                

                if($count==0){
                    $requete = "INSERT INTO utilisateurs (login, password) VALUES ('$login' , '$password')";
                    $exec_requete = $connect -> query($requete);
                    header('Location: connexion.php');
                    var_dump($exec_requete);
                }
                else{//utilisateur déjà existant
                    header('Location: inscription.php?erreur=1');
                }        
            }
            else{ //mot de passes différent
                header('Location: inscription.php?erreur=2');
            }
        }
    }

    mysqli_close($connect); //fermer la connexion
?>

<!-- partie HTML -->
<!DOCTYPE html>
<html>
    <?php include('includes/header.php'); ?>

<body>
<?php include ('includes/nav.php')?>
<!-- header des pages -->
<main class="img_salle" >
    <section>
        <!-- partie PHP qui affiche les erreurs -->
        <?php
            if(isset($_GET['erreur'])) {
                $err = $_GET['erreur'];
                if($err == 1){
                    echo "<center><p style='color:red'>Ce nom d'utilisateur a déjà été utilisé</p></center>";
                }
                if($err == 2){
                    echo "<center><p style='color:red'>Les mot de passes ne correspondent pas</p></center>";
                }
                
            } 
        ?>
        <form action="inscription.php" method="POST">

            <div class="container">
                <div class="bold register center">Inscrivez-vous</div>
                
                    <hr>
                    <label for="login" class="bold margin">Nom d'utilisateur</label>
                    <input type="text" placeholder="Saissisez un nom d'utilisateur" name="login" id="login" required>

                    <label for="password" class="bold margin">Mot de passe</label>
                    <input type="password" placeholder="Mot de passe" name="password" id="password" required>

                    <label for="password2" class="bold margin">Confirmez le mot de passe</label>
                    <input type="password" placeholder="Confirmez le mot de passe" name="password2" id="password2" required>
                    <hr>
                

                <button type="submit" class="registerbtn">S'inscrire</button>
            </div>
            <div class="container signin">
                <p>Avez-vous déjà un compte? <a href="connexion.php">Connexion</a></p>
            </div>
        </form>
    </section>
</main>

<?php include('includes/footer.php')?>
</html>