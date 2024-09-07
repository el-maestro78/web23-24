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
    <title>Modify Item's Category</title>
</head>
<body>
    <?php
        include '../../ini.php';
        include '../../check_login.php';
        include '../toolbar.php';
        //Get the $items_array
        include '../../controller/admin/fetch_items.php';
        // get $categories array
        include '../../controller/admin/fetch_item_categ.php';
    ?>
    <div class="container">
            <div class="form_box">
                <div class="details">Modify Item's Category</div>
                <div class="form">
                    <label for="item" class="insert_label">Select Item</label>
                    <select id="item" class="categ_input" required>
                        <?php
                            foreach ($items_array as $item) {
                                $id = $item['item_id'];
                                $name = $item['iname'];
                                $categ = $item['category'];
                                echo "<option value=\"$id\">$name - Current: $categ</option>";
                            }
                        ?>
                    </select>
                    <label for="category" class="insert_label">Select Category</label>
                    <select id="category" class="categ_input" required>
                        <?php
                            foreach ($categories_array as $category) {
                                $id = $category['category_id'];
                                $name = $category['category_name'];
                                echo "<option value=\"$id\">$name</option>";
                            }
                        ?>
                    </select>
                    <input type="submit" class="button_input" id="submit" value="Submit">
                </div>
            </div>
    </div>
    <script>
        const itemInput = document.getElementById('item');
        const categoryInput = document.getElementById('category');
        const submit = document.getElementById('submit');

        submit.addEventListener('click', function (event){
            event.preventDefault()
            submit_data();
        });

        function submit_data(){
            const item = itemInput.value;
            const category = categoryInput.value;

            const params = new URLSearchParams();
            params.append('item', item);
            params.append('category', category);

            fetch('../../controller/admin/update_item_category.php', {
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
    </script>
</body>
</html>
