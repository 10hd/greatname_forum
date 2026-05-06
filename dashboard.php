<?php
session_start();
include 'db.php';

if (!isset($_SESSION["username"])) {
    header("Location: index.php");
    exit();
}

$query = "SELECT user_id, name FROM accounts ORDER BY user_id ASC";
$result = pg_query($dbconn, $query);
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

    <main class="flex flex-col gap-4 justify-center flex-1 items-center w-full max-w-md px-4">
        <div class="text-center mb-2">
            <h2 class="text-2xl font-bold mt-4"><span id="date"></span>, <?php echo htmlspecialchars($_SESSION["username"]); ?>!</h2>
        </div>

        <div class="border-3 rounded-lg p-6 w-full bg-zinc-950">
            <h2 class="text-xl font-bold mb-4 border-b border-zinc-800 pb-2">Users</h2>
            <ul class="flex flex-col gap-2">
                <?php 
                while ($row = pg_fetch_assoc($result)): 
                ?>
                    <li class="flex items-center gap-3 py-1 border-b border-zinc-900 last:border-0">
                        <span class="text-zinc-600 text-sm w-8">#<?php echo $row['user_id']; ?></span>
                        <a href="visit.php?id=<?php echo $row['user_id']; ?>" 
                           class="text-lg text-blue-500 hover:underline">
                            <?php echo htmlspecialchars($row['name']); ?>
                        </a>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>

        <div class="flex gap-4 mt-2">
            <a href="profile.php" class="text-blue-500 hover:underline">View My Profile</a>
            <span class="text-zinc-800">|</span>
            <a href="logout.php" class="text-blue-500 hover:underline">Log out</a>
        </div>
    </main>

    <footer class="mb-5 mt-5 w-full text-center">
        <p>Copyright &copy; <span id="year"></span> <span class="text-[#6674b2] font-bold">greatname</span>. All rights reserved.</p>
    </footer>

    <script src="timeofday.js"></script>
    <script src="year.js"></script>
</body>
</html>