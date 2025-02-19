<?php
include 'config.php';
include "header.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

echo "Welcome, " . $_SESSION['username'] . "!";
?>
<a href="create_quiz.php">Create Quiz</a>
<a href="list_quizzes.php">Take Quiz</a>
<a href="logout.php">Logout</a>
