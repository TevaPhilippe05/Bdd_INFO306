<?php
include_once "bdd.php";

get("/teams/:team_id", function ($param) {
    $id_groupe = $param["team_id"];

    // Vérification de la connexion à la base de données
    if (!db()) {
        die(json_encode([
            "success" => false,
            "message" => "Erreur de connexion : " . mysqli_connect_error()
        ]));
    } else {

        // Récupérer les informations du groupe
        $query = "SELECT Num_groupe, nb_credit, bom_groupe as nom_groupe 
                  FROM Groupe WHERE Num_groupe = '$id_groupe'";

        $result = mysqli_query(db(), $query);

        // Vérifier si le groupe existe
        if ($result && mysqli_num_rows($result) > 0) {
            // Récupérer les résultats sous forme de tableau associatif
            $result_array = mysqli_fetch_assoc($result);

            // Encapsuler les résultats dans un tableau comme dans votre exemple
            $response = [
                $result_array // Le tableau avec les résultats
            ];

            // Envoi de la réponse JSON avec l'en-tête appropriée
            header('Content-Type: application/json');
            echo json_encode($response);
        } else {
            // Si aucun groupe trouvé, retourner une réponse d'erreur
            header('Content-Type: application/json');
            echo json_encode([
                "success" => false,
                "message" => "Groupe introuvable."
            ]);
        }

        exit;
    }
});
