<?php
include '../../model/config.php';

$json_url = 'http://usidas.ceid.upatras.gr/web/2023/export.php';
$json_data = file_get_contents($json_url);
if ($json_data === FALSE) {
    $error = "Error fetching JSON data from the URL";
    echo json_encode(['error' => $error]);
    exit;
}

$data = json_decode($json_data, true); // True returns an associative array

if ($data === NULL) {
    $error = "Error, the JSON is empty or not valid";
    echo json_encode(['error' => $error]);
    exit;
}

$categories = $data['categories'];
try {
    foreach ($categories as $category) {
        $category_id = (int)$category['id'];
        $category_name = (string)$category['category_name'];
        $query = <<<EOF
            INSERT INTO item_category(category_id, category_name)
            VALUES ($1, $2)
            ON CONFLICT (category_name) 
            DO UPDATE SET category_id = EXCLUDED.category_id
            RETURNING category_id;
        EOF;
        $result = pg_query_params($dbconn, $query, array($category_id, $category_name));
        if (!$result) {
            $error = "Error inserting category with ID: $category_id\n";
            echo json_encode(['error' => $error]);
            exit;
        }
    }
    echo $categories;

    $items = $data['items'];

    foreach ($items as $item) {
        $item_id = $item['id'];
        $item_name = $item['name'];
        $item_category = $item['category'];
        $details = '';
        if (!empty($item['details']) && isset($item['details'][0]['detail_value'])) {
            $details = $item['details'][0]['detail_value'];
        }

        $query = <<<EOF
            INSERT INTO items (iname, category)
            VALUES ($1, $2)
            ON CONFLICT (iname) 
            DO UPDATE SET category = EXCLUDED.category
            RETURNING category;
        EOF;

        $result = pg_query_params($dbconn, $query, array($item_name, $item_category));
        if (!$result) {
            $error = "Error inserting category with ID: $item_category \n";
            echo json_encode(['error' => $error]);
            exit;
        }
    }
    echo json_encode(['added' => true]);

}catch(Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
    exit;
}

include '../../model/database.php';
