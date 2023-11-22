<?php
include 'index.php';
$database = new Database();

$title = $_POST['title'];
$description = $_POST['description'];
$date = $_POST['date'];
$sponsors = $_POST['sponsors'];
$location = $_POST['location'];
$agenda = $_POST['agenda'];
$speakers = $_POST['speakers'];
$bileteInregistrare = $_POST['bilete'];

$database->addEvent($title, $description, $date, $sponsors, $location, $agenda, $speakers, $bileteInregistrare);
header('Location: dashboard.php');
?>
