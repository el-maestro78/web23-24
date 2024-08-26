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
    <title>Add new Category</title>
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
                <div class="details">Add new Category</div>
                <div class="form">
                    <label for="category" class="insert_label">Category Name</label>
                    <input type="text" id="category" class="insert_input" required>
                    <label for="details" class="descr">Add more details</label> <br>
                    <textarea id="details" class="insert_label" rows="5" cols="40" required></textarea>
                    <input type="submit" class="button_input" id="submit" value="Submit">
                </div>
            </div>
    </div>
    <script>
        const categoryInput = document.getElementById('category');
        const detailsInput = document.getElementById('details');
        const submit = document.getElementById('submit');

        submit.addEventListener('click', function (event){
            event.preventDefault()
            if(categoryInput.value.trim()  === ''){
                alert('You have to give a name')
            }else {
                submit_data();
            }
        });

        function submit_data(){
            const category = categoryInput.value;
            const details = detailsInput.value;

            const params = new URLSearchParams();
            params.append('category', category);
            params.append('details', details);

            fetch('../../controller/admin/add_item_category.php', {
                method:'POST',
                body:params
            })
            .then(response => response.json())
            .then(data =>{
                if (data.created) {
                        alert('Created successfully');
                        window.location.href ='storeManage.php';
                    } else if(!data.created && data.exists){
                        alert('Category already exists');
                    }else{
                    alert('Error: ' + data.error);
                }
            })
            .catch(error => console.error('Error saving this category to the database:', error));
        }
    </script>
</body>
</html>