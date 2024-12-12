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
    $user_id = $_PUT['mail'];
    $user_pwd = $_PUT['password'];

    $state = array("id" => 1, "title" => "En ligne", "color" => "green", "icon" => "check");

    /*
    
    $user_existe = verification_user_existe($user_id);                             (return boolean)
    if $(user_existe){
        $password_correct = verification_password_correct($user_id, $user_pwd) ;   (return boolean)
        if ($password_correct){
            $donnee_user = remplir_donne_user($user_id, $user_pwd, $state);                (return donnee_user)
            var_dump(json_encode($donnee_user));
        } else{
            var_dump("Le mot de passe est incorrect");
        }
    } else {
        var_dump("L"utilisateur n'existe pas");
    }
        
    Ce qu'il faut faire :
        - 1 : Vérifier si l'utilisateur existe 
        - 2 : Le cas échéant, vérifier si le mot de passe est bon
        - 3 : Le cas échéant, renvoyer le tableau donnée user
            - 3.1 : Le tableau se compose ainsi :
                -id          a recuperer                    
                    -> id = Etudiant(N_Etu)
                -firstName   a recuperer                    
                    -> firstname = Etudiant(prenom)
                -lastName    a recuperer                    
                    -> lastname = Etudiant(nom)
                -email       donnée en argument ($user_id)
                -state       donnée en argument ($state)
                -skill       a recuperer
                    -> skills[name] = Competence(nom)
                    -> skills[level] = Competence(niveau)
                    -> skills[color] = Competence(couleur)
                    -> skills[icon] = Competence(icone)
                -marks       a recuperer
                    -> marks[activityId] = Activite(id)
                    -> marks[mark] = Note(note)

                Note: il peut y avoir plusieurs skill et marks
    */

    $user_existe = user_connect($user_id);
    if ($user_existe){
        $password_correct = password_correct($user_id, $user_pwd);
        if ($password_correct){
            $donnee_user = remplir_donnee_utilisateur($user_id, $state);
            var_dump(json_encode($donnee_user));
        }  else{
            var_dump("Le mot de passe est incorrect");
        }
    } else {
        var_dump("L'utilisateur n'existe pas");
    }

    exit;
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