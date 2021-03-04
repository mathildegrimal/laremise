<?php
$nav_en_cours="index";
require_once 'commons/entete.php';
entete("Accueil");
require_once 'commons/bandeauconnexion.php';
require_once 'commons/menu.php';
navencours($nav_en_cours);
?>

<section id="carrousel">

	<div class="slideshow-container">

		<!-- Full-width images with number and caption text -->
		<div class="mySlides fade">
			<img src="img\carrousel\artichaut.jpg" style="width:100%">
		</div>

		<div class="mySlides fade">
			<img src="img\carrousel\fraise.jpg" style="width:100%">
		</div>

		<div class="mySlides fade">
			<img src="img\carrousel\pain.jpg" style="width:100%">
		</div>
		<div class="mySlides fade">
			<img src="img\carrousel\produits.jpg" style="width:100%">
		</div>

		<!-- Next and previous buttons -->
		<a class="prev" onclick="plusSlides(-1)">&#10094;</a>
		<a class="next" onclick="plusSlides(1)">&#10095;</a>
	</div>
	<br>



</section>

<section id="magasin">

	<div class="conteneur-photo-magasin">
		<img class="photo-magasin" alt="Photo magasin" src="img\magasin.jpg"/>
	</div>

	<div class="description-magasin">
		<div class="titre-magasin">Un magasin 100% bio </div>
		<p class="texte-magasin">
			Depuis 1992 au coeur du quartier des Arceaux, La Remise propose une grande variété de fruits et légumes issus de l'agriculture biologique. Une large gamme de produits frais et d'épicerie vient s'ajouter aux fruits et légumes. La Remise c'est surtout une entreprise familiale indépendante à taille humaine. C'est aussi une expérience de 25 ans au service de la BIO, certifiée par ECOCERT.
		</p>
		<div>
			<a href="magasin.php#localisation" class="bouton-nous-trouver">Nous trouver</a>
		</div>
	</div>

</section>
<script type="text/javascript">
  var slideIndex = 1;
showSlides(slideIndex);

// Next/previous controls
function plusSlides(n) {
  showSlides(slideIndex += n);
}

// Thumbnail image controls
function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
  }
  slides[slideIndex-1].style.display = "block";

}
</script>


<?php
require_once 'commons/basdepage.php';
require_once 'commons/pieddepage.php';
?>

