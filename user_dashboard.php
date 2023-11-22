<?php
include 'index.php';
$database = new Database();

$eventsResult = $database->getEvents();
$username = $_SESSION['username'];
$userQuery = "SELECT * FROM users WHERE username = '$username'";
$userResult = $database->executeQuery($userQuery);


if ($userResult && $userResult->num_rows > 0) {
    $userData = $userResult->fetch_assoc();
    $displayName = $userData['username']; 
} else {
    $displayName = "Guest";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        h1 {
            color: #333;
        }

        .event-container {
            width: 80%;
            margin-top: 20px;
        }

        .event {
            background-color: #fff;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .event a {
            color: #3498db;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <h1>Welcome, <?php echo $displayName; ?>!</h1>

    <div class="event-container">
        <?php
        if ($eventsResult && $eventsResult->num_rows > 0) {
            while ($row = $eventsResult->fetch_assoc()) {
                echo "<div class='event'>";
                echo "<h2>{$row['titlu']}</h2>";
                echo "<p>{$row['despre']}</p>";
                echo "<p>Date: {$row['data_si_ora']}</p>";
                echo "<p>Location: {$row['location']}</p>";
                echo "<p>Agenda: {$row['agenda']}</p>";
                echo "<p>Speakers: {$row['speakers']}</p>";
                echo "<p>Sponsors: {$row['sponsors']}</p>";
                echo "<a href='buy_ticket.php?id={$row['id']}'>Buy Ticket</a>";
                echo "</div>";
            }
        } else {
            echo "<p>No events available.</p>";
        }
        ?>
    </div>

    <p><a href="logout.php">Logout</a></p>
</body>
</html>
