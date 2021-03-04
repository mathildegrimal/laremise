
<?php
$nav_en_cours="";
include('commons/entete.php');
entete('Connexion');
include('commons/bandeauconnexion.php');
include('commons/menu.php');
navencours($nav_en_cours);
include('commons/bandeau.php');

if(isset($_GET['err']))
    $err = $_GET['err'];
else
    $err = -1;

if(isset($_GET['mail']))
    $monMail = $_GET['mail'];
else
    $monMail="0";
?>
<section id="connexion">
    <div class="user-container">
        <div class="login">

        <?php
        if (isset($_GET['recovmdp'])&& $_GET['recovmdp']==1) { ?>
            <div class="center">
                <form method='post' enctype="multipart/form-data" action='envoi-mail-mdp.php'>
                    <label for="emailrecov">Entrez votre mail ci dessous pour reinitialiser votre mot de passe</label>
                    <input id="emailrecov" name="mel" type="email"><br>
                    <button class="submit-bouton" type="submit" name="emailrecov">Reinitialiser</button>
                </form>
            </div>
        </div><!--  </div> class login -->
<?php } elseif (isset($_GET['err'])&& $_GET['err']==0) { ?>
            <div class="center">
            Votre compte a bien été créé.
                <form method='post' enctype="multipart/form-data" action='connexion.php'>
                    <button class="submit-bouton" type="submit">Connectez-vous</button>
                </form>
            </div>
        </div><!--  </div> class login -->
<?php } elseif (isset($_GET['err']) && $_GET['err']==1) { ?>
            <div class="center">
                Echec de la connexion, les identifiants saisis sont inconnus.
                <form method='post' enctype="multipart/form-data" action='connexion.php'>
                    <button class="submit-bouton" type="submit">Recommencer</button>
                </form>
            </div>
        </div><!--  </div> class login -->
<?php } elseif (isset($_GET['err']) && $_GET['err']==2) { ?>
            <div class="center">
                Echec de la connexion, le mot de passe saisi est erroné.
                <form method='post' enctype="multipart/form-data" action='connexion.php'>
                    <button class="submit-bouton" type="submit">Recommencer</button>
                </form>
            </div>
        </div><!--  </div> class login -->
<?php } elseif (isset($_GET['err'])&& $_GET['err']==3 && isset($_GET['mail']) && $_GET['mail']==$monMail) { ?>
            <div class="center">
                Consultez le mail envoyé à <?= $monMail ?> pour mettre à jour votre mot de passe
            </div>
        </div><!--  </div> class login -->

<?php } elseif (isset($_GET['err'])&& $_GET['err']==4) { ?>
            <div class="center">
                Votre mot de passe a bien été reinitialisé.
                <form method='post' enctype="multipart/form-data" action='connexion.php'>
                    <button class="submit-bouton" type="submit">Connectez-vous</button>
                </form>
            </div>
        </div><!--  </div> class login -->
<?php } elseif (isset($_GET['err'])&& $_GET['err']==5) { ?>
            <div class="center">
                L'adresse email <?=$monMail?> n'est associée à aucun compte.
                <form method='post' enctype="multipart/form-data" action='connexion.php?recovmdp=1'>
                    <button class="submit-bouton" type="submit">Recommencer</button>
                </form>
            </div>
        </div><!--  </div> class login -->
<?php } else { ?>

            <h2 class="titre-connexion center">Connexion</h2>

            <form method='post' enctype="multipart/form-data" action='connexion-validation.php'>
                <div id="login" class="form-group">
                    <label class="label-login">Login</label></td>
                    <input class="input-login" id='login' name="ndc" type="text" maxlength="50">
                </div>
                <div id='motdepasse' class="form-group">
                    <label class="label-motdepasse">Mot de passe</label></td>
                    <input class="input-motdepasse" name="mdp" type="password"></td>

                </div>
                <input id="submit-connexion" class="center submit-bouton" type="submit" value="Connexion">
            </form>
            <a class="lienmdprecovery" href="connexion.php?recovmdp=1">Mot de passe oublié ?</a>
        </div><!--  </div> class login -->
<?php } ?>


<div class="creercompte">
    <h2 class="titre-connexion center">Pas encore de compte ?</h2>
        <form method='post' enctype="multipart/form-data" action='creation.php'>
            <input id="submit-connexion" class="center submit-bouton" type="submit" value="Créer un compte">
        </form>
    <div class="center"> Vous pourrez ensuite passer des commandes ou valider votre panier.</div>
</div>
</center>
</div>
</section>


<?php
include('commons/basdepage.php');
include('commons/pieddepage.php')
?>

