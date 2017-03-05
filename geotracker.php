
<!DOCTYPE html>
<html>
<body>

<?php
echo $_SERVER['QUERY_STRING'] . "<br>";
parse_str($_SERVER['QUERY_STRING'], $query);
$lat = $query['lat'];
$lon = $query['lon'];
date_default_timezone_set('America/Los_Angeles');
$trunc = intval( substr( $query['timestamp'] , 0, -3 ) );
$timestamp = date( 'Y-m-d H:i:s', $trunc);
$altitude = $query['altitude'];
$speed = $query['speed'];

echo "Lat: " . $lat . "<br>";
echo "Lon: " . $lon . "<br>";
echo "Timestamp: " . $timestamp . "<br>";
echo "Altitude: " . $altitude . "<br>";
echo "Speed: " . $speed . "<br>";

$message = "fred.php>> lat={$lat} lon={$lon} timestamp={$timestamp} altitude={$altitude} speed={$speed}";
error_log($message);
$description = "'Last known location:\r\nLat: {$lat} \r\nLon: {$lon} \r\nTimestamp: {$timestamp} (Pacific) \r\nAltitude: {$altitude} (ft)\r\nSpeed: {$speed} (MPH)'" ;

$servername = "localhost";
$username = "*** update with username of database ***";
$password = "*** update with password of database ***";
$dbname = "vansoyec_wrdp10";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

//$sql = "UPDATE `wp_gmp_markers` SET `coord_x` = $lat, `coord_y`= $lon WHERE `id` = 33";
$sql = "UPDATE `wp_gmp_markers` SET `description` = $description, `coord_x` = $lat, `coord_y`= $lon WHERE `id` = 33";

if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
//    error_log("fred.php>> Record updated successfully");
    
} else {
    echo "Error updating record: " . $conn->error;
    error_log("fred.php>> Error updating record: " . $conn->error);
}

$conn->close();
?>

</body>
</html>
