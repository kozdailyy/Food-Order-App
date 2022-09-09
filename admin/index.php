<!DOCTYPE html>
<html lang="en">
<?php include('inc/head.php'); ?>
<body>
    
<?php require('inc/menu.php'); ?>

    <!-- Main section -->
    <section class="main-content">
        <div class="wrapper">
            <h1>DASHBOARD</h1>
            <br><br>
            <?php 
                if (isset($_SESSION['login'])) {
                    echo $_SESSION['login'];
                    unset($_SESSION['login']);
                    ?> 
                    <br><br>
                    <?php
                }
            ?>

            <div class="col-4 text-center">

                <?php 
                
                    $getCategory = $bdd->query('SELECT * FROM tbl_category');
                    $count = $getCategory->rowCount();
                
                ?>

                <h1><?= $count; ?></h1>
                <br>
                Categories
            </div>

            <div class="col-4 text-center">

                <?php 
                    
                    $getFood = $bdd->query('SELECT * FROM tbl_food');
                    $count2 = $getFood->rowCount();
                
                ?>

                <h1><?= $count2; ?></h1>
                <br>
                Foods
            </div>

            <div class="col-4 text-center">

                <?php 
                    
                    $getOrder = $bdd->query('SELECT * FROM tbl_order');
                    $count3 = $getOrder->rowCount();
                
                ?>

                <h1><?= $count3; ?></h1>
                <br>
                Total Order
            </div>

            <div class="col-4 text-center">

                <?php 
                    
                    $getRevenue = $bdd->query('SELECT SUM(total) AS Total FROM tbl_order WHERE status="Delivered"');

                    $row = $getRevenue->fetch();

                    $totalRevenue = $row['Total'];
                
                ?>

                <h1><?= $totalRevenue; ?>XAF</h1>
                <br>
                Revenue Generated
            </div>

            <div class="clear-fix"></div>
        </div>
    </section>

    
    <?php include('inc/footer.php'); ?>


</body>
</html>