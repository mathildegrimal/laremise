<?php
require 'class/db.class.php';
require 'class/panier.class.php';
$DB = new DB();
$panier = new panier($DB);
?>
