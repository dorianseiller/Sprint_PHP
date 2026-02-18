<?php
session_start();
require_once './repository/characterRepository.php';
require_once './repository/gameRepository.php';
require_once './utils/auth.php';
require_once './utils/functions.php';

if (!isset($_SESSION['character_id'])) {
    redirect('index.php');
}

$characterId = $_SESSION['character_id'];
$character = getCharacterById($characterId);

if (isAuthenticated()) {
    addGame($_SESSION['user']['id'], $characterId);
}

unset($_SESSION['current_question_id']);
unset($_SESSION['character_id']);

$template = './template/result.phtml';
include_once './template/layout.phtml';