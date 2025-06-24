<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Print received data for debugging
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

    $name = $_POST["name"];
    $email = $_POST["email_address"];
    $subject = $_POST["subject"];
    $phone = $_POST["phone"];
    $message = $_POST["message"];

    // Connect to MySQL (Database name is "contacts")
    $conn = new mysqli("localhost", "root", "", "contacts");

    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    } else {
        echo "Database connected successfully!<br>";
    }

    // Prepare SQL query (Table name is also "contacts")
    $stmt = $conn->prepare("INSERT INTO contacts (name, email, subject, phone, message) VALUES (?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Prepare statement failed: " . $conn->error);
    }

    $stmt->bind_param("sssss", $name, $email, $subject, $phone, $message);

    // Execute the query
    if ($stmt->execute()) {
        echo "Message sent successfully!";
    } else {
        die("Query execution failed: " . $stmt->error);
    }

    if ($stmt->execute()) {
        echo "<script>
            alert('Message sent successfully!');
            window.location.href = 'index.html';
        </script>";
    } else {
        echo "<script>
            alert('Error: Something went wrong.');
            window.location.href = 'index.html';
        </script>";
    }
    

    $stmt->close();
    $conn->close();
}
?>
