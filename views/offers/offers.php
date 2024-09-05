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
    <button id="new-offer" value="Make new offer">This is for the news actually TODO</button> <!--TODO-->
    <h2>Pending Offers</h2>
    <div class="pending-container">
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
                    <td>Completion Date</td>
                </tr>
            </thead>
            <tbody id="past-table-body"></tbody>
        </table>
    </div>
    <script>
        const pendingTable = document.getElementById('pending-table-body');
        const pastTable = document.getElementById('past-table-body');
        fetch('../../controller/civilian/fetch_past_offers.php', {
            method: 'POST',
        })
        .then(response => response.json())
        .then(data =>{
            data.forEach(announc =>{
                let item_name = announc.item_name;
                let pending = announc.pending;
                let completed = announc.completed;
                let quantity = announc.quantity;
                let reg_date = announc.reg_date;
                let assign_date = announc.assign_date;
                let completed_date = announc.completed_date;
                if(completed !== 't'){
                    let row = document.createElement('tr');
                    row.innerHTML = `
                           <td>${item_name}</td>
                           <td>${quantity}</td>
                           <td>${reg_date}</td>
                           <td>${assign_date ? assign_date : 'N/A'}</td>
                       `;
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