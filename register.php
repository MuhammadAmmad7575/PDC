<?php

include 'db-config.php';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"));

    if (empty($data->username) || empty($data->email) || empty($data->password) ||empty($data->mobileNumber) ||empty($data->gender)) {
        http_response_code(400);
        echo json_encode(array("status" => false, "error" => "Fill all the required field(s)"), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        exit();
    }

    if (!filter_var($data->email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo json_encode(array("status" => false, "error" => "Invalid email format"), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        exit();
    }

    $email_check_query = "SELECT * FROM users WHERE email = ? and is_DELETED =0";
    $email_check_statement = $conn->prepare($email_check_query);
    $email_check_statement->bind_param("s", $data->email);
    $email_check_statement->execute();
    $email_check_result = $email_check_statement->get_result();

    if ($email_check_result->num_rows > 0) {
        http_response_code(409);
        echo json_encode(array("status" => false, "error" => "Email already exists"), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        exit();
    }

    $hashed_password = password_hash($data->password, PASSWORD_BCRYPT);
    $insert_query = "INSERT INTO users (username, email, password, mobileNumber, gender, is_deleted) VALUES (?, ?, ?, ?, ?, 0)";

    $insert_statement = $conn->prepare($insert_query);
    
    // Bind parameters using variables
    $insert_statement->bind_param("sssss", $data->username, $data->email, $hashed_password, $data->mobileNumber, $data->gender);

    if ($insert_statement->execute()) {
        
        http_response_code(201);
        echo json_encode(array("status" => true, "message" => "Survey completed successfully"), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
       
    } else {
        http_response_code(500);
        echo json_encode(array("status" => false, "error" => "Error: " . $conn->error), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
} else {
    http_response_code(405);
    echo json_encode(array("error" => "Invalid request method"), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
}

$conn->close();
?>
