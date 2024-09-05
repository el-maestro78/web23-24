<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <link rel='stylesheet' type='text/css' media='screen' href='civ_news.css'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="icon" href="../favico/favicon.ico" type="image/x-icon">
        <title>News</title>
    </head>
    <body>
        <?php
            include '../../ini.php';
            include '../../check_login.php';
            include '../toolbar.php';
        ?>
        <div class="container">
        <h2>News List</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th>Base ID</th>
                    <th>Item ID</th>
                </tr>
            </thead>
            <tbody id="table-body">
            </tbody>
        </table>
    </div>
        <script>
            const params = new URLSearchParams();
            params.append('details', '');
            fetch('../../controller/civilian/fetch_news.php', {
                method: 'POST',
                body: params
            })
            .then(response => response.json())
            .then(data =>{
                const tableBody = document.getElementById('table-body');
                data.forEach(announc =>{
                    let title = announc.title;
                    let descr = announc.descr;
                    let date = announc.date;
                    let base_id  = announc.base_id;
                    let item_name = announc.item_name;
                    let row = document.createElement('tr');

                    row.innerHTML = `
                        <td>${title}</td>
                        <td>${descr}</td>
                        <td>${date}</td>
                        <td>${base_id}</td>
                        <td>${item_name}</td>
                    `;

                tableBody.appendChild(row);
                })
            })
            .catch(error => console.error('Error fetching news:', error))
        </script>
    </body>
</html>