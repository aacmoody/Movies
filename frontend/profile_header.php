<?php
$loggedInUserID = $_SESSION['username'] ?? null;
$loggedInUserName = $_SESSION['name'] ?? null;

echo "<div id='header'>";

echo "<img src='images/logo/logo4.png' alt='Movie Shack' id='logo'>";

if ($loggedInUserID) {
    echo "<a href='logout.php'>Logout</a>";
    echo "<a href='./edit_profile.php'>EditProfile</a>";
} else {
    echo "<a href='./createaccount.php'>Create Account</a>";
    echo "<a href='./login.php'>Login</a>";
}
echo "<a href='./index.php'>Home</a>";
if ($loggedInUserID) {
    echo  "<a style='background:transparent;text-decoration: none; color: green'> Welcome $loggedInUserID </a>";
}
echo "</div>";
echo "<hr>";

/*
<div style="text-align: right;">
<a href="./index.php?uid=<?php echo $loggedInUserID; ?>">Home</a>
<a href="./logout.php?uid=<?php echo $loggedInUserID; ?>">Logout</a>
<a href="./edit_profile.php">Edit Profile</a>
<?php if (isset($_SESSION['loggedin']) && $_SESSION['username'] === 'admin') : ?>
    <a href="deleteprofile.php">Delete Profile</a>
<?php endif; ?>
</div>
*/
