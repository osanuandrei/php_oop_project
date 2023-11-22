<?php
include 'index.php';

$database = new Database();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
        }
        .login-form-container { display: none }
        .table-row { dispay: block }
        .ul > * {
            display:block;
            margin-bottom:35px;
        }
        a {
            display:inline;
        }
        .container-supreme {
            display:flex;
            align-items:center;
            flex-direction:column;
            background: url('./background-dark.jpg') no-repeat;
            height:100vh;
            color:white; 
            justify-content:center;
        }
        label {
            display: block
        }

        td, th {
        padding-left:45px 
        }

        .form {
            margin-bottom:100px;
            text-align:center;
        }

    </style>
</head>
<body>
    <div class="container-supreme">
    <form method="post" action="process_create_event.php" class='form'>
    <h1>Create New Event</h1>

    <form method="post" action="proceseaza_formular.php">
        <label for="title">Titlu:</label>
        <input type="text" id="title" name="title" required>

        <label for="description">Descriere:</label>
        <textarea id="description" name="description" required></textarea>

        <label for="date">Data și ora:</label>
        <input type="datetime-local" id="date" name="date" required>

        <label for="sponsors">Sponsori:</label>
        <input type="text" id="sponsors" name="sponsors" required>

        <label for="location">Locație:</label>
        <input type="text" id="location" name="location" required>

        <label for="agenda">Agenda:</label>
        <textarea id="agenda" name="agenda"></textarea>

        <label for="speakers">Speakeri:</label>
        <input type="text" id="speakers" name="speakers">

        <label for="bilete">Bilete și înregistrare:</label>
        <textarea id="bilete" name="bilete"></textarea>

        <input type="submit" value="Adaugă eveniment" style="display: block; margin-top: 10px;">

    </form>
    </form>
    <?php
    $eventsResult = $database->getEvents();

    // Check if there are results
    if ($eventsResult) {
        echo "<table class='table'>";
        echo "<tr class='table-header'>";
        echo "<th>ID</th>";
        echo "<th>Titlu</th>";
        echo "<th>Despre</th>";
        echo "<th>Data si ora</th>";
        echo "<th>Locatie</th>";
        echo "<th>Sponsors</th>";
        echo "<th>Agenda</th>";
        echo "<th>Speakeri</th>";
        echo "<th>Bilete/Înregistrare</th>";
        echo "<th>Actiuni</th>";
        echo "</tr>";
    
        while ($row = $eventsResult->fetch_assoc()) {
            if(strlen($row['despre']) > 10) {
                $row['despre'] = substr($row['despre'], 0, 28) . '...';
            }
            echo "<tr class='table-row'>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['titlu']}</td>";
            echo "<td>{$row['despre']}</td>";
            echo "<td>{$row['data_si_ora']}</td>";
            echo "<td>{$row['location']}</td>";
            echo "<td>{$row['sponsors']}</td>";
            echo "<td>{$row['agenda']}</td>";
            echo "<td>{$row['speakers']}</td>";
            echo "<td>{$row['bilete_inregistrare']}</td>";
            echo "<td><a href='edit_event.php?id={$row['id']}'>Edit</a></td>";
            echo "<td><a href='remove_event.php?id={$row['id']}'>Delete</a></td>";
            echo "<td><a href='./{$row['titlu']}.html'>Vezi eveniment</a></td>";
            echo "</tr>";
        }
    
        echo "</table>";
    } else {
        echo "No events found.";
    }
?>
    </div>
</body>
</html>