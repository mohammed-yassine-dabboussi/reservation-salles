<!-- si il y a une session ouverte on déclare la valeur de login dans la variable $login -->

<?php 
    $login = false;
    if (isset($_SESSION['login'])) {
        $login = $_SESSION['login'];
    } 
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="styles/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? '' ?></title>
</head>