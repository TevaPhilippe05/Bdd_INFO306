<?php
include_once "bdd.php";

get("/teams/:team_id", function ($param) {
    $id_groupe= $param["team_id"];

    if (!db()) {
        die("Erreur de connexion : " . mysqli_connect_error());
    } else {

        //Get groupe info
        $query = "SELECT Num_groupe as id,
                    nb_credit as coin,
                    nom_groupe as name FROM Groupe WHERE Num_groupe = '$id_groupe'";
        $result = mysqli_query(db(), $query);

        $result_array = mysqli_fetch_assoc($result);
        $response = [
            "id" => $result_array['id'],
            "name" => $result_array['name'],
            "coin" => $result_array["coin"],
        ];

//        header('access-control-allow-methods: GET,POST,PUT,DELETE,OPTIONS
//        access-control-allow-origin: http://51.68.91.213
//        connection: Keep-Alive
//        content-encoding: gzip
//        content-length: 977
//        content-type: text/html;
//        charset=UTF-8
//        date: Sun,15 Dec 2024 21:32:04 GMT
//        keep-alive: timeout=5,max=100
//        server: Apache/2.4.62 (Debian)
//        vary: Accept-Encoding ');
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;

    }
});
