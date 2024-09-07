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
    <title>Modify Category</title>
</head>
<body>
    <?php
        include '../../ini.php';
        include '../../check_login.php';
        include '../toolbar.php';
        // get $categories array
        include '../../controller/admin/fetch_item_categ.php';
    ?>
    <div class="container">
            <div class="form_box">
                <div class="details">Modify Item</div>
                <div class="form">
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
                    <label for="name" class="insert_label">Give new Name</label>
                    <input type="text" id="name" class="insert_input" required>
                    <input type="submit" class="button_name" id="name_submit" value="Submit new name">
                    <label for="details" class="descr">Update details</label> <br>
                    <textarea id="details" class="insert_label" rows="5" cols="40" required></textarea>
                    <input type="submit" class="button_input" id="details_submit" value="Submit new details">
                </div>
            </div>
    </div>
    <script>

        const categoryIdInput = document.getElementById('category');

        const nameInput = document.getElementById('name');
        const nameSubmit = document.getElementById('name_submit');

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

        nameSubmit.addEventListener('click', function (event){
            event.preventDefault()
            if(nameInput.value.trim()  === ''){
                alert('You have to give a name')
            }else {
                submit_name();
            }
        });

        function submit_details(){
            const category_id = categoryIdInput.value;
            const details = detailsInput.value;

            const params = new URLSearchParams();
            params.append('category', category_id);
            params.append('details', details);

            fetch('../../controller/admin/update_categ_details.php', {
                method:'POST',
                body:params
            })
            .then(response => response.json())
            .then(data =>{
                if (data.updated) {
                        alert('Updated successfully');
                        window.location.href ='storeManage.php';
                    } else if(!data.updated && !data.exists){
                        alert('Category doesn\'t exist');
                    }else{
                    alert('Error: ' + data.error);
                }
            })
            .catch(error => console.error('Error saving this category to the database:', error));
        }

        function submit_name(){
            const category = categoryIdInput.value;
            const name = nameInput.value;

            const params = new URLSearchParams();
            params.append('category', category);
            params.append('name', name);

            fetch('../../controller/admin/update_categ_name.php', {
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
                        alert('Category doesn\'t exist');
                    }else{
                    alert('Error: ' + data.error);
                }
            })
            .catch(error => console.error('Error saving this category to the database:', error));
        }


    </script>
</body>
</html>