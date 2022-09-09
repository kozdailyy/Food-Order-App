<!DOCTYPE html>
<html lang="en">
<?php include('inc/head.php'); ?>
<body>
    <?php require('inc/menu.php'); ?>

    <div class="main-content">
        <div class="wrapper">
            <h1>Change Password</h1>
            <br><br>

            <?php 
                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                } 
            ?>

            <form action="" method="post">

                <table class="tbl-30">

                    <tr>
                        <td>Current Password: </td>
                        <td>
                            <input type="password" name="current_password" placeholder="Current Password" required>
                        </td>
                    </tr>

                    <tr>
                        <td>New Password: </td>
                        <td>
                            <input type="password" name="new_password" placeholder="New Password" required>
                        </td>
                    </tr>

                    <tr>
                        <td>Confirm Password: </td>
                        <td>
                            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <input type="hidden" name="id" value="<?= $id; ?>">
                            <input type="submit" name="submit" value="Change Password" class="btn-secondary">
                        </td>
                    </tr>

                </table>

            </form>

        </div>
    </div>

    <?php 
    
        //Check if the formular is validated
        if (isset($_POST['submit'])) {

            //Get the formular data
            $id = $_POST['id'];
            $current_password = md5($_POST['current_password']);
            $new_password = md5($_POST['new_password']);
            $confirm_password = md5($_POST['confirm_password']);

            //Get the current_password of the admin
            $checkAdmin = $bdd->prepare('SELECT * FROM tbl_admin WHERE id = ? AND password = ?');
            $checkAdmin->execute(array($id, $current_password));

            if ($checkAdmin == true) {
                
                //Check wether at least an admin with that password exist or not
                if ($checkAdmin->rowCount() == 1) {
                    
                    //Check wether new and confirm password match or not
                    if ($new_password == $confirm_password) {
                        
                        //Update the password
                        $updatePassword = $bdd->prepare('UPDATE tbl_admin SET password = ? WHERE id = ?');
                        $updatePassword->execute(array($new_password, $id));

                        if($updatePassword == true){

                            $_SESSION['pwd-changed'] = "<div class='success'>Password changed successfully.</div>";

                        }else{
                            $_SESSION['pwd-changed'] = "<div class='error'>Password failed to change.</div>";
                        }


                    }else {
                        $_SESSION['pwd-not-match'] = "<div class='error'>Password Did Not Match.</div>";
                    }

                }else {
                    $_SESSION['user-not-found'] = "<div class='error'>User Not Found or Current Password Incorrect !</div>";
                }

                header('Location:' .SITEURL. 'admin/manage-admin.php');

            }
        }

    ?>


    <?php include('inc/footer.php'); ?>
</body>
</html>