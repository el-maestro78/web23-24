<!DOCTYPE html>
<html lang="en">
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
        <link rel="icon" href="../../views/favico/favicon.ico" type="image/x-icon">
        <title>About us</title>
    </head>
    <style>
        #content{
            margin: 20px;
            font-family: Arial, sans-serif;
        }
        #content img {
            justify-content: center;
            max-width: 70%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 5px;
        }
    </style>
    <body>
        <?php
            header('Cache-Control: max-age=604800');
            include '../../ini.php';
            include '../../check_login.php';
            include '../toolbar.php';
            ?>
        <div id="content"></div>
        <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
        <script>
            fetch('../../README.md')
            .then(response => response.text())
            .then(text => {
                document.getElementById('content').innerHTML = marked.parse(text);
            });
        </script>
    </body>
</html>