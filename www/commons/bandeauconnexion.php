<div id="bandeau-connexion">
    <div id="bouton-connexion">
        <?php if (!isset($_SESSION['Utilisateur'])) { ?>
            <a class="bouton-connexion" href='connexion.php'>
                <img  class="" alt="" src="img\icones\user_icon.png"/>
                <span>Connexion</span>
            </a>
        </div>
        <div id="bouton-panier">
            <span id="total"><?= number_format($panier->total(),2,',',' '); ?></span> €</span>
            <a class="bouton-panier" href="panier.php">
                <img class="" alt="" src="img\icones\icone-panier.png"/>
                <span>Votre panier</span>
            </a>
        </div>
    </div>
<?php } else {
    $nomDeCompte = $_SESSION['Utilisateur']['login'];
    $reqCompte = $DB->select1("SELECT cpt_grade FROM compte WHERE cpt_login = :login",array('login'=>$nomDeCompte));
    if ($reqCompte->cpt_grade!=1) { ?>
        <a class="bouton-connexion" href='espaceclient.php'>
            <img  class="" alt="" src="img\icones\user_icon.png"/>
            <span><?php echo $_SESSION['Utilisateur']['prenom']." ".$_SESSION['Utilisateur']['nom'];?></span><form action='deconnexion.php' method='post'>
                <button class='deconnexion-bouton' type='submit' name='deconnexion'>Deconnexion</button>
            </form>
        </a>
    </div>
    <div id="bouton-panier">
        <span id="total"><?= number_format($panier->total(),2,',',' '); ?></span> €</span>
        <a class="bouton-panier" href="panier.php">
            <img class="" alt="" src="img\icones\icone-panier.png"/>
            <span>Votre panier</span>
        </a>
    </div>
</div>
    <?php } else {?>
        <a class='bouton-connexion' href="index-admin.php">Administration
        <img  class="" alt="" src="img\icones\user_icon.png"/>
            <span><?php echo $_SESSION['Utilisateur']['prenom']." ".$_SESSION['Utilisateur']['nom'];?></span><form action='deconnexion.php' method='post'>
                <button class='deconnexion-bouton' type='submit' name='deconnexion'>Deconnexion</button>
            </form>
        </a>
    </div>
    <div id="bouton-panier">
        <span id="total"><?= number_format($panier->total(),2,',',' '); ?></span> €</span>
        <a class="bouton-panier" href="panier.php">
            <img class="" alt="" src="img\icones\icone-panier.png"/>
            <span>Votre panier</span>
        </a>
    </div>
</div>
<?php }
}?>
