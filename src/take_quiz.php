<?php
include 'config.php';
include "header.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$quiz_id = $_GET['quiz_id'];

$sql = "SELECT * FROM preguntas WHERE quiz_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $quiz_id);
$stmt->execute();
$result = $stmt->get_result();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $score = 0;
    while ($row = $result->fetch_assoc()) {
        if ($_POST["q".$row['id']] == $row['correct_option']) {
            $score++;
        }
    }

    $sql = "INSERT INTO resultados (user_id, quiz_id, score) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $_SESSION['user_id'], $quiz_id, $score);
    $stmt->execute();

    echo "Your score: $score out of " . $result->num_rows;
} else {
    echo "<form method='post'>";
    while ($row = $result->fetch_assoc()) {
        echo "<p>" . $row['question_text'] . "</p>";
        echo "<input type='radio' name='q".$row['id']."' value='a'>" . $row['option_a'] . "<br>";
        echo "<input type='radio' name='q".$row['id']."' value='b'>" . $row['option_b'] . "<br>";
        echo "<input type='radio' name='q".$row['id']."' value='c'>" . $row['option_c'] . "<br>";
        echo "<input type='radio' name='q".$row['id']."' value='d'>" . $row['option_d'] . "<br>";
    }
    echo "<input type='submit' value='Submit Quiz'>";
    echo "</form>";
}
