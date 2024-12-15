<?php
include_once "utility.php";
include_once "db_request.php";
include_once "Chloe_test.php";
include_once "raph.php";
include_once "learners.php";

$bdd = db();

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