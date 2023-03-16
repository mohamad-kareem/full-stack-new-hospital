<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
include('connections.php');

$sql = "SELECT name FROM hospitals";
$result = $mysqli->query($sql);

$results = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $results[] = $row;
    }
}

echo json_encode($results);
?>
