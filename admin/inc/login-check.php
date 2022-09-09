<?php 

    if(!isset($_SESSION['user'])){
        $_SESSION['no-login'] = "<div class='error text-center'>Please login to access admin panel.</div>";

        header('Location: ' .SITEURL. 'admin/login.php');
    }

?>