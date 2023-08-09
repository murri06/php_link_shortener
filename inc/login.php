<?php

namespace Acme;
require_once '../vendor/autoload.php';
session_start();

$pdo = new Database('sql205.infinityfree.com', 'if0_34693072_php_link_shortener',
    'if0_34693072', 'EavByKrz0g');
$pdo->connect();
$domain = "https://murri.rf.gd/";

if (isset($_POST['login'])) {

    $login = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    if ($res = $pdo->userValidation($login)) {

        if (password_verify($password, $res['password'])) {
            $_SESSION['username'] = $res['username'];
            header("Location: $domain");

        } else header("Location: $domain?e=5");

    } else header("Location: $domain?e=5");
}

if (isset($_POST['register'])) {

    $login = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password2 = filter_input(INPUT_POST, 'passwordRepeat', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if ($pdo->userValidation($login)) {
        header("Location: $domain?e=1");
        exit();
    }

    if ($password !== $password2) {
        header("Location: $domain?e=2");
        exit();
    }
    $password = password_hash($password, PASSWORD_BCRYPT);
    if ($pdo->createUser($login, $password)) {
        header("Location: $domain?e=3");
        exit();
    } else
        header("Location: $domain?e=4");
}