<?php
include_once "bdd.php";
include_once "utility.php";
include_once "db_request.php";
include_once "Chloe_test.php";
include_once "raph.php";

$bdd = db();

get("/learners/:learnerId", function ($param) {
    $learner_id = $param["learnerId"];
    var_dump($learner_id);
    exit;
});

put("/learners/:learnerId", function ($param) {
    $_PUT = read_put();
    $user_pwd = $_PUT['password'];
});

// Quand on se connect sur le site
post("/learners", function () {
    
    $_PUT = read_put();
    $login = $_PUT['mail'];
    $password = $_PUT['password'];

    // Verifie la connection a la DB
    if (!db()) {
        die("Erreur de connexion : " . mysqli_connect_error());
    }
    else {

        // On verifie l'existence de l'utilisateur qui essay de se connecter
        $query = "SELECT nom FROM Etudiant WHERE login = '$login'";
        $result = mysqli_query(db(), $query);


        // L'utilisateur exist on verifie sont mdp
        if (mysqli_num_rows($result) > 0) {
            $query= "SELECT nom FROM Etudiant WHERE login = '$login' AND mdp = '$password'";
            $result = mysqli_query(db(), $query);

            if (mysqli_num_rows($result) > 0) {
                $query = "SELECT E.N_etu as id, 
                                E.nom as firstName,
                                E.prenom as lastName,
                                E.login as email,
                                E.Num_groupe as team,
                                Etat.Id as id,
                                Etat.titre as title,
                                Etat.couleur as color,
                                Etat.icon as icon,
                                C.nom as name,
                                C.niveau as level,
                                C.couleur as color,
                                C.icon as icon,
                                N.Id as activityId,
                                N.note as mark
                        FROM Etudiant E 
                        JOIN Etat Etat ON Etat.Id = E.Id_etat
                        JOIN Etudiant_Comptence EC ON EC.N_etu = E.N_etu
                        JOIN Comptence C ON C.Nom = EC.Nom_competence
                        JOIN Note_Groupe NG ON NG.Num_groupe = E.Num_groupe
                        JOIN Note N ON N.id = NG.id_note
                        WHERE login = '$login' AND mdp = '$password'";
                $result = mysqli_query(db(), $query);


                // Formatting the result into JSON
                $result_array = mysqli_fetch_assoc($result);
                $response = [
                    "id" => $result_array['id'],
                    "firstName" => $result_array['firstName'],
                    "lastName" => $result_array['lastName'],
                    "email" => $result_array['email'],
                    "team" => $result_array['team'],
                    "state" => [
                        "id" => $result_array['id'],
                        "title" => $result_array['title'],
                        "color" => $result_array['color'],
                        "icon" => $result_array['icon']
                    ],
                    "skills" => [
                        [
                            "name" => "name",
                            "level" => "level",
                            "color" => "color",
                            "icon" => "icon"
                        ]
                    ],
                    "marks" => [
                        [
                            "activityId" => "activityId",
                            "mark" => "mark"
                        ]
                    ]
                ];

                // Encode the response as JSON and send it
                header('Content-Type: application/json');
                echo json_encode($response);
                exit;
            }
            else {
                error_log("Le mdp est incorrect");
            }
        }
        else {
            error_log("Le login n'existe pas");
        }

    }
});

put("/learners/:learnerId/state", function ($param) {
    var_dump($param);
    exit;
});

get("/state", function () {
    /* 
    Dans CMD ->

    Premier exemple:
    curl -X GET http://152.228.214.245/info306/info_gr4/state

    Autre exemple :
    curl -X DELETE http://152.228.214.245/info306/info_gr4/activities/2/marks

    curl -X GET "http://152.228.214.245/info306/info_gr4/activities?date=true&coin=false"
    */
    global $bdd;
    $query = "SELECT * FROM `Etat`";
    $data = mysqli_query($bdd, $query);
    if (!$data) {
        die("Erreur dans la requête : " . mysqli_error($bdd));
    }
    $res = mysqli_fetch_all($data, MYSQLI_ASSOC);
    
    var_dump(json_encode($res));
    exit;
});

get("/activities", function () {
    $date = $_GET['date'];
    $coin = $_GET['coin'];
    $name = $_GET['name'];
    $limit = $_GET['limit'];
    $offset = $_GET['offset'];

    global $bdd;
    if ($date){
        $query = "SELECT * FROM `Activite`
        ORDER BY $date
        LIMIT $limit OFFSET $offset";
    }
    else if ($coin){
        $query = "SELECT * FROM `Activite`
        ORDER BY $coin
        LIMIT $limit OFFSET $offset";
    }
    else if ($name){
        $query = "SELECT * FROM `Activite`
        ORDER BY $name
        LIMIT $limit OFFSET $offset";
    }
    
    $data = mysqli_query($bdd, $query);
    if (!$data) {
        die("Erreur dans la requête : " . mysqli_error($bdd));
    }
    $res = mysqli_fetch_all($data, MYSQLI_ASSOC);
    
    var_dump(json_encode($res));
    exit;
});

get("/activities/:activity_id/sessions/:session_id", function ($param) {
    $activity_id = $param["activity_id"]; // Inutile en réalité
    $session_id = $param["session_id"];
    global $bdd;

    $query = "SELECT * FROM `Session`
    WHERE id = '$session_id'";

    $data = mysqli_query($bdd, $query);
    if (!$data) {
        die("Erreur dans la requête : " . mysqli_error($bdd));
    }
    $res = mysqli_fetch_all($data, MYSQLI_ASSOC);
    
    var_dump(json_encode($res));
    exit;
});

header("HTTP/1.0 404");

?>