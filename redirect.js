let cookie = document.cookie;

if (!document.cookie.includes("loggedIn=1")) {
    console.log("Access denied. Redirecting to login...");
    window.location.href = "index.php";
}