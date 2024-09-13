<?php
include '../../model/config.php';
session_start();
require "../../model/vendor/autoload.php";
include "../../auxiliary.php";
$API_KEY = $_ENV['GEO_CODING_API'];


$city = validate_input($_POST['city']);
$zipcode = validate_input($_POST['zcode']);
$country = validate_input($_POST['country']);
$street = validate_input($_POST['street']);

/*
$street = "1600 Amphitheatre Parkway"; // Example street
$city = "Mountain View"; // Example city
$zipcode = "94043"; // Example ZIP code
$country = "Greece"; // Example country
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
*/
$address = urlencode("$street, $city, $zipcode, $country");
$url = "https://api.opencagedata.com/geocode/v1/json?q=$address&key=$API_KEY";
//$response = file_get_contents($url);
$context = stream_context_create([
    'http' => [
        'method' => 'GET',
        'header' => 'Accept: application/json'
    ],
    'ssl' => [
        'verify_peer'       => false,
        'verify_peer_name'  => false,
    ]
]);

// Make API request
$response = @file_get_contents($url, false, $context);


if ($response === FALSE) {
    echo json_encode(['error' => 'Error occurred while making the API request.']);
    exit;
}
$result = json_decode($response, true);
//print_r($result); // DEBUG


if ($result && $result['total_results'] > 0) {
    $first = $result['results'][0];

    // Check if 'geometry' exists in the result and extract latitude and longitude
    if (isset($first['geometry'])) {
        $longitude = $first['geometry']['lng'];
        $latitude = $first['geometry']['lat'];
        //$formattedAddress = $first['formatted'];
        echo json_encode([
            'long' => $longitude,
            'lat' => $latitude,
            //'address' => $first['formatted']
        ]);
    } else {
        echo json_encode(['error' => 'Geometry data not available in the API response.']);
    }
} else {
    echo json_encode(['error' => 'No results found or invalid response from API.']);
}