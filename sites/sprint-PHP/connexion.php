<?php

function getConnection(): PDO
{
    $host = 'db.3wa.io';
    $dbName = 'dorianseiller_sprint1'; 
    $user = 'dorianseiller';
    $password = '3c6e9d2cd394fbccfb626df3544e429d';

    try {
        $pdo = new PDO(
            "mysql:host=$host;dbname=$dbName;charset=utf8",
            $user,
            $password,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
        return $pdo;
    } catch (PDOException $e) {
        die("Erreur de connexion : " . $e->getMessage());
    }
}