<?php 
    session_start();
    $login = $_SESSION['login'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include ('includes/header.php')?>
</head>
<body>
    <?php include ('includes/nav.php')?>
        <main class="img_salle">
            <div class="main_index_con , background-color"  >
                <h1 id="test">Bienvenue <?php echo $login;?></h1>
            </div>
        </main>
    <?php include ('includes/footer.php')?>
</body>
</html>