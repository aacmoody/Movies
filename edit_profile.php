<?php
session_start();

include_once  __DIR__ . "/database/dbconnection.php";

$conn = getDbConnecion();

$uid = $_SESSION['username'];

$sql = "SELECT * FROM users WHERE username = '$uid'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();

    $firstName = $row['name'];
    $lastName = $row['lastname'];
    $biography = $row['biography'];
    $role = $row['role'];
    $email = $row['email'];
    $profileImage = $row['image'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the submitted form data
    $password = $_POST['password'];

    // Verify password
    $passwordQuery = "SELECT password FROM users WHERE username = '$uid'";
    $passwordResult = $conn->query($passwordQuery);
    if ($passwordResult->num_rows === 1) {
        $passwordRow = $passwordResult->fetch_assoc();
        $storedPassword = $passwordRow['password'];

        if (!password_verify($password, $storedPassword)) {
            echo "Error: Password is incorrect.";
            exit;
        }
    }

    $updateSql = "UPDATE users SET";

    if (!empty($_POST['name'])) {
        $newFirstName = $_POST['name'];
        $updateSql .= " name = '$newFirstName',";
    }
    if (!empty($_POST['lastname'])) {
        $newLastName = $_POST['lastname'];
        $updateSql .= " lastname = '$newLastName',";
    }
    if (!empty($_POST['biography'])) {
        $newBiography = $_POST['biography'];
        $updateSql .= " biography = '$newBiography',";
    }
    if (!empty($_POST['role'])) {
        $newRole = $_POST['role'];
        $updateSql .= " role = '$newRole',";
    }
    if (!empty($_POST['email'])) {
        $newEmail = $_POST['email'];
        $updateSql .= " email = '$newEmail',";
    }
    if (!empty($_FILES['image']['tmp_name'])) {
        $newProfileImage = addslashes(file_get_contents($_FILES['image']['tmp_name']));
        $updateSql .= " image = '$newProfileImage',";
    }
    if (!empty($_POST['new_password'])) {
        $newPassword = $_POST['new_password'];
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $updateSql .= " password = '$hashedPassword',";
    }

    // Remove trailing comma
    $updateSql = rtrim($updateSql, ",");

    $updateSql .= " WHERE username = '$uid'";

    if ($conn->query($updateSql) === TRUE) {
        echo "Profile updated successfully.";
        header("Location: profile.php?uid=$uid");
        exit;
    } else {
        echo "Error updating profile: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Movie Shack</title>
    <link rel="stylesheet" type="text/css" href="./css/style.css">
</head>

<body>
    <?php include "frontend/edit_profile_header.php"; ?>
    <main>
        <div class='aligncenter'>
            <h1>Edit Profile</h1>
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
                <label for="username">Username: <?php echo $uid; ?></label><br><br>
                <label for="name">First Name:</label>
                <input type="text" name="name" value="<?php echo $firstName; ?>"><br>
                <label for="lastname">Last Name:</label>
                <input type="text" name="lastname" value="<?php echo $lastName; ?>"><br>
                <label for="biography">Biography:</label><br>
                <textarea name="biography"><?php echo $biography; ?></textarea><br>
                <label for="role">Role:</label>
                <input type="text" name="role" value="<?php echo $role; ?>"><br>
                <label for="email">Email:</label>
                <input type="email" name="email" value="<?php echo $email; ?>"><br>
                <label for="image">Profile Image: (File Size limited to 10MB)</label>
                <input type="file" name="image"><br>
                <label for="new_password">New Password:</label>
                <input type="password" name="new_password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{8,}" title="Please enter a password with at least 8 characters, one capital letter, one number, and one symbol."><br>
                <br>
                <h4>To make changes, enter your current password and a new password:</h4>

                <label for="password">Current Password:</label>
                <input type="password" name="password"><br><br>
                <br>
                <input type="submit" value="Save Changes" class="sumbitbutton">
            </form>
            <br>
            <br>
            <hr>
            <br>
            <br>
            <span style="color: red">
                Warning! You cannot undo this action!
                <a href="delete_profile.php?uid=<?php echo $uid; ?>">Permanently Delete Profile</a>.
            </span>
            <br>
        </div>
    </main>
    <br><br><br><br>
</body>

</html>