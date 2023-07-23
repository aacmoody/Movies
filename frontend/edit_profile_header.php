<?php
$loggedInUserID = $_SESSION['username'] ?? null;
$loggedInUserName = $_SESSION['name'] ?? null;

echo "<div id='header'>";
echo "<img src='images/logo/logo4.png' alt='Movie Shack' id='logo'>";

if ($loggedInUserID) {
    echo "<a href='logout.php'>Logout</a>";
    echo "<a href='./profile.php?uid=$loggedInUserID'>$loggedInUserID</a>";
} else {
    echo "<a href='./createaccount.php'>Create Account</a>";
    echo "<a href='./login.php'>Login</a>";
}
echo "<a href='./index.php'>Home</a>";
echo "</div>";
echo "<hr>";
