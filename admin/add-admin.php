<!DOCTYPE html>
<html lang="en">
<?php include('inc/head.php'); ?>
<body>
    <?php include('inc/menu.php'); ?>

    <div class="main-content">
        <div class="wrapper">
            <h1>Add Admin</h1>

            <br><br>
            <form action="" method="POST">

                <table style="width: 30%;">
                    <tr>
                        <td>Full Name:</td>
                        <td>
                            <input type="text" name="full_name" placeholder="Enter your name" autocomplete="off" required>
                        </td>
                    </tr>

                    <tr>
                        <td>Username :</td>
                        <td>
                            <input type="text" name="username" placeholder="Enter your username" autocomplete="off" required>
                        </td>
                    </tr>

                    <tr>
                        <td>Password :</td>
                        <td>
                            <input type="password" name="password" placeholder="Enter your password"  required>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <input type="submit" value="Add admin" name="submit" class="btn-secondary">
                        </td>
                    </tr>
                </table>


            </form>

        </div>
    </div>


    <?php include('inc/footer.php'); ?>
</body>
</html>

<?php 

    // require('../config/database.php');
    
    //Check if the formular is validate
    if(isset($_POST['submit'])){
        
        //Get the formular data
        $full_name = htmlspecialchars($_POST['full_name']);
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars(md5($_POST['password']));

        //Insert Admin in database
        $insertAdmin = $bdd->prepare('INSERT INTO tbl_admin(full_name, user_name, password)VALUES(?, ?, ?)');
        $insertAdmin->execute(array($full_name, $username, $password));

        //Check wether the insertion succeeded or not and display the error or success message
        if($insertAdmin==true){
            $_SESSION['add'] = "<div class='success' style='color: #2ed573;'>Admin added successfully</div>";
        }else{
            $_SESSION['add'] = "<div class='error' style='color: #ff4757;'>Failed to add admin. Try later.</div>";
        }

        //Redirection...
        header('Location:'.SITEURL.'admin/manage-admin.php');

    }

?>