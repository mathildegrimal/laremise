<?php
$nav_en_cours ="magasin";
require_once 'commons/entete.php';
entete("Magasin");
require_once 'commons/bandeauconnexion.php';
require_once 'commons/menu.php';
navencours($nav_en_cours);
require_once 'commons/bandeau.php';
?>
<section id="magasin-page">

	<div class="texte-magasin-page">

		A l'origine de La Remise, un maraîcher parmi les pionniers de l’agriculture biologique dans les environs de Montpellier. Il propose ses légumes sur les marchés au milieu des années 1980, avant d’ouvrir son magasin dans le quartier montpelliérain des Arceaux. Depuis 1992, le magasin se consacre uniquement à la revente et s'approvisionne en priorité auprès des producteurs locaux. Une large gamme de produits frais et d'épicerie vient s'ajouter à un grand choix de fruits et légumes. Une attention particulière est portée la qualité et la fraîcheur des produits, garanties par un arrivage journalier. Le magasin est certifé par ECOCERT comme détaillant de produits biologiques.


	</div>


	<div id="localisation">
		<div class="titre-localisation">
			Nous trouver :
		</div>
		<div class="map-responsive" alt="Adresse">
			<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2888.75591312128!2d3.860358415383149!3d43.61162357912275!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12b6aeff6e7e868d%3A0x306cf4020abd8225!2sLa%20Remise!5e0!3m2!1sfr!2sfr!4v1586987295573!5m2!1sfr!2sfr" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
		</div>
	</div>
</section>
<?php
require_once 'commons/basdepage.php';
require_once 'commons/pieddepage.php';
?>
