// Settings/core.php
<?php
session_start();


//for header redirection
ob_start();

//function to check for login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit;
}


//function to get user ID


//function to check for role (admin, customer, etc)



?>