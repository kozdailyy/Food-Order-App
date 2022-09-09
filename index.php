    <<?php include('include/menu.php'); ?>

    <!-- food-Search -->
    <section class="food-search text-center">
        <div class="container">
            <form action="<?= SITEURL; ?>food-search.php" method="post">
                <input type="search" name="search" placeholder="Search for food..." autocomplete="off" required>
                <input type="submit" value="Search" name="submit" class="btn btn-primary">
            </form>
        </div>    
    </section>

    <?php 
    
        if (isset($_SESSION['order'])) {
            
            echo $_SESSION['order'];
            unset($_SESSION['order']);

        }
    
    ?>

    <!-- categories -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>

            <?php 
            
                //Displaying Category from database
                $getCategory = $bdd->query('SELECT * FROM tbl_category WHERE featured = "Yes" AND active = "Yes" LIMIT 3');

                //check wether category is available or not
                if ($getCategory->rowCount() > 0) {
                    
                    while ($cat = $getCategory->fetch()) {
                        
                        //Get the value of the category
                        $id = $cat['id'];
                        $title = $cat['title'];
                        $image_name = $cat['image_name'];
                        ?>
                        
                        <a href="<?= SITEURL; ?>categories-foods.php?category_id=<?= $id; ?>">
                            <div class="box-3 float-container">
                                <?php 
                                
                                    //Check wether image is available or not
                                    if ($image_name == "") {
                                        
                                        echo "<div class='error'>Image not Available.</div>";

                                    } else {
                                        
                                        ?>
                                        <img src="<?= SITEURL; ?>assets/img/category/<?= $image_name; ?>" alt="pizza" class="img-logo img-curve">
                                        <?php

                                    }
                                
                                ?>
                                
                                <h3 class="float-text text-white"><?= $title; ?></h3>
                            </div>
                        </a>

                        <?php

                    }

                } else {
                    
                    echo "<div class='error'>Category not Added.</div>";

                }
            
            ?>

            <div class="clear-fix"></div>
        </div>
        
    </section>

    <!-- food-menu -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>
            
            <?php 
            
                //Get foods from database
                $getFood = $bdd->query('SELECT * FROM tbl_food WHERE featured = "Yes" AND active = "Yes" LIMIT 6');

                if ($getFood->rowCount() > 0) {
                    
                    while ($food = $getFood->fetch()) {
                        
                        $id = $food['id'];
                        $title = $food['title'];
                        $price = $food['price'];
                        $description = $food['description'];
                        $image_name = $food['image_name'];
                        ?>
                        
                        <div class="food-menu-box">
                            <div class="food-menu-img">
                                <?php 
                                
                                    if ($image_name == "") {
                                        
                                        echo "<div class='error'>Image not Available.</div>";

                                    } else {
                                        
                                        ?>
                                        <img src="<?= SITEURL; ?>assets/img/food/<?= $image_name; ?>" alt="Eru" class="img-logo img-curve"> 
                                        <?php

                                    }
                                
                                ?>
                                
                            </div>
                            <div class="food-menu-desc">
                                <h4><?= $title; ?></h4>
                                <p class="food-price"><?= $price; ?> FCFA</p>
                                <p class="food-detail"><?= $description; ?></p>
                                <br>
                                <a href="<?= SITEURL; ?>order.php?food_id=<?= $id; ?>" class="btn btn-primary">Order now</a>
                                <div class="clear-fix"></div>
                            </div>
                        </div>
                        
                        <?php

                    }

                } else {
                    
                    echo "<div class='error'>Food not Available.</div>";

                }

            
            ?>
            
            <div class="clear-fix"></div>

        </div>

        <p class="text-center">
            <a href="<?= SITEURL; ?>foods.php">See All Foods</a>
        </p>

    </section>

    <?php include('include/footer.php'); ?>