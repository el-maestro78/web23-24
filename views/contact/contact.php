<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="icon" href="../../views/favico/favicon.ico" type="image/x-icon">
    <title>Contact Us</title>
</head>
<style>
    .title{
        display: flex;
        justify-content: center;
    }
    .member {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-top: 10px;
    }
    .member-info {
        display: flex;
        flex-direction: column;
    }
    .member-info div {
        margin-bottom: 5px;
    }
    .member-email a {
        color: inherit;
        text-decoration: none;
    }
    .member-email a:hover {
        text-decoration: underline;
    }
    img{
        margin-left: 5px;
        border-radius: 50%;
        max-width: 150px;
        height: auto;
    }
    .new-issue-btn{
        display: flex;
        justify-content: center;
        align-content: center;
        margin: 0 auto;
        background-color: #2d4931;
        color: white;
        border: none;
        padding: 10px;
        border-radius: 5px;
        font-size: 18px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
    .new-issue-btn:hover {
        background-color: #28a745;
    }
</style>
<body>
    <?php
        header('Cache-Control: max-age=604800');
        include '../../ini.php';
        include '../../check_login.php';
        include '../toolbar.php';
    ?>
    <h1 class="title">Project Team</h1>
    <div class="team">
        <div class="member">
            <img src="https://avatars.githubusercontent.com/u/59723723?v=4" href="https://github.com/TheodoreGiannak" alt="Theodore's Github Pic">
            <div class="member-info">
                <div class="member-name">Γιαννακόπουλος Θεόδωρος</div>
                <div class="member-am">1072573</div>
                <div class="member-email">
                    <a href="mailto:up1072573@ac.upatras.gr">up1072573@ac.upatras.gr</a>
                </div>
            </div>
        </div>
        <div class="member">
            <img src="https://avatars.githubusercontent.com/u/90005222?v=4" href="https://github.com/el-maestro78" alt="Kostas' Github Pic">
            <div class="member-info">
                <div class="member-name">Ζαχουλίτης Κωνσταντίνος Γεώργιος</div>
                <div class="member-am">1072578</div>
                <div class="member-email">
                    <a href="mailto:up1072578@ac.upatras.gr">up1072578@ac.upatras.gr</a>
                </div>
            </div>
        </div>
        <div class="member">
            <img src="https://avatars.githubusercontent.com/u/132392065?v=4" href="https://github.com/MikeChoco01" alt="Mike's Github Pic">
            <div class="member-info">
                <div class="member-name">Σοκολάκης Μιχαήλ</div>
                <div class="member-am">1072589</div>
                <div class="member-email">
                    <a href="mailto:up1072589@ac.upatras.gr">up1072589@ac.upatras.gr</a>
                </div>
            </div>
        </div>
    </div>
    <p></p>
    <button class="new-issue-btn" onclick="window.location.href='https://github.com/el-maestro78/web23-24/issues/new';">
        Click here if you found an issue in the site
    </button>
</body>
</html>
