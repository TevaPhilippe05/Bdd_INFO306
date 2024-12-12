<?php
include_once "bdd.php";

function user_connect($login) {

    if (!db()) {
        die("Erreur de connexion : " . mysqli_connect_error());
    }

    $query = "SELECT `nom`, `login` FROM Etudiant WHERE login = '$login'";
    $result = mysqli_query(db(), $query);

    // Vérifier si un résultat existe
    $user_exists = mysqli_num_rows($result) > 0;

    return $user_exists;
}

function password_correct($login, $mdp) {

    if (!db()) {
        die("Erreur de connexion : " . mysqli_connect_error());
    }

    $query = "SELECT `login`, `mdp` FROM Etudiant WHERE login = '$login' AND mdp = '$mdp'";
    $result = mysqli_query(db(), $query);

    // Vérifier si un résultat existe
    $password_ok = mysqli_num_rows($result) > 0;

    return $password_ok;
}

function remplir_donnee_utilisateur($user_id, $state){

    if (!db()) {
        die("Erreur de connexion : " . mysqli_connect_error());
    }

    $query = "SELECT `N_etu`, `prenom`, `nom` FROM Etudiant E'
              JOIN Groupe G ON G.Num_groupe = E.id_groupe
              JOIN Comptence C ON C.nom = E.
              WHERE login = '$user_id'";

    $result = mysqli_query(db(), $query);

    // Vérifier si un résultat existe
    $password_ok = mysqli_num_rows($result) > 0;

    $skills = [array("name" => null, "level" => null, "color" => null, "icon" => null), null]; //a enlever quand ce sera fait
    $marks = [array("activityId" => null, "mark" => null), null]; //a enlever quand ce sera fait

    array(
        'id' => null, 
        "firstName" => null, 
        "lastName" => null, 
        "email" => $user_id, 
        "state" => $state, 
        "skills" => $skills, 
        "marks" => $marks);
}


?>