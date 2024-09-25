<?php
include '../../model/config.php';

if ($_FILES['file']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['error' => 'File upload failed.']);
    exit;
}

$json_data = file_get_contents($_FILES['file']['tmp_name']);
if ($json_data === FALSE) {
    echo json_encode(['error' => 'Error reading uploaded JSON file']);
    exit;
}

$data = json_decode($json_data, true);

if ($data === NULL) {
    echo json_encode(['error' => 'Error, the JSON is empty or not valid']);
    exit;
}

try {
    $categories = $data['categories'];
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
            throw new Exception("Error inserting category with ID: $category_id");
        }
    }

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
            INSERT INTO items (iname, category, details)
            VALUES ($1, $2, $3)
            ON CONFLICT (iname) 
            DO UPDATE SET category = EXCLUDED.category, details = EXCLUDED.details
            RETURNING category;
        EOF;

        $result = pg_query_params($dbconn, $query, array($item_name, $item_category, $details));
        if (!$result) {
            throw new Exception("Error inserting item with name: $item_name");
        }
    }

    echo json_encode(['added' => true]);

} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
    exit;
}

include '../../model/database.php';
