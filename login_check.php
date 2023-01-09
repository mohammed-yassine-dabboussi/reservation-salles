<?php

// démarrer une session
session_start();
include 'includes/connect_db.php';

// attribution d'une valeur par défaut aux POST pour éviter les erreurs
if (!isset($_POST["login"])){
    $_POST['login'] = "";
    $_POST['password'] = "";
}

// création des variables issues des POST
$login = $_POST["login"];
$password = $_POST["password"];

// requete pour récupérer le contenu de la DB pour l'utilisateur concerné
$catchUsers = $connect -> query("SELECT * FROM utilisateurs WHERE login='$login'");
// verifier si le login existe déjà en comptant les éventuels doublons
$users = mysqli_num_rows($catchUsers);
// fetch le contenu de la requête
$userInfo = $catchUsers -> fetch_all();

// condition pour rentrer dans les erreurs que lorsque des données sont rentrées
if (isset($_POST['submit'])){
    // une requete pour valider la connexion si le login existe déjà et que le mot de passe correspond à celui en DB
    if (($users === 1 ) && ($_POST["password"] == $userInfo [0][2])) {
        if (($users === 1) && ($login != NULL) && ($password != NULL)) {
            $_SESSION["login"] = $login;
            $_SESSION["password"] = $password;
            // puis valider la connexion en redirigeant vers profil.php
            header('Location: planning.php');
        }
    }
    elseif ($users !=1){
        header('Location: connexion.php?erreur=1');
        echo "Ce login n'existe pas";
    }
    elseif ($_POST["password"] !== $userInfo [0][2]) {
        header('Location: connexion.php?erreur=2');
        echo "Le mot de passe incorrect";
    }
}

?>