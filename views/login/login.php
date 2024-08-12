<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <link rel='stylesheet' type='text/css' media='screen' href='../main.css'>
    <link rel='stylesheet' type='text/css' media='screen' href='login.css'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Login</title>
</head>
<?php
//    include("../model/config.php");
//    $dbconn = getDbConnection();
//    include("../controller/login4all.php")
?> 
<body>
    <div class="page">
    <div class="container">

        <div class="left_box">
        <div class="login">Login</div>
        <div class="box_text">You must be loggined in, in order to access our page. This is important to avoid fake help requests and have an organised track of all requests.</div>
        <div class="box_text_2">Not a registered user?</div>
        <a href="../signup/signup.php" class="signup-link">Sign Up</a>
        </div>

        <div class="right_box">
        <div class="form">
            <label for="email">Email</label>
            <input type="email" id="email">
            <div class="gradient-line"></div>

            <label for="password">Password</label>
            <input type="password" id="password">
            <div class="gradient-line"></div>

            <input type="submit" class="button_input" id="submit" value="Submit">
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
    });
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const submitButton = document.getElementById('submit');
    function checkInputs() {

            if (emailInput.value !== '' && passwordInput.value !== '') {
                submitButton.classList.add('gradient-border');
            } else {
                submitButton.classList.remove('gradient-border');
            }
        }
      emailInput.addEventListener('input', checkInputs);
      passwordInput.addEventListener('input', checkInputs);
    </script>

</body>
</html>