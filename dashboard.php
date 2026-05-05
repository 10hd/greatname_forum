<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: index.php");
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
    <title>greatname.net | Dashboard</title>
</head>
<body class="font-serif bg-slate-950 text-white flex flex-col min-h-screen items-center m-0 p-0 h-full">
    <header class="mt-5">
        <h1 class="text-4xl font-bold logo">greatname.net</h1>
    </header>
    <main class="flex flex-col gap-4 justify-center flex-1 items-center">
        <div class="border-3 rounded-lg p-8 w-full max-w-md bg-zinc-950">
            <h2 class="text-2xl font-bold mb-4 text-center"><span id="date"></span>, <?php echo htmlspecialchars($_SESSION["username"]); ?>!</h2>
            <h3 class="text-xl font-bold mb-4 text-center text-emerald-600">You have successfully logged in to your greatname.net account.</h3>
            <h4 class="text-xl mb-4 text-center text-mist-400">Click <a href="profile.php" class="text-lg text-blue-500 text-center cursor-pointer hover:underline">here</a> to view your profile or log out.</h4>
        </div>
    </main>
    <footer class="mb-5">
        <p>Copyright &copy; <span id="year"></span> <span class="text-[#6674b2] font-bold">greatname</span>. All rights reserved.</p>
    </footer>
    <script src="timeofday.js"></script>
    <script src="year.js"></script>
</body>
</html>