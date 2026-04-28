// get username from session storage
const savedName = sessionStorage.getItem("username");

//if there is username then put the span with id "username" to the saved username
if (savedName) {
    document.getElementById("username").textContent = savedName;
} else {
    alert("No username found in session storage. Your session may have expired.");
    window.location.href = "index.html";
}