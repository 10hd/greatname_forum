<?php
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch ($request) {
    case '':
    case '/':
        require __DIR__ . '/register.php';
        exit();

    case '/dashboard':
        require __DIR__ . '/dashboard.php';
        exit();

    case '/profile':
        require __DIR__ . '/profile.php';
        exit();

    case '/visit':
        require __DIR__ . '/visit.php';
        exit();

    default:
        http_response_code(404);
        require __DIR__ . '/404.php';
}
?>