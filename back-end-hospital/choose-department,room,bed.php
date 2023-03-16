<?php 

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
include('connections.php');


$user_id = $_POST['user_id'];
$department_name = $_POST['department_name'];
$room_number = $_POST['room_number'];
$bed_num=$_POST['bed'];

$hospital = $mysqli->prepare('SELECT hospital_id FROM hospital_users WHERE user_id = ?');
$hospital->bind_param('i', $user_id);
$hospital->execute();
$hospital->store_result();
$hospital->bind_result($hospital_id);
$hospital->fetch();

$department = $mysqli->prepare('SELECT id FROM departments WHERE name = ?');
$department->bind_param('s', $department_name);
$department->execute();
$department->store_result();
$department->bind_result($department_id);
$department->fetch();

$room = $mysqli->prepare('SELECT id FROM rooms WHERE room_number = ?');
$room->bind_param('i', $room_number);
$room->execute();
$room->store_result();
$room->bind_result($room_id);
$room->fetch();


$user_department = $mysqli->prepare('INSERT INTO user_departments (user_id, department_id, hospital_id) VALUES (?, ?, ?)');
$user_department->bind_param("iii", $user_id, $department_id, $hospital_id);
$user_department->execute();
$user_department->store_result();
$response['status'] = 'users chosen success';
echo json_encode($response);


$user_room = $mysqli->prepare('INSERT INTO user_rooms(user_id,room_id,bed_number) VALUES (?, ?, ?)');
$user_room->bind_param("iii", $user_id, $room_id, $bed_num);
$user_room->execute();
$user_room->store_result();
$response['status'] = 'users chosen success';
echo json_encode($response);

?>
