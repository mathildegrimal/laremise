<?php
$nav_en_cours="";
require_once 'commons/entete.php';
entete('panier');
require_once 'commons/bandeauconnexion.php';
require_once 'commons/menu.php';
navencours($nav_en_cours);
require_once 'commons/bandeau.php';?>
<div class="form-insert">
    <h2 id="panier">Votre panier</h2>

    <form method="post" action="recappanier.php">
        <div class="aff-panier">
            <table id="aff-panier">
                <tr class="aff-panier"><td></td>
                    <th>Produit</th>
                    <th>Prix unit. HT</th>
                    <th>Quantité</th>
                    <th>Total TTC</th>
                    <th>Action</th>
                </tr>
                <?php
                $ids = array_keys($_SESSION['panier']);
                if(empty($ids)){
                    $products = array();
                }else{
                    $products = $DB->query('SELECT * FROM produit,image,tva WHERE produit.`pdt_tva`=tva.`tva_id` AND produit.`pdt_image`=image.`img_id` AND pdt_id IN ('.implode(',',$ids).')');
                }
                foreach($products as $product):
                    $stock=$product->pdt_stock;
                    $stock=$stock-($_SESSION['panier'][$product->pdt_id]);


                    if($_SESSION['panier'][$product->pdt_id]!=0){
                       $tva_val=1+($product->tva_valeur/100);
                       $quantite=$_SESSION['panier'][$product->pdt_id];?>

                       <tr class="aff-panier">
                        <td><a href="#" ><img class="panier_img" src="uploads\\<?= explode('/',$product->img_nom)[1];?>"></img></a></td>
                        <td><?= $product->pdt_nom; ?></td>
                        <td><?= number_format($product->pdt_prixht,2,',',' '); ?> €</td>
                        <td><a class="add addarticlePanier" href="moinspanier.php?id=<?= $product->pdt_id; ?>"><img id="suppr" src="img/suppr.png"></a>
                            <?= $quantite; ?>
                            <?php if($stock>=1){?>
                                <a class="add addarticlePanier" href="addpanier.php?id=<?= $product->pdt_id; ?>"><img id="ajout" src="img/ajout.png"></a>
                            <?php }?>

                        </td>
                        <td><?= number_format($product->pdt_prixttc*$quantite,2,',',' '); ?> €</td>
                        <td>
                            <a href="panier.php?delPanier=<?= $product->pdt_id; ?>" class="del"><img src="img/del.png"></a>
                        </td>

                    </tr>

                <?php } endforeach; ?>
            </table>
        </div>
        <div class="total"> Total :
            <div id="total">
                <?= number_format($panier->total(),2,',',' '); ?> €
            </div>
            <div><a href="produits.php">Ajouter d'autres articles</a></div>

        </div>
        <div class="valid-panier">
            <button class="submit-bouton" type="submit" name="valid-panier">Passer la commande </button>
        </div>
    </form>
</div>
<?php
require_once 'commons/basdepage.php';
require_once 'commons/pieddepage.php';
?>
