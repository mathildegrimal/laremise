<?php
$nav_en_cours="";
include('commons/entete.php');
entete("Changement de mot de passe");
include('commons/bandeauconnexion.php');
include('commons/menu.php');
include('commons/bandeau.php');
$code = $_GET["code"];
if(isset($code))
{
    ?>
    <section id="changement-mdp">

    <h1>Changer de mot de passe</h1>
    <form id="form-creercompte" action="changement-mdp-validation.php?code=<?=$code?>" method="post">
    <?php
    if (isset($_GET['err'])&& $_GET['err']==1){
        echo "<div class='erreur'>Les mots de passe ne correspondent pas, veuillez reessayer</div>";

    } elseif (isset($_GET['err'])&& $_GET['err']==2){
        echo "<div class='erreur'>Echec du changement de mot de passe, veuillez réessayer</div>";
    }?>
        <div class="creer-compte-form-group">
            <label for="confirmPass">Mot de passe : </label>
            <input  id="motdepasse" type="password" name="motdepasse" pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).{6,}" required>
            <div id="pattern-mdp">Le mot de passe doit contenir au moins 6 caractères, dont une majuscule, un chiffre et 1 caractère spécial</div>
            <div id="err"></div>
        </div>
        <div class="creer-compte-form-group">
            <label for="confirmPass">Confirmation du mot de passe : </label>
            <input id="confirmPass" type="password" name="confirmPass" pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).{6,}" onblur="verifPass('motdepasse','confirmPass')" required>
            <div id="errmdp"></div>
        </div>
        <button id="submit-creer-compte" class="submit-bouton" type="submit">Enregistrer</button>
    </form>

    <script>
        function verifPass(id1, id2) {
            if(document.getElementById(id1).value != document.getElementById(id2).value){
                document.getElementById("errmdp").innerHTML = "<p style='color:red'>Les mots de passe ne correspondent pas</p>";
            } else {
                document.getElementById("errmdp").innerHTML = "";
            }
        }
    </script>

</html>
<?php
}
else
    echo '<html><body><h1>Erreur <a href="index.php">retour à l\'acceuil</a></h1></body></html>';
?>
