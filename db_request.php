<?php
include_once "bdd.php";

function getUserInfo($learner_id) {
    $query = "SELECT E.N_etu as id, 
                                E.nom as firstName,
                                E.prenom as lastName,
                                E.login as email,
                                E.Num_groupe as team,
                                Etat.Id as id_e,
                                Etat.titre as title,
                                Etat.couleur as state_color,
                                Etat.icon as state_icon,
                                C.nom as skill_name,
                                C.niveau as skill_level,
                                C.couleur as skill_color,
                                C.icon as skill_icon,
                                N.Id as activityId,
                                N.note as mark
                        FROM Etudiant E
                        LEFT JOIN Etat Etat ON Etat.Id = E.Id_etat
                        LEFT JOIN Etudiant_Competence EC ON EC.N_etu = E.N_etu
                        LEFT JOIN Competence C ON C.Nom = EC.Nom_competence
                        LEFT JOIN Note_groupe NG ON NG.Num_groupe = E.Num_groupe
                        LEFT JOIN Note N ON N.id = NG.id_note
                        WHERE E.N_etu ='$learner_id'";

    $result = mysqli_query(db(), $query);
    if (!$result) {
        die("Query Error: " . mysqli_error(db()));
    }

    $response = null;
    $skills = [];
    $marks = [];

    while ($row = mysqli_fetch_assoc($result)) {
        // Initialize response with student and state data only once
        if ($response === null) {
            $response = [
                "id" => +$row['id'],
                "firstName" => $row['firstName'],
                "lastName" => $row['lastName'],
                "email" => $row['email'],
                "team" => $row['team'],
                "state" => [
                    "id" => +$row['id_e'],
                    "title" => $row['title'],
                    "color" => $row['state_color'],
                    "icon" => $row['state_icon']
                ],
                "skills" => [],
                "marks" => []
            ];
        }

        // Add skills to the skills array
        if ($row['skill_name']) {
            $skills[] = [
                "name" => $row["skill_name"],
                "level" => +$row["skill_level"],
                "color" => $row["skill_color"],
                "icon" => $row["skill_icon"]
            ];
        }

        // Add marks to the marks array
        if ($row['activityId']) {
            $marks[] = [
                "activityId" => +$row["activityId"],
                "mark" => +$row["mark"]
            ];
        }
    }

    // Attach skills and marks to the response
    $response["skills"] = $skills;
    $response["marks"] = $marks;

    return $response;
}


function getUsersIdFromGroupe($id_groupe)
{
    $query = "SELECT N_etu as id FROM Etudiant WHERE Num_groupe='$id_groupe'";
    $result = mysqli_query(db(), $query);
    return $result;
}

function getGroupeActivite($id_groupe)
{
    $query = "SELECT S.Id as id,
              S.Id_activite as id_a,
              A.Id_prof as trainerId,
              A.nom as name,
              A.description as syllabus,
              A.credit as coin,
              A.nb_groupe_max as maxTeams,
              P.titre as title,
              P.date_debut as startDate,
              P.date_fin as endDate,
              P.couleur as color
              FROM Session S
              JOIN Activite A ON S.Id_activite=A.Id
              JOIN Periode P ON A.Periode=P.Id
              JOIN Groupe_Activite G ON A.id=G.Id_activite
              WHERE G.Num_groupe='$id_groupe'";

    $result = mysqli_query(db(), $query);

    return $result;
}