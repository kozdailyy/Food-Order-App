<!DOCTYPE html>
<html lang="en">
<?php include('inc/head.php') ?>
<body>
    
    <?php require('inc/menu.php'); ?>

    <div class="main-content">
        <div class="wrapper">
            <h1>Add Category</h1>
            <br><br>

            <?php 
            
                if (isset($_SESSION['add'])) {
                    echo $_SESSION['add'];
                    unset($_SESSION['add']);
                    ?> 
                    <br><br>
                    <?php
                }
                if (isset($_SESSION['upload'])) {
                    echo $_SESSION['upload'];
                    unset($_SESSION['upload']);
                    ?> 
                    <br><br>
                    <?php
                }

            ?>

            <form action="" method="post" enctype="multipart/form-data">

                <table class="tbl-30">

                    <tr>
                        <td>Title: </td>
                        <td>
                            <input type="text" name="title" placeholder="Category Title" required>
                        </td>
                    </tr>

                    <tr>
                        <td>Select Image: </td>
                        <td>
                            <input type="file" name="image" >
                        </td>
                    </tr>

                    <tr>
                        <td>Featured: </td>
                        <td>
                            <input type="radio" name="featured" value="Yes"> Yes
                            <input type="radio" name="featured" value="No"> No
                        </td>
                    </tr>

                    <tr>
                        <td>Active: </td>
                        <td>
                            <input type="radio" name="active" value="Yes"> Yes
                            <input type="radio" name="active" value="No"> No
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <input type="submit" value="Add Category" name="submit" class="btn-secondary">
                        </td>
                    </tr>

                </table>

            </form>


        </div>
    </div>



    <?php require('inc/footer.php'); ?>

</body>
</html>

<?php 

    //Check if user validate the formular
    if (isset($_POST['submit'])) {

        //Get the data of the image
        $title = htmlspecialchars($_POST['title']);
        
        //Check whether a radio button is checked or not
        //button Featured
        if (isset($_POST['featured'])) {
            $featured = $_POST['featured'];
        }else{
            $featured = "No";
        }

        //Button Active
        if (isset($_POST['active'])) {
            $active = $_POST['active'];
        }else{
            $active = "No";
        }

        //Check whether the image is selected or not 
        if (isset($_FILES['image']['name'])) {

            //Upload the image
            //To upload image we need image name, source_path and destination_path
            $image_name = $_FILES['image']['name'];

            //Upload the image if image is selected
            if($image_name != ""){

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

                    header('Location: ' .SITEURL. 'admin/add-category.php');
                    
                    //break the operation
                    die();
                }
                
            }

        } else {
            $image_name = "";
        }

        //insert the category to the database
        $insertCategory = $bdd->prepare('INSERT INTO tbl_category SET title = ?, image_name = ?, featured = ?, active = ?');
        $insertCategory->execute(array($title, $image_name, $featured, $active));

        //Check \whether the insertion has succeeded or not and display the error or the success message then proceed to redirection 
        if ($insertCategory == true) {
            $_SESSION['add'] = "<div class='success'>Category Added Successfully.</div>";

            header('Location: ' .SITEURL. 'admin/manage-category.php');
        }else {
            $_SESSION['add'] = "<div class='success'>Failed to add category. Try Again.</div>";

            header('Location: ' .SITEURL. 'admin/add-category.php');
        }
    }

?>