<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <link rel='stylesheet' type='text/css' media='screen' href='news.css'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="icon" href="../favico/favicon.ico" type="image/x-icon">
        <title>Create News</title>
    </head>
    <body>
        <?php
            include '../../ini.php';
            include '../../check_login.php';
            include '../toolbar.php';
        ?>
        <div class="news_box">
            <div class="details">Add a new Announcement</div>
            <div class="form">
                <label for="fname" class=news_label>First Name</label>
                <input type="text" id="fname" class="news_input" required>
                <label for="lname" class=news_label>Last Name</label>
                <input type="text" id="lname" class="news_input" required>
                <label for="phonenr" class="news_label">Phone Number</label> <br>
                <input type="text" id="details">
                <div class="gradient-line"></div>
                <input type="submit" class="button_input" id="submit" value="Submit">
            </div>
        </div>
        <script>
            /*
            *
            * news_id SERIAL PRIMARY KEY,
            descr VARCHAR(255),
            base_id INTEGER REFERENCES base(base_id) NOT NULL,
            item_id INTEGER REFERENCES items(item_id) NOT NULL,
            req_id INTEGER REFERENCES requests(req_id) NOT NULL*/


            fetch('../../controller/admin/create_announcement.php')
            .then(response => response.json())
            .then(data => {
                data.success;//TODO
            })
            .catch(error => {
                console.error("Error while creating an announcement: ", error);
            });
        </script>
    </body>
</html>