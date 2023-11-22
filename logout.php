<?php
include 'index.php';

echo "<h1>te-ai delogat</h1>";

$database = new Database();
$eventsResult = $database->getEvents();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <style>
       
    </style>
</head>
<body>

    <br>
    <p><a href="login_user.php">Login Again</a></p>
</body>
</html>
