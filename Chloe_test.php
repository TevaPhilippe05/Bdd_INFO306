<?php
include_once "bdd.php";
include_once "utility.php";
include_once "db_request.php";

$bdd = db();

    /*get("/teams/:team_id", function ($param) {
        global $bdd;
        $Id_groupe= $param["team_id"];
        $query = "SELECT * FROM Groupe WHERE Num_groupe = '$Id_groupe'";
        $data = mysqli_query($bdd, $query);
        if (!$data) {
            die("Erreur dans la requête : " . mysqli_error($bdd));
        }
        $res = mysqli_fetch_all($data, MYSQLI_ASSOC);
        
        var_dump($data);
        exit;
    });*/

    get("/trainers/:trainer_id", function ($param) {
        global $bdd;
        $id = $param["trainer_id"];
        $query = "SELECT * FROM Professeur WHERE Id = '$id'";
        $data = mysqli_query($bdd, $query);
        if (!$data) {
            die("Erreur dans la requête : " . mysqli_error($bdd));
        }
        $res = mysqli_fetch_all($data, MYSQLI_ASSOC);
        
        var_dump($res);
        exit;
    });


    delete("/activities/:activity_id/marks", function ($param) {
        global $bdd;
        $id_activite = $param["activity_id"];

        $query = "DELETE FROM Note WHERE Id = '$id_activite'";
        $data = mysqli_query($bdd, $query);
        if (!$data) {
            die("Erreur dans la requête : " . mysqli_error($bdd));
        }

        return ["succes" => $data];        
        exit;
    });
        
    delete("/activities/:activity_id/comments/:comment_id", function ($param) {
        global $bdd;

        $id_activite = $param["activity_id"];
        $id_comment = $param["comment_id"];

        $query = "DELETE FROM Commentaires WHERE Id = '$id_comment' AND Id_activite = '$id_activite' ";
       $data = mysqli_query($bdd, $query);
        if (!$data) {
            die("Erreur dans la requête : " . mysqli_error($bdd));
        }
        var_dump($param);

        return ["succes" => $data];        
        exit;

    });
//Il y a une incoérence quelque part car on a pas besoin de id activite non?
    delete("/activities/:activity_id/sessions/:session_id", function ($param) {
        global $bdd;
        $id_activite = $param["activity_id"];
        $id_session = $param["session_id"];

        $query = "DELETE FROM Session WHERE Id = '$id_session' AND Id_activite = '$id_activite' ";
        $data = mysqli_query($bdd, $query);
        if (!$data) {
            die("Erreur dans la requête : " . mysqli_error($bdd));
        }
        var_dump($param);
        return ["succes" => $data];
        exit;
    });
