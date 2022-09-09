<!DOCTYPE html>
<html lang="en">
<?php include('inc/head.php') ?>
<body>

    <?php include('inc/menu.php') ?>

    <div class="main-content">
        <div class="wrapper">
            <h1>Add Food</h1>
            <br><br>

            <?php 
            
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
                            <input type="text" name="title" placeholder="Title of the food" required>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>Description: </td>
                        <td>
                            <textarea name="description" cols="30" rows="5" placeholder="Description of the Food."></textarea>
                        </td>
                    </tr>

                    <tr>
                        <td>Price: </td>
                        <td>
                            <input type="number" name="price">
                        </td>
                    </tr>

                    <tr>
                        <td>Select the Image: </td>
                        <td>
                            <input type="file" name="image">
                        </td>
                    </tr>

                    <tr>
                        <td>Category: </td>
                        <td>
                            <select name="category" >

                                <?php 
                                
                                    //Get all active categories from database
                                    $getCategory = $bdd->query('SELECT * FROM tbl_category WHERE active = "Yes"');

                                    if($getCategory->rowCount() > 0){

                                        while ($cat = $getCategory->fetch()) {
                                            
                                            $id = $cat['id'];
                                            $title = $cat['title'];
                                            ?>
                                            <option value="<?= $id; ?>"><?= $title; ?></option>
                                            <?php

                                        }

                                    }else {
                                        
                                        ?>
                                        <option value="0">No Category Found.</option>
                                        <?php

                                    }
                                
                                ?>

                            </select>
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
                            <input type="submit" value="Add Food" name="submit" class="btn-secondary">
                        </td>
                    </tr>


                </table>

            </form>

        </div>
    </div>



    <?php 

    if (isset($_POST['submit'])) {
        
        //Get the data from the form
        $title = htmlspecialchars($_POST["title"]);
        $description = nl2br($_POST["description"]);
        $price = htmlspecialchars($_POST["price"]);
        $category = $_POST["category"];

        if (isset($_POST["featured"])) {
            
            $featured = $_POST["featured"];

        } else {
            
            $featured = "No";

        }

        if (isset($_POST["active"])) {
            
            $active = $_POST["active"];

        } else {
            
            $active = "No";

        }

        //Upload image if selected
        if (isset($_FILES['image']['name'])) {
            
            //get the details of the image
            $image_name = $_FILES['image']['name'];

            if ($image_name != "") {
                
                //Rename the image
                $ext = end(explode('.', $image_name));

                $image_name = "Food-Name-" .rand(0000, 9999). "." .$ext;

                //Upload the image
                //Source Path
                $src = $_FILES['image']['tmp_name'];

                //Destination path
                $dst = "../assets/img/food/" .$image_name;

                //Now upload the image
                $upload = move_uploaded_file($src, $dst);

                //Check wether the image is uploaded or not
                if ($upload == false) {
                    
                    $_SESSION['upload'] = "<div class='error'>Failed to upload the image.</div>";
                    header('Location: ' .SITEURL. 'admin/add-food.php');
                    die();

                }

            }

        }else {
            
            //Set the default value as blank
            $image_name = "";

        }


        //Insert the data in the database
        $insertFood = $bdd->prepare('INSERT INTO tbl_food SET title = ?, description = ?, price = ?, image_name = ?, category_id = ?, featured = ?, active = ?');
        $insertFood->execute(array($title, $description, $price, $image_name, $category, $featured, $active));

        //Check wether data inserted or not
        if ($insertFood == true) {
            
            $_SESSION['add'] = "<div class='success'>Food Added successfully.</div>";
            header('Location: ' .SITEURL. 'admin/manage-food.php');

        } else {
            
            $_SESSION['add'] = "<div class='error'>Failed to add food.</div>";

            header('Location: ' .SITEURL. 'admin/manage-food.php');

        }


    }


    ?>


    <?php require('inc/footer.php') ?>
    
</body>
</html>

