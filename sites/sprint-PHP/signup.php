<?php
session_start();
require_once './repository/userRepository.php';
require_once './utils/auth.php'; 
require_once './utils/functions.php';

$error = null;

if (!empty($_POST)) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    try {
        if (empty($username) || empty($email) || empty($password)) {
            throw new Exception("Tous les champs sont obligatoires.");
        }

       
        $passwordRegex = '/^(?=.*[A-Z])(?=.*[!@#$%^&*(),.?":{}|<>]).{8,}$/';

        if (!preg_match($passwordRegex, $password)) {
            throw new Exception("Le mot de passe doit contenir au moins 8 caractères, une majuscule et un caractère spécial.");
        }
      

        if (emailExists($email)) {
            throw new Exception("Cet email est déjà utilisé par un autre compte.");
        }

        addPlayer($username, $email, $password);
        
        header('Location: login.php?signup_success=1');
        exit();

    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

$template = './template/signup.phtml';
include_once './template/layout.phtml';