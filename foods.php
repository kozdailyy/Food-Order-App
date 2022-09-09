    <?php include('include/menu.php'); ?>

    <!-- food-Search -->
    <section class="food-search text-center">
        <div class="container">
            <form action="<?= SITEURL; ?>food-search.php" method="post">
                <input type="search" name="" placeholder="Search for food...">
                <input type="submit" value="submit" name="search" class="btn btn-primary">
            </form>
        </div>    
    </section>

    <!-- food-menu -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php 
            
                //Display Food that are active
                $getFood = $bdd->query('SELECT * FROM tbl_food WHERE active = "Yes"');

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
                                        
                                        <img src="<?= SITEURL; ?>assets/img/food/<?= $image_name; ?>" alt="<?= $image_name; ?>" class="img-logo img-curve"> 
                                        
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

    </section>

    <?php include('include/footer.php'); ?>
