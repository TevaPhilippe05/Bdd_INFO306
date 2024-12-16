<?php
include_once "bdd.php";
include_once "learners.php";

get("/teams/:team_id", function ($param) {
    $id_groupe = $param["team_id"];

    if (!db()) {
        die("Erreur de connexion : " . mysqli_connect_error());
    } else {
        //Cette requête récupère les informations du groupe
        $query = "SELECT Num_groupe as id, nb_credit as coin, nom_groupe as name FROM Groupe WHERE Num_groupe = '$id_groupe'";
        $result_1 = mysqli_query(db(), $query);

        //Cette requête récupère toutes les clés des étudiants du groupe
        $query = "SELECT N_etu as id FROM Etudiant WHERE Num_groupe='$id_groupe'";
        $result = mysqli_query(db(), $query);

        $learners = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $learner_id = $row['id'];

            $learners[] = getUserInfo($learner_id);
        }

        // Ici on renvoie les données formatées en JSON
        $result_array = mysqli_fetch_assoc($result_1);
        $response = [
            "id" => $result_array['id'],
            "name" => $result_array['name'],
            "coin" => $result_array["coin"],
            "learners" => $learners
        ];

        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
});
