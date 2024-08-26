<?php
    echo'
    <label for="vehicleFilter">Filter by Vehicle ID: </label>
    <select id="vehicleFilter">
        <option value="all">All</option>';
    foreach ($vehicle_bases as $veh) {
    echo '<option value="' . htmlspecialchars($veh) . '">' . htmlspecialchars($veh) . '</option>';
}

echo '</select>';

