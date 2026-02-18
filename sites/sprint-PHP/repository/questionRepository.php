<?php
require_once 'connexion.php';

function getQuestionById(int $id)
{
    $pdo = getConnection();
    $sql = 'SELECT * FROM QUESTION WHERE id = :id';
    $query = $pdo->prepare($sql);
    $query->execute(['id' => $id]);
    return $query->fetch(PDO::FETCH_ASSOC);
}

function getLink(int $parentQuestId, string $expectedAnswer)
{
    $pdo = getConnection();
    $sql = 'SELECT * FROM TREE_LINK WHERE parent_quest_id = :qid AND expected_answer = :ans';
    $query = $pdo->prepare($sql);
    $query->execute([
        'qid' => $parentQuestId,
        'ans' => $expectedAnswer
    ]);
    return $query->fetch(PDO::FETCH_ASSOC);
}