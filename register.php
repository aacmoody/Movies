<?php

// Include files
include_once  __DIR__ . "/database/dbconnection.php";

$connection = getDbConnecion();

// Function to display an error message in red
function displayErrorMessage($message) {
    echo "<h1 style='color: red;'>$message</h1>";
    echo "<a href='createaccount.php'>Go Back</a>";
    exit(); // Exit the script to prevent further execution
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $biography = $_POST['biography'];
    $role = $_POST['role'];
    $maiden = $_POST['maiden'];

    $name = mysqli_real_escape_string($connection, $name);
    $lastname = mysqli_real_escape_string($connection, $lastname);
    $username = mysqli_real_escape_string($connection, $username);
    $email = mysqli_real_escape_string($connection, $email);
    $biography = mysqli_real_escape_string($connection, $biography);
    $role = mysqli_real_escape_string($connection, $role);
    $maiden = mysqli_real_escape_string($connection, $maiden);

    // Check if username or email already exists
    $checkQuery = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
    $result = $connection->query($checkQuery);
    if ($result->num_rows > 0) {
        if ($result->fetch_assoc()['username'] === $username) {
            displayErrorMessage("Username already exists.");
        } else {
            displayErrorMessage("Email already in use.");
        }
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);


    $image = $_FILES['image']['tmp_name'];
    $imageSize = $_FILES['image']['size'];
    $maxImageSize = 10 * 1024 * 1024; // 10MB

    if ($imageSize > $maxImageSize) {
        displayErrorMessage("Registration failed. Image size exceeds the maximum limit.");
    }

    $imageData = addslashes(file_get_contents($image));


    $sql = "INSERT INTO users (username, password, name, lastname, email, biography, image, role, maiden) 
            VALUES ('$username', '$hashedPassword', '$name', '$lastname', '$email', '$biography', '$imageData', '$role', '$maiden')";

    if ($connection->query($sql) === TRUE) {
        echo "<h1>Registration successful</h1>";
        echo "<script>window.location.href = 'index.php';</script>";
    } else {
        echo "<h1>Registration failed</h1>";
    }
}

$connection->close();

?>

