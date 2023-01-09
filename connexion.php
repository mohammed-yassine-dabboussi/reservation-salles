<?php
    include('includes/connect_db.php'); // connexion à la base de donnée
?>

<!DOCTYPE html>
<html lang="en">
<?php include('includes/header.php'); //insertion de header ?>

<body>
    <?php include ('includes/nav.php')?>
    <main id="main-con">
        <form action="login_check.php" method="POST" id="connexion_form" class="background-color">  
            <h2>Connexion</h2>
            <div class="input-container">
                <i class="fa fa-user icon"></i>
                <input class="input-field" type="text" placeholder="Nom d'utilisateur" name="login" >
            </div>
            <div class="input-container">
                <i class="fa fa-key icon"></i>
                <input class="input-field" type="password" placeholder="Mot de passe" name="password" >
            </div>
            <button type="submit" name="submit" class="button se_connecter">Se connecter</button>
        </form>
    </main>
    <?php include ('includes/footer.php')?>
</body>
</html>
