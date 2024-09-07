<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <link rel="preload" href='civ_news.css' as="style" onload="this.rel='stylesheet'">
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

            fetch('../../controller/civilian/fetch_news.php', {
                method: 'POST'
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
                    row.setAttribute('data-item', item_name);
                    row.setAttribute('data-base', base_id);
                    row.innerHTML = `
                        <td>${title}</td>
                        <td>${descr}</td>
                        <td>${date}</td>
                        <td>${base_id}</td>
                        <td>${item_name}</td>
                    `;
                    row.addEventListener('click', function() {
                        let want_make_offer = confirm('Do you want to make an offer for this product? You will be redirected form page');
                        if(want_make_offer){
                            window.location.href = `../offers/new_offer.php?
                            item=${encodeURIComponent(this.getAttribute('data-item'))}&
                            base=${encodeURIComponent(this.getAttribute('data-base'))}`;
                        }
                    });
                tableBody.appendChild(row);
                });
            })
            .catch(error => console.error('Error fetching news:', error))
        </script>
    </body>
</html>