    <?php include('config/database.php'); ?>
    <?php include('include/menu.php'); ?>

    <?php 
    
        //Check wether food id is set or not
        if (isset($_GET["food_id"])) {
            
            $food_id = $_GET["food_id"];

            //Get details of the selected food
            $getFood = $bdd->prepare('SELECT * FROM tbl_food WHERE id = ?');
            $getFood->execute(array($food_id));

            //check wether data is available or not
            if ($getFood->rowcount() == 1) {

                //Get data from database
                $food = $getFood->fetch();
                $title = $food['title'];
                $price = $food['price'];
                $image_name = $food['image_name'];

            } else {

                header('Location: ' .SITEURL);

            }

        } else {
            
            header('Location: ' .SITEURL);

        }
    
    ?>

    <!-- Food Search -->
    <section class="food-search">
        <div class="container">
            
            <h2 class="text-center text-white">Fill this form to confirm your order.</h2>

            <form action="" method="POST" class="order">
                <fieldset>
                    <legend>Selected Food</legend>

                    <div class="food-menu-img">
                        <?php 
                        
                            if ($image_name == "") {

                                echo "<div class='error'>Image Not Available.</div>";

                            } else {
                                
                                ?>
                                
                                <img src="<?= SITEURL; ?>assets/img/food/<?= $image_name; ?>" alt="<?= $image_name; ?>" class="img-logo img-curve">

                                <?php

                            }
                        
                        ?>
                    </div>
    
                    <div class="food-menu-desc">
                        <h3><?= $title; ?></h3>
                        <input type="hidden" name="food" value="<?= $title; ?>">

                        <p class="food-price"><?= $price; ?> FCFA</p>
                        <input type="hidden" name="price" value="<?= $price; ?>">

                        <div class="order-label">Quantity</div>
                        <input type="number" name="qty" class="input-responsive" value="1" required>
                        
                    </div>

                </fieldset>
                
                <fieldset>
                    <legend>Delivery Details</legend>
                    <div class="order-label">Full Name</div>
                    <input type="text" name="full-name" placeholder="E.g. Koz Daily" class="input-responsive" required>

                    <div class="order-label">Phone Number</div>
                    <input type="tel" name="contact" placeholder="E.g. 650xxxxxx" class="input-responsive" required>

                    <div class="order-label">Email</div>
                    <input type="email" name="email" placeholder="E.g. k33z@0daily.com" class="input-responsive" required>

                    <div class="order-label">Address</div>
                    <textarea name="address" rows="10" placeholder="E.g. Street, City, Country" class="input-responsive" required></textarea>

                    <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
                </fieldset>

            </form>

            <?php
            
                if (isset($_POST['submit'])) {

                    //Get details from the form
                    $food = $_POST['food'];
                    $price = $_POST['price'];
                    $qty = $_POST['qty'];
                    $total = $price * $qty;
                    $order_date = date("Y-m-d h:i:sa");
                    $status = "Ordered";  // Ordered, On Delivery, Delivered, Cancelled
                    $customer_name = htmlspecialchars($_POST['full-name']);
                    $customer_contact = htmlspecialchars($_POST['contact']);
                    $customer_email = htmlspecialchars($_POST['email']);
                    $customer_adress = htmlspecialchars($_POST['address']);

                    //Save the Order in database
                    $insertOrder = $bdd->prepare("INSERT INTO tbl_order SET food = ?, price = ?, qty = ?, total = ?, order_date = ?, status = ?, customer_name = ?, customer_contact = ?, customer_email = ?, customer_adress = ? ");
                    $insertOrder->execute(array($food, $price, $qty, $total, $order_date, $status, $customer_name, $customer_contact, $customer_email, $customer_adress));

                    //check if query executed successfully
                    if ($insertOrder == true) {
                        
                        $_SESSION['order'] = "<div class='success text-center'>Food Ordered Successfully.</div>";
                        header('location: ' .SITEURL);

                    } else {

                        $_SESSION['order'] = "<div class='error text-center'>Failed to order food.</div>";
                        header('location: ' .SITEURL);

                    }

                }
            
            ?>

        </div>
    </section>

    <?php include('include/footer.php'); ?>