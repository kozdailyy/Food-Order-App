    <?php require('include/menu.php'); ?>

    <!-- categories -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explolre Foods</h2>

            <?php 
            
                //Displaying all category that are active
                $getCategory = $bdd->query('SELECT * FROM tbl_category WHERE active = "Yes"');

                //check wether category is available or not
                if ($getCategory->rowCount() > 0) {
                    
                    while ($cat = $getCategory->fetch()) {
                        
                        $id = $cat['id'];
                        $title = $cat['title'];
                        $image_name = $cat['image_name'];
                        ?>
                        
                        <a href="<?= SITEURL; ?>categories-foods.php?category_id=<?= $id; ?>">
                            <div class="box-3 float-container">
                                <?php 
                                
                                    if ($image_name == "") {
                                        
                                        echo "<div class='error'>Image not Available.</div>";

                                    } else {
                                        ?>

                                        <img src="<?= SITEURL; ?>assets/img/category/<?= $image_name; ?>" alt="<?= $image_name; ?>" class="img-logo img-curve">
                                        
                                        <?php
                                        
                                    }
                                
                                ?>
                                
                                <h3 class="float-text text-white"><?= $title; ?></h3>
                            </div>
                        </a>
                        
                        <?php

                    }

                } else {
                    
                    echo "<div class='error'>Category  not Found.</div>";

                }
            
            ?>


            <div class="clear-fix"></div>
        </div>
        
    </section>

    <?php include('include/footer.php'); ?>