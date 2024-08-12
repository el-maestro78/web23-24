<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <link rel='stylesheet' type='text/css' media='screen' href='../main.css'>
    <link rel='stylesheet' type='text/css' media='screen' href='signup.css'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Sign Up</title>
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
        <div class="signup">Sign Up</div>
        <div class="left_form">
            <label for="fname" class=left_label>First Name</label>
            <input type="text" id="fname" class="left_input" required>
            <div class="gradient-line"></div>
        
            <label for="lname" class=left_label>Last Name</label>
            <input type="text" id="lname" class="left_input" required>
            <div class="gradient-line"></div>

            <label for="email" class=left_label>Email</label>
            <input type="email" id="email" class="left_input" required>
            <div class="gradient-line"></div>

            <label for="password" class=left_label>Password</label>
            <input type="password" id="password" class="left_input" required>
            <div class="gradient-line"></div>
            <input type="checkbox" onclick="showPassword('password')">Show

            <label for="password" class=left_label>Confirm Password</label>
            <input type="password" id="conf_password" class="left_input" required>
            <div class="gradient-line"></div>
            <input type="checkbox" onclick="showPassword('conf_password')">Show
        </div>
        </div>

        <div class="right_box">
        <div class="details">Lacation and Contact Details</div>
        <div class="right_form">
            <label for="street">Street</label>
            <input type="text" id="street">
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
      const inputs = document.querySelectorAll('.form input');
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

      function showPassword(inputId) {
        var x = document.getElementById(inputId);
        if (x.type === "password") {
          x.type = "text";
        } else {
          x.type = "password";
      }
    }
    </script>

</body>
</html>