<?php
include_once "bdd.php";
include_once "utility.php";
include_once "db_request.php";

$bdd = db();

# Teva et antonin on fait les learners, vous pouvez commencer par /state
get("/learners/:learnerId", function ($param) {
    $learner_id = $param['learnerId'];
    return $learner_id;
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
                $query = "SELECT N_etu as id, 
                                nom as firstName,
                                prenom as lastName,
                                login as email,
                                Num_
                        FROM Etudiant WHERE login = '$login' AND mdp = '$password'";
                $result = mysqli_query(db(), $query);


                // Formatting the result into JSON
                $result_array = mysqli_fetch_assoc($result);
                $response = [
                    "id" => $result_array['id'],
                    "firstName" => $result_array['firstName'],
                    "lastName" => $result_array['lastName'],
                    "email" => $result_array['email'],
                    "team" => $result_array['Num_'], // Assuming 'Num_' corresponds to 'team'
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
    */
    global $bdd;
    $query = "SELECT * FROM `Etat`";
    $data = mysqli_query($bdd, $query);
    if (!$data) {
        die("Erreur dans la requête : " . mysqli_error($bdd));
    }
    $res = mysqli_fetch_all($data, MYSQLI_ASSOC);
    
    var_dump($res);
    exit;
});

get("/teams/:team_id", function ($param) {
    /*global $bdd;
    $query = "SELECT * FROM `Groupe` WHERE `Num_groupe` = $param";
    $data = mysqli_query($bdd, $query);
    if (!$data) {
        die("Erreur dans la requête : " . mysqli_error($bdd));
    }
    $res = mysqli_fetch_all($data, MYSQLI_ASSOC);
    
    var_dump($res);*/
    var_dump($param);
    exit;
});

get("/activities", function ($date, $coin, $name, $limit, $offset) {
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
    
    var_dump($res);
    exit;
});

get("/activities/:activity_id", function ($param) {
    var_dump($param);
    exit;
});

post("/activities/:activity_id/marks", function ($param) {
    var_dump($param);
    exit;
});

delete("/activities/:activity_id/marks", function ($param) {
    var_dump($param);
    exit;
});

post("/activities/:activity_id/comments", function ($param): void {
    var_dump($param);
    exit;
});


delete("/activities/:activity_id/comments/:comment_id", function ($param) {
    var_dump($param);
    exit;
});

get("/activities/:activity_id/sessions/:session_id", function ($param) {
    var_dump($param);
    exit;
});

post("/activities/:activity_id/session/:session_id", function ($param) {
    var_dump($param);
    exit;
});


delete("/activities/:activity_id/sessions/:session_id", function ($param) {
    var_dump($param);
    exit;
});


get("/trainers/:trainer_id", function ($param) {
    var_dump($param);
    exit;
});

header("HTTP/1.0 404");

?>