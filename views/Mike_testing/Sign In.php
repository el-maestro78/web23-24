<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Civilian registration</title>
</head>
<body>
    <h2>Registration</h2>
    <form action="register_user.php" method="post">
        <label for="username">username:</label>
        <input type="text" id="username" name="username" required><br><br>
        <label for="password">password:</label>
        <input type="password" id="password" name="password" required><br><br>
        <label for="full_name">full_name:</label>
        <input type="text" id="full_name" name="full_name" required><br><br>
        <label for="phone_number">phone_number:</label>
        <input type="text" id="phone_number" name="phone_number" required><br><br>
        <button type="submit">submit</button>
    </form>
</body>
</html>
