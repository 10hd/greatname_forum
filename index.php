<?php include 'auth.php';
if (isset($_COOKIE['loggedIn']) && $_COOKIE['loggedIn'] === "1") {
    header("Location: dashboard.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="shortcut icon" href="coliseum.svg" type="image/x-icon">
    <title>greatname.net | Registration</title>
</head>
<body class="font-serif bg-slate-950 text-white flex flex-col min-h-screen items-center m-0 p-0 h-full">
    <header class="mt-5">
        <h1 class="text-4xl font-bold">greatname.net</h1>
    </header>
    <main class="flex flex-col gap-4 justify-center flex-1 items-center">
        <form action="auth.php" method="POST" class="border-3 rounded-lg p-8 w-full max-w-md">
            <h2 class="text-2xl font-bold mb-4 text-center">Registration & Login</h2>
            <div>
                <p class="text-lg text-mist-400">Enter your username</p>
                <input class="bg-mist-200 text-black rounded mb-4 w-full p-2" type="text" name="usernameField" id="usernameInput">
            </div>
            <div>
                <p class="text-lg text-mist-400">Enter your password</p>
                <input class="bg-mist-200 text-black rounded w-full p-2" type="password" name="passwordField" id="passwordInput">
                <a href="resetPassword.php" class="text-blue-500 opacity-50 underline mb-12 cursor-pointer">Forgot your password?</a>
            </div>
            <div class="flex align-items-center justify-center gap-2">
                <button name="action" value="login" type="submit" id="loginButton" class="bg-mist-700 hover:bg-mist-600 text-white font-bold w-30 py-2 px-4 rounded hover:cursor-pointer">Login</button>
                <button name="action" value="register" type="submit" id="registerButton" class="bg-mist-700 hover:bg-mist-600 text-white font-bold w-30 py-2 px-4 rounded hover:cursor-pointer">Register</button>
            </div>
            <?php
            $msg = "";
            if (isset($_GET["error"]) && $_GET["error"] === "invalid") {
                $msg = "Invalid username or password.";
            }
            ?>
            <p class="text-md font-bold mt-2 text-center text-red-400" id="errorText"><?php echo $msg; ?></p>
        </form>
    </main>
    <footer class="mb-5">
        <p>Copyright &copy; <span id="year"></span> <span class="text-[#6674b2] font-bold">greatname</span>. All rights reserved.</p>
    </footer>
    <script src="script.js"></script>
    <script src="year.js"></script>
</body>
</html>