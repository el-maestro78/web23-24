<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <link rel='stylesheet' type='text/css' media='screen' href='new_request.css'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="icon" href="../favico/favicon.ico" type="image/x-icon">
        <title>New Request</title>
    </head>
    <body>
        <?php
            include '../../ini.php';
            include '../../check_login.php';
            include '../toolbar.php';
        ?>
        <div>
            <div class="news_box">
                <div class="details">Make a new Request</div>
                <div class="form">
                    <!--
                    <label for="title" class=news_label>First Name</label>
                    <input type="text" id="title" class="text_input" required>
                    -->
                    <div id="category-container">
                        <label for="categ" class="req_label">Select Category</label>
                        <select id="categ" class="item_input" required></select>
                    </div>
                    <div id="item-search-container">
                        <label for="item-search" class="req_label">Search for Item</label>
                        <input type="text" id="item-search" class="item_input form-control" placeholder="Search for items...">
                    </div>
                    <div id="item-container">
                        <label for="item-1" class="req_label">Select Item</label>
                        <select id="item-1" class="item_input" required></select>
                    </div>
                    <button type="button" id="add-item-button" class="item_btn">Add Another Item</button>
                    <input type="submit" class="button_input" id="submit" value="Submit">
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/gh/xcash/bootstrap-autocomplete@v2.3.7/dist/latest/bootstrap-autocomplete.min.js"></script>
        <script>

            let itemCount = 1;
            let itemsData = [];
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
                newItemLabel.className = 'req_label';
                newItemLabel.setAttribute('for', `item-${itemCount}`);
                newItemLabel.textContent = 'Select Item';

                const newItemSelect = document.createElement('select');
                newItemSelect.id = `item-${itemCount}`;
                newItemSelect.className = 'item_input';
                newItemSelect.required = true;

                const container = document.getElementById('item-container');
                container.appendChild(newItemLabel);
                container.appendChild(newItemSelect);
                populateItemSelects(itemsData);
            });
            function populateCategorySelects(categoryData) {
                const categorySelect = document.getElementById('categ');
                Object.entries(categoryData).forEach(([category_id, category]) => {
                    const option = document.createElement('option');
                    option.value = category_id;
                    option.text = category;
                    categorySelect.appendChild(option);
                });
            }
            fetch('../../controller/admin/fetch_items.php')
                .then(response => response.json())
                .then(data => {
                    itemsData = Object.values(data.items);
                    populateItemSelects(itemsData);
                    populateCategorySelects(data.categories);
                })
                .catch(error => {
                    console.error("Error while fetching data for request: ", error);
                });

            function submit_request() {

            }

        </script>
    </body>
</html>