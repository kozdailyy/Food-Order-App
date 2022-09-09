<!DOCTYPE html>
<html lang="en">
<?php include('inc/head.php'); ?>
<body>
    
    <?php require('inc/menu.php'); ?>

    <div class="main-content">
        <div class="wrapper">
            <h1>Update Category</h1>
            <br><br>


            <?php 
            
                //check wether the id is set or not
                if (isset($_GET["id"])) {
                    
                    $id = $_GET['id'];

                    $getCategory = $bdd->prepare('SELECT * FROM tbl_category WHERE id = ?');
                    $getCategory->execute(array($id));

                    if ($getCategory->rowCount() == 1) {

                        //Get all the data
                        $categoryInfos = $getCategory->fetch();
                        $title= $categoryInfos['title'];
                        $currentImage = $categoryInfos['image_name'];
                        $featured = $categoryInfos['featured'];
                        $active = $categoryInfos['active'];

                    } else {
                        //Displaying error message and Redirection...
                        $_SESSION['no-category-found'] = "<div class='error'>Category Not Found.</div>";
                        header('Location: ' .SITEURL. 'admin/manage-category.php'); 
                    }

                } else {
                    
                    header('Location: ' .SITEURL. 'admin/manage-category.php');

                }
            
            ?>

            <form action="" method="post" enctype="multipart/form-data">

                <table class="tbl-30">

                    <tr>
                        <td>Title: </td>
                        <td>
                            <input type="text" name="title" value="<?= $title; ?>" required>
                        </td>
                    </tr>

                    <tr>
                        <td>Current Image: </td>
                        <td>
                            <?php 
                            
                                if ($currentImage != "") {
                                    
                                    ?>
                                    
                                    <img src="<?= SITEURL; ?>assets/img/category/<?= $currentImage; ?>" alt="<?= $currentImage; ?>" width="150px">
                                    
                                    <?php

                                } else {
                                    echo "<div class='error'>Image not added.</div>";
                                }

                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td>New image: </td>
                        <td>
                            <input type="file" name="image">
                        </td>
                    </tr>

                    <tr>
                        <td>Featured: </td>
                        <td>
                            <input <?php if ($featured == "Yes") { echo "checked"; } ?> type="radio" name="featured" value="Yes">Yes
                            <input <?php if ($featured == "No") { echo "checked"; } ?> type="radio" name="featured" value="No">No
                        </td>
                    </tr>

                    <tr>
                        <td>Active: </td>
                        <td>
                            <input <?php if ($active == "Yes") { echo "checked"; } ?> type="radio" name="active" value="Yes">Yes
                            <input <?php if ($active == "No") { echo "checked"; } ?> type="radio" name="active" value="No">No
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <input type="hidden" name="current_image" value="<?= $currentImage; ?>">
                            <input type="hidden" name="id" value="<?= $id; ?>">
                            <input type="submit" value="Update Category" name="submit" class="btn-secondary">
                        </td>
                    </tr>

                </table>

            </form>



        </div>
    </div>


    <?php 

        if (isset($_POST["submit"])) {
            
            //Get All Value from the Form
            $id = $_POST["id"];
            $title = htmlspecialchars($_POST['title']);
            $currentImage = $_POST["current_image"];
            $featured = $_POST["featured"];
            $active = $_POST["active"];

            //Updating new image
            //Check wether image is selected or not
            if (isset($_FILES['image']['name'])) {
                
                //Get image details
                $image_name = $_FILES['image']['name'];

                //check wether image is available or not
                if ($image_name != "") {
                    
                    //Upload the new image

                    //Auto rename our image
                    //Get the extension of our image
                    $ext = end(explode('.', $image_name));

                    //Rename the image
                    $image_name = "Food_category" .rand(000, 999). '.' .$ext;

                    $source_path = $_FILES['image']['tmp_name'];

                    $destination_path = "../assets/img/category/" .$image_name;

                    //Finally upload the image
                    $upload = move_uploaded_file($source_path, $destination_path);

                    //checked if the upload failed and display the error message and redirect to the same page
                    if ($upload == false) {
                        $_SESSION['upload'] = "<div class='error'>Failed to upload image.</div>";

                        header('Location: ' .SITEURL. 'admin/manage-category.php');
                        
                        //break the operation
                        die();
                    }

                    //Remove the current Image if image is available
                    if ($currentImage != "") {
                        
                        $remove_path = "../assets/img/category/".$currentImage;
                        $remove = unlink($remove_path);

                        if ($remove == false) {
                            
                            $_SESSION['remove'] = "<div class='error'>Failed to remove current image.</div>";
                            header('Location: ' .SITEURL. 'admin/manage-category.php');
                            die();
                        }

                    }

                } else {
                    
                    $image_name = $currentImage;
                }

            }else {
                
                $image_name = $currentImage;
            }

            //Update the database
            $updateImage = $bdd->prepare('UPDATE tbl_category SET title = ?, image_name = ?, featured = ?, active = ? WHERE id = ?');
            $updateImage->execute(array($title, $image_name, $featured, $active, $id));

            //Redirection to Manage Category Page with Message
            if ($updateImage == true) {
                
                $_SESSION['update'] = "<div class='success'>Category Update Successfully.</div>";

            } else {
                
                $_SESSION['update'] = "<div class='error'>Failed to Update Category.</div>";
                
            }
            
            header('Location: ' .SITEURL. 'admin/manage-category.php');

        }
    
    ?>

    <?php include('inc/footer.php'); ?>

</body>
</html>