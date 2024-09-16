<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <link rel='stylesheet' type='text/css' media='screen' href='offers.css'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="icon" href="../favico/favicon.ico" type="image/x-icon">
    <title>See Offers</title>
</head>
<body>
    <?php
        include '../../ini.php';
        include '../../check_login.php';
        include '../toolbar.php';
    ?>
    <h2>Pending Offers</h2>
    <div class="pending-container">
        <p>Click on an offer if you want to cancel</p>
        <table>
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Registration Date</th>
                    <th>Assign Date</th>
                    <th>Assign_date</th>
                </tr>
            </thead>
            <tbody id="pending-table-body"></tbody>
        </table>
    </div>
    <h2>Past Offers</h2>
    <div class="past-container">
        <table>
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Quantity</th>
                    <th>Registration Date</th>
                    <th>Assign Date</th>
                    <th>Completion Date</th>
                </tr>
            </thead>
            <tbody id="past-table-body"></tbody>
        </table>
    </div>
    <script>
        function remove_offer(offer_id){
            const params = new URLSearchParams();
            params.append('offer_id', offer_id);
            fetch('../../controller/civilian/remove_offer.php', {
                method: 'POST',
                body: params,
                header:'Content-Type: application/json'
            })
            .then(response => response.json())
            .then(data =>{
                console.log(data)
                if(data.removed){
                    alert("Removed Successfully!");
                    location.reload();
                }else{
                    alert("Error" + data.error);
                }
            }).catch(error => console.error('Error removing offer:', error))
        }

        const pendingTable = document.getElementById('pending-table-body');
        const pastTable = document.getElementById('past-table-body');
        fetch('../../controller/civilian/fetch_past_offers.php', {
            method: 'POST',
        })
        .then(response => response.json())
        .then(data =>{
            data.forEach(offer =>{
                let offer_id = offer.off_id;
                let item_name = offer.item_name;
                let pending = offer.pending;
                let completed = offer.completed;
                let quantity = offer.quantity;
                let reg_date = offer.reg_date;
                let assign_date = offer.assign_date;
                let completed_date =offer.completed_date;
                if(completed !== 't'){
                    let row = document.createElement('tr');
                    row.setAttribute('data-item', item_name);
                    row.setAttribute('data-offer-id', offer_id);
                    row.innerHTML = `
                           <td>${item_name}</td>
                           <td>${quantity}</td>
                           <td>${reg_date}</td>
                           <td>${assign_date ? assign_date : 'N/A'}</td>
                       `;
                    row.addEventListener("click", function (event){
                        event.preventDefault();
                        let want_remove_offer = confirm('Do you want to remove this offer?');
                        if(want_remove_offer){
                            console.log("Attribute" + this.getAttribute('data-offer-id'))
                            remove_offer(this.getAttribute('data-offer-id'));
                        }
                    });
                    pendingTable.appendChild(row);
                }else{
                    let row = document.createElement('tr');
                    row.innerHTML = `
                           <td>${item_name}</td>
                           <td>${quantity}</td>
                           <td>${reg_date}</td>
                           <td>${assign_date}</td>
                           <td>${completed_date}</td>
                       `;
                    pastTable.appendChild(row);
                }
            })
        }).catch(error => console.error('Error fetching offers:', error))
    </script>
</body>
</html>