<?php
session_start();
include 'db.php';

$limit = 10;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

$query = "SELECT user_id, name, emoji, deactivated FROM accounts ORDER BY user_id ASC LIMIT $1 OFFSET $2";
$result = pg_query_params($dbconn, $query, [$limit, $offset]);

$countQuery = "SELECT count(*) FROM accounts";
$countResult = pg_query($dbconn, $countQuery);
$totalUsers = pg_fetch_result($countResult, 0, 0);
$totalPages = ceil($totalUsers / $limit);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="shortcut icon" href="coliseum.svg" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <title>greatname.net | Dashboard</title>
</head>
<body class="bg-black text-white flex flex-col min-h-screen items-center m-0 p-0 h-full">
    <header class="mt-5">
        <h1 class="text-4xl font-bold">great<span class="text-[#6674b2]">name</span>.net</h1>
    </header>

    <main class="flex flex-col gap-4 justify-center flex-1 items-center w-full max-w-lg px-4">
        <div class="p-6 w-full">
            <h2 class="text-xl font-bold mb-4 border-b border-mist-400 pb-2 px-2">Join a Room</h2>
            <div class="p-6 w-full flex flex-col justify-center flex-1 items-center">
                <a href="/global" class="mt-6 bg-[#6674b2] opacity-80 border-2 border-transparent hover:bg-slate-800 hover:border-white text-white font-bold w-80 py-2 px-4 rounded-full hover:cursor-pointer transition-colors">Global Room</a>
                <a href="" class="mt-6 bg-gray-500 opacity-80 border-2 border-transparent hover:bg-slate-800 hover:border-white text-white font-bold w-80 py-2 px-4 rounded-full hover:cursor-pointer transition-colors">Private Room</a>
            </div>
        </div>
        <div class="p-6 w-full">
            <div class="flex justify-between items-center px-2 border-b border-mist-400 mb-4">
                <h2 class="text-xl font-bold mb-1 basis-1/2">ID list</h2>
                <?php if ($page > 1): ?>
                <a href="?page=<?php echo $page - 1; ?>" class="mb-2 bg-gray-500 opacity-80 border-2 border-transparent hover:bg-slate-800 hover:border-white text-white font-bold py-1 px-3 rounded-full hover:cursor-pointer transition-colors">Prev</a>
                <?php else: ?>
                <span class="text-zinc-600 cursor-default py-1 px-4">Prev</span>
                <?php endif; ?>

                <span class="text-md text-zinc-500 mb-1"><?php echo $page; ?></span>
            
                <?php if ($page < $totalPages): ?>
                <a href="?page=<?php echo $page + 1; ?>" class="mb-2 bg-gray-500 opacity-80 border-2 border-transparent hover:bg-slate-800 hover:border-white text-white font-bold py-1 px-3 rounded-full hover:cursor-pointer transition-colors">Next</a>
                <?php else: ?>
                <span class="text-zinc-600 cursor-default py-1 px-4">Next</span>
                <?php endif; ?>
            </div>
            
            <ul class="flex flex-col gap-2">
                <?php 
                while ($row = pg_fetch_assoc($result)): ?>
                    <li class="flex items-center gap-3 py-1 px-2 rounded hover:bg-zinc-900">
                        <span class="text-mist-400 text-md px-1">uid <?php echo $row['user_id']; ?>:</span>
                        <?php
                        if ($row['deactivated'] == 'f'): ?> 
                            <a href="/visit?id=<?php echo $row['name']; ?>" class="text-lg text-blue-500 hover:underline">
                            <?php echo htmlspecialchars($row['emoji']);?>
                            <?php echo htmlspecialchars($row['name']);?>
                            </a>
                        <?php else: ?>
                            <span class="text-gray-500 italic cursor-default">Deactivated</span>
                        <?php endif; ?>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>

        <div class="flex gap-4 mt-2">
            <a href="/profile" class="text-blue-500 text-lg hover:underline">View My Profile</a>
            <span class="text-mist-500 cursor-default">|</span>
            <a href="logout.php" class="text-blue-500 text-lg hover:underline">Log out</a>
        </div>
    </main>

    <footer class="mb-5 mt-5 w-full text-center">
        <p>Copyright &copy; <span id="year"></span> greatname. All rights reserved.</p>
    </footer>

    <script src="year.js"></script>
</body>
</html>