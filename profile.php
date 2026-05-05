<?php
session_start();
include 'db.php';

if (!isset($_SESSION["username"])) {
    header("Location: index.php");
    exit();
}

$query = "SELECT user_id, created_at, deactivated, is_admin FROM accounts WHERE name = $1";
$result = pg_query_params($dbconn, $query, [$_SESSION["username"]]);

if ($result) {
    $user = pg_fetch_assoc($result);
} else {
    $user = null;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="shortcut icon" href="coliseum.svg" type="image/x-icon">
    <title>greatname.net | Profile</title>
</head>
<body class="font-serif bg-slate-950 text-white flex flex-col min-h-screen items-center m-0 p-0 h-full">
    <header class="mt-5">
        <h1 class="text-4xl font-bold logo">greatname.net</h1>
    </header>
    <main class="flex flex-col gap-4 justify-center flex-1 items-center w-full">
        <div class="border-3 rounded-lg p-8 w-full max-w-md bg-zinc-950">
            <h2 class="text-2xl font-bold mb-2">Profile info:</h2>
            <h3 class="text-xl mb-4 text-mist-300">
                Username: <span class="text-mist-400" style="color: <?php echo ($user['is_admin'] === 't') ? 'red' : 'inherit'; ?>;"><?php echo htmlspecialchars($_SESSION["username"]); ?></span>
                <br>
                User ID: <span class="text-mist-400"><?php echo $user['user_id']; ?></span>
                <br>
                Account created: <span class="text-mist-400"><?php $date = new DateTime($user['created_at']); echo $date->format('d/m/Y H:i'); ?></span>
                <br>
                Account status: <span class="text-mist-400"><?php echo ($user['deactivated'] === 't') ? 'Deactivated' : 'Active'; ?></span>
            </h3>
            <h4 class="text-xl font-bold mb-2">Description:</h4>
            <p class="text-mist-300 text-lg mb-4">
                <?php echo htmlspecialchars($user['description'] ?? 'No description set.'); ?>
                <a href="description.php" class="text-blue-500 hover:underline">Edit Description</a>
            </p>
            <a href="logout.php" class="text-lg text-blue-500 text-center cursor-pointer hover:underline">Log out</a>
        </div>
    </main>
    <footer class="mb-5 w-full text-center">
        <p>Copyright &copy; <span id="year"></span> <span class="text-[#6674b2] font-bold">greatname</span>. All rights reserved.</p>
    </footer>
    <script src="year.js"></script>
</body>
</html>