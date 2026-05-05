<?php
session_start();
include 'db.php';

$options = [
    'memory_cost' => 65536,
    'time_cost' => 4,
    'threads' => 1
];

if ($dbconn) {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if ($_POST["action"] === "register") {
            $registerHash = password_hash($_POST["passwordField"], PASSWORD_ARGON2ID, $options);
            $insertQuery = "INSERT INTO accounts (name, password_hash) VALUES ($1, $2)";
            $insertResults = pg_query_params($dbconn, $insertQuery, [$_POST["usernameField"], $registerHash]);

            if ($insertResults) {
                $_SESSION["username"] = $_POST["usernameField"];
                header("Location: dashboard.php");
                exit();
            } else {
                header("Location: index.php?error=" . urlencode(pg_last_error($dbconn)));
                exit();
            }
        } elseif ($_POST["action"] === "login") {
            $selectQuery = "SELECT password_hash FROM accounts WHERE name = $1";
            $selectResults = pg_query_params($dbconn, $selectQuery, [$_POST["usernameField"]]);

            if ($selectResults) {
                $row = pg_fetch_assoc($selectResults);
                if ($row && password_verify($_POST["passwordField"], $row["password_hash"])) {
                    $_SESSION["username"] = $_POST["usernameField"];
                    header("Location: dashboard.php");
                    exit();
                } else {
                    header("Location: index.php?error=invalid");
                    exit();
                }
            } else {
                header("Location: index.php?error=" . urlencode(pg_last_error($dbconn)));
                exit();
            }
        }
    }
}
?>