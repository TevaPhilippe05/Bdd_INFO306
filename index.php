<?php
include_once "bdd.php";
include_once "utility.php";

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

    /*NOTE !! : 
    
    Ici, (Antonin), Il y a : 
    
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

    $skills = [array("name" => null, "level" => null, "color" => null, "icon" => null), null]; //a enlever quand ce sera fait
    $marks = [array("activityId" => null, "mark" => null), null]; //a enlever quand ce sera fait

    $user_existe = True;
    if ($user_existe){
        $password_correct = True;
        if ($password_correct){
            $donnee_user = array(
                'id' => null, 
                "firstName" => null, 
                "lastName" => null, 
                "email" => $user_id, 
                "state" => $state, 
                "skills" => $skills, 
                "marks" => $marks); //a enlever quand ce sera fait
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
    var_dump("Pas de paramètres");
    exit;
});

get("/teams/:team_id", function ($param) {
    var_dump($param);
    exit;
});

get("/activities", function ($date, $coin, $name, $limit, $offset) {
    var_dump($date, $coin, $name, $limit, $offset);
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