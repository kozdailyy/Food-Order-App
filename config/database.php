<?php 

    if(!defined('SITEURL'))
        define('SITEURL', 'http://localhost:8090/FoodOrderApp/');
    if(!defined('DB_SERVER'))
        define('DB_SERVER', "localhost");
    if(!defined('DB_USER'))
        define('DB_USER', "root");
    if(!defined('DB_PASSWORD'))
        define('DB_PASSWORD', "root");
    if(!defined('DB_NAME'))
        define('DB_NAME', "food_order");
    if(!defined('DB_DRIVER'))
        define('DB_DRIVER', "mysql");

    try {
        if(!isset($_SESSION))
            session_start();
        $bdd = new PDO(DB_DRIVER . ":dbname=" . DB_NAME . ";host=" . DB_SERVER, DB_USER, DB_PASSWORD);
        // $bdd = new PDO('mysql:host=localhost;dbname=food-order;charset=utf8;','root','root');
    } catch (Exception $e) {
        die('Une erreur a ete trouvee :' . $e->getMessage());
    }

?>