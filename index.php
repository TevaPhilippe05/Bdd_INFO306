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

header("HTTP/1.0 404");

?>