<?php
// Database connection settings
$servername = "localhost";
$username = "root"; // or your MySQL username
$password = "";     // your MySQL password
$dbname = " library_system";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data and sanitize
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // hash password for security

    // Validate inputs (simple version)
    if (!empty($name) && !empty($email) && !empty($password)) {
        // Check if email already exists
        $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            echo "Email already registered.";
        } else {
            // Insert new user
            $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $email, $password);

            if ($stmt->execute()) {
                echo "Registration successful. <a href='index.php'>Go to login</a>";
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        }

        $check->close();
    } else {
        echo "Please fill in all fields.";
    }
}

$conn->close();
?>
