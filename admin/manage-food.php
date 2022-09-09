<!DOCTYPE html>
<html lang="en">
<?php include('inc/head.php') ?>

<body>

    <?php require('inc/menu.php'); ?>

    <!-- Main section -->
    <div class="main-content">
        <div class="wrapper">
            <h1>MANAGE FOOD</h1>
            <br><br>

            <?php 
            
                if (isset($_SESSION['add'])) {
                    echo $_SESSION['add'];
                    unset($_SESSION['add']);
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

                if (isset($_SESSION['upload'])) {
                    echo $_SESSION['upload'];
                    unset($_SESSION['upload']);
                    ?> 
                    <br><br>
                    <?php
                }

                if (isset($_SESSION['unauthorized'])) {
                    echo $_SESSION['unauthorized'];
                    unset($_SESSION['unauthorized']);
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

                if (isset($_SESSION['remove-failed'])) {
                    echo $_SESSION['remove-failed'];
                    unset($_SESSION['remove-failed']);
                    ?> 
                    <br><br>
                    <?php
                }

            ?>

            <a href="<?= SITEURL; ?>admin/add-food.php" class="btn-primary">Add Food</a>
            <br><br><br>

            <table class="tbl-full">
                <tr>
                    <th>S.N</th>
                    <th>Title</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Featured</th>
                    <th>Active</th>
                    <th>Actions</th>
                </tr>

                <?php 
                
                    $getFood = $bdd->query('SELECT * FROM tbl_food');
                    
                    $sn = 1;

                    if ($getFood->rowCount() > 0) {
                        
                        while ($food = $getFood->fetch()) {
                            
                            $id = $food['id'];
                            $title = $food['title'];
                            $price = $food['price'];
                            $image_name = $food['image_name'];
                            $featured = $food['featured'];
                            $active = $food['active'];


                            ?>
                            
                            <tr>
                                <td><?= $sn++; ?></td>
                                <td><?= $title; ?></td>
                                <td><?= $price; ?></td>
                                <td>
                                    <?php 
                                    
                                        if ($image_name == "") {
                                            
                                            echo "<div class='error'>Image Not Added.</div>";

                                        } else {
                                            
                                            ?>
                                            
                                            <img src="<?= SITEURL; ?>assets/img/food/<?= $image_name; ?>" alt="<?= $image_name; ?>" width="100px">
                                            
                                            <?php
                                        }
                                    
                                    ?>
                                </td>
                                <td><?= $featured; ?></td>
                                <td><?= $active; ?></td>
                                <td>
                                    <a href="<?= SITEURL;?>admin/update-food.php?id=<?= $id; ?>&image_name=<?= $image_name; ?>" class="btn-secondary">Update food</a>
                                    <a href="<?= SITEURL;?>admin/delete-food.php?id=<?= $id; ?>&image_name=<?= $image_name; ?>" class="btn-danger">Delete food</a>
                                </td>
                            </tr>
                            
                            <?php
                        }

                    }else {
                        
                        echo "<tr><td colspan='7' class='error'> Food not added Yet. </td></tr>";

                    }
                
                ?>

              
            </table>

        </div>
    </div>

    <?php include('inc/footer.php'); ?>
    
    
</body>
</html>