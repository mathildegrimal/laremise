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
	<div>
		<h1>Clause n° 1 : Objet</h1>
		<p>Les conditions générales de vente décrites ci-après détaillent les droits et obligations de la société  La Remise et de son client dans le cadre de la vente des marchandises suivantes :  fruits et légumes, épicerie, produits frais, vrac et pains.
		Toute prestation accomplie par la société  La Remise implique donc l'adhésion sans réserve de le client aux présentes conditions générales de vente.</p>
		<h1>Clause n° 2 : Prix</h1>
		<p>Les prix des marchandises vendues sont ceux en vigueur au jour de la prise de commande. Ils sont libellés en euros et calculés hors taxes. Par voie de conséquence, ils seront majorés du taux de TVA.
		La société  La Remise s'accorde le droit de modifier ses tarifs à tout moment. Toutefois, elle s'engage à facturer les marchandises commandées aux prix indiqués lors de l'enregistrement de la commande.</p>
		<h1>Clause n° 3 : Escompte</h1>
		<p>Aucun escompte ne sera consenti en cas de paiement anticipé.</p>
		<h1>Clause n° 4 : Modalités de paiement</h1>
		<p>Le règlement des commandes s'effectue en magasin, au moment de la récupération de la commande :
			<ul>
				<li>soit par chèque</li>
				<li>soit par carte bancaire</li>
				<li> soit en espèces</li>
			</ul>
		Lors de l'enregistrement de la commande, le client s’engage à venir la récuperer le jour et à l’heure prévus. Dans le cas où le client ne viendrait pas récupérer sa commande sans prévenir au préalable, La Remise pourra lui réclamer le paiement ultérieurement.</p>
		<h1>Clause n° 5 : Clause de réserve de propriété</h1>
			<p>La société  La Remise conserve la propriété des biens vendus jusqu'au paiement intégral du prix, en principal et en accessoires.</p>
		<h1>Clause n° 6 : récupération de la commande</h1>
			<p>La récupération est effectuée par la remise directe de la marchandise à le client.</p>
		<h1>Clause n° 7 : Force majeure</h1>
			<p>La responsabilité de la société  La Remise ne pourra pas être mise en oeuvre si la non-exécution ou le retard dans l'exécution de l'une de ses obligations décrites dans les présentes conditions générales de vente découle d'un cas de force majeure. À ce titre, la force majeure s'entend de tout événement extérieur, imprévisible et irrésistible au sens de l'article 1148 du Code civil.</p>
		<h1>Clause n° 8 : Tribunal compétent</h1>
			<p>Tout litige relatif à l'interprétation et à l'exécution des présentes conditions générales de vente est soumis au droit français.
			À défaut de résolution amiable, le litige sera porté devant le Tribunal de commerce de Montpellier.</p>

			<p>Fait à Montpellier, le  14/06/2020</p>


		</div>
	</section>
	<?php
	require_once 'commons/basdepage.php';
	require_once 'commons/pieddepage.php';
	?>
