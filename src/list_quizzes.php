<?php
include 'config.php';
include "header.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT * FROM cuestionarios";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<a href='take_quiz.php?quiz_id=" . $row["id"] . "'>" . $row["title"] . "</a><br>";
    }
} else {
    echo "No quizzes available";
}
