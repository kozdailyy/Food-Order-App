<?php 

    include('../config/database.php');

    //check wether the id and the image name ist set or not
    if (isset($_GET['id']) && isset($_GET['image_name'])) {
        
        //Get the value and delete
        $id = $_GET["id"];
        $image_name = $_GET["image_name"];

        //Remove image if available
        if ($image_name != "") {
            
            //Image available so remove it
            $path = "../assets/img/category/" .$image_name;
            $remove = unlink($path);

            //If Failed to remove Image
            if ($remove == false) {
                
                //Display error message
                $_SESSION['remove'] = "<div class='error'>Failed to remove Category image.</div>";
                //Redirect to Manage Category Page
                header('Location: ' .SITEURL. 'admin/manage-category.php');
                //Stop the process
                die();
            }

        }

        $deleteCategory = $bdd->prepare('DELETE FROM tbl_category WHERE id = ?');
        $deleteCategory->execute(array($id));

        //Check wether the Category is deleted from database or not and set message and redirect
        if ($deleteCategory == true) {
            
            $_SESSION['delete'] = "<div class='success'>Category deleted successfully.</div>";

        } else {

            $_SESSION['delete'] = "<div class='error'>Failed to delete Category.</div>";

        }

        header('Location: ' .SITEURL. 'admin/manage-category.php');


    } else {

        //Redirect to manage-category page
        header('Location: ' .SITEURL. 'admin/manage-category.php');
        
    }

?>