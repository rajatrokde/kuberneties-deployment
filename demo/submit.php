<?php
// Define cluster DNS names
$read_servername = "mysql-read-service.default.svc.cluster.local";
$write_servername = "mysql-write-service.default.svc.cluster.local";
$username = "username";
$password = "password";
$dbname = "database_name";

// Create connections
$read_conn = new mysqli($read_servername, $username, $password, $dbname);
$write_conn = new mysqli($write_servername, $username, $password, $dbname);

// Check connections
if ($read_conn->connect_error) {
    die("Read connection failed: " . $read_conn->connect_error);
}
if ($write_conn->connect_error) {
    die("Write connection failed: " . $write_conn->connect_error);
}

// Function to handle read operations
function readData($conn, $query) {
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "Data: " . $row["column_name"] . "<br>";
        }
    } else {
        echo "No data found.";
    }
}

// Function to handle write operations
function writeData($conn, $query) {
    if ($conn->query($query) === TRUE) {
        echo "Operation successful.";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Example usage
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    
    if ($action === 'read') {
        $query = "SELECT * FROM table_name"; // Replace with your read query
        readData($read_conn, $query);
    } elseif ($action === 'write') {
        $query = "INSERT INTO table_name (column1, column2) VALUES ('value1', 'value2')"; // Replace with your write query
        writeData($write_conn, $query);
    }
}

// Close connections
$read_conn->close();
$write_conn->close();
?>
