<?php require('delete-admin.php'); ?>

<!DOCTYPE html>
<html lang="en">
<?php include('inc/head.php'); ?>

<body>
    
    <?php require('inc/menu.php'); ?>

    <!-- Main section -->
    <div class="main-content">
        <div class="wrapper">
            <h1>MANAGE ADMIN</h1>

            <?php 
                if(isset($_SESSION['delete'])){
                    echo  $_SESSION['delete'];
                    unset($_SESSION['delete']);
                }
                if(isset($_SESSION['add'])){
                    echo $_SESSION['add'];
                    unset($_SESSION['add']);
                }
                if(isset($_SESSION['update'])){
                    echo $_SESSION['update'];
                    unset($_SESSION['update']);
                }
                if(isset($_SESSION['user-not-found'])){
                    echo $_SESSION['user-not-found'];
                    unset($_SESSION['user-not-found']);
                }
                if(isset($_SESSION['pwd-not-match'])){
                    echo $_SESSION['pwd-not-match'];
                    unset($_SESSION['pwd-not-match']);
                }
                if(isset($_SESSION['pwd-changed'])){
                    echo $_SESSION['pwd-changed'];
                    unset($_SESSION['pwd-changed']);
                }
            ?>

            <br><br>

            <a href="add-admin.php" class="btn-primary">Add Admin</a>
            <br><br><br>

            <table class="tbl-full">
                <tr>
                    <th>S.N</th>
                    <th>full name</th>
                    <th>username</th>
                    <th>Actions</th>
                </tr>

                <?php 
                    $getAllUsers = $bdd->query('SELECT * FROM tbl_admin');
                    $sn = 1;

                    if($getAllUsers->rowcount() > 0){

                        while($admin = $getAllUsers->fetch()){

                            
                            $id = $admin['id'];
                            $full_name = $admin['full_name'];
                            $user_name = $admin['user_name'];

                            ?> 
                            
                            <tr>
                                <td><?= $sn++; ?></td>
                                <td><?= $full_name; ?></td>
                                <td><?= $user_name; ?></td>
                                <td>
                                    <a href="change-password.php?id=<?= $id; ?>" class="btn-primary">Change password</a>
                                    <a href="update-admin.php?id=<?= $id; ?>" class="btn-secondary">Update admin</a>
                                    <a href="delete-admin.php?id=<?= $id; ?>" class="btn-danger">Delete admin</a>
                                </td>
                            </tr>
                            
                            <?php
                        }
                    }else{

                    }
                ?>

            </table>

        </div>
    </div>

    <?php include('inc/footer.php'); ?>


</body>
</html>