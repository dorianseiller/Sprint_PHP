<?php
require_once 'connexion.php';

function addGame(int $playerId, int $foundCharId)
{
    $pdo = getConnection();
    $sql = 'INSERT INTO GAME (player_id, found_char_id, game_date) VALUES (:pid, :cid, NOW())';
    $query = $pdo->prepare($sql);
    $query->execute([
        'pid' => $playerId,
        'cid' => $foundCharId
    ]);
}

function getGamesByPlayerId(int $playerId)
{
    $pdo = getConnection();
    $sql = 'SELECT g.game_date, c.name 
            FROM GAME g 
            JOIN `CHARACTER` c ON g.found_char_id = c.id 
            WHERE g.player_id = :pid 
            ORDER BY g.game_date DESC';
    $query = $pdo->prepare($sql);
    $query->execute(['pid' => $playerId]);
    return $query->fetchAll(PDO::FETCH_ASSOC);
}