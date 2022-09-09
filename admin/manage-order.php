<!DOCTYPE html>
<html lang="en">
<?php include('inc/head.php') ?>

<body>

    <?php require('inc/menu.php'); ?>

    <!-- Main section -->
    <div class="main-content">
        <div class="wrapper" style="width: 90%;">
            <h1>MANAGE ORDER</h1>
            <br><br><br>

            <?php 
            
                if (isset($_SESSION['update'])) {
                    echo $_SESSION['update'];
                    unset($_SESSION['update']);
                    ?> 
                    <br><br>
                    <?php
                }
            
            ?>

            <table class="tbl-full">
                <tr>
                    <th>S.N</th>
                    <th>Food</th>
                    <th>Price</th>
                    <th>Qty.</th>
                    <th>Total</th>
                    <th>Order Date</th>
                    <th>Status</th>
                    <th>Customer Name</th>
                    <th>Contact</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>

                <?php 
                
                    //Get all the order from the database
                    $getOrder = $bdd->query('SELECT * FROM tbl_order ORDER BY id DESC');

                    $sn = 1;

                    if ($getOrder->rowCount() > 0) {
                        
                        while ($order = $getOrder->fetch()) {
                            
                            //Get all the order details
                            $id = $order['id'];
                            $food = $order['food'];
                            $price = $order['price'];
                            $qty = $order['qty'];
                            $total = $order['total'];
                            $order_date = $order['order_date'];
                            $status = $order['status'];
                            $customer_name = $order['customer_name'];   
                            $customer_contact = $order['customer_contact'];
                            $customer_email = $order['customer_email'];
                            $customer_address = $order['customer_adress'];

                            ?>
                            
                            <tr>
                                <td><?= $sn++; ?>.</td>
                                <td><?= $food; ?></td>
                                <td><?= $price; ?></td>
                                <td><?= $qty; ?></td>
                                <td><?= $total; ?></td>
                                <td><?= $order_date; ?></td>
                                <td>
                                    <?php 
                                    
                                        if ($status == "Ordered") {
                                            
                                            echo "<label>$status</label>";
                                            
                                        } elseif ($status == "On Delivery") {
                                            
                                            echo "<label style='color: orange;'>$status</label>";

                                        } elseif ($status == "Delivered") {
                                            
                                            echo "<label style='color: green;'>$status</label>";

                                        } else {

                                            echo "<label style='color: red;'>$status</label>";

                                        }
                                    
                                    ?>
                                </td>
                                <td><?= $customer_name; ?></td>
                                <td><?= $customer_contact; ?></td>
                                <td><?= $customer_email; ?></td>
                                <td><?= $customer_address; ?></td>
                                <td>
                                    <a href="<?= SITEURL; ?>admin/update-order.php?id=<?= $id; ?>" class="btn-secondary">Update Order</a>
                                </td>
                            </tr>
                            
                            <?php

                        }

                    } else {
                        
                        echo "<tr><td colspan='12' class='error'>Order not Available.</td></tr>";

                    }
                
                ?>

                
            </table>

        </div>
    </div>

    <?php include('inc/footer.php'); ?>
    
    
</body>
</html>