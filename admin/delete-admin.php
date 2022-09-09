<?php 

    require('../config/database.php');

    //Check if the id is set and if it's not empty
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        
        //Get id 
        $idOfAdmin = $_GET['id'];

        //Check if admin exists
        $checkIfAdminExists = $bdd->prepare('SELECT * FROM tbl_admin WHERE id = ?');
        $checkIfAdminExists->execute(array($idOfAdmin));

        if($checkIfAdminExists->rowCount() > 0){

            //Delete the admin
            $deleteAdmin = $bdd->prepare('DELETE FROM tbl_admin WHERE id = ?');
            $deleteAdmin->execute(array($idOfAdmin));

            
            if($deleteAdmin==true){
                $_SESSION['delete'] = "<div class='success' style='color: #2ed573;'>Admin deleted successfully</div>";
            }else{
                $_SESSION['delete'] = "<div class='error' style='color: #ff4757;'>Failed to delete admin. Try later.</div>";
            }

            header('Location:'.SITEURL.'admin/manage-admin.php');

        }
    }


?>