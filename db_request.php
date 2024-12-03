<?php
include_once "bdd.php";

function user_connect($login, $mdp) {

    if (!db()) {
        die("Erreur de connexion : " . mysqli_connect_error());
    }

    $query = "SELECT `nom`, `login` FROM Etudiant WHERE login = '$login'";
    $result = mysqli_query(db(), $query);

    // Vérifier si un résultat existe
    $user_exists = mysqli_num_rows($result) > 0;

    return $user_exists;
}
?>