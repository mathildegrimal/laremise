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
	<h1> Mentions légales</h1>
	<p>
		<ul>
			<li>• Mathilde Grimal – At home</li>
			<li>• Responsable de la rédaction et de la publication : Mathilde Grimal</li>
			<li>• mat.grimal@gmail .com</li>
			<li>• Hébergeur : Alwaysdata - https://www.alwaysdata.com</li>
		</ul>
	</p>
</section>
<?php
require_once 'commons/basdepage.php';
require_once 'commons/pieddepage.php';
?>
