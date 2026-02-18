<?php
require_once __DIR__ . '/../connexion.php';

function getPlayerByEmail(string $email): ?array
{
    $pdo = getConnection();
    $stmt = $pdo->prepare("SELECT * FROM PLAYER WHERE email = :email");
    $stmt->execute(['email' => $email]);
    
    $player = $stmt->fetch(PDO::FETCH_ASSOC);
    return $player ?: null;
}

function emailExists(string $email): bool
{
    $pdo = getConnection();
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM PLAYER WHERE email = :email");
    $stmt->execute(['email' => $email]);
    return $stmt->fetchColumn() > 0;
}

function addPlayer(string $username, string $email, string $password): void
{
    $pdo = getConnection();
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    $stmt = $pdo->prepare("INSERT INTO PLAYER (username, email, password) VALUES (:username, :email, :password)");
    $stmt->execute([
        'username' => $username,
        'email' => $email,
        'password' => $hashedPassword
    ]);
}

function updateUserPassword(int $userId, string $newPassword): void
{
    $pdo = getConnection();
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    
    $stmt = $pdo->prepare("UPDATE PLAYER SET password = :password WHERE id = :id");
    $stmt->execute([
        'password' => $hashedPassword,
        'id' => $userId
    ]);
}

function deleteUserById(int $userId): void
{
    $pdo = getConnection();
    $stmt = $pdo->prepare("DELETE FROM PLAYER WHERE id = :id");
    $stmt->execute(['id' => $userId]);
}