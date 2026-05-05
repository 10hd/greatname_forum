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
            $username = trim($_POST["usernameField"]);
            $email = trim($_POST["emailField"]);

            if (empty($username) || empty($_POST["passwordField"])) {
                header("Location: index.php?error=empty_fields");
                exit();
            }

            if (!preg_match("/^[a-zA-Z]+$/", $username)) {
                header("Location: index.php?error=invalid_username_format");
                exit();
            }

            if (!empty($email)) {
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    header("Location: index.php?error=invalid_email");
                    exit();
                }
            } else {
                $email = null;
            }

            $checkQuery = "SELECT 1 FROM accounts WHERE name = $1";
            $checkResult = pg_query_params($dbconn, $checkQuery, [$username]);

            if (pg_fetch_row($checkResult)) {
                header("Location: index.php?error=username_taken");
                exit();
            }

            $registerHash = password_hash($_POST["passwordField"], PASSWORD_ARGON2ID, $options);

            $insertQuery = "INSERT INTO accounts (name, email, password_hash) VALUES ($1, $2, $3)";
            $insertResults = pg_query_params($dbconn, $insertQuery, [$username, $email, $registerHash]);

            if ($insertResults) {
                $_SESSION["username"] = $username;
                header("Location: dashboard.php");
                exit();
            } else {
                header("Location: index.php?error=" . urlencode(pg_last_error($dbconn)));
                exit();
            }
        } elseif ($_POST["action"] === "login") {
            $username = trim($_POST["usernameField"]);
            $selectQuery = "SELECT password_hash FROM accounts WHERE name = $1";
            $selectResults = pg_query_params($dbconn, $selectQuery, [$username]);

            if ($selectResults) {
                $row = pg_fetch_assoc($selectResults);
                if ($row && password_verify($_POST["passwordField"], $row["password_hash"])) {
                    $_SESSION["username"] = $username;
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