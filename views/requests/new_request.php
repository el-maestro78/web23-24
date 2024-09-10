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
            <div class="requests_box">
                <div class="details">Make a new Request</div>
                <div class="form">
                    <label for="people" class="req_label">People in Need</label>
                    <input type="number" id="people" class="insert_people" required step="1" min="1" max="20">
                    <div id="category-container">
                        <label for="categ" class="req_label">Select Category</label>
                        <select id="categ" class="item_input form-select" required></select>
                    </div>
                    <button type="button" id="add-item-button" class="item_btn">Add New Item</button>
                    <div class="wrapper">
                        <div class="content">
                            <div class="search">
                                <label class="req_label" for="item-1">Select Item</label>
                                <i class="uil uil-search"></i>
                                <input id="item-1" spellcheck="false" type="text" placeholder="Search for an item...">
                            </div>
                            <ul class="options" data-item-count="1"></ul>
                        </div>
                    </div>
                </div>
                <input type="submit" class="button_input" id="submit" value="Submit">
            </div>

        </div>
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
                newWrapper.innerHTML = `
                    <div class="content">
                        <div class="search">
                            <label class="req_label" for="item-${itemCount}">Select Item</label>
                            <i class="uil uil-search"></i>
                            <input id="item-${itemCount}" spellcheck="false" type="text" placeholder="Search for an item...">
                        </div>
                        <ul class="options" data-item-count="${itemCount}"></ul>
                    </div>
                `;

                const formContainer = document.querySelector('.form');
                formContainer.appendChild(newWrapper);

                const newSearchInput = newWrapper.querySelector(`#item-${itemCount}`);
                const newSearchOptions = newWrapper.querySelector('.options');

                newSearchInput.addEventListener('input', function() {
                    newSearchOptions.style.display = 'block';
                });
                newSearchInput.addEventListener('keyup', function() {
                    updateOptions(this, newSearchOptions);
                });

                document.addEventListener('click', function(event) {
                    if (!event.target.closest('.content')) {
                        newSearchOptions.style.display = 'none';
                    }
                });
            }
            function updateOptions(input, optionsList) {
                let searchWord = input.value.toLowerCase();
                if (searchWord === '') {
                    optionsList.innerHTML = '';
                    return;
                }

                let filteredItems = itemsData.filter(item => {
                    return item.iname.toLowerCase().startsWith(searchWord);
                }).map(item => {
                    return `<li onclick="updateName(this, ${optionsList.getAttribute('data-item-count')})" data-id="${item.item_id}">${item.iname}</li>`;
                }).join("");

                optionsList.innerHTML = filteredItems || `<p style="margin-top: 10px;">Not found</p>`;
            }
            function updateName(selectedLi, itemCount) {
                const inputId = `item-${itemCount}`;
                const searchInput = document.getElementById(inputId);
                if (searchInput) {
                    searchInput.value = selectedLi.innerText;
                    searchInput.setAttribute('data-id', selectedLi.getAttribute('data-id'));
                    selectedLi.closest('.options').style.display = 'none';
                } else {
                    console.error(`Input with id ${inputId} not found.`);
                }
            }

            document.getElementById('add-item-button').addEventListener('click', newItemSearch);

            document.addEventListener('DOMContentLoaded', function() {
                const initialInput = document.querySelector('#item-1');
                const initialOptions = document.querySelector('.options');

                initialInput.addEventListener('input', function() {
                    initialOptions.style.display = 'block';
                });

                initialInput.addEventListener('keyup', function() {
                    updateOptions(this, initialOptions);
                });

                // Close options when clicking outside
                document.addEventListener('click', function(event) {
                    if (!event.target.closest('.content')) {
                        initialOptions.style.display = 'none';
                    }
                });
            });
            function populateCategorySelects(categoryData) {
                const categorySelect = document.getElementById('categ');
                categorySelect.innerHTML = '';
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
                    itemsData = Object.values(data.combined_items);
                    populateItemSelects(itemsData);
                    populateCategorySelects(data.categories);

                })
                .catch(error => {
                    console.error("Error while fetching data for request: ", error);
                });

            const peopleInput = document.getElementById('people');
            const categoryInput = document.getElementById('categ');
            categoryInput.addEventListener('change', function (event){
                const searchInputs = document.querySelectorAll('input[type="text"]');
                    searchInputs.forEach(input => {
                    input.value = '';
                });
                const original_items = itemsData;
                event.preventDefault();
                const selectedCategory = event.target.value;
                let filteredItems;
                if (selectedCategory === '') {
                    filteredItems = original_items;
                } else {
                    filteredItems = itemsData.filter(item => item.category_id === selectedCategory);
                }
                itemsData = filteredItems;
                addItem(itemsData);
                //addItem(filteredItems);
            });
            function submit_request() {
                const peopleCount = document.getElementById('people').value;
                const selectedCategory = document.getElementById('categ').value;

                const items = [];
                document.querySelectorAll('.content').forEach((content, index) => {
                    const searchInput = content.querySelector('input[type="text"]');
                    if (searchInput && searchInput.value.trim() !== '') {
                        const item_id = searchInput.getAttribute('data-id');
                        if(item_id === null){
                            alert('You must choose an item. Check items inputs');
                        }else{
                            items.push(item_id);
                        }
                    }//console.log(items)
                });
                const params = new URLSearchParams();
                params.append('people', peopleCount);
                params.append('category', selectedCategory);
                params.append('items', JSON.stringify(items));
                console.log(params)
                fetch('../../controller/civilian/create_request.php',{
                    method: "POST",
                    body: params
                })
                .then(response=> response.json())
                .then(data =>{
                    if(data.created){
                        let goBack = confirm('Created Successfully! If you want do go back press OK');
                        if(goBack){
                            window.location.href = 'requests.php';
                        }else{
                            location.reload();
                        }
                    }else {
                        alert('Error: ' + data.error);
                    }
                }).catch(error =>{
                    console.log("Error while creating request: ",error)
                });
            }
            peopleInput.addEventListener('input', function (event) {
                event.preventDefault()
                this.value = this.value.replace(/[^0-9]/g, '');
            });
            const itemsSelected = document.querySelector('input[type="text"]');
            document.getElementById('submit').addEventListener('click', function(event){
                event.preventDefault();
                if( peopleInput.value !== '' &&
                    peopleInput.value >=1 &&
                    newSearchInput.value !== ''){
                    submit_request();
                }else{
                    alert('You have to give a correct number and item')
                }
            });
        </script>
    </body>
</html>