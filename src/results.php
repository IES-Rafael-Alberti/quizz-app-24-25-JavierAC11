<?php
include 'config.php';
include "header.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT c.title, r.score, r.date_taken 
        FROM resultados r 
        JOIN cuestionarios c ON r.quiz_id = c.id 
        WHERE r.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "Quiz: " . $row["title"] . " - Score: " . $row["score"] . " - Date: " . $row["date_taken"] . "<br>";
    }
} else {
    echo "No results found";
}
