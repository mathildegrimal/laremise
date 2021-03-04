<?php
require 'commons/_header.php';
$json = array('error' => true);
if(isset($_GET['id'])){
	$product = $DB->query('SELECT pdt_id FROM produit WHERE pdt_id=:id', array('id' => $_GET['id']));
	if(empty($product)){
		$json['message'] = "Ce produit n'existe pas";
	}else{
		$panier->moins($product[0]->pdt_id);
		$json['error']  = false;
		$json['total']  = number_format($panier->total(),2,',',' ');
		$json['count']  = $panier->count();
		$json['message'] = 'Le produit a bien été ajouté à votre panier';
	}
}else{
	$json['message'] = "Vous n'avez pas sélectionné de produit à ajouter au panier";
}
echo json_encode($json);
