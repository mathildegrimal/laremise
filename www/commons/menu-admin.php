<section id="header">
	<a href="index-amin.php">
		<div class="conteneur-logo">
			<img class="logo" src="img\logo.svg"/>
		</div>
	</a>
	<div >
		AU SERVICE DE LA BIO DEPUIS 1985
	</div>
</section>
<nav id="nav" class="menu-admin">
	<a  href="index-admin.php" <?php if ($nav_en_cours == 'administration') {echo ' class="en-cours"';}?> >Accueil</a>

	<a  href="listeProduits.php" <?php if ($nav_en_cours == 'listitem') {echo ' class="en-cours"';}?>>Afficher/modifier les produit</a>

	<a  href="insertionProduitForm.php"<?php if ($nav_en_cours == 'insertion') {echo ' class="en-cours"';}?>>Insérer des produits</a>

	<a  href="listeCommandes.php" <?php if ($nav_en_cours == 'commandes') {echo ' class="en-cours"';}?>>Commandes</a>
</nav>
</section>
