<?php
include 'config.php';
include "header.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $conn->real_escape_string($_POST['title']);
    $description = $conn->real_escape_string($_POST['description']);

    $sql = "INSERT INTO cuestionarios (title, description) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $title, $description);

    if ($stmt->execute()) {
        $quiz_id = $stmt->insert_id;
        header("Location: add_question.php?quiz_id=$quiz_id");
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
<form method="post">
    Title: <input type="text" name="title" required><br>
    Description: <textarea name="description"></textarea><br>
    <input type="submit" value="Create Quiz">
</form>
