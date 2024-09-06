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
                    <label for="people" class="req_label">People in Need</label>
                    <input type="number" id="people" class="insert_people" required step="1" min="1" max="20">
                    <div id="category-container">
                        <label for="categ" class="req_label">Select Category</label>
                        <select id="categ" class="item_input form-select" required></select>
                    </div>
                    <div class="wrapper">
                        <div class="content">
                            <div class="search">
                                <label class="req_label" for="item-1">Add New Item</label>
                                <i class="uil uil-search"></i>
                                <input id="item-1" spellcheck="false" type="text" placeholder="Search for an item...">
                            </div>
                            <ul class="options"></ul>
                        </div>
                    </div>
                    <button type="button" id="add-item-button" class="item_btn">Add Another Item</button>
                </div>
                <input type="submit" class="button_input" id="submit" value="Submit">
            </div>

        </div>
        <script src="autocomplete.js"></script>
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
            document.getElementById('add-item-button').addEventListener('click', newItemSearch);
            function newItemSearch() {
                itemCount++;
                const newWrapper = document.createElement('div');
                newWrapper.className = 'wrapper';
                    const newContent = document.createElement('div');
                    newContent.className = 'content';
                        const newSearchElement = document.createElement('div');
                        newSearchElement.className = 'search';
                            const newItemLabel = document.createElement('label');
                            newItemLabel.className = "req_label";
                            newItemLabel.setAttribute('for', `item-${itemCount}`);
                            newItemLabel.textContent = 'Select Item';
                            const newSearchClass = document.createElement('i');
                            newSearchClass.className = 'uil uil-search';
                            const newSearchInput = document.createElement('input');
                            newSearchInput.id = `item-${itemCount}`;
                            newSearchInput.spellcheck = false;
                            newSearchInput.type = 'text';
                            newSearchInput.placeholder = 'Search for an item...';
                    const newSearchOptions = document.createElement('ul');
                    newSearchOptions.className = 'options';

                newSearchElement.appendChild(newItemLabel);
                newSearchElement.appendChild(newSearchClass);
                newSearchElement.appendChild(newSearchInput);
                newContent.appendChild(newSearchElement);
                newContent.appendChild(newSearchOptions);

                newWrapper.appendChild(newContent);

                const formContainer = document.querySelector('.form');
                formContainer.appendChild(newWrapper);
                newSearchInput.addEventListener('input', function() {
                    newSearchOptions.style.display = 'block';
                });
                newSearchInput.addEventListener('keyup', function() {
                    let searchWord = newSearchInput.value.toLowerCase();
                    if (searchWord === '') {
                        newSearchOptions.innerHTML = '';
                        return;
                    }
                    let filteredItems = itemsData.filter(item => {
                        return item.iname.toLowerCase().startsWith(searchWord);
                    }).map(item => {
                        return `<li onclick="updateName(this, ${itemCount})" data-id="${item.item_id}">${item.iname}</li>`;
                    }).join("");
                newSearchOptions.innerHTML = filteredItems || `<p style="margin-top: 10px;">Not found</p>`;
                });
             newSearchOptions.addEventListener('click', function(){
                  newSearchOptions.style.display = 'none';
             });
            }
            function populateCategorySelects(categoryData) {
                const categorySelect = document.getElementById('categ');
                categorySelect.innerHTML = '';  // Clear previous options
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

            const peopleInput = document.getElementById('people');
            function submit_request() {
                fetch('../../controller/civilian/create_request.php',{
                    method: "POST"
                })
                .then(response=> response.json())
                .then(data =>{

                }).catch(error =>{
                    console.log("Error while creating request: ",error)
                });
            }
            document.getElementById('submit').addEventListener('click', function(event){
                event.preventDefault();
                if(peopleInput.value !== '' && peopleInput.value >=1){
                    submit_request();
                }else{
                    alert('You have to give a correct number')
                }
            });
        </script>
    </body>
</html>