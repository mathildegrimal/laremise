<?php
$nav_en_cours="";
require_once 'commons/entete.php';
entete("Créez un compte");
require_once 'commons/bandeauconnexion.php';
require_once 'commons/menu.php';
require_once 'commons/bandeau.php';
?>

<section id="creationcompte">
    <h1>Créez votre compte</h1>
    <!--cpt_idcli_nom cli_prenomcli_rue cli_ville cli_cp-->

    <form id="form-creercompte" action="insertionCompte.php" method="post" onsubmit='return verifForm(this)'>
        <?php
        if (isset($_GET['err'])&& $_GET['err']==1) {?>
            <div class="erreur">Impossible de créer le compte</div>
        <?php }
        if (isset($_GET['err'])&& $_GET['err']==3) {?>
            <div class="erreur">Impossible de créer le compte, l'email choisi est déjà utilisé, veuillez recommencer </div>
        <?php }
        if (isset($_GET['err'])&& $_GET['err']==2) {?>
            <div class="erreur">Les mots de passe ne correspondent pas, veuillez recommencer.</div><br>
        <?php }
        if (isset($_GET['err'])&& $_GET['err']==4) {?>
            <div class="erreur">Le login choisi est déja utilisé, veuillez recommencer.</div><br>
        <?php }?>

        <div class="creer-compte-form-group">
            <label for="nomclient" required> Nom : </label>
            <input  id="nomclient" type="text" name="nom" required>
            <div id="errnomclient"></div>
        </div>
        <div class="creer-compte-form-group">
            <label for="prenomclient">Prenom : </label>
            <input  id="prenomclient" type="text" name="prenom" required>
            <div id="errprenomclient"></div>
        </div>
        <div class="creer-compte-form-group">
            <label for="loginclient">Login :</label>
            <input id="loginclient" type="text" name="login" onblur="verifLength(this, 'loginclient','login',5,45)"required/>
            <div id="errloginclient"></div>
        </div>
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
        <div class="creer-compte-form-group">
            <label for="emailclient">Email : </label>
            <input id="emailclient" type="email" name="email"required>
        </div>
        <div class="creer-compte-form-group">
            <label for="adresseclient">Adresse (n° de rue et rue) : </label>
            <input id="adresseclient" type="text" name="adresse"required>
        </div>
        <div class="creer-compte-form-group">
            <label for="CP">Code Postal</label>
            <input id="CP" type="text" pattern="[0-9]{5}"name="CP"required>
        </div>
        <div class="creer-compte-form-group">
            <label for="ville">Ville</label>
            <input id="villeclient" type="text" name="ville" onblur="verifLength(this,'villeclient','ville',2,150)" required>
            <div id="errvilleclient"></div>
        </div>
        <button id="submit-creer-compte" class="submit-bouton" type="submit">Enregistrer</button>

        </form>

    </section>
    <script>



        function verifLength(champ,id,nom,taillemin, taillemax)
        {
            if(champ.value.length < taillemin  || champ.value.length > taillemax)
            {
                 document.getElementById("err"+id).innerHTML = "<p class='erreur'>Le champ "+nom+" doit comporter entre "+taillemin+" et "+taillemax+" caractères </p>";
            } else
            {
                document.getElementById("err"+id).innerHTML = "";

            }
        }


        function verifPass(id1, id2) {
            if(document.getElementById(id1).value != document.getElementById(id2).value){
                document.getElementById("errmdp").innerHTML = "<p style='color:red'>Les mots de passe ne correspondent pas</p>";
                return false;
            } else {
                document.getElementById("errmdp").innerHTML = "";
                return true;

            }
        }

        console.log(verifPass('motdepasse','confirmPass'));
        console.log(document.getElementById('motdepasse').value);

        function verifForm(f)
{


   var loginOK = verifLength(f.login, 'loginclient','login',5,45);
   var villeOK = verifLength(f.ville,'ville','ville',2,150);
   var mdpOK= verifPass(f.motdepasse,f.confirmPass);

   if(loginOK && villeOK && mdpOK)
      return true;
   else
   {
      alert("Veuillez remplir correctement tous les champs");
      return false;
   }
}

</script>
<?php
require_once 'commons/basdepage.php';
require_once 'commons/pieddepage.php';
?>
