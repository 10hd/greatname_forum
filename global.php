<?php
session_start();
include 'db.php';

if (!isset($_SESSION["username"])) {
    header("Location: /");
    exit();
}

$query = "SELECT m.content, m.sent_at, a.name, a.emoji FROM global_chat m JOIN accounts a ON m.user_id = a.user_id WHERE m.is_deleted = false AND m.chat_id = 0 ORDER BY m.sent_at ASC LIMIT 100";
$result = pg_query($dbconn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="shortcut icon" href="coliseum.svg" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <title>greatname.net | Global</title>
</head>
<body class="bg-black text-white flex flex-col min-h-screen items-center m-0 p-0 h-full">
    <header class="mt-5">
        <h1 class="text-4xl font-bold">great<span class="text-[#6674b2]">name</span>.net</h1>
    </header>

    <main class="flex flex-col justify-center flex-1 items-center w-full px-4">
        <div class="text-center mb-2">
            <h2 class="text-3xl font-bold mt-6">Global</h2>
        </div>
        <div class="flex-1 w-full mt-2 border border-zinc-800 rounded-t-xl overflow-y-auto p-4 flex flex-col gap-3 h-[500px]" id="chatBox">
            <?php while ($row = pg_fetch_assoc($result)): ?>
            <div class="flex flex-col">
                <div class="flex">
                    <a href="/visit?id=<?php echo $row['name']; ?>" class="text-md font-bold text-zinc-500 mb-1 hover:text-blue-500 hover:underline"><?php echo htmlspecialchars($row['emoji'] . ' ' . $row['name']); ?></a>
                    <span class="text-sm mt-0.5 text-zinc-600 ml-2"><?php $date = new DateTime($row['sent_at']); echo $date->format('d/m/Y H:i'); ?></span>
                </div>
                <p class="bg-zinc-800 p-2 rounded-lg text-md max-w-max"><?php echo htmlspecialchars($row['content']); ?></p>
            </div>
            <?php endwhile; ?>
        </div>

        <form action="message.php" method="POST" class="w-full flex gap-2 p-3 bg-zinc-900 border-x border-b border-zinc-800 rounded-b-xl">
            <input type="text" name="message" placeholder="I just wanted to let you know..." class="flex-1 bg-black border border-zinc-700 rounded-full px-4 py-2 focus:outline-none" required>
            <button type="submit" class="bg-[#6674b2] hover:bg-[#5561a3] text-white px-6 py-2 rounded-full font-bold transition-transform active:scale-95 hover:cursor-pointer">send</button>
        </form>

        <div class="flex gap-4 mt-6">
            <a href="/dashboard" class="text-blue-500 text-lg hover:underline">Back</a>
            <span class="text-mist-500 cursor-default">|</span>
            <a href="logout.php" class="text-blue-500 text-lg hover:underline">Log out</a>
        </div>
    </main>

    <footer class="mb-5 mt-5 w-full text-center">
        <p>Copyright &copy; <span id="year"></span> greatname. All rights reserved.</p>
    </footer>

    <script>
        const chatBox = document.querySelector('.overflow-y-auto');
        chatBox.scrollTop = chatBox.scrollHeight;
    </script>
    <script src="year.js"></script>
</body>
</html>