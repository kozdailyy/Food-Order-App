<?php 

    require('../config/database.php');


    if (isset($_GET['id']) && isset($_GET['image_name'])) {
        
        //Get the id and the image name
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //Remove image if available
        if ($image_name != "") {
            
            //Get the image path
            $path = "../assets/img/food/" .$image_name;

            //Remove the image file from folder
            $remove = unlink($path);

            //check wether the image is remove or not
            if ($remove == false) {
                
                $_SESSION['upload'] = "<div class='error'>Failed to remove the image.</div>";
                header('Location: ' .SITEURL. 'admin/manage-food.php');
                //Stop the process
                die();

            }

        }

        //Delete food from database
        $deleteFood = $bdd->prepare('DELETE FROM tbl_food WHERE id = ?');
        $deleteFood->execute(array($id));

        if ($deleteFood == true) {
            
            $_SESSION['delete'] = "<div class='success'>Food deleted successfully.</div>";
            header('Location: ' .SITEURL. 'admin/manage-food.php');

        } else {
            
            $_SESSION['delete'] = "<div class='error'>Failed to delete the food.</div>";
            header('Location: ' .SITEURL. 'admin/manage-food.php');
        }

    } else {
        
        $_SESSION['unauthorized'] = "<div class='error'>Unauthorized Access.</div>";
        header('Location: ' .SITEURL. 'admin/manage-food.php');

    }

?>