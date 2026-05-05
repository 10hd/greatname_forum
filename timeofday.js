const hour = new Date().getHours();
let greeting;

if (hour >= 5 && hour < 12) {
    greeting = "Good morning";
} else if (hour >= 12 && hour < 20) {
    greeting = "Hello";
} else {
    greeting = "Good night";
}

document.getElementById("date").textContent = greeting;