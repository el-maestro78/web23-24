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
        // get $categories array
        //include '../../controller/admin/fetch_item_categ.php';
    ?>
    <div class="container">
            <div class="form_box">
                <div class="details">Remove Category</div>
                <div class="form">
                    <label for="category" class="insert_label">Select Category</label>
                    <select id="category" class="select_input" required>
                    </select>
                    <input type="submit" class="button_input" id="submit" value="Submit">
                </div>
            </div>
    </div>
    <script>
        const categoryInput = document.getElementById('category');
        const submit = document.getElementById('submit');

        fetch('../../controller/admin/fetch_item_categ.php',{
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
               row.innerHTML = `Id: ${id}, Current Name: ${name}`
               categoryInput.append(row)
           })
       })
       .catch(error=>console.log(error));

        submit.addEventListener('click', function (event){
            event.preventDefault()
            const userConfirmed = confirm('Are you sure you want to remove this category?');
            if (userConfirmed) {
                submit_data();
            }else {
                alert('Removal canceled.');
            }
        });

        function submit_data(){
            const category = categoryInput.value;
            const params = new URLSearchParams();
            params.append('category', category);

            fetch('../../controller/admin/remove_item_category.php', {
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
                    alert('Category doesn\'t exist');
                }else{
                     alert('Error: ' + data.error);
                }
            })
            .catch(error => console.error('Error removing this category from the database:', error));
        }

    </script>
</body>
</html>
