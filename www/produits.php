<?php
$nav_en_cours ="produits";
require_once 'commons/entete.php';
entete("Nos produits");
require_once 'commons/bandeauconnexion.php';
require_once 'commons/menu.php';
navencours($nav_en_cours);
require_once 'commons/bandeau.php';
?>
<div id="liste-produits">
	<div id="categ">
		<div id="titre-categ">
			<h1>Rayons</h1>
			<ul id="liste-categorie" >
				<li><a href="produits.php" class="item-categ">Tous nos produits</a></li>
					<li><a href="?categ=1" class="item-categ">Fruits et légumes</a></li>
					<li><a href="?categ=2" class="item-categ">Epicerie</a></li>
					<li><a href="?categ=3" class="item-categ">Frais</a></li>
					<li><a href="?categ=4" class="item-categ">Pain</a></li>
					<li><a href="?categ=5" class="item-categ">Vrac</a></li>

			</ul>
		</div>
	</div>

	<div id='grille-produits'>
		<div class="recherche-pdt">
			<form action="produits.php" id="search" method="post">
				<div class="recherche-form-group">
					<input name="recherche" type="text" placeholder="Mots-Clefs...">
					<button class="submit-bouton" name="recherchePdt" type="submit" value=""> Rechercher</button>
				</div>
			</form>
		</div>
		<?php

		if(isset($_GET['categ'])){
			$categ=$_GET['categ'];
			$produits = $DB->query("SELECT * FROM image, produit where image.`img_id` = produit.`pdt_image` AND produit.`pdt_id_categorie`= :categ", array('categ' => $categ));


		} else if (isset($_POST['recherchePdt'])){

			$recherche=$_POST['recherche'];
			$produits = $DB->query("SELECT * FROM image, produit where image.`img_id` = produit.`pdt_image` AND produit.`pdt_nom` LIKE :recherche", array('recherche' => "%$recherche%"));
			if ($produits==NULL) echo "Désolé, aucun produits ne correspond à votre recherche";


		} else {
			$produits = $DB->query("SELECT * FROM image, produit where image.`img_id` = produit.`pdt_image`");

		}

		foreach($produits as $produit) :
			$stock=$produit->pdt_stock;
			if (isset($_SESSION['panier'][$produit->pdt_id]))
			$stock=$stock-($_SESSION['panier'][$produit->pdt_id]);?>

			<div class="produit">
				<div class="nom-produit"><?= $produit->pdt_nom ;?></div>
				<?php if(!is_null($produit->pdt_marque)) echo "<div> $produit->pdt_marque </div>"; ?>
				<div id="produit_img">
					<img class="produit_img img-fluid" alt="Responsive image" src="uploads\\<?= explode('/',$produit->img_nom)[1];?>"></img>
				</div>
				<div class="prix-produit"><?= $produit->pdt_prixttc;?> € TTC</div>
				<div><?= $produit->pdt_poids; ?> kg</div>
				<div>
					<?php if ($stock>=1) {?>
						<a class="submit-bouton addarticlePanier" href="addpanier.php?id=<?= $produit->pdt_id; ?>">Ajouter</a>
						<?php if (isset($_SESSION['panier'][$produit->pdt_id])){ echo "<div>Produit ajouté !</div>";}?>
					<?php }else {
						echo "Plus de stock";
					}?>
				</div>
			</div>


		<?php endforeach; ?>

	</div>
</div>
<?php
require 'commons/basdepage.php';
require 'commons/pieddepage.php';
?>



