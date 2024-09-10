<?php ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <link rel='stylesheet' type='text/css' media='screen' href='removeForm.css'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="icon" href="../favico/favicon.ico" type="image/x-icon">
    <title>Remove Item</title>
</head>
<body>
    <?php
        include '../../ini.php';
        include '../../check_login.php';
        include '../toolbar.php';
        //include '../../controller/admin/fetch_items.php';
    ?>
    <div class="container">
            <div class="form_box">
                <div class="details">Remove Item</div>
                <div class="form">
                    <label for="item" class="insert_label">Select Item to Remove</label>
                    <select id="item" class="select_input" required>
                    </select>
                    <input type="submit" class="button_input" id="submit" value="Submit">
                </div>
            </div>
    </div>
    <script>
        const itemInput = document.getElementById('item');
        const submit = document.getElementById('submit');

        fetch(`../../controller/admin/fetch_items.php?timestamp=${new Date().getTime()}`,{
            method:'POST'
        })
        .then(response=>response.json())
        .then(data=>{
           Object.values(data.items).forEach(item =>{
                let id = item.item_id;
                let name = item.iname;
                let quant = item.quantity;
                let option = document.createElement('option');
                option.value = id;
                option.innerHTML = `Name: ${name} - Quantity: ${quant}`;
                itemInput.appendChild(option);
            })
         })
         .catch(error=> console.log(error));
        submit.addEventListener('click', function (event){
            event.preventDefault()
            const userConfirmed = confirm('Are you sure you want to remove this item?');
            if (userConfirmed) {
                submit_data();
            }else {
                alert('Removal canceled.');
            }
        });

        function submit_data(){
            const item = itemInput.value;
            const params = new URLSearchParams();
            params.append('item', item);

            fetch('../../controller/admin/remove_item.php', {
                method:'POST',
                body:params
            })
            .then(response => response.json())
            .then(data =>{
                if (data.removed) {
                        let goBack = confirm('Removed successfully! Do you want to go back?');
                        if(goBack){
                            window.location.href ='storeManage.php';
                        }else{
                            location.reload();
                        }
                    } else if(!data.removed && !data.exists){
                        alert('Item doesn\'t exist');
                    }else{
                    alert('Error: ' + data.error);// Item is needed or loaded in a vehicle');
                }
            })
            .catch(error => console.error('Error removing this item from the database:', error));
        }
    </script>
</body>
</html>
