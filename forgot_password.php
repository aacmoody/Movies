<?php
include_once  __DIR__ . "/database/dbconnection.php";

$con = getDbConnecion();


if (isset($_POST['verifyUserName']) && isset($_POST['newPassword']) && isset($_POST['verifyMaiden'])) {
    $verifyUserName = $_POST['verifyUserName'];
    $newPassword = $_POST['newPassword'];
    $verifyMaiden = $_POST['verifyMaiden'];

    $query = "SELECT username, maiden FROM users WHERE username = '$verifyUserName'";
    $result = $con->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $storedMaiden = $row['maiden'];

        if ($verifyMaiden === $storedMaiden) {
            // Hash the password
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            $updateQuery = "UPDATE users SET password = '$hashedPassword' WHERE username = '$verifyUserName'";
            if ($con->query($updateQuery) === TRUE) {
                echo "Password reset successful.";
                sleep(2);
                header("Location: login.php");
            } else {
                echo "Error updating password: " . $con->error;
            }
        } else {
            echo "Verification failed. Please provide the correct maiden name.";
        }
    } else {
        echo "Username not found.";
    }
}
?>

<html>

<head>
    <title>Movie Shack</title>
    <link rel="stylesheet" type="text/css" href="./css/style.css">
</head>

<body>
    <?php include "frontend/header.php"; ?>
    <main>
        <div class="aligncenter">
            <div id="forgotPasswordForm">
                <h2>Forgot Password</h2>
                <form name="f2" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <p>
                        <label>Verify your username: </label>
                        <input type="text" id="verifyUserName" name="verifyUserName" />
                    </p>
                    <p>
                        <label>Verify your maiden name: </label>
                        <input type="password" id="verifyMaiden" name="verifyMaiden" />
                    </p>
                    <p>
                        <label>Enter a new password: </label>
                        <input type="password" id="newPassword" name="newPassword" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{8,}" title="Please enter a password with at least 8 characters, one capital letter, one number, and one symbol." />
                    </p>
                    <p>
                        <input type="submit" id="resetPasswordBtn" value="Reset Password" class="sumbitbutton"/>
                    </p>
                </form>
            </div>

            <script>
                function showForgotPassword() {
                    var forgotPasswordForm = document.getElementById("forgotPasswordForm");
                    forgotPasswordForm.style.display = "block";
                }
            </script>
        </div>
    </main>
</body>

</html>