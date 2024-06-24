<?php


if ($_SERVER["REQUEST_METHOD"] == "POST"){

    $firstname = htmlspecialchars($_POST["firstname"]);
    $lastname = htmlspecialchars($_POST["lastname"]);
    $sex = htmlspecialchars($_POST["sex"]);
    $countries = htmlspecialchars($_POST["country"]);
    $city = htmlspecialchars($_POST["city"]);
    $email = htmlspecialchars($_POST["email"]);
    $password = htmlspecialchars($_POST["pwd"]);
    $terms = htmlspecialchars($_POST["terms"]);

    if(empty($firstname)){
        exit();
        header("Location: ../pages/account.php");
    }

    header("Location: ../pages/account.php");
} else {
    header("Location: ../pages/account.php");
}