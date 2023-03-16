<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
include('connections.php');

$response = array();

if (isset($_POST['employee_name'], $_POST['hospital_name'], $_POST['is_active'], $_POST['date_joined'])) {
    $employee_name = $_POST['employee_name'];
    $hospital_name = $_POST['hospital_name'];
    $is_active = ($_POST['is_active'] == 'on') ? 1 : 0;
    $date_joined = $_POST['date_joined'];

    $query = $mysqli->prepare('SELECT id FROM users WHERE name=?');
    $query->bind_param('s', $employee_name);
    $query->execute();
    $query->bind_result($employee_id);
    $query->fetch();
    $query->close();
    echo "hospital_id: ".$employee_id."\n"; // Debugging code
    $query = $mysqli->prepare('SELECT id FROM hospitals WHERE name=?');
    $query->bind_param('s', $hospital_name);
    $query->execute();
    $query->bind_result($hospital_id);
    $query->fetch();
    $query->close();
    echo "hospital_id: ".$hospital_id."\n"; // Debugging code
    $query = $mysqli->prepare('SELECT usertype_id FROM users WHERE name=?');
    $query->bind_param('s', $employee_name);
    $query->execute();
    $query->bind_result($user_type_id);
    $query->fetch();
    $query->close();
    echo "hospital_id: ".$user_type_id."\n"; // Debugging code
    if($user_type_id!=3){
        $response['error'] = "user is not an employee";
        echo $employee_id,$hospital_id;
    }else{
    
        if (!$employee_id || !$hospital_id) {
        $response['error'] = "employee or hospital not found";
    } else {
        $query = $mysqli->prepare('INSERT INTO hospital_users (hospital_id, user_id, is_active, date_joined) VALUES (?,?,?,?)');
        $query->bind_param('iiis', $hospital_id, $employee_id, $is_active, $date_joined);
        if ($query->execute()) {
            $response['status'] = "employee added";
        } else {
            $response['error'] = mysqli_stmt_error($query);
        }
        $query->close();
    }
}}
 else {
    $response['error'] = "required fields missing";
}


echo json_encode($response);
?>
