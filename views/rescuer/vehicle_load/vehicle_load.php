<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <link rel='stylesheet' type='text/css' media='screen' href='vehicle_load.css'>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="icon" href="../../favico/favicon.ico" type="image/x-icon">
        <title>Manage Storage</title>

    </head>

    <body>
        <?php
        include '../../../ini.php';
        include '../../../check_login.php';
        include '../../toolbar.php';
        ?>

        <div id = 'info' class = 'text_box'></div>
        <p> In order the "Edit Vehicle Load" to be enabled, you have to be up to 100m away from a base.
        <div class = 'button_container' id = "buttons">
        <form method="POST" id="refresh_loc_form">
            <button type="submit" id="refresh_location" class="button_modify">Refresh Location</button>
        </form>
        </div>
            <div class="table-container">
                <table id="vehicle-table">
                    <thead>
                        <tr>
                             <th>Item ID</th>
                            <th>Item Name</th>
                            <th>Quantity</th>
                         </tr>
                    </thead>
                        <tbody id = 'table_body'></tbody>
                 </table>
            </div>
        <script>
            fetch(`../../../controller/rescuer/vehicle_load_queries.php?timestamp=${new Date().getTime()}`)
            .then(response=>response.json())
            .then(data=>{ console.log(data);
                const table = document.getElementById('table_body');
                Object.values(data.veh_info).forEach(vehicle=>{
                    const row = document.createElement('tr');
                    row.innerHTML = `
                                    <td>${vehicle.item_id}</td>
                                    <td>${vehicle.iname}</td>
                                    <td>${vehicle.load}</td>
                                    `
                                    table.appendChild(row)
                })

                const info_div = document.getElementById('info');
                let info = data.veh_id;
                let distance = data.current_distance;
                info_div.innerHTML = `
                    <h2>Assigned Vehicle (Id): ${info.veh_id}</h2>
                    <p>Closest Base's Id: ${distance[0]} |
                    Distance: ${distance[1]}m</p>
                `
                const buttons = document.getElementById('buttons');
                const link = document.createElement('a');
                if (distance[1] <= 100)
                    link.href = 'vehicle_load_edit.php';
                else {
                    link.href = '#';
                    link.onclick = function() {
                        alert('You are too far away from the base to edit the vehicle load.');
                        return false;
                    };
                }
                link.innerHTML = 'Edit Vehicle Load'
                link.className = data.edit_button_class
                buttons.appendChild(link);

            })
            .catch(error=>console.log(error))
        </script>
    </body>
</html>
