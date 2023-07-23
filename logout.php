<?php
session_start();
session_destroy();
?>

<html>

<head>
    <title>Movie Shack</title>
    <link rel="stylesheet" type="text/css" href="./css/style.css">
    <script>
        setTimeout(function() {
            window.location.href = "index.php";
        }, 1000); // Delay of 2 seconds (2000 milliseconds)
    </script>
</head>

<body>

    <?php include "frontend/header.php"; ?>
    <main>
        <h1>Logged out successfully</h1>
    </main>
</body>

</html>