<?php

include_once "bdd.php";

$bdd = db();

function user_connect($mail, $psw) {
    $query = "SELECT * FROM Etudiant WHERE {$mail}";
    $out = mysqli_query($bdd, $query);
    return $out;
}
?>