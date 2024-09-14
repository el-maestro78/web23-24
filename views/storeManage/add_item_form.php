<?php ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <link rel='stylesheet' type='text/css' media='screen' href='addForm.css'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="icon" href="../favico/favicon.ico" type="image/x-icon">
    <title>Add new Item</title>
</head>
<body>
    <?php
        include '../../ini.php';
        include '../../check_login.php';
        include '../toolbar.php';
        // get $categories array
        //include '../../controller/admin/fetch_item_categ.php';
    ?>
    <div class="container">
            <div class="form_box">
                <div class="details">Add a new Item</div>
                <div class="form">
                    <label for="item_name" class="insert_label">Item Name</label>
                    <input type="text" id="item_name" class="insert_input" required>
                    <label for="category" class="insert_label">Select Category</label>
                    <select id="category" class="categ_input" required>
                    </select>
                    <label for="quantity" class="insert_label">Quantity</label>
                    <input type="number" id="quantity" class="insert_quantity" required step="1" min="0">
                    <label for="details" class="descr">Add more details</label> <br>
                    <textarea id="details" class="insert_label" rows="5" cols="40" required></textarea>
                    <input type="submit" class="button_input" id="submit" value="Submit">
                </div>
            </div>
    </div>
    <script>
        const itemInput = document.getElementById('item_name');
        const categoryInput = document.getElementById('category');
        const quantityInput = document.getElementById('quantity');
        const detailsInput = document.getElementById('details');
        const submit = document.getElementById('submit');

       fetch('../../controller/admin/fetch_item_categ.php', {
                method:'POST'
       })
       .then(response => response.json())
       .then(data =>{
           data.forEach(categ=>{
               let id = categ.category_id;
               let name = categ.category_name;
               let row = document.createElement('option');
               row.value = id;
               row.setAttribute('category', id);
               row.innerHTML = `${name}`
               categoryInput.append(row)
           })
       })
       .catch(error=>console.log(error))

        submit.addEventListener('click', function (event){
            event.preventDefault()
            if(itemInput.value.trim()  === '' || quantityInput.value.trim()  === ''){
                alert('You have to give name and quantity')
            }else {
                submit_data();
            }
        });
        quantityInput.addEventListener('input', function (event) {
            event.preventDefault()
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        function submit_data(){
            const item = itemInput.value;
            const category = categoryInput.value;
            const quantity = quantityInput.value;
            const details = detailsInput.value;

            const params = new URLSearchParams();
            params.append('item', item);
            params.append('category', category);
            params.append('quantity', quantity);
            params.append('details', details);

            fetch('../../controller/admin/add_item.php', {
                method:'POST',
                body:params
            })
            .then(response => response.json())
            .then(data =>{
                if (data.created) {
                        let goBack = confirm('Created successfully! Do you want to go back?');
                        if(goBack){
                            window.location.href ='storeManage.php';
                        }else{
                            location.reload();
                        }
                    } else if(data.exists){
                        alert('Item already exists');
                    }else{
                    alert('Error: ' + data.error);
                }
            })
            .catch(error => console.error('Error saving this item to the database:', error));
        }


    </script>
</body>
</html>