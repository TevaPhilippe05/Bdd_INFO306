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
    var_dump($user_pwd);
    /*$tableau = json_encode({
        "id": 10,
        "firstName": "theUser",
        "lastName": "John",
        "email": "john@email.com",
        "state": {
          "id": 1,
          "title": "En ligne",
          "color": "green",
          "icon": "check"
        },
        "skills": [
          {
            "name": "agile",
            "level": 2,
            "color": "brown",
            "icon": "brightness_1"
          }
        ],
        "marks": [
          {
            "activityId": 1,
            "mark": 5
          }
        ]
      })

    var_dump($tableau);*/
    exit;
});


header("HTTP/1.0 404");
