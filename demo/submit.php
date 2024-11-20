<?php
// Configuration for database connections
$read_host = "READ_CLUSTER_IP";
$write_host = "WRITE_CLUSTER_IP";
$db_user = "root";
$db_password = "password";
$db_name = "students";

// Create database connections
$read_conn = new mysqli($read_host, $db_user, $db_password, $db_name);
$write_conn = new mysqli($write_host, $db_user, $db_password, $db_name);

// Check connections
if ($read_conn->connect_error) {
    die("Read connection failed: " . $read_conn->connect_error);
}
if ($write_conn->connect_error) {
    die("Write connection failed: " . $write_conn->connect_error);
}

// Function to handle read operations
function readData($read_conn, $query) {
    $result = $read_conn->query($query);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "Data: " . $row["column_name"] . "<br>";
        }
    } else {
        echo "No data found.";
    }
}

// Function to handle write operations
function writeData($write_conn, $query) {
    if ($write_conn->query($query) === TRUE) {
        echo "Operation successful.";
    } else {
        echo "Error: " . $write_conn->error;
    }
}

// Example usage
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assuming action type is passed in POST data
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
