<?php 
 //not used yet
session_start();
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
include('connections.php');

if (isset($_POST['department_name'],$_POST['room_number'])){
    $user_id=$_SESSION['id'];
    $department_name=$_POST['department_name'];
    $room_number=$_POST['room_number'];

    $hos_id=$mysqli->prepare('SELECT hospital_id FROM hospital_users WHERE user_id=?');
    $hos_id->bind_param('s',$user_id);
    $hos_id->execute();
    $hos_id->store_result();
    $num_rows=$hos_id->num_rows();

    if($num_rows>0){
        $hos_id->bind_result($hospital_id);
        $hos_id->fetch();

        $room=$mysqli->prepare('select id from rooms where room_number=?');
        $room->bind_param('s',$room_number);
        $room->execute();
        $room->store_result();
        $room->bind_result($room_id);
        $room->fetch();


        $department=$mysqli->prepare('select id from departments where name=?');
        $department->bind_param('s',$department_name);
        $department->execute();
        $department->store_result();
        $department->bind_result($department_id);
        $department->fetch();

        $user_department=$mysqli->prepare('insert into user_departments(user_id,department_id,hospital_id) values(?,?,?);');
        $user_department->bind_param("iii",$user_id,$department_id,$hospital_id);
        $user_department->execute();
        $user_department->store_result();
        $response['status']='users chosen success';
        echo json_encode($response);
    }
    else{
        $response['status']='patient is not found';
        echo json_encode($response);
    }

}
