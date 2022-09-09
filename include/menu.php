<?php require('config/database.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant</title>

    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <!-- Navbar -->
    <section class="navbar">
        <div class="container">
            <div class="logo">
                <a href="<?= SITEURL; ?>" title="Logo">
                    <img class="img-logo" src="assets/img/logo.png" alt="Restaurant logo">
                </a>
            </div>
            <div class="menu text-right">
                <ul>
                    <li>
                        <a href="<?= SITEURL; ?>">Home</a>
                    </li>
                    <li>
                        <a href="<?= SITEURL; ?>categories.php">Categories</a>
                    </li>
                    <li>
                        <a href="<?= SITEURL; ?>foods.php">Foods</a>
                    </li>
                    <li>
                        <a href="#">Contact</a>
                    </li>
                </ul>
            </div>

            <div class="clear-fix"></div>
        </div>
    </section>