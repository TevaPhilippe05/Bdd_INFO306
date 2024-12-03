<?php

#To fill
$username = "info_gr4";
$password = "v2C";

function db()
{
    global $username, $password;
    $bdd = mysqli_connect("localhost", $username, $password, $username) or die("Connection failed: " . mysqli_connect_error());
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
    return $bdd;
}

function from_csv($csv) {
    if (($handle = fopen($csv, 'r')) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
            print_r($data);
        }
        fclose($handle);
    } else {
        echo "Error opening the file.";
    }

    $query = "INSERT INTO Etudiant ({})"
}
