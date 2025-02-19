<?php
include 'config.php';
include "header.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$quiz_id = $_GET['quiz_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_question'])) {
        $question = $conn->real_escape_string($_POST['question']);
        $option_a = $conn->real_escape_string($_POST['option_a']);
        $option_b = $conn->real_escape_string($_POST['option_b']);
        $option_c = $conn->real_escape_string($_POST['option_c']);
        $option_d = $conn->real_escape_string($_POST['option_d']);
        $correct = $conn->real_escape_string($_POST['correct']);

        $sql = "INSERT INTO preguntas (quiz_id, question_text, option_a, option_b, option_c, option_d, correct_option) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issssss", $quiz_id, $question, $option_a, $option_b, $option_c, $option_d, $correct);

        if ($stmt->execute()) {
            echo "Question added successfully";
        } else {
            echo "Error: " . $stmt->error;
        }
    } elseif (isset($_POST['finish_quiz'])) {
        header("Location: list_quizzes.php");
        exit();
    }
}
?>
<form method="post">
    Question: <input type="text" name="question"><br>
    Option A: <input type="text" name="option_a"><br>
    Option B: <input type="text" name="option_b"><br>
    Option C: <input type="text" name="option_c"><br>
    Option D: <input type="text" name="option_d"><br>
    Correct Option:
    <select name="correct">
        <option value="a">A</option>
        <option value="b">B</option>
        <option value="c">C</option>
        <option value="d">D</option>
    </select><br>
    <input type="submit" name="add_question" value="Add Question">
    <input type="submit" name="finish_quiz" value="Finish Quiz">
</form>
