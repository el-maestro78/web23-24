<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Civilian Login</title>
    <style>
        <?php include 'CSS/main.css'; ?>
    </style>
</head>
<body>
    <?php
        include("../model/config.php");
        // $dbconn = getDbConnection();
        include("../controller/login4all.php");
    ?>

    <div class="page">
        <div class="container">
            <div class="left_login_box">
                <div class="login">Login</div>
                <div class="box_text">
                    You must be loggined in, in order to access our page. This is important to avoid fake help requests and have an organised track of all requests.
                </div>
                <div class="box_text_2">Not a registered user?</div>
                <a href="signup.php" class="signup-link">Sign Up</a>
            </div>

            <div class="right_login_box">
                <div class="login_form">
                    <form action="authenticate.php" method="post">
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" required>
                        <div class="gradient-line"></div>

                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" required>
                        <div class="gradient-line"></div>

                        <button type="submit" class="button_input" id="submit">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const inputs = document.querySelectorAll('.login_form input');
        const lines = document.querySelectorAll('.gradient-line');

        inputs.forEach((input, index) => {
            input.addEventListener('focus', () => {
                lines[index].classList.add('active');
            });

            input.addEventListener('blur', () => {
                if (!input.value.trim()) { // Check if the input is empty
                    lines[index].classList.remove('active');
                }
            });
        });

        const usernameInput = document.getElementById('username');
        const passwordInput = document.getElementById('password');
        const submitButton = document.getElementById('submit');

        function checkInputs() {
            if (usernameInput.value !== '' && passwordInput.value !== '') {
                submitButton.classList.add('gradient-border');
            } else {
                submitButton.classList.remove('gradient-border');
            }
        }
        usernameInput.addEventListener('input', checkInputs);
        passwordInput.addEventListener('input', checkInputs);
    });
    </script>
</body>
</html>


