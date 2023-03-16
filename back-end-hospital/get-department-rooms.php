<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
include('connections.php');

$sql = "SELECT departments.name, rooms.room_number, rooms.number_beds
FROM departments, rooms
WHERE departments.id = rooms.department_id";

$result = $mysqli->query($sql);

$results = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $results[] = $row;
    }
}

echo json_encode($results);
?>
