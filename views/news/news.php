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
        <div>
            <div class="news_box">
                <div class="details">Add a new Announcement</div>
                <div class="form">
                    <label for="base" class=news_label>Select Base in Need</label>
                    <select id="base" class="news_input" required></select>
                    <div id="item-container">
                        <label for="item-1" class="item_label">Select Item</label>
                        <select id="item-1" class="news_input" required></select>
                    </div>
                    <button type="button" id="add-item-button" class="item_input">Add Another Item</button>
                    <label for="details" class="descr">Add more details</label> <br>
                    <textarea id="details" class="news_input" rows="5" cols="40" required></textarea>
                    <input type="submit" class="button_input" id="submit" value="Submit">
                </div>
            </div>
        </div>
        <script>
            let itemCount = 1; // Initial count for item selects
            let itemsData = []; // Global variable to store fetched item data

            function populateItemSelects(itemData) {
                const itemSelects = document.querySelectorAll('#item-container select');
                itemSelects.forEach(select => {
                    select.innerHTML = '';
                    itemData.forEach(item => {
                        const option = document.createElement('option');
                        option.value = item.item_id;
                        option.text = `${item.iname} - Quantity: ${item.quantity}`;
                        select.appendChild(option);
                    });
                });
            }
            document.getElementById('add-item-button').addEventListener('click', function() {
                itemCount++;
                const newItemLabel = document.createElement('label');
                newItemLabel.className = 'item_label';
                newItemLabel.setAttribute('for', `item-${itemCount}`);
                newItemLabel.textContent = 'Select Item';

                const newItemSelect = document.createElement('select');
                newItemSelect.id = `item-${itemCount}`;
                newItemSelect.className = 'news_input';
                newItemSelect.required = true;

                const container = document.getElementById('item-container');
                container.appendChild(newItemLabel);
                container.appendChild(newItemSelect);
                populateItemSelects(itemsData);
            });

            fetch('../../controller/admin/get_items_for_announc.php')
                .then(response => response.json())
                .then(data => {
                    if (data.items && data.bases) {
                        itemsData = data.items;
                        const baseSelect = document.getElementById('base');
                        data.bases.forEach(base => {
                            const option = document.createElement('option');
                            option.value = base.base_id;
                            option.text = `Base ${base.base_id}`;
                            baseSelect.appendChild(option);
                        });
                        populateItemSelects(itemsData);
                    } else {
                        console.error('Unexpected data format:', data);
                    }
                })
                .catch(error => {
                    console.error("Error while fetching data for announcement: ", error);
                });

            function submit_news() {
                const base = baseInput.value;
                const details = detailsInput.value;
                const itemSelects = document.querySelectorAll('#item-container select');
                const items = Array.from(itemSelects).map(select => select.value);

                const params = new URLSearchParams();
                params.append('details', details);
                params.append('item', JSON.stringify(items));
                params.append('base', base);

                fetch('../../controller/admin/create_announcement.php', {
                    method: 'POST',
                    body: params
                })
                .then(response => response.json())
                .then(data => {
                    if (data.created) {
                        alert('Created successfully');
                    } else {
                        alert('Error: ' + data.array) //data.error
                    }
                })
                .catch(error => console.error('Error submitting news:', error));
            }

            const baseInput = document.getElementById('base');
            const detailsInput = document.getElementById('details');
            const submit = document.getElementById('submit');
            submit.addEventListener('click', function (event) {
                event.preventDefault();
                submit_news();
            });

        </script>
    </body>
</html>