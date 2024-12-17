<?php
include_once "bdd.php";

function getUserInfo($learner_id) {
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
                        JOIN Etudiant_Competence EC ON EC.N_etu = E.N_etu
                        JOIN Competence C ON C.Nom = EC.Nom_competence
                        JOIN Note_groupe NG ON NG.Num_groupe = E.Num_groupe
                        JOIN Note N ON N.id = NG.id_note
                        WHERE E.N_etu ='$learner_id'";
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

?>