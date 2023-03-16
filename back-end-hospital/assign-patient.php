
<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
include('connections.php');

$response = array();

if (isset($_POST['patient_name'], $_POST['hospital_name'], $_POST['date_joined'])) {
    $patient_name = $_POST['patient_name'];
    $hospital_name = $_POST['hospital_name'];
    $date_joined = $_POST['date_joined'];
 
    $query = $mysqli->prepare('SELECT id FROM users WHERE name=?');
    $query->bind_param('s', $patient_name);
    $query->execute();
    $query->bind_result($patient_id);
    $query->fetch();
    $query->close();
    
    $query = $mysqli->prepare('SELECT id FROM hospitals WHERE name=?');
    $query->bind_param('s', $hospital_name);
    $query->execute();
    $query->bind_result($hospital_id);
    $query->fetch();
    $query->close();

    $query = $mysqli->prepare('SELECT COUNT(*) FROM hospital_users WHERE user_id=?');
    $query->bind_param('i', $patient_id);
    $query->execute();
    $query->bind_result($count);
    $query->fetch();
    $query->close();

    if ($count > 0) {
        $response['error'] = "patient already exists in the hospital";
    } else {
        $is_active = true;

        $query = $mysqli->prepare('INSERT INTO hospital_users (hospital_id, user_id, is_active, date_joined) VALUES (?,?,?,?)');
        $query->bind_param('iiss', $hospital_id, $patient_id, $is_active, $date_joined);
        if ($query->execute()) {
            $response['status'] = "patient added";
        } else {
            $response['error'] = mysqli_stmt_error($query);
        }
        $query->close();
    }
} else {
    $response['error'] = "required fields missing";
}

echo json_encode($response);
?>
