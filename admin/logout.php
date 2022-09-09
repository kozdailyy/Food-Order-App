<?php 

    require('../config/database.php');
    //destroy the current session
    session_destroy();

    //Redirection to login page
    header('Location: ' .SITEURL. 'admin/login.php');

?>