<?php
include 'index.php';
$database = new Database();

$eventId = null;
$eventData = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $eventId = $_POST['eventId'];
    $eventData = [
        'titlu' => $_POST['title'],
        'despre' => $_POST['despre'],
        'data_si_ora' => $_POST['data_si_ora'],
        'sponsors' => $_POST['sponsors'],
        'location' => $_POST['location'],
        'agenda' => $_POST['agenda'],          
        'speakers' => $_POST['speakers'],     
        'bilete_inregistrare' => $_POST['bilete_inregistrare']  
    ];

    // Debugging: Output data to check if it's correct
    var_dump($eventId, $eventData);

    // Update the event
    $success = $database->updateEvent(
        $eventId,
        $eventData['titlu'],
        $eventData['despre'],
        $eventData['data_si_ora'],
        $eventData['location'],
        $eventData['sponsors'],
        $eventData['agenda'],                   
        $eventData['speakers'],                 
        $eventData['bilete_inregistrare']      
    );

    // Debugging: Check if the update was successful
    var_dump($success);

    if ($success) {
        // Redirect to the dashboard if the update was successful
        header('Location: dashboard.php');
        exit();
    } else {
        // Output an error message or handle the error accordingly
        echo "Error updating the event.";
    }
} elseif (isset($_GET['id'])) {
    $eventId = $_GET['id'];
    $eventData = $database->fetchEventById($eventId);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Event</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .edit-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        label {
            display: block;
            margin-top: 10px;
            font-size: 16px;
            color: #333;
        }

        .textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            box-sizing: border-box;
        }

        input[type="date"],
        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            box-sizing: border-box;
        }

        .button {
            background-color: #4caf50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 15px;
        }

        .button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <form method="post" class="edit-container" action="edit_event.php">
        <input type="hidden" name="eventId" value="<?php echo $eventId; ?>">
        <h1>Edit Event</h1>
        <label for="title">Titlu:</label>
        <input type="text" class="textarea" id="title" name="title" value="<?php echo isset($eventData['titlu']) ? $eventData['titlu'] : ''; ?>"><br>

        <label for="despre">Despre:</label>
        <input type="text" class="textarea" id="despre" name="despre" value="<?php echo isset($eventData['despre']) ? $eventData['despre'] : ''; ?>"><br>

        <label for="data_si_ora">Data si ora:</label>
        <input type="date" class="textarea" id="data_si_ora" name="data_si_ora" value="<?php echo isset($eventData['data_si_ora']) ? $eventData['data_si_ora'] : ''; ?>"><br>

        <label for="sponsors">Sponsori:</label>
        <input type="text" class="textarea" id="sponsors" name="sponsors" value="<?php echo isset($eventData['sponsors']) ? $eventData['sponsors'] : ''; ?>"><br>

        <label for="location">Locatie:</label>
        <input type="text" class="textarea" id="location" name="location" value="<?php echo isset($eventData['location']) ? $eventData['location'] : ''; ?>"><br>

        
        <label for="agenda">Agenda:</label>
        <input type="text" class="textarea" id="agenda" name="agenda" value="<?php echo isset($eventData['agenda']) ? $eventData['agenda'] : ''; ?>"><br>

        
        <label for="speakers">Speakeri:</label>
        <input type="text" class="textarea" id="speakers" name="speakers" value="<?php echo isset($eventData['speakers']) ? $eventData['speakers'] : ''; ?>"><br>

        
        <label for="bilete_inregistrare">Bilete/Înregistrare:</label>
        <input type="text" class="textarea" id="bilete_inregistrare" name="bilete_inregistrare" value="<?php echo isset($eventData['bilete_inregistrare']) ? $eventData['bilete_inregistrare'] : ''; ?>"><br>

        <input type="submit" value="Save Changes" class="button">
    </form>
</body>
</html>
