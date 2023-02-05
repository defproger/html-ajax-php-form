<?php

$Users = [
    [
        "email" => "user1@a.b",
        "id" => 1,
        "name" => "User",
        "password" => '202cb962ac59075b964b07152d234b70' //password with md5
    ],
    [
        "email" => "user2@a.b",
        "id" => 2,
        "name" => "User",
        "password" => '202cb962ac59075b964b07152d234b70'
    ]
];

$name = $_POST["name"];
$surname = $_POST["surname"];
$email = $_POST["email"];
$password = $_POST["password"];
$passwordRepeat = $_POST["password_repeat"];

$errors = [];

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "invalid email";
}

if ($password != $passwordRepeat) {
    $errors[] = "passwords do not match";
}

foreach ($Users as $user) {
    if ($user["email"] == $email) {
        $errors[] = "user already exists";
        break;
    }
}

if (count($errors) > 0) {
    $log = "$name $surname ($email) " . implode(' | ', $errors) . " on " . date("Y-m-d H:i:s") . PHP_EOL;
    $errorMessage = "<p>" . implode("<br/>", $errors) . "</p>";
    $data = [
        'ok' => false,
        'data' => $errorMessage
    ];
} else {
    $log = "$name $surname ($email) registered on " . date("Y-m-d H:i:s") . PHP_EOL;
    $data = [
        'ok' => true,
        'data' => "<p>successful</p>"
    ];
}

file_put_contents(".log", $log, FILE_APPEND);
echo json_encode($data);
