<?php include('../config/database.php'); ?>
<!DOCTYPE html>
<html lang="en">
<?php include('inc/head.php'); ?>
<body>

    <?php include('inc/menu.php'); ?>

    <div class="main-content">
        <div class="wrapper">
            <h1>Update Order</h1>
            <br><br>

            <?php 
            
                if (isset($_GET["id"])) {
                    
                    $id = $_GET["id"];

                    //get order based on the id
                    $getOrder = $bdd->prepare('SELECT * FROM tbl_order WHERE id =?');
                    $getOrder->execute(array($id));

                    if ($getOrder->rowCount() == 1) {
                        
                        $order = $getOrder->fetch();

                        $food = $order['food'];
                        $price = $order['price'];
                        $qty = $order['qty'];
                        $status = $order['status'];
                        $customer_name = $order['customer_name'];
                        $customer_contact = $order['customer_contact'];
                        $customer_email = $order['customer_email'];
                        $customer_address = $order['customer_adress'];

                    } else {
                        
                        header('location: ' .SITEURL. 'admin/manage-order.php');

                    }

                } else {
                    
                    header('location: ' .SITEURL. 'admin/manage-order.php');

                }
            
            ?>


            <form action="" method="post">

                <table class="tbl-30">

                    <tr>
                        <td>Food Name</td>
                        <td><b><?= $food; ?></b></td>
                    </tr>

                    <tr>
                        <td>Price</td>
                        <td><b><?= $price; ?></b></td>
                    </tr>

                    <tr>
                        <td>Qty</td>
                        <td>
                            <input type="number" name="qty" value="<?= $qty; ?>">
                        </td>
                    </tr>

                    <tr>
                        <td>Status</td>
                        <td>
                            <select name="status" >
                                <option <?php if($status == "Ordered") { echo "Selected"; } ?> value="Ordered">Ordered</option>
                                <option <?php if($status == "On Delivery") { echo "Selected"; } ?> value="On Delivery">On Delivery</option>
                                <option <?php if($status == "Delivered") { echo "Selected"; } ?>value="Delivered">Delivered</option>
                                <option <?php if($status == "Cancelled") { echo "Selected"; } ?>value="Cancelled">Cancelled</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>Customer Name: </td>
                        <td>
                            <input type="text" name="customer_name" value="<?= $customer_name; ?>">
                        </td>
                    </tr>

                    <tr>
                        <td>Customer Contact: </td>
                        <td>
                            <input type="text" name="customer_contact" value="<?= $customer_contact; ?>">
                        </td>
                    </tr>

                    <tr>
                        <td>Customer Email: </td>
                        <td>
                            <input type="text" name="customer_email" value="<?= $customer_email; ?>">
                        </td>
                    </tr>

                    <tr>
                        <td>Customer Address: </td>
                        <td>
                            <textarea name="customer_address" cols="30" rows="5"><?= $customer_address; ?></textarea>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <input type="hidden" name="id" value="<?= $id; ?>">
                            <input type="hidden" name="price" value="<?= $price; ?>">
                            <input type="submit" value="Update Order" name="submit" class="btn-secondary">
                        </td>
                    </tr>

                </table>


            </form>


            <?php 
            
                if (isset($_POST["submit"])) {
                    
                    //Get all value from the form
                    $id = $_POST["id"];
                    $price = $_POST["price"];
                    $qty = $_POST["qty"];
                    $total = $price * $qty;
                    $status = $_POST["status"];

                    $customer_name = htmlspecialchars($_POST["customer_name"]);
                    $customer_email = htmlspecialchars($_POST["customer_email"]);
                    $customer_contact = htmlspecialchars($_POST["customer_contact"]);
                    $customer_address = nl2br(htmlspecialchars($_POST["customer_address"]));

                    //Update the order
                    $updateOrder = $bdd->prepare('UPDATE tbl_order SET qty = ?, total = ?, status = ?, customer_name = ?, customer_email = ?, customer_contact = ?, customer_adress = ? WHERE id = ?');
                    $updateOrder->execute(array($qty, $total, $status, $customer_name, $customer_email, $customer_contact, $customer_address, $id));

                    if ($updateOrder == true) {
                        
                        $_SESSION['update'] = "<div class='success'>Order Updated Successfully.</div>";
                        header('location: ' .SITEURL. 'admin/manage-order.php');

                    } else {
                        
                        $_SESSION['update'] = "<div class='error'>Failed to Update Order.</div>";
                        header('location: ' .SITEURL. 'admin/manage-order.php');

                    }

                }
            
            ?>

        </div>
    </div>



    <?php include('inc/footer.php'); ?>

</body>
</html>