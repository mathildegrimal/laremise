<?php
$nav_en_cours ="contact";
require_once 'commons/entete.php';
entete("Contactez-nous");
require_once 'commons/bandeauconnexion.php';
require_once 'commons/menu.php';
navencours('contact');
require_once 'commons/bandeau.php';
if(isset($_GET['err']))
        $err = $_GET['err'];
?>



<div class="form-insert" id="">
        <h1 class="titre-form">Contactez-nous via le formulaire ci-dessous, nous vous repondrons dans les plus brefs délais !</h1>
        <form action="envoi-mail.php" method="POST" enctype="multipart/form-data">
                <div class="form-insert-group">
                        <label for="nom">Votre nom :</label><br />
                        <input id="nom" name="name" type="text" required /><br />
                        <label for="email">Votre adresse email :</label><br/>
                        <input id="email"name="email" type="email" value="" required /><br />

                </div>
                <div class="form-insert-group">
                        <label for="objet">Objet de votre message :</label><br/>
                        <input id="objet" name="subject" type="text" value=""required/><br />
                </div>
                <div class="form-insert-group">
                        <label for="message">Votre message :</label><br/>
                        <textarea id="message" name="message" rows="7" required> </textarea><br/>
                </div>
                <div class='form-insert-group'>
                        <input class="submit-bouton" type="submit" value="Envoyer"/>
                </div>

        </form>
</div>

<?php
require_once 'commons/basdepage.php';
?>
<script type="text/javascript">

        var erreur = <?php print $err;?>;
        if(erreur == 3)
        {
                alert("Mail envoyé avec succès");

}
</script>
<?php
require_once 'commons/pieddepage.php';
?>
