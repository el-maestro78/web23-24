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
    <link rel="icon" href="../favico/favicon.ico" type="image/x-icon">
    <title>Login</title>
</head>

<body>
<?php include '../../ini.php'; ?>
    <div class="page">
        <div class="container">

            <div class="left_box">
                <div class="login">Login</div>
                <div class="box_text">You must be logged in, in order to access our page. This is important to avoid fake help requests and have an organised track of all requests.</div>
                <div class="box_text_2">Not a registered user?</div>
                <a href="../signup/civilian_signup.php" class="signup_link">Sign Up</a>
            </div>

            <div class="right_box">
                <div class="form">
                    <label for="email">Email</label>
                    <input type="email" id="email">
                    <div class="gradient-line"></div>

                    <label for="password">Password</label>
                    <div class="password_container">
                        <input type="password" id="password" class="left_input" required>
                        <button type="button" class="password_icon" onclick="showPassword('password','pass_img')">
                            <img src="../media/hide_pass.png" alt="Show Password" id="pass_img">
                        </button>
                    </div>
                    <div class="gradient-line"></div>
                    <input type="submit" class="button_input" id="submit" value="Submit">
                </div>
            </div>
        </div>
    </div>

    <script defer>
    document.addEventListener('DOMContentLoaded', function() {
      const inputs = document.querySelectorAll('.form input');
      const lines = document.querySelectorAll('.form .gradient-line');

      inputs.forEach((input, index) => {
        const line = lines[index];
        if (line) {
            input.addEventListener('focus', () => {
                line.classList.add('active');
            });

            input.addEventListener('blur', () => {
                if (!input.value.trim()) {
                    line.classList.remove('active');
                }
            });
        }
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

      function showPassword(inputID, imgID) {
        var x = document.getElementById(inputID);
        var y = document.getElementById(imgID)
        if (x.type === "password") {
          x.type = "text";
          y.src="../media/hide_pass.png"
          y.alt="Hide Password"
        } else {
          x.type = "password";
          y.src="../media/show_pass.png"
          y.alt="Show Password"
      }
    }
    submitButton.addEventListener('click', function(event) {
        event.preventDefault();
        submitCredentials();
    });

    function submitCredentials() {
        const email = emailInput.value;
        const password = passwordInput.value;

        fetch('../../controller/all_users/check_cred.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ email: email, password: password })
        })
        .then(response => response.json())
        .then(data => {
            console.log(data)
            if (data.exists) {
                window.location.href = "../home_page.php";
            } else {
                alert('Invalid credentials, please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred, please try again later.');
        });
    }
    </script>

</body>
</html>