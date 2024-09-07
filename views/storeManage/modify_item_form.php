<?php ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <link rel='stylesheet' type='text/css' media='screen' href='modifyForm.css'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="icon" href="../favico/favicon.ico" type="image/x-icon">
    <title>Modify Items</title>
</head>
<body>
    <?php
        include '../../ini.php';
        include '../../check_login.php';
        include '../toolbar.php';
        //Get the $items_array
        include '../../controller/admin/fetch_items.php';
    ?>
    <div class="container">
            <div class="form_box">
                <div class="details">Modify Item</div>
                <div class="form">
                    <label for="item" class="insert_label">Select Item</label>
                    <select id="item" class="categ_input" required>
                        <?php
                            foreach ($items_array as $item) {
                                $id = $item['item_id'];
                                $name = $item['iname'];
                                $quant = $item['quantity'];
                                echo "<option value=\"$id\">$name - $quant</option>";
                            }
                        ?>
                    </select>
                    <label for="quantity" class="insert_label">Update Quantity</label>
                    <input type="number" id="quantity" class="quantity_input" required step="1" min="0">
                    <input type="submit" class="button_quantity" id="quantity_submit" value="Submit">
                    <label for="details" class="descr">Update details</label> <br>
                    <textarea id="details" class="insert_label" rows="5" cols="40" required></textarea>
                    <input type="submit" class="button_input" id="details_submit" value="Submit">
                </div>
            </div>
    </div>
    <script>
        const itemInput = document.getElementById('item');

        const quantityInput = document.getElementById('quantity');
        const quantitySubmit = document.getElementById('quantity_submit');

        const detailsInput = document.getElementById('details');
        const detailsSubmit = document.getElementById('details_submit');

        detailsSubmit.addEventListener('click', function (event){
            event.preventDefault()
            if(detailsInput.value.trim()  === ''){
                alert('You have to give a new text for details')
            }else {
                submit_details();
            }
        });

        quantitySubmit.addEventListener('click', function (event){
            event.preventDefault()
            if(quantityInput.value.trim()  === ''){
                alert('You have to give quantity')
            }else {
                submit_quantity();
            }
        });

        quantityInput.addEventListener('input', function (event) {
            event.preventDefault()
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        function submit_details(){
            const item = itemInput.value;
            const details = detailsInput.value;

            const params = new URLSearchParams();
            params.append('item', item);
            params.append('details', details);

            fetch('../../controller/admin/update_item_details.php', {
                method:'POST',
                body:params
            })
            .then(response => response.json())
            .then(data =>{
                if (data.updated) {
                        let goBack = confirm('Updated successfully! Do you want to go back?');
                        if(goBack){
                            window.location.href ='storeManage.php';
                        }else{
                            location.reload();
                        }
                    } else if(!data.updated && !data.exists){
                        alert('Item doesn\'t exist');
                    }else{
                    alert('Error: ' + data.error);
                }
            })
            .catch(error => console.error('Error saving this item to the database:', error));
        }

        function submit_quantity(){
            const item = itemInput.value;
            const quantity = quantityInput.value;

            const params = new URLSearchParams();
            params.append('item', item);
            params.append('quantity', quantity);

            fetch('../../controller/admin/update_item_quantity.php', {
                method:'POST',
                body:params
            })
            .then(response => response.json())
            .then(data =>{
                if (data.updated) {
                        alert('Updated successfully');
                        window.location.href ='storeManage.php';
                    } else if(!data.updated && !data.exists){
                        alert('Item doesn\'t exist');
                    }else{
                    alert('Error: ' + data.error);
                }
            })
            .catch(error => console.error('Error saving this item to the database:', error));
        }


    </script>
</body>
</html>