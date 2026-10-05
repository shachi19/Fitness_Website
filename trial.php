<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$database = "Regt"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Function to save registration information
function registerUser($username, $password) {
    global $conn;
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO regtrial (username, password) VALUES ('$username', '$hashedPassword')";
    if ($conn->query($sql) === TRUE) {
        return "Registration successful";
    } else {
        return "Error: " . $sql . "<br>" . $conn->error;
    }
}


// Function to check login credentials
function loginUser($username, $password) {
    global $conn;
    $sql = "SELECT * FROM regtrial WHERE username='$username'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user["password"])) {
            echo "Login successful";
        } else {
            echo "Incorrect password";
        }
    } else {
        echo "User not found";
    }
}

// Function to get user information
function getUser($username) {
    global $conn;
    $sql = "SELECT * FROM regtrial WHERE username='$username'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        return $user;
    } else {
        return null;
    }
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
       if (isset($_POST["register"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];
        $message = registerUser($username, $password);
        echo "<script>alert('$message');</script>";
    } elseif (isset($_POST["login"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];
        loginUser($username, $password);
    }
}

// Close connection
$conn->close();
?>
