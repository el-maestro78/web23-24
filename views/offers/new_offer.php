<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <link rel='stylesheet' type='text/css' media='screen' href='new_offer.css'>
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
            $item = $_GET['item'];
            $base = $_GET['base'];
            if(!isset($item) || !isset($base)){
                header('Location: ../../404.php');
            }
        ?>
        <div class="container">
            <div class="offer_container">
                <div class="details">New Offer</div>
                <div class="form">
                    <label class=offer_label id="item" data-base="<?=$base?>" data-item="<?=$item?>">Item: <?=$item?></label>
                     <label for="quantity" class="offer_label">Quantity</label>
                    <input type="number" id="quantity" class="insert_quantity" required step="1" min="0">
                    <input type="submit" class="button_input" id="submit" value="Submit">
                </div>
            </div>
        </div>
    </body>
    <script>
        //const item = "<//$item ?>"; Isn't allowed
        //const base = "<//$base ?>";
        const item = document.getElementById('item').getAttribute('data-item');
        const base = document.getElementById('item').getAttribute('data-base');
        const quantityInput = document.getElementById('quantity');
        const submit = document.getElementById('submit');

        submit.addEventListener('click', function (event){
            event.preventDefault()
            if(quantityInput.value.trim()  === ''){
                alert('You have to quantity')
            }else {
                submit_data();
            }
        });
        quantityInput.addEventListener('input', function (event) {
            event.preventDefault()
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        function submit_data(){
            const quantity = quantityInput.value;

            const params = new URLSearchParams();
            params.append('item', item);
            params.append('quantity', quantity);

            fetch('../../controller/civilian/create_offer.php', {
                method:'POST',
                body:params
            })
            .then(response => response.json())
            .then(data =>{
                if(data.created){
                    let goBack = confirm('Created Successfully! If you want do go back press OK');
                    if(goBack){
                        window.location.href = '../news/civ_news.php';
                    }else{
                        location.reload();
                    }
                }else {
                    alert('Error: ' + data.error);
                }
            })
            .catch(error => console.error('Error saving this item to the database:', error));
        }
    </script>
</html>
