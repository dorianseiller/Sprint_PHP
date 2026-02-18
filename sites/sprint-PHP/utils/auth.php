<?php

function isAuthenticated(): bool
{
    if (!isset($_SESSION['user']) && isset($_COOKIE['remember_me'])) {
        require_once __DIR__ . '/../repository/userRepository.php';
        
        $email = $_COOKIE['remember_me'];
        $user = getPlayerByEmail($email);
        
        if ($user) {
            $_SESSION['user'] = $user;
        }
    }

    return isset($_SESSION['user']);
}

function logout(): void
{
    $_SESSION = [];
    if (session_id()) {
        session_destroy();
    }
    
    if (isset($_COOKIE['remember_me'])) {
        setcookie('remember_me', '', time() - 3600, "/");
        unset($_COOKIE['remember_me']);
    }
}


function getUser(): ?array
{
    return $_SESSION['user'] ?? null;
}