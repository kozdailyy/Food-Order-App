<!DOCTYPE html>
<html lang="en">
<?php include('inc/head.php'); ?> 
<body>
    <?php require('inc/menu.php'); ?>

    <div class="main-content">
        <div class="wrapper">
            <h1>Update Admin</h1>
            <br><br>

            <?php 
            
                $id = $_GET['id'];

                $getAdmin = $bdd->prepare('SELECT * FROM tbl_admin WHERE id = ?');
                $getAdmin->execute(array($id));

                if ($getAdmin==true) {
                    
                    if ($getAdmin->rowCount() == 1) {
                        
                        $adminInfos = $getAdmin->fetch();

                        $fullname = $adminInfos['full_name'];
                        $username = $adminInfos['user_name'];

                    }else{
                        header('Location:' .SITEURL. 'admin/manage-admin.php');
                    }
                }
            
            ?>

            <form action="" method="post">

                <table class="tbl-30">

                    <tr>
                        <td>Full Name:</td>
                        <td>
                            <input type="text" name="fullname" value="<?= $fullname; ?>" autocomplete="off" required>
                        </td>
                    </tr>

                    <tr>
                        <td>Username:</td>
                        <td>
                            <input type="text" name="username" value="<?= $username; ?>" autocomplete="off" required>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <input type="hidden" name="id" value="<?= $id; ?>">
                            <input type="submit" value="Update Admin" name="submit" class="btn-secondary">
                        </td>
                    </tr>

                </table>

            </form>

        </div>
    </div>

    <?php 
    
                if (isset($_POST['submit'])) {
                    
                    $id = $_POST['id'];
                    $fullname = htmlspecialchars($_POST['fullname']);
                    $username = htmlspecialchars($_POST['username']);

                    $updateAdmin = $bdd->prepare('UPDATE tbl_admin SET full_name = ?, user_name = ? WHERE id = ?');
                    $updateAdmin->execute(array($fullname, $username, $id));

                    if ($updateAdmin == true) {
                        $_SESSION['update'] = "<div class='success'>Admin updated successfully.</div>";
                    }else{
                        $_SESSION['update'] = "<div class='error'>Failed to update admin.</div>";
                    }

                    header('Location:' .SITEURL. 'admin/manage-admin.php');
                }
    
    ?>


    <?php include('inc/footer.php'); ?>

</body>
</html>