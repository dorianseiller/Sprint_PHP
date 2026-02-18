<?php
session_start();
require_once './repository/questionRepository.php';
require_once './utils/functions.php';
require_once './utils/auth.php';



if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

if (isset($_GET['reset']) && $_GET['reset'] == 1) {
    $_SESSION['current_question_id'] = 1;
    redirect('quiz.php');
}


if (!isset($_SESSION['current_question_id'])) {
    $_SESSION['current_question_id'] = 1; 
}

$currentId = $_SESSION['current_question_id'];
$question = getQuestionById($currentId);

if (!$question) {
    session_destroy();
    redirect('index.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $answerValue = $_POST['answer'];
    $link = getLink($currentId, $answerValue);

    if ($link) {
        if ($link['found_char_id']) {
            $_SESSION['character_id'] = $link['found_char_id'];
            redirect('result.php');
        } elseif ($link['next_quest_id']) {
            $_SESSION['current_question_id'] = $link['next_quest_id'];
            redirect('quiz.php');
        }
    } else {
        redirect('index.php');
    }
}

$template = './template/quiz.phtml';
include_once './template/layout.phtml';