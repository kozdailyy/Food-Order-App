    <?php include('include/menu.php'); ?>

    <?php 
    
        //check wether id is passed or not
        if (isset($_GET["category_id"])) {
            
            $category_id = $_GET["category_id"];

            //Get category title based on category id
            $getCategory = $bdd->prepare('SELECT * FROM tbl_category WHERE id = ?');
            $getCategory->execute(array($category_id));

            //Get Value from the database
            $cat = $getCategory->fetch();

            $category_title = $cat['title'];


        } else {
            
            header('Location: ' .SITEURL);

        }
    
    ?>

    <!-- fOOD sEARCH -->
    <section class="food-search text-center">
        <div class="container">
            
            <h2>Foods on <a href="#" class="text-white">"<?= $category_title; ?>"</a></h2>

        </div>
    </section>

    <!-- food-menu -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php 
            
                //Get food on selected category
                $getFood = $bdd->prepare("SELECT * FROM tbl_food WHERE category_id = ?");
                $getFood->execute(array($category_id));

                //check wether food available or not
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
                                        
                                        echo "<div class='error'>Image not Found.</div>";

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

        <p class="text-center">
            <a href="<?= SITEURL; ?>foods.php">See All Foods</a>
        </p>

    </section>

    <?php include('include/footer.php'); ?>