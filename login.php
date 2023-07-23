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

?>
<!DOCTYPE html>

<html>

<head>
    <title>Movie Shack</title>
    <link rel="stylesheet" type="text/css" href="./css/style.css">
</head>

<body>
    <?php include "frontend/header.php"; ?>
    <main>
        <br><br>
        <div class="aligncenter">

            <div id="frm">
                <h1>Login</h1>
                <form name="f1" action="authentication.php" onsubmit="return validation()" method="POST">
                    <p>
                        <label> UserName: </label>
                        <input type="text" id="user" name="user" />
                    </p>
                    <p>
                        <label> Password: </label>
                        <input type="password" id="pass" name="pass" />
                    </p>
                    <p>
                        <input type="submit" id="btn" value="Login" class="sumbitbutton" />
                    </p>
                </form>
                <br> <br>
                <p>
                    <a href="forgot_password.php">Forgot Password?</a>
                </p>
            </div>

            <script>
                function validation() {
                    var id = document.f1.user.value;
                    var ps = document.f1.pass.value;
                    if (id.length == "" && ps.length == "") {
                        alert("User Name and Password fields are empty");
                        return false;
                    } else {
                        if (id.length == "") {
                            alert("User Name is empty");
                            return false;
                        }
                        if (ps.length == "") {
                            alert("Password field is empty");
                            return false;
                        }
                    }
                }
            </script>
        </div>
    </main>
</body>

</html>