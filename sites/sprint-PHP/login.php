<?php
session_start();
require_once './repository/userRepository.php';
require_once './utils/auth.php';
require_once './utils/functions.php';

$error = null;

if (!empty($_POST)) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $remember = isset($_POST['remember']);

    $user = getPlayerByEmail($email);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user;

        if ($remember) {
            setcookie('remember_me', $email, time() + (3600 * 24 * 30), "/");
        }

        redirect('index.php');
    } else {
        $error = "Identifiants incorrects.";
    }
}

$savedEmail = isset($_COOKIE['remember_me']) ? $_COOKIE['remember_me'] : '';

$template = './template/login.phtml';
include_once './template/layout.phtml';