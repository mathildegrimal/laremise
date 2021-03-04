<?php
$nav_en_cours="espaceclient";
require_once 'commons/entete.php';
entete("Mon compte");
require_once 'commons/bandeauconnexion.php';
require_once 'commons/menu.php';
navencours($nav_en_cours);
require_once 'commons/bandeau.php';
$id=$_SESSION['Utilisateur']['id'];
$req = $DB->select1("SELECT * FROM client WHERE `cpt_id` = :id", array('id'=>$id));
?>

<section id="espaceclient">

    <div id="titre-espaceclient">
        <h1>Mon espace client<h1>
    </div>
    <div id="liensclient">
            <a href="espaceclient.php" <?php if(!isset($_GET['id'])) { echo 'class="liensclient-en-cours"';} ?> >Informations du compte</a>
            <a href="espaceclient.php?id=adresse" <?php if(isset($_GET['id']) && $_GET['id']=='adresse') { echo 'class="liensclient-en-cours"';}?> >Adresse</a>
            <a href="espaceclient.php?id=commandes" <?php if(isset($_GET['id']) && $_GET['id']=='commandes') { echo 'class="liensclient-en-cours"';}?> >Mes commandes </a>
    </div>
    <div id="infosclient">

        <div id="container-infos">
            <?php if (!isset($_GET['id']) || ($_GET['id']=="")) {?>
                <h3> MES INFOS </h3>
                <div id='adresse'>
                    <div id='nom-client'> Login : <?=$_SESSION['Utilisateur']['login']?></div>&nbsp
                    <div id='email-client'> Email : <?=$_SESSION['Utilisateur']['email']?></div>&nbsp
                    <!-- <a href='modifcompte.php'>Changer de mot de passe</a> -->
                </div>
                <?php
                } else if ($_GET['id']=="adresse") { ?>
                    <h3>ADRESSE DE FACTURATION</h3>
                    <div id='adresse'>
                        <div><?=$req->cli_rue?></div>&nbsp
                        <div><?=$req->cli_cp?></div>&nbsp
                        <div><?=$req->cli_ville?></div>
                    </div>
                    <!-- <a href='modifcompte.php'> Modifier mon adresse </a> -->
                <?php } else if ($_GET['id']=="commandes"){ ?>
                    <h3> MES COMMANDES</h3>
                    <div id='adresse'>
                    <?php $commandes=$DB->query('SELECT * FROM `commande` WHERE `cmd_compte`=:idutil ORDER BY cmd_date_drive',array('idutil' => $_SESSION['Utilisateur']['id']));?>

                            <table class='aff-pdt'>
                                <tr class='aff-pdt'>
                                    <th class='aff-pdt'>ID Commande</th>
                                    <th class='aff-pdt'>Date commande </th>
                                    <th class='aff-pdt'>Total</th>
                                    <th class='aff-pdt'>Date drive</th>
                                    <th class='aff-pdt'>Heure drive</th>
                                    <th class='aff-pdt'>Détail</th>
                                </tr>
                    <?php foreach ($commandes as $commande) {?>

                                    <tr class='aff-pdt'>
                                        <td class='aff-pdt'><?=$commande->cmd_id?></td>
                                        <td class='aff-pdt'><?=$commande->cmd_date_commande?></td>
                                        <td class='aff-pdt'><?=$commande->cmd_total?> € </td>
                                        <td class='aff-pdt'><?=$commande->cmd_date_drive?></td>
                                        <td class='aff-pdt'><?=$commande->cmd_heure_drive?></td>
                                        <td class='aff-pdt'><a href='espaceclient.php?id=detailcmd&idcmd=<?=$commande->cmd_id?>'>Voir les produits</a></td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>

                    <?php } else if($_GET['id']=="detailcmd" && isset($_GET['idcmd'])){
                        $reqPanier=$DB->query("SELECT * FROM panier,produit WHERE panier.`pan_pdt`= produit.`pdt_id` AND pan_commande = :idcmd", array('idcmd'=> $_GET['idcmd']));

                        if ($reqPanier) {?>
                            <h5> Commande n°<?=$_GET['idcmd']?></h5>
                                <button type='submit' class='submit-bouton' name='facture'><a class="facture" href='facturepdf.php?idcmd=<?= $_GET['idcmd']?>'>Télécharger la facture</a></button>
                            <div class='aff-pdt'>
                                <table class='aff-pdt'>
                                    <tr class='aff-pdt'>
                                        <th>Nom du produit</th>
                                        <th>Prix unitaire</th>
                                        <th>Quantité</th>
                                        <th>Prix avec TVA</th>

                                    </tr>
                                    <?php foreach ($reqPanier as $produit) { ?>
                                        <tr class='aff-pdt'>
                                            <td><?=$produit->pdt_nom?></td>
                                            <td><?= number_format($produit->pdt_prixht,2,',',' ')?> €</td>
                                            <td><?=$produit->pan_quantite?></td>
                                            <td><?=$produit->pan_montant?></td>
                                        </tr>
                                    <?php } ?>
                                </table>
                                <a href='espaceclient.php?id=commandes'>Retour à la liste des commandes</a></br>
                            </div>
                        <?php }
                    } ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
require_once 'commons/basdepage.php';
require_once 'commons/pieddepage.php';
?>
