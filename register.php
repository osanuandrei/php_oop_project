<?php
include 'index.php';
$database = new Database();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];


    $existingUser = $database->checkExistingUser($username);

    if (!$existingUser) {
    
        $registrationResult = $database->registerUser($username, $password);

        if ($registrationResult) {
            echo "Registration successful!";
            header('Location: user_dashboard.php'); 
            exit();
        } else {
            echo "Registration failed.";
        }
        
    } else {
        echo "Username already exists. Please choose another one.";
    }
}
?>
