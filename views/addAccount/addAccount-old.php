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
        include '../toolbar.php';
    ?>
     <div class="page">
        <div class="container">

        <div class="left_box">
        <div class="rescAddAccount">Rescuer's Credentials </div>
        <div class="form">
            <label for="fname" class=left_label>First Name</label>
            <input type="text" id="fname" class="left_input" required>
            <div class="gradient-line"></div>

            <label for="lname" class=left_label>Last Name</label>
            <input type="text" id="lname" class="left_input" required>
            <div class="gradient-line"></div>

            <label for="username" class=left_label>Username</label>
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
            </div>
            <div class="gradient-line"></div>

            <label for="conf_password" class=left_label>Confirm Password</label>
            <div class="password_container">
             <input type="password" id="conf_password" class="left_input" required>
              <button type="button" class="password_icon" onclick="showPassword('conf_password','conf_pass_img')">
              <img src="../media/hide_pass.png" alt="Show Password" id="conf_pass_img">
              </button>
            </div>
            <div class="gradient-line"></div>
        </div>
        </div>

        <div class="right_box">
        <div class="details">Location and Contact Details</div>
        <div class="form">

            <label for="country">Country</label> <br>
            <input type="text" id="country">
            <div class="gradient-line"></div>

            <label for="city">City</label> <br>
            <input type="text" id="city">
            <div class="gradient-line"></div>

            <label for="street">Street n' Number</label> <br>
            <input type="text" id="street">
            <div class="gradient-line"></div>

            <label for="zcode">Zip Code</label> <br>
            <input type="text" id="zcode">
            <div class="gradient-line"></div>

            <label for="phonenr">Phone Number</label> <br>
            <input type="text" id="phonenr">
            <div class="gradient-line"></div>

            <input type="submit" class="button_input" id="submit" value="Submit">
        </div>
        </div>

    </div>
    </div>

    <script>
    var PREVENT_SUBMIT = true;
    document.addEventListener('DOMContentLoaded', function() {
      const inputs = document.querySelectorAll('.form input');
      const lines = document.querySelectorAll('.gradient-line');
      /*
      inputs.forEach((input, index) => {
        input.addEventListener('focus', () => {
          lines[index].classList.add('active');
        });

        input.addEventListener('blur', () => {
          if (!input.value.trim()) { // Check if the input is empty
            lines[index].classList.remove('active');
          }
        });

      });// */
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
    const countryInput = document.getElementById('country');
    const cityInput = document.getElementById('city');
    const streetInput= document.getElementById('street');
    const zcodeInput= document.getElementById('zcode');
    const phonenrInput = document.getElementById('phonenr');
    const submitButton = document.getElementById('submit');
    function checkInputs() {
        if (emailInput.value !== '' &&
            passwordInput.value !== '' &&
            fnameInput.value !== '' &&
            lnameInput.value !== '' &&
            usernameInput.value !== '' &&
            confPassInput.value !== '' &&
            countryInput.value !== '' &&
            cityInput.value !== '' &&
            streetInput.value !== '' &&
            zcodeInput.value !== '' &&
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
    emailInput.addEventListener('input', checkInputs);
    passwordInput.addEventListener('input', checkInputs);
    fnameInput.addEventListener('input', checkInputs);
    lnameInput.addEventListener('input', checkInputs);
    usernameInput.addEventListener('input', checkInputs);
    confPassInput.addEventListener('input', checkInputs);
    countryInput.addEventListener('input', checkInputs);
    cityInput.addEventListener('input', checkInputs);
    streetInput.addEventListener('input', checkInputs);
    zcodeInput.addEventListener('input', checkInputs);
    phonenrInput.addEventListener('input', checkInputs);
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
    function getCoordinates() {
        const country = countryInput.value;
        const city = cityInput.value;
        const street = streetInput.value;
        const zcode = zcodeInput.value;
        const params = new URLSearchParams();
        params.append('country', country);
        params.append('city', city);
        params.append('street', street);
        params.append('zcode', zcode);
        /*
         `country=${encodeURIComponent(country)}&
          city=${encodeURIComponent(city)}&
          street=${encodeURIComponent(street)}&
          zcode=${encodeURIComponent(zcode)}` */
        return fetch('../../controller/all_users/location_to_coord.php', {
            method: 'POST',
            body: params
        }).then(response => response.json()
        ).then(data => {
            if (data.error) {
                alert('An error occurred: ' + data.error);
                return [null, null];
            } else {
                const longitude = data.longitude;
                const latitude = data.latitude;
                return [longitude, latitude];
            }
        }).catch(error => {
            console.error('Error:', error);
            alert('An error occurred, please try again later.');
            return [null, null];
        });
    }
    function submitCredentials() {
        const conf_pass = confPassInput.value;
        const password = passwordInput.value;
        if (!PREVENT_SUBMIT){
            alert('Something wrong with the input');
            return;
        }
        if(password !== conf_pass){
            alert('Passwords must match');
            return;
        }
        let long = null;
        let lat = null;

        getCoordinates().then(([longitude, latitude]) => {
            if (longitude === null || latitude === null) {
                alert('Doesn\'t return coordinates');
            return;
            }
        });


        const name = fnameInput.value;
        const surname = lnameInput.value;
        const username = usernameInput.value;
        const email = emailInput.value;
        const phone = phonenrInput.value;
        const params = new URLSearchParams();
        params.append('name', name);
        params.append('surname', surname);
        params.append('username', username);
        params.append('pass', password);
        params.append('email', email);
        params.append('phone', phone);
        params.append('long', longitude);
        params.append('lat', latitude);
        /*
        `name=${encodeURIComponent(name)}&
              surname=${encodeURIComponent(surname)}&
              username=${encodeURIComponent(username)}&
              password=${encodeURIComponent(password)}&
              email=${encodeURIComponent(email)}&
              phone=${encodeURIComponent(phone)}&
              long=${encodeURIComponent(long)}&
              lat=${encodeURIComponent(lat)}`
        * */
        fetch('../../controller/admin/create_rescuer_account.php', {
            method: 'POST',
            body: params
        }).then(response => response.json()
        ).then(data => {
            if(data.created){
                alert('Account created successfully!');
            }else{
                alert('Failed to create account: ' + data.message);
            }
        }).catch(error => {
            console.error('Error:', error);
            alert('An error occurred, please try again later.');
        });
    }
    submitButton.addEventListener('click', function(event) {
        event.preventDefault();
        submitCredentials();
    });

    </script>
</body>
</html>