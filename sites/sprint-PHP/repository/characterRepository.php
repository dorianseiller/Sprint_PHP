<?php
require_once 'connexion.php';

function getCharacterById(int $id)
{
    $pdo = getConnection();
    $sql = 'SELECT * FROM `CHARACTER` WHERE id = :id';
    $query = $pdo->prepare($sql);
    $query->execute(['id' => $id]);
    return $query->fetch(PDO::FETCH_ASSOC);
}