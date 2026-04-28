// input fields for username and password
const usernameField = document.getElementById("usernameInput");
const passwordField = document.getElementById("passwordInput");

// login and register buttons
const loginButton = document.getElementById("loginButton");
const registerButton = document.getElementById("registerButton");

const sleep = (ms) => new Promise(resolve => setTimeout(resolve, ms));

// username field typewrite effect
async function usernamePlaceholder() {
    const placeholderUsername = ["xX_CoolName1234_Xx", "super_AwesomeUSERNAME1111", "ILoveEveryone_guy", "admin123_official", "skidkid_1337", "D0ntSt34lMyN4mePls"];

    await sleep(Math.random() * 500);
    while (true) {
        for (const i in placeholderUsername) {
            usernameFinal = placeholderUsername[Math.random() * placeholderUsername.length | 0];
            for (let i = 0; i <= usernameFinal.length; i++) {
                usernameField.placeholder = usernameFinal.slice(0, i);
                await sleep(100);
            }
            await sleep(500);
            for (let i = usernameFinal.length; i >= 0; i--) {
                usernameField.placeholder = usernameFinal.slice(0, i);
                await sleep(100);
            }
            await sleep(500);
        }
    }
};

// password field typewrite effect
async function passwordPlaceholder() {
    const placeholderPassword = ["secyurePassword_0123", "ThisIsNotThePasswordYoureLookingFor", "password123456789", "dog2", "ilovepizza123", "MeowMrrpMrowMeow"];

    await sleep(Math.random() * 500);
    while (true) {
        for (const i in placeholderPassword) {
            passwordFinal = placeholderPassword[Math.random() * placeholderPassword.length | 0];
            for (let i = 0; i <= passwordFinal.length; i++) {
                passwordField.placeholder = passwordFinal.slice(0, i);
                await sleep(100);
            }
            await sleep(500);
            for (let i = passwordFinal.length; i >= 0; i--) {
                passwordField.placeholder = passwordFinal.slice(0, i);
                await sleep(100);
            }
            await sleep(500);
        }
    }
};

usernamePlaceholder();
passwordPlaceholder();

// event listener for login button
loginButton.addEventListener("click", () => {
    usernameField.value
    const username = usernameField.value;
    const password = passwordField.value;
    //console.log("%cLogin attempt\n%cUsername: %s\nPassword: %s", "color: #f9554f", "color: white", username, password);

    const savedUsername = sessionStorage.getItem("username");
    const savedPassword = sessionStorage.getItem("password");

    if (username && password) {
        if (username === savedUsername && password === savedPassword) {
            window.location.href = "dashboard.html";
        } else {
            alert("Invalid username or password.");
        }
    } else {
        alert("Please enter both a username and password.");
    }
});

// event listener for register button
registerButton.addEventListener("click", () => {
    const username = usernameField.value;
    const password = passwordField.value;
    //console.log("%cRegister attempt\n%cUsername: %s\nPassword: %s", "color: red", "color: white", username, password);

    if (username && password) {
        sessionStorage.setItem("username", username);
        sessionStorage.setItem("password", password);
        window.location.href = "dashboard.html";
    } else {
        alert("Please enter both a username and password.");
    }
});