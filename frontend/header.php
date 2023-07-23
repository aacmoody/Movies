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
echo "<a href='./AddMovie.php'>Add Movie</a>";
echo "<a href='./index.php'>Home</a>";
if ($loggedInUserID) {
    echo  "<a style='background:transparent;text-decoration: none; color: green'> Welcome $loggedInUserID </a>";
}
echo "</div>";
echo "<hr>";
?>
          