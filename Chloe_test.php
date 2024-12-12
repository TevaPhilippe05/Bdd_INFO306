<?php
include_once "bdd.php";
include_once "utility.php";
include_once "db_request.php";

$bdd = db();

    get("/teams/:team_id", function ($param) {
        global $bdd;
        $query = "SELECT * FROM `Groupe` WHERE Num_groupe = $param";
        $data = mysqli_query($bdd, $query);
        if (!$data) {
            die("Erreur dans la requête : " . mysqli_error($bdd));
        }
        $res = mysqli_fetch_all($data, MYSQLI_ASSOC);
        
        var_dump($data);
        exit;
    });

    delete("/activities/:activity_id/marks", function ($id_activite,$id_etudiant) {
        global $bdd;
        $query = "DELETE n.note FROM `Note` AS n Join `Note_Groupe` As ng ON n.Id = ng.Id_note WHERE ng.Num_groupe = 1 AND n.Id_activite = 7";
        $data = mysqli_query($bdd, $query);
        if (!$data) {
            die("Erreur dans la requête : " . mysqli_error($bdd));
        }
        //$res = mysqli_fetch_all($data, MYSQLI_ASSOC);
        
        //var_dump($res);
        return ["succes" => $data];
        exit;
    });
