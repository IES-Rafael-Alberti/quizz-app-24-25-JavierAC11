<?php
define('DB_HOST', 'mysql');
define('DB_USER', 'quizuser');
define('DB_PASS', 'quizpassword');
define('DB_NAME', 'quiz_app');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
