<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
include('connections.php');

$name = $_POST['name'];
$email_address = $_POST['email'];
$password = $_POST['password'];
$date_of_birth = $_POST['date_of_birth'];
$user_type=$_POST["user_type"];


$check_email = $mysqli->prepare('select email from users where email=?');
$check_email->bind_param('s', $email_address);
$check_email->execute();
$check_email->store_result();
$email_exists = $check_email->num_rows();

$type =  $mysqli->prepare('select id from user_types where position=?');
$type->bind_param('s', $user_type);
$type->execute();
$type->store_result();
$type->bind_result($user_type_id);
$type->fetch();


if ($email_exists > 0) {
    $response['status'] = "failed";
} else {
    if(strlen($password)>=8 && preg_match('/[A-Z]/', $password) && preg_match('/[a-z]/', $password) && preg_match('/\d/',$password) && preg_match('/[!@#$%^&*()\-_=+{};:,<.>]/',$password)){
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $query = $mysqli->prepare('insert into users(name,email,password,date_of_birth, usertype_id) values(?,?,?,?,?)');
    $query->bind_param('ssssi', $name, $email_address, $hashed_password, $date_of_birth, $user_type_id);
    $query->execute();
    $response['status'] = "success";}
    else{
        $response['status']="invalid";
        
    }
}
echo json_encode($response);
?>
