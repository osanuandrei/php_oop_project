<?php
class Database {
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "proiect_php_oop_2";
    private $conn;

    public function __construct() {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
        
    }
    
public function registerUser($username, $password) {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$hashedPassword')";
    return $this->conn->query($sql);
}


    public function getConnection() {
        return $this->conn;
    }
    public function getTicketNumber($eventId) {
        // Conectează-te la baza de date
        $connection = $this->getConnection();
    
        // Prepară și execută interogarea SQL pentru a prelua numărul biletului
        $sql = "SELECT bilete_inregistrare FROM eveniment WHERE id = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("i", $eventId);
        $stmt->execute();
        $stmt->bind_result($ticketNumber);
    
        // Verifică dacă s-a găsit un rezultat
        if ($stmt->fetch()) {
            // Închide declarația și returnează numărul biletului
            $stmt->close();
            return $ticketNumber;
        } else {
            // Închide declarația și returnează o valoare semnificativă dacă nu s-a găsit niciun rezultat
            $stmt->close();
            return "Not available";
        }
    }
    

    public function checkExistingUser($username) {
        $sql = "SELECT * FROM users WHERE username = '$username'";
        $result = $this->conn->query($sql);
    
        return $result->num_rows > 0;
    }

    public function addEvent($titlu, $despre, $data, $sponsors, $location, $agenda, $speakers, $bileteInregistrare) {
        $sql = "INSERT INTO eveniment (titlu, despre, data_si_ora, sponsors, location, agenda, speakers, bilete_inregistrare) 
        VALUES ('$titlu', '$despre', '$data','$sponsors','$location', '$agenda', '$speakers', '$bileteInregistrare')";
        $this->conn->query($sql);
        $this->createEventPage($titlu, $despre, $data, $sponsors, $location, $agenda, $speakers, $bileteInregistrare);
    }

    public function checkCredentials($username, $password, $table) {
        $db = new mysqli($this->host, $this->username, $this->password, $this->database);
        $sql = "SELECT * FROM $table WHERE username = '$username' AND password = '$password'";
        $result = $db->query($sql);
        if ($result->num_rows === 1) {
            return true;
        } else {
            return false;
        }
    }
    public function executeQuery($sql) {
        $result = $this->conn->query($sql);

        if (!$result) {
            die("Error executing query: " . $this->conn->error);
        }

        return $result;
    }


    public function getEvents() {
        $db = new mysqli($this->host, $this->username, $this->password, $this->database);
        $sql = "SELECT * FROM eveniment";
        $result = $db->query($sql);

        return $result;
    }

    function removeEvent($eventId) {
        // Create and execute a query to fetch the event details
        $connection = new mysqli('localhost', 'root', '', 'proiect_php_oop_2');
        $sql = "DELETE FROM eveniment WHERE id = $eventId";
        $result = $connection->query($sql);
    }

    function fetchEventById($eventId) {
        // Create and execute a query to fetch the event details
        $connection = new mysqli('localhost', 'root', '', 'proiect_php_oop_2');
        $sql = "SELECT * FROM eveniment WHERE id = $eventId";
        $result = $connection->query($sql);
    
        if ($result) {
            if ($result->num_rows == 1) {
                // Fetch and return the event data
                $eventData = $result->fetch_assoc();
                return $eventData;
            } else {
                // Event not found
                return null;
            }
        } else {
            // Query execution failed
            return null;
        }
    }

    public function createEventPage($titlu, $despre, $data, $sponsors, $location, $agenda, $speakers, $bilete_inregistrare) {
        $htmlContent = "<!DOCTYPE html>
        <html>
        <head>
            <title>Generated HTML</title>
        </head>
        <body>
            <h1>Hello, World!</h1>
            <p>Titlul evenimentului: $titlu</p>
            <p>Descrierea evenimentului: $despre</p>
            <p>Data evenimentului: $data</p>
            <p>Sponsorii evenimentului: $sponsors</p>
            <p>Locatia evenimentului: $location</p>
            <p>Agenda evenimentului: $agenda</p>
            <p>Vorbitori evenimentului: $speakers</p>
            <p>Bilete-inregistrare: $bilete_inregistrare</p>
        </body>
        </html>";
    
        // Define the path to the HTML file you want to create
        // $filePath = "./generated_html.html";
        $filePath = "./" . $titlu . ".html";
        // var_dump(file_put_contents($filePath, $htmlContent));
        // Use file_put_contents to create or overwrite the HTML file
        if (file_put_contents($filePath, $htmlContent) !== false) {
            echo "HTML file generated successfully at $filePath";
        } else {
            echo "Failed to generate the HTML file.";
        }
    }
    
    
    
    function updateEvent($eventId, $newTitle, $newDescription, $newDate, $newLocation, $newSponsors, $newAgenda, $newSpeakers, $newBileteInregistrare) {
        $connection = new mysqli('localhost', 'root', '', 'proiect_php_oop_2');
        $sql = "UPDATE eveniment
                SET titlu = '$newTitle', despre = '$newDescription', sponsors = '$newSponsors', location = '$newLocation', 
                agenda = '$newAgenda', speakers = '$newSpeakers', bilete_inregistrare = '$newBileteInregistrare'
                WHERE id = $eventId";
        $result = $connection->query($sql);
    
        if ($result) {
            $this->createEventPage($newTitle, $newDescription, $newDate, $newSponsors, $newLocation, $newAgenda, $newSpeakers, $newBileteInregistrare);
            return true;
        } else {
            return false;
        }
    }
    
}

class User {
    private $db;
    private $loggedIn = false;
    private $username;

    public function __construct($database) {
        $this->db = $database;
    }

    public function loginAdmin($username, $password) {
        // Verify user credentials against the database.
        $userExists = $this->db->checkCredentials($username, $password, 'admins');

        if ($userExists) {
            $this->loggedIn = true;
            $this->username = $username;
            $_SESSION['username'] = $username;
        }
    }


    public function logout() {
        // End the user's session or revoke the authentication token.
        $this->loggedIn = false;
        $this->username = null;
        session_destroy();
    }

    public function isLoggedIn() {
        return $this->loggedIn;
    }

    public function getUsername() {
        return $this->username;
    }
}
session_start();