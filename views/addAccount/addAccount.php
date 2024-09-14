<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <link rel='stylesheet' type='text/css' media='screen' href='addAccount.css'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="icon" href="../favico/favicon.ico" type="image/x-icon">
    <title>Create Account</title>
</head>
<body>
    <?php
        include '../../ini.php';
        include '../../check_login.php';
        include '../toolbar.php';
    ?>
     <div class="page">
        <div class="container">

            <div class="left_box">
            <div class="rescAddAccount">Rescuer's Credentials </div>
            <div class="form">
                <label for="uname" class=left_label>Username</label>
                <input type="text" id="uname" class="left_input" required>
                <div class="gradient-line"></div>

                <label for="email" class=left_label>Email</label>
                <input type="email" id="email" class="left_input" required>
                <div class="gradient-line"></div>

                <label for="password" class=left_label>Password</label>
                <div class="password_container">
                 <input type="password" id="password" class="left_input" required>
                  <button type="button" class="password_icon" onclick="showPassword('password','pass_img')">
                  <img src="../media/hide_pass.png" alt="Show Password" id="pass_img">
                  </button>
            </div><div class="gradient-line"></div>

                <label for="conf_password" class=left_label>Confirm Password</label>
                <div class="password_container">
                 <input type="password" id="conf_password" class="left_input" required>
                  <button type="button" class="password_icon" onclick="showPassword('conf_password','conf_pass_img')">
                  <img src="../media/hide_pass.png" alt="Show Password" id="conf_pass_img">
                  </button>
                </div><div class="gradient-line"></div>
            </div>
        </div>
         <div class="right_box">
            <div class="details">Location and Contact Details</div>
                <div class="form">

                <label for="fname" class=left_label>First Name</label>
                <input type="text" id="fname" class="left_input" required>
                <div class="gradient-line"></div>

                <label for="lname" class=left_label>Last Name</label>
                <input type="text" id="lname" class="left_input" required>
                <div class="gradient-line"></div>

                    <label for="phonenr">Phone Number</label> <br>
                    <input type="text" id="phonenr">
                    <div class="gradient-line"></div>
                    <label for="Vehicle" class="left_label">Select Vehicle</label>
                    <select id="Vehicle" class="veh_input" required>
                    </select>
                    <input type="submit" class="button_input" id="submit" value="Submit">
                </div>
            </div>
        </div>
    </div>

    <script>
    const vehicleSelect = document.getElementById('Vehicle');
    function populate_vehicles(){
        fetch('../../controller/admin/fetch_available_vehicles.php')
        .then(response=>response.json())
        .then(data=>{
            if (data.exists) {
                vehicleSelect.innerHTML = '';
                data.vehicles.forEach(veh => {
                    const option = document.createElement('option');
                    option.value = veh.veh_id;
                    option.textContent = `Vehicle ID: ${veh.veh_id}`;
                    vehicleSelect.appendChild(option);
                });

            }else {
                const option = document.createElement('option');
                option.value = '';
                option.textContent = 'No vehicles available';
                option.disabled = true;
                vehicleSelect.appendChild(option);
                vehicleSelect.style.display = 'none';
            }
        })
        .catch(error=>console.log('Error fetching available vehicles', error))
    }
    populate_vehicles();

    var PREVENT_SUBMIT = true;
    document.addEventListener('DOMContentLoaded', function() {
      const inputs = document.querySelectorAll('.form input');
      const lines = document.querySelectorAll('.gradient-line');
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
    const fnameInput = document.getElementById('fname');
    const lnameInput = document.getElementById('lname');
    const usernameInput = document.getElementById('uname');
    const confPassInput = document.getElementById('conf_password');
    const phonenrInput = document.getElementById('phonenr');
    const submitButton = document.getElementById('submit');
    function checkInputs() {
        if (emailInput.value !== '' &&
            passwordInput.value !== '' &&
            fnameInput.value !== '' &&
            lnameInput.value !== '' &&
            usernameInput.value !== '' &&
            confPassInput.value !== '' &&
            phonenrInput.value !== '' &&
            submitButton.value !== '') {
                submitButton.classList.add('gradient-border');
                PREVENT_SUBMIT = true;
        }else{
            submitButton.classList.remove('gradient-border');
            PREVENT_SUBMIT = false;
        }
        if((phonenrInput.value).length !== 10){
            PREVENT_SUBMIT = true;
        }

    }

    function showPassword(inputID, imgID) {var x = document.getElementById(inputID);var y = document.getElementById(imgID)
        if (x.type === "password") {
            x.type = "text";
            y.src="../media/show_pass.png"
            y.alt="Hide Password"
        } else {
            x.type = "password";
            y.src="../media/hide_pass.png"
            y.alt="Show Password"
        }
    }
    function submitCredentials() {
        const conf_pass = confPassInput.value;
        const password = passwordInput.value;
        const name = fnameInput.value;
        const surname = lnameInput.value;
        const username = usernameInput.value;
        const email = emailInput.value;
        const phone = phonenrInput.value;
        const vehicle = vehicleSelect.value;
        const params = new URLSearchParams();
        if (!PREVENT_SUBMIT){
            alert('Something wrong with the input.');
            return;
        }
        if(password !== conf_pass){
            alert('Passwords must match');
            return;
        }
        if(phone.length !== 10){
            alert('Phone is not correct');
            return;
        }
        params.append('name', name);
        params.append('surname', surname);
        params.append('username', username);
        params.append('pass', password);
        params.append('email', email);
        params.append('phone', phone);
        params.append('vehicle', vehicle);
        fetch('../../controller/admin/create_rescuer_account.php', {
            method: 'POST',
            body: params
        }).then(response => response.json()
        ).then(data => {
            if(data.created){
                alert('Account created successfully!');
            }else if(data.username_exists){
                alert('Username ' + username + ' already exists');
            }else if(data.email_exists){
                alert('Email ' + email + ' already exists');
            }else{
                alert('Failed to create account:' + data.error);
            }
        }).catch(error => {
            console.error('Error:', error);
            alert('An error occurred, please try again later.');
        });
    }
    submitButton.addEventListener('click', function(event) {
        event.preventDefault();
        if(vehicleSelect.value === ''){
            alert('Not available vehicle for new rescuers');
        }else{
            submitCredentials();
        }
    });

    </script>
</body>
</html>