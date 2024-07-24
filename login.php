<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div id="error-toast" class="error-toast"></div>
    <div class="container">
        <div class="login">
            <form action="login-process.php" method="post" id="login-form">
                <h2>Login</h2>
                <hr>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" placeholder="Username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Password" required>
                    <span class="show-password" id="show-password">Show Password</span>
                </div>
                <div class="form-group">
                    <button type="submit">Login</button>
                </div>
            </form>
        </div>
        <div class="text">
            <h1>Ayo kita menuju <span>Kebaikan</span></h1>
            <img src="masjid.jpg" alt="" class="">
        </div>
    </div>

    <script>
        const passwordInput = document.getElementById("password");
        const showPasswordButton = document.getElementById("show-password");
        const errorToast = document.getElementById("error-toast");

        showPasswordButton.addEventListener("click", () => {
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                showPasswordButton.textContent = "Hide Password";
            } else {
                passwordInput.type = "password";
                showPasswordButton.textContent = "Show Password";
            }
        });

        const urlParams = new URLSearchParams(window.location.search);
        const errorMessage = urlParams.get("error");

        if (errorMessage) {
            errorToast.textContent = errorMessage;
            errorToast.style.display = "block";

            setTimeout(() => {
                errorToast.style.display = "none";
            }, 3000);
        }

        const successMessage = urlParams.get("success");

        if (successMessage) {
            errorToast.textContent = successMessage;
            errorToast.style.backgroundColor = "#00cc00";
            errorToast.style.display = "block";

            setTimeout(() => {
                errorToast.style.display = "none";
            }, 3000);
        }

        
    </script>
</body>
</html>
