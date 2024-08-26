
<?php
    echo'
    <label for="categoryFilter">Filter by Category: </label>
    <select id="categoryFilter">
        <option value="all">All</option>';
    foreach ($categories as $category) {
    echo '<option value="' . htmlspecialchars($category) . '">' . htmlspecialchars($category) . '</option>';
}

echo '</select>';

