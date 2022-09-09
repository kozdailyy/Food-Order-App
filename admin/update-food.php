<?php 

    require('../config/database.php');
    // require('update-food-action.php');

?>
<!DOCTYPE html>
<html lang="en">
<?php include('inc/head.php'); ?>
<body>
    
    <?php include('inc/menu.php'); ?>

    <?php 
    
        if (isset($_GET['id'])) {
            
            $id = $_GET['id'];

            //Get selected Food
            $getFood = $bdd->prepare('SELECT * FROM tbl_food WHERE id = ?');
            $getFood->execute(array($id));

            //Get Infos of the selected food
            $foodInfos = $getFood->fetch();

            $title = $foodInfos['title'];
            $description = $foodInfos['description'];
            $price = $foodInfos['price'];
            $current_image = $foodInfos['image_name'];
            $category = $foodInfos['category_id'];
            $featured = $foodInfos['featured'];
            $active = $foodInfos['active'];

        } else {
            
            header('Location: ' .SITEURL. 'admin/manage-food.php');

        }
    
    ?>

    <div class="main-content">
        <div class="wrapper">
            <h1>Update Food</h1>
            <br><br>

            <form action="" method="post" enctype="multipart/form-data">

                <table class="tbl-30">

                    <tr>
                        <td>Title: </td>
                        <td>
                            <input type="text" name="title" value="<?= $title; ?>">
                        </td>
                    </tr>

                    <tr>
                        <td>Description: </td>
                        <td>
                            <textarea name="description" cols="30" rows="5"><?= $description; ?></textarea>
                        </td>
                    </tr>

                    <tr>
                        <td>Price: </td>
                        <td>
                            <input type="number" name="price" value="<?= $price; ?>">
                        </td>
                    </tr>

                    <tr>
                        <td>Current Image: </td>
                        <td>
                            <?php 
                            
                                if ($current_image == "") {
                                    
                                    echo "<div class='error'>Image Not Available.</div>";

                                } else {
                                    
                                    ?>
                                    <img src="<?= SITEURL; ?>/assets/img/food/<?= $current_image; ?>" alt="<?= $current_image; ?>" width="150px">
                                    <?php
                                    
                                }

                            ?>
                            
                        </td>
                    </tr>

                    <tr>
                        <td>New Image: </td>
                        <td>
                            <input type="file" name="image" >
                        </td>
                    </tr>

                    <tr>
                        <td>Category: </td>
                        <td>
                            <select name="category" >

                                <?php 
                                
                                    //Get Active Category
                                    $getCategory = $bdd->query('SELECT * FROM tbl_category WHERE active = "Yes"');
                                    if ($getCategory->rowCount() > 0) {
                                        
                                        while ($cat = $getCategory->fetch()) {
                                            
                                            $cat_title = $cat['title'];
                                            $cat_id = $cat['id'];
                                            ?>
                                            <option <?php if($category == $cat_id) { echo "selected"; } ?> value="<?= $cat_id; ?>"><?= $cat_title; ?></option>
                                            <?php

                                        }

                                    }else{
                                        echo "<option value='0'>Category Not Available.</option>";
                                    }
                                
                                ?>

                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>Featured: </td>
                        <td>
                            <input <?php if ($featured == "Yes") {echo "checked";} ?> type="radio" name="featured" value="Yes">Yes
                            <input <?php if ($featured == "No") {echo "checked";} ?> type="radio" name="featured" value="No">No
                        </td>
                    </tr>

                    <tr>
                        <td>Active: </td>
                        <td>
                            <input <?php if ($active == "Yes") { echo "checked"; } ?> type="radio" name="active" value="Yes">Yes
                            <input <?php if ($active == "No") { echo "checked"; } ?> type="radio" name="active" value="No">No
                        </td>
                    </tr>

                    <?php 
            
                        if (isset($_POST["submit"])) {
                            
                            //Get all details from the form
                            $id = $_POST["id"];
                            $title = htmlspecialchars($_POST["title"]);
                            $description = nl2br(htmlspecialchars($_POST["description"]));
                            $price = $_POST["price"];
                            $current_image = $_POST["current_image"];
                            $category = $_POST["category"];
                            $featured = $_POST["featured"];
                            $active = $_POST["active"];

                            //Upload the image if selected

                            //check wether upload button is clicked or not
                            if (isset($_FILES['image']['name'])) {
                                
                                $image_name = $_FILES['image']['name'];

                                //checked wether image is available or not
                                if ($image_name != "") {
                                    
                                    //rename the image
                                    $expl = explode('.', $image_name);
                                    $ext = end($expl);
                                    $image_name = "Food-Name-" .rand(0000, 9999). "." .$ext;

                                    //Get source path and destination path
                                    $src = $_FILES['image']['tmp_name'];
                                    $dest = "../assets/img/food/" .$image_name;

                                    //Upload the image
                                    $upload = move_uploaded_file($src, $dest);

                                    //Check wether the image is uploaded or not
                                    if ($upload == false) {
                                        
                                        $_SESSION['upload'] = "<div class='error'>Failed to upload to image.</div>";

                                        header('Location: ' .SITEURL. 'admin/manage-food.php');
                                        
                                        //Stop the process
                                        die();

                                    }

                                    //Remove current image if available
                                    if ($current_image != "") {
                                        
                                        //remove the image
                                        $remove_path = "../assets/img/food/" .$current_image;
                                        $remove = unlink($remove_path);

                                        //check wether image is remove or not
                                        if ($remove == false) {
                                            
                                            $_SESSION['remove-failed'] = "<div class='error'>Failed to remove current image.</div>";

                                            header('Location: ' .SITEURL. 'admin/manage-food.php');

                                            die();

                                        }

                                    }

                                }else {
                                    
                                    $image_name = $current_image;

                                }

                            }else {
                                
                                $image_name = $current_image;

                            }

                            //Update food in database
                            $updateFood = $bdd->prepare('UPDATE tbl_food SET title = ?, description = ?, price = ?, image_name = ?, category_id = ?, featured = ?, active = ? WHERE id = ?');
                            $updateFood->execute(array($title, $description, $price, $image_name, $category, $featured, $active, $id));

                            //Check wether the Update is successfully or not
                            if ($updateFood == true) {
                                
                                $_SESSION['update'] = "<div class='success'>Food Updated Succesfully.</div>";

                                header('Location: ' .SITEURL. 'admin/manage-food.php');

                            } else {
                                
                                $_SESSION['update'] = "<div class='error'>Failed to update Food.</div>";

                                header('Location: ' .SITEURL. 'admin/manage-food.php');

                            }

                        }

                    ?>


                    <tr>
                        <td>
                            <input type="hidden" name="current_image" value="<?= $current_image; ?>">
                            <input type="hidden" name="id" value="<?= $id; ?>">
                            <input type="submit" value="Update Category" name="submit" class="btn-secondary">
                        </td>
                    </tr>

                </table>

            </form>

        </div>
    </div>

    
    
    <?php include('inc/footer.php'); ?>


</body>
</html>