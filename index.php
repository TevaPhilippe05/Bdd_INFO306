<?php
include_once "bdd.php";
include_once "utility.php";

get("/learners/:learnerId", function ($param) {
    $learner_id = $param['learnerId'];
});

put("/learners/:learnerId", function () {
    $_PUT = read_put();
    $user_pwd = $_PUT['password'];
});

post("/learners", function () {
    $_PUT = read_put();
    $user_id = $_PUT['mail'];
    $user_pwd = $_PUT['password'];
    var_dump($user_id);
    var_dump($user_pwd);
    exit;
});


header("HTTP/1.0 404");
