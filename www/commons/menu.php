<?php function navencours($encours){
	$nav_en_cours=$encours;
	return $nav_en_cours;
}?>
<section id="header">
	<a href="index.php">
		<div class="conteneur-logo">
			<img class="logo" src="img\logo.svg"/>
		</div>
	</a>
	<div >
		AU SERVICE DE LA BIO DEPUIS 1985
	</div>


</section>
<nav id="nav" class="menu-principal">
	<a  href="index.php" <?php if ($nav_en_cours == 'index') {echo ' class="en-cours"';}?> >Accueil</a>
	<a  href="magasin.php" <?php if ($nav_en_cours == 'magasin') {echo ' class="en-cours"';}?>>Magasin</a>
	<a  href="produits.php"<?php if ($nav_en_cours == 'produits') {echo ' class="en-cours"';}?>>Nos produits</a>
	<a  href="espaceclient.php"<?php
	if (!isset($_SESSION['Utilisateur'])) echo 'class="display-none">';
	else {
		if ($nav_en_cours == 'espaceclient') {echo 'class="en-cours"';}
	}?>>
Mon compte</a>
<a  href="contact.php" <?php if ($nav_en_cours == 'contact') {echo ' class="en-cours"';}?>>Contact</a>
</nav>
</section>

