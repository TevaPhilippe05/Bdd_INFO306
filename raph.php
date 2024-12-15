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
    global $bdd;

    if (!empty($_POST["learner_id"]) && !empty($_POST["mark"])) {
        $id_groupe = intval($_POST["learner_id"]);
        $note = intval($_POST["mark"]);
        $activity_id = intval($param['activity_id']);

        $query = "SELECT * FROM `Note_groupe` NG 
                  JOIN `Note` N ON NG.Id_note = N.Id 
                  JOIN `Activite` A ON N.Id_Activite = A.Id 
                  WHERE NG.Num_Groupe = $id_groupe AND A.Id = $activity_id";
        $data = mysqli_query($bdd, $query);
        $res = mysqli_fetch_all($data, MYSQLI_ASSOC);

        if (empty($res)) {
            $query = "INSERT INTO `Note` (`Note`, `Id_Activite`) VALUES ($note, $activity_id)";
            mysqli_query($bdd, $query);

            $note_id = mysqli_insert_id($bdd);
            $query = "INSERT INTO `Note_groupe` (`Num_Groupe`, `Id_note`) VALUES ($id_groupe, $note_id)";
            mysqli_query($bdd, $query);
        } else {
            $noteId = intval($res[0]['Id_note']);
            $query = "UPDATE `Note` SET `Note` = $note WHERE `Note`.`Id` = $noteId";
            mysqli_query($bdd, $query);
        }

        // Return a success response
        var_dump(json_encode(["success" => true]));
        exit;
    }

    // Invalid input
    var_dump(json_encode(["success" => false]));
    exit;
});

get("/activities/:activity_id/sessions/:session_id", function ($param) {
    global $bdd;
    $query = "SELECT S.ID, P2.date_debut, P.*, S.*  FROM `Session` S 
    JOIN `Activite` A ON S.Id_Activite = A.Id 
    JOIN `Professeur` P ON A.Id_prof = P.Id 
    JOIN `Periode` P2 ON A.Periode = P.Id
    WHERE S.Id={$param['session_id']} AND S.Id_Activite={$param['activity_id']}";
    $data = mysqli_query($bdd, $query);
    if (!$data) {
        die("Erreur dans la requête : " . mysqli_error($bdd));
    }
    $res = mysqli_fetch_all($data, MYSQLI_ASSOC);

    var_dump(json_encode($res));
    exit;
});


post("/activities/:activity_id/subscribe/", function ($param) { //activities{activity_id}/sessions/{session_id}
    global $bdd;

    $groupe_id = intval($_POST['team_id']);
    $activity_id = intval($param['activity_id']);


    $query = "SELECT * FROM `Groupe_Activite` WHERE `Num_groupe` = $groupe_id AND `Id_activite` = $activity_id";
    $data = mysqli_query($bdd, $query);
    $res = mysqli_fetch_all($data, MYSQLI_ASSOC);

    if (empty($res)) {
        $query = "INSERT INTO `Groupe_Activite` (`Num_groupe`, `Id_activite`) VALUES ($groupe_id, $activity_id)";
        mysqli_query($bdd, $query);

        var_dump(json_encode(["success" => true]));
        exit;
    } else {
        var_dump(json_encode(["success" => false]));
        exit;
    }
});

post("/activities/:activity_id/comments/", function ($param) { //activities{activity_id}/sessions/{session_id}
    global $bdd;

    $message = strval($_POST['message']);
    $activity_id = intval($param['activity_id']);
    $current_date = date("Y-m-d");
    $query = "INSERT INTO `Commentaires` (`date`,`message`, `id_activite`) VALUES ('$current_date','$message', $activity_id)";
    mysqli_query($bdd, $query);

    var_dump(json_encode(["success" => true]));
    exit;
});
