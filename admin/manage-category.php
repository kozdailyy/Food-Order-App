<!DOCTYPE html>
<html lang="en">
<?php include('inc/head.php') ?>

<body>

    <?php require('inc/menu.php'); ?>

    <!-- Main section -->
    <div class="main-content">
        <div class="wrapper">
            <h1>MANAGE CATEGORY</h1>
            <br><br>

            <?php 
            
                if (isset($_SESSION['add'])) {
                    echo $_SESSION['add'];
                    unset($_SESSION['add']);
                    ?> 
                    <br><br>
                    <?php
                }
                if (isset($_SESSION['remove'])) {
                    echo $_SESSION['remove'];
                    unset($_SESSION['remove']);
                    ?> 
                    <br><br>
                    <?php
                }
                if (isset($_SESSION['delete'])) {
                    echo $_SESSION['delete'];
                    unset($_SESSION['delete']);
                    ?> 
                    <br><br>
                    <?php
                }
                if (isset($_SESSION['no-category-found'])) {
                    echo $_SESSION['no-category-found'];
                    unset($_SESSION['no-category-found']);
                    ?> 
                    <br><br>
                    <?php
                }
                if (isset($_SESSION['update'])) {
                    echo $_SESSION['update'];
                    unset($_SESSION['update']);
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

            <a href="<?= SITEURL;?>admin/add-category.php" class="btn-primary">Add Category</a>
            <br><br><br>

            <table class="tbl-full">
                <tr>
                    <th>S.N</th>
                    <th>Title</th>
                    <th>Image</th>
                    <th>Featured</th>
                    <th>Active</th>
                    <th>Actions</th>
                </tr>

                <?php 
                
                    //Get All Category FROM Database
                    $getAllCategory = $bdd->query('SELECT * FROM tbl_category');

                    $sn = 1;

                    //Check wether we have data or not in database
                    if ($getAllCategory->rowCount() > 0) {
                        
                        //Display the data
                        while ($cat = $getAllCategory->fetch()) {
                            $id = $cat['id'];
                            $title = $cat['title'];
                            $image_name = $cat['image_name'];
                            $featured = $cat['featured'];
                            $active = $cat['active'];

                            ?>
                            
                            <tr>
                                <td><?= $sn++; ?></td>
                                <td><?= $title; ?></td>
                                <td>

                                    <?php 
                                    
                                        //check wether image_name is available or not
                                        if ($image_name != "") {
                                            ?>
                                            
                                            <img src="<?= SITEURL; ?>assets/img/category/<?= $image_name; ?>" alt="<?= $image_name; ?>" width="100px">
                                            
                                            <?php
                                        }else {
                                            echo "<div class='error'>Image not added.</div>";
                                        }

                                    ?>

                                </td>
                                <td><?= $featured; ?></td>
                                <td><?= $active; ?></td>
                                <td>
                                    <a href="<?= SITEURL; ?>admin/update-category.php?id=<?= $id; ?>&image_name=<?= $image_name; ?>" class="btn-secondary">Update Category</a>
                                    <a href="<?= SITEURL; ?>admin/delete-category.php?id=<?= $id; ?>&image_name=<?= $image_name; ?>" class="btn-danger">Delete Category</a>
                                </td>
                            </tr>
                            
                            <?php
                        }

                    }else{
                        ?> 
                        <tr>
                            <td colspan="6"><div class="error">No Category Added.</div></td>
                        </tr>
                        <?php
                    }
                
                ?>

            </table>

        </div>
    </div>

    <?php include('inc/footer.php'); ?>
    
    
</body>
</html>