<?php require('../config/database.php') ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Food Order App</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    
    <div class="login">

        <h1 class="text-center">Login</h1><br><br>

        <?php 
        
            if (isset($_SESSION['login'])) {
                echo $_SESSION['login'];
                unset($_SESSION['login']);
                ?> 
                <br><br>
                <?php
            }
            if (isset($_SESSION['no-login'])) {
                echo $_SESSION['no-login'];
                unset($_SESSION['no-login']);
                ?> 
                <br><br>
                <?php
            }
            
        ?>

        <form action="" method="post" class="text-center">

            <label for="username">Username:</label><br>
            <input type="text" name="username" placeholder="Enter Username" required><br><br>

            <label for="password">Password:</label><br> 
            <input type="password" name="password" placeholder="Enter password" required><br><br>

            <input type="submit" value="Login" name="submit" class="btn-primary">

        </form><br><br> 

        <p class="text-center">Created By - <a href="#">KozDaily</a></p>

    </div>

</body>
</html>


<?php 

    //Check if the formular is validated
    if (isset($_POST['submit'])) {
        
        //Get data from formular 
        $username = htmlspecialchars($_POST['username']);
        $password = md5($_POST['password']);


        //check wether user exist or not in database
        $checkUser = $bdd->prepare('SELECT * FROM tbl_admin WHERE user_name = ? AND password = ?');
        $checkUser->execute(array($username, $password));

        if ($checkUser->rowCount() == 1) {
            
            //User authentification and process of redirection
            $_SESSION['login'] = "<div class='success'>Admin logged successfully.</div>";
            $_SESSION['user'] = $username;

            header('Location: ' .SITEURL. 'admin/');

        }else{

            $_SESSION['login'] = "<div class='error text-center'>Login failed. Username or password did not match.</div>";
            header('Location: ' .SITEURL. 'admin/login.php');

        }


    }

?>