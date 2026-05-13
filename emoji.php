<?php
session_start();
include 'db.php';

if (!isset($_SESSION["username"])) {
    header("Location: /");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_SESSION["username"];
    $input = isset($_POST['personality_emoji']) ? trim($_POST['personality_emoji']) : '';

    $emoji = NULL;

    if ($input !== '') {
        if (preg_match_all('/\X/u', $input, $matches)) {
            $firstChar = $matches[0][0];

            if (preg_match('/\p{Emoji}/u', $firstChar)) {
                $emoji = $firstChar;
            }
        }
    }

    $query = "UPDATE accounts SET emoji = $1 WHERE name = $2";
    pg_query_params($dbconn, $query, [$emoji, $username]);

    header("Location: /profile"); 
    exit();
}