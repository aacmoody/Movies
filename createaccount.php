<?php
// Check PHP error
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Alert error
if (isset($_GET['error'])) {
    $error = $_GET['error'];
    echo '<script type="text/javascript">';
    echo " alert('ERROR :' + '$error')";
    echo '</script>';
}

// Alert success
if (isset($_GET['success'])) {
    $success = $_GET['success'];
    echo '<script type="text/javascript">';
    echo " alert('SUCCESS :' + '$success')";
    echo '</script>';
}

// Include register
include  __DIR__ . "/database/dbconnection.php";
include  __DIR__ . "/register.php";

?>

<!DOCTYPE html>
<html>

<head>
    <title>The Movie Shack</title>
    <link rel="stylesheet" type="text/css" href="./css/style.css">
</head>

<body>
    <?php include "frontend/header.php"; ?>
    <main>
        <div class="aligncenter">
            <h2>Create Account</h2>

            <form method="POST" action="register.php" enctype="multipart/form-data">
                Astrisk (*) are required fields
                <br><br>
                <label for="name">* Enter First Name</label>
                <input type="text" name="name" id="name" required><br>

                <label for="lastname">* Enter Last Name</label>
                <input type="text" name="lastname" id="lastname" required><br>
                <label for="lastname">* Enter Your Maiden Name (case sensitive):</label>
                <input type="password" name="maiden" id="maiden" required><br>

                <label for="username">* Enter Username</label>
                <input type="text" name="username" id="username" required><br>

                <label for="email">* Enter Email</label>
                <input type="text" name="email" id="email" required><br>

                <label for="password">* Enter Password (At least 8 characters, one capital letter, one number, and one symbol)</label>
                <input type="password" name="password" id="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{8,}" title="Please enter a password with at least 8 characters, one capital letter, one number, and one symbol." required>
                <br>
                <label for="biography">Enter Biography</label> <br>
                <textarea name="biography" id="biography" rows="4"></textarea><br>
                <br>
                <label for="image">Profile Image (File Size limited to 10MB) </label>
                <input type="file" name="image" id="image" accept="image/*"><br>

                <label for="role">* Enter Role</label>
                <input type="text" name="role" id="role" required><br>

                <input type="submit" value="Register" class="sumbitbutton">
            </form>
            <br>
        </div>
        <br><br><br><br>
    </main>
</body>

</html>