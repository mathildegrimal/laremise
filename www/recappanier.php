<?php
$nav_en_cours="";
require_once 'commons/entete.php';
entete('panier');
require_once 'commons/bandeauconnexion.php';
require_once 'commons/menu.php';
navencours($nav_en_cours);
require_once 'commons/bandeau.php';?>

<?php
if(!isset($_SESSION['Utilisateur'])&& $_SESSION['Utilisateur']==""){
    header('Location:connexion.php');
} else {
    if ($panier->total()<=0) { echo "Votre panier ne contient aucun article";
    echo"<div class ='form-insert'><a href='panier.php'>Retourner au panier</a></div>";
} else { ?>
    <div class="form-insert">
        <h2 id="panier">Recapitulatif de votre votre panier</h2>
        <form method="post" action="commande.php">
            <div class="aff-pdt">
                <table class="aff-pdt">
                    <tr class="aff-pdt">
                        <th>Nom du produit</th>
                        <th>Prix unitaire</th>
                        <th>Quantité</th>
                        <th>Prix avec TVA</th>
                    </tr>
                    <?php
                    $ids = array_keys($_SESSION['panier']);
                    if(empty($ids)){
                        $products = array();
                    }else{
                        $products = $DB->query('SELECT * FROM produit,image WHERE produit.`pdt_image`=image.`img_id` AND pdt_id IN ('.implode(',',$ids).')');
                    }
                    foreach($products as $product):
                     if($_SESSION['panier'][$product->pdt_id]!=0){
                        $quantite=$_SESSION['panier'][$product->pdt_id]?>

                        <tr class="aff-pdt">

                            <td><?= $product->pdt_nom; ?></td>
                            <td><?= number_format($product->pdt_prixht,2,',',' '); ?> €</td>
                            <td><?= $quantite; ?></td>
                            <td><?= number_format($product->pdt_prixttc*$quantite,2,',',' '); ?> €</td>
                        </tr>

                    <?php }endforeach; ?>
                </table>
            </div>
            <div class="total">
                <h3>Grand Total :</h3>
                <div id="total">
                    <?= number_format($panier->total(),2,',',' '); ?> €
                </div>

            </div>
            <div>Pour ajouter d'autres articles, cliquez <a href="produits.php">ici.</a></div>
            <div> Choisissez la date et l'heure de récupération au magasin :
                <?php
                date_default_timezone_set('Europe/Paris');
                define("JOURS",['Monday','Tuesday','Wednesday','Thursday','Friday', 'Saturday']);
                define("HEURES",['08:00'=>'8h','09:00'=>'9h','10:00'=>'10h','11:00'=>'11h','12:00'=>'12h', '13:00'=>'13h','14:00'=>'14h','15:00'=>'15h','16:00'=>'16h','17:00'=>'17h','18:00'=>'18h']);

                $tabdates=array();

                $english_days = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
                $french_days = array('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi');
                $english_months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
                $french_months = array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');

                foreach (JOURS as $key => $value) {
                    $datestr=date('l d F Y', strtotime ($value));
                    $date=date('m-d-Y', strtotime ($value));
                    $tabdates[$date]=$datestr;
                }

                ksort($tabdates);

                foreach ($tabdates as $key => $value) {
                    $tabdates[$key]=str_replace($english_months, $french_months, str_replace ($english_days, $french_days,$tabdates[$key]));
                }
                array_shift($tabdates);

                ?>

                <select name="daterecup">
                    <?php
                    foreach ($tabdates as $key => $value) {
                        echo "<option value=".$key.">".$value."</option>";
                    }?>
                </select>

                <select name="heurerecup">
                    <?php
                    foreach (HEURES as $key => $value) {
                        echo "<option value=".$key.">".$value."</option>";
                    }
                    ?>
                </select>

<?php if (isset($_GET['err'])&& $_GET['err']==1){ ?>
    <div style="color:red">Attention ! Toute l'année, nous sommes ouverts du lundi au samedi de 8h à 19h30. En juillet et août le magasin sera fermé entre 13h et 16h</div>
<?php } ?>
</div>
<button class="submit-bouton" type="submit" name="validation">Valider la commande</button>
</form>
</div>
<?php }
}
require_once 'commons/basdepage.php';
require_once 'commons/pieddepage.php';
?>
