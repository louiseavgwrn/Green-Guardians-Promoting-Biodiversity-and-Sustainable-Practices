<?php
session_start();

// Destroy all session data
session_unset();
session_destroy();

// Redirect to the login page or index page
header("Location: index.php");
exit;
?>
    