<?php
require_once 'commons/entete.php';
entete("Commandes");
$nav_en_cours="commandes";
require_once 'commons/menu-admin.php';
require_once 'commons/bandeau.php';
?>
<div id='commandes'>
    <?php

    if (isset($_GET['idcmd'])){

        $reqPanier=$DB->query("SELECT * FROM panier, produit WHERE panier.`pan_pdt`= produit.`pdt_id` AND pan_commande = :idcmd", array('idcmd'=> $_GET['idcmd']));
        if ($reqPanier) { ?>

            <div class='aff-pdt'>
                <h3> Commande n°<?= $_GET['idcmd']?> </h3>
                <button type='submit' class='submit-bouton' name='facture'><a class="facture" href='../facturepdf.php?idcmd=<?= $_GET['idcmd'] ?>'> Télécharger la facture </a></button>
                <table class='aff-pdt'>
                    <tr class='aff-pdt'>
                        <th>Nom du produit</th>
                        <th>Prix unitaire</th>
                        <th>Quantité</th>
                        <th>Prix avec TVA</th>
                    </tr>

                    <?php
                    foreach ($reqPanier as $produit) { ?>

                        <tr>
                            <td><?= $produit->pdt_nom ?> </td>
                            <td><?= number_format($produit->pdt_prixht,2,',',' ') ?> €</td>
                            <td><?= $produit->pan_quantite ?></td>
                            <td><?= $produit->pan_montant ?></td>
                        </tr>
                        <?php
                    } ?>
                </table>

            </div>
            <?php
        }
    }?>
    <div class='aff-pdt'>
        <h3>Liste des commandes</h3>
        <table class='aff-pdt'>
            <tr class='aff-pdt'>
                <th>ID Commande</th>
                <th>Date commande </th>
                <th>Total</th>
                <th>Date drive</th>
                <th>Heure drive</th>
                <th>Détail</th>
            </tr>

            <?php

            $commandes=$DB->query('SELECT * FROM `commande` ORDER BY cmd_date_drive AND cmd_heure_drive');

            foreach ($commandes as $commande) {?>

                <tr>
                    <td><?= $commande->cmd_id ?></td>
                    <td><?= $commande->cmd_date_commande ?></td>
                    <td><?= $commande->cmd_total ?> € </td>
                    <td><?= $commande->cmd_date_drive ?></td>
                    <td><?= $commande->cmd_heure_drive ?></td>
                    <td><a href='listeCommandes.php?idcmd=<?= $commande->cmd_id ?>'>Voir les produits</a></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>
