<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Civilian login </title>
</head>
<body>
    <h2>Σύνδεση</h2>
    <form action="authenticate.php" method="post">
        <label for="username">Όνομα Χρήστη:</label>
        <input type="text" id="username" name="username" required><br><br>
        
	<label for="password">Κωδικός Πρόσβασης:</label>
        <input type="password" id="password" name="password" required><br><br>
        
	<button type="submit">Login</button>
    </form>
</body>
</html>


