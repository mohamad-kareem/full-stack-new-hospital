<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
include('connections.php');

$email = $_POST['email'];
$password = $_POST['password'];

$query = $mysqli->prepare('SELECT id,name,email,password,date_of_birth,usertype_id FROM users WHERE email=?');
$query->bind_param('s', $email);
$query->execute();

$query->store_result();
$num_rows = $query->num_rows();
$query->bind_result($id, $name, $email, $hashed_password, $date_of_birth, $usertype_id);
$query->fetch();
$response = [];
if ($num_rows == 0) {
    $response['response'] = "email not found";
} else {
    if (password_verify($password, $hashed_password)) {
        $response['user_id'] = $id;
        $response['name'] = $name;
        $response['email'] = $email;
        $response['date_of_birth'] = $date_of_birth;
        $response['usertype_id'] = $usertype_id; 
        $response['response'] = "logged in";
    } else {
        $response["response"] = "Incorrect password";
    }
}
echo json_encode($response);
?>
