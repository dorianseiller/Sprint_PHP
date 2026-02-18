<?php
session_start();
require_once './repository/gameRepository.php';
require_once './repository/userRepository.php';
require_once './utils/auth.php';
require_once './utils/functions.php';

if (!isAuthenticated()) {
    redirect('login.php');
}

$user = $_SESSION['user'];
$games = getGamesByPlayerId($user['id']);
$message = null;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (isset($_POST['action']) && $_POST['action'] === 'change_password') {
        $currentPassword = $_POST['current_password'];
        $newPassword = $_POST['new_password'];

        $playerData = getPlayerByEmail($user['email']);

        if ($playerData && password_verify($currentPassword, $playerData['password'])) {
            $passwordRegex = '/^(?=.*[A-Z])(?=.*[!@#$%^&*(),.?":{}|<>]).{8,}$/';
            if (preg_match($passwordRegex, $newPassword)) {
                updateUserPassword($user['id'], $newPassword);
                $message = "Mot de passe modifié avec succès.";
            } else {
                $error = "Le mot de passe doit contenir 8 caractères, une majuscule et un caractère spécial.";
            }
        } else {
            $error = "Mot de passe actuel incorrect.";
        }
    }

    if (isset($_POST['action']) && $_POST['action'] === 'delete_account') {
        deleteUserById($user['id']);
        logout();
        redirect('index.php');
    }
}

$template = './template/account.phtml';
include_once './template/layout.phtml';