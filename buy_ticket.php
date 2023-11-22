<?php
include 'index.php';
$database = new Database();

// Verifică dacă există un ID eveniment în parametrii GET
if (isset($_GET['id'])) {
    $eventId = $_GET['id'];

    // Aici poți să preiei numărul biletului înregistrat pentru evenimentul specificat
    $ticketNumber = $database->getTicketNumber($eventId);

    // Afisează mesajul
    echo "<h1>Thank you for your purchase, your ticket number is: $ticketNumber</h1>";
} else {
    // Dacă nu există un ID eveniment în parametrii GET, poți redirecționa utilizatorul sau afișa un mesaj de eroare
    echo "<p>Error: Event ID not provided.</p>";
}
?>
