<?php

get("/activities/:activity_id", function ($param) {
    global $bdd;
    $query = "SELECT * FROM `Activite` A JOIN `Periode` P ON A.Periode = P.Id WHERE A.Id=$param[activity_id]";
    $data = mysqli_query($bdd, $query);
    if (!$data) {
        die("Erreur dans la requête : " . mysqli_error($bdd));
    }
    $res = mysqli_fetch_all($data, MYSQLI_ASSOC);
    
    var_dump(json_encode($res));
    exit;
});

post("/activities/:activity_id/marks", function ($param) {
    $id_groupe = $_POST["id_groupe"];
    $note = $_POST["note"];

    global $bdd;
    $query = "SELECT * FROM `Note_groupe` NG JOIN `Note` N ON NG.Id_note = N.Id JOIN `Activite` A ON N.Id_Activite = A.Id WHERE NG.Num_Groupe = $id_groupe AND A.Id = $param[activity_id]";
    $data = mysqli_query($bdd, $query);
    if (!$data) {
        die("Erreur dans la requête : " . mysqli_error($bdd));
    }
    $res = mysqli_fetch_all($data, MYSQLI_ASSOC);
    
    var_dump(json_encode($res));
    exit;
});