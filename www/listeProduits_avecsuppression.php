<?php
include ('../commons/entete.php');
entete("Produits");
include('updateProduit.func.php');
$nav_en_cours="listitem";
include('menu-admin.php');
include('../commons/bandeau.php');
?>
<div class="form-insert">
	<?php
	if (isset($_POST['updateProduit'])){
		updateProduit($DB);
	}
	?>
</div>
<?php
if (isset($_GET['modifier'])) { ?>

        <form class="form-insert" action="#" method="post" enctype="multipart/form-data">
               <h1 class="titre-form"> Données à modifier </h1>


               <div class="insert-form-group">
                      <div class="nowrap">
                             <label for="idpdt">Numéro produit :</label> </br>
                             <input id="idpdt" type="text" name="id" required value="<?php if (isset($_POST['updateProduit'])) echo ""; else echo returnValue($DB,'pdt_id');
                                ?>">
                             <label for="nom">Nom du produit :</label> </br>
                             <input id="nom_produit" type="text" name="nom" required value="<?php if (isset($_POST['updateProduit'])) echo ''; else echo returnValue($DB,'pdt_nom');?>">
                     </div>
                     <div class="nowrap">
                             <label for="marque">Marque :</label> </br>
                             <input id="marque" type="text" name="marque" value="<?php if (isset($_POST['updateProduit'])) echo ''; else echo returnValue($DB,'pdt_marque');?>">
                     </div>
             </div>

             <div class="insert-form-group">
              <div class="nowrap">
                     <label for="poids">Poids :</label> </br>
                     <input id="poids" type="text" name="poids"required value="<?php if (isset($_POST['updateProduit'])) echo ''; else echo returnValue($DB,'pdt_poids');?>">
             </div>
             <div class="nowrap">
                     <label for="prix_unitaire">Prix unitaire HT:</label> </br>
                     <input id="prix_unitaire" type="text" name="prixu" required value="<?php if (isset($_POST['updateProduit'])) echo ''; else echo returnValue($DB,'pdt_prixht');?>">
             </div>
			<div class="nowrap"><!--
                                <label for="prix_kilo">Prix au kilo :</label> </br>
                                <input id="prix_kilo" type="text" name="prixk"required value=> -->
                                <label for="stock">Stock :</label> </br>
                                <input id="stock" type="text" name="stock" required value="<?php if (isset($_POST['updateProduit'])) echo ''; else echo returnValue($DB,'pdt_stock');?>">
                        </div>

                </div>

                <label for="description">Description :</label> </br>
                <textarea class="textarea-form-insert" id="description" type="text" name="description" rows="7" required><?php if (isset($_POST['updateProduit'])) echo ''; else echo returnValue($DB,'pdt_description');?></textarea>

                <div class="insert-form-group">

                	<label for="tva_id_tva">Selectionnez la valeur de la TVA : </label>
                	<select id="tva_id_tva" type="text" name="tva" size="3">
                		<?php
                		$tvas=$DB->query('SELECT * FROM `tva`');
                		foreach ($tvas as $tva) {?>
                			<option value="<?php echo $tva->tva_id; ?>"><?php echo $tva->tva_valeur; ?></option>
                		<?php } ?>
                	</select>

                	<label for="categorie">Sélectionnez la catégorie : </label>
                	<select id="categorie" type="text" name="categorie">
                		<?php
                		$categories=$DB->query('SELECT * FROM categorie');
                		foreach($categories as $categorie){?>
                			<option value="<?php echo $categorie->cat_id; ?>"> <?php echo $categorie->cat_libelle; ?></option>
                		<?php } ?>
                	</select>
                	<label for="admin">admin</label> </br>
                	<input id="admin" type="text" name="admin"required value="1">
                </div>
                <div class="insert-form-group">
                	<label for="insert-image">Choisissez une image :</label>
                	<input id="insert-image" type="file" name="imgUpload"><br>
                </div>
                <div class="insert-form-group">
                	<button class="submit-bouton" type="submit" name="updateProduit"> Enregistrer </button>
                </div>

        </form>
        <?php
}

$reqItem=$DB->query("SELECT * FROM image, produit, tva, categorie where image.`img_id`= produit.`pdt_image` AND `tva_id`= `pdt_tva` AND `cat_id`= `pdt_id_categorie`");


echo "
<div class='aff-pdt'>
<table class='aff-pdt'>
<tr class='aff-pdt'>
<td>N° produit</td>
<td>Nom</td>
<td>Marque</td>
<td>Poids</td>
<td>Prix unitaire HT</td>
<td>Prix unitaire TTC</td>
<td>Prix au kilo</td>
<td>Description</td>
<td>TVA</td>
<td>Catégorie</td>
<td>Stock</td>
<td>Image</td>
<td>Action</td>
</tr>";

foreach($reqItem as $i)
{
       echo "<tr>
       <td>".$i->pdt_id."</td>
       <td>".$i->pdt_nom."</td>
       <td>".$i->pdt_marque."</td>
       <td>".$i->pdt_poids."</td>
       <td>".$i->pdt_prixht."</td>
       <td>".$i->pdt_prixttc."</td>
       <td>".$i->pdt_prixkg."</td>
       <td>".$i->pdt_description."</td>
       <td>".$i->tva_valeur."</td>
       <td>".$i->cat_libelle."</td>
       <td>".$i->pdt_stock."</td>

       <td>
       <img class='aff-produit-img'src='uploads\\".explode('/',$i->img_nom)[1]."'></img>
       </td>
       <td>
       <a id='suppPdt' href='?supprimer=".$i->pdt_id."' onclick='confirmSuppr()'> Supprimer </a></br>
       <a href='?modifier=".$i->pdt_id."'> Modifier </a>";

       if (isset($_GET['supprimer']) && $_GET['supprimer']==$i->pdt_id){
        echo"<div><form method='post' action=''>
                        <p>Etes vous sur de vouloir supprimer ce produit ?</p>
                        <button class='submit-bouton' type='submit' name='confirmer'>Confirmer</button>
                        <button class='submit-bouton' type='submit' name='annuler'>Annuler</button>
                        </form>
                        </div>";
                        if (isset($_POST['confirmer'])){
                                supprimer($DB, $i->pdt_id);
                                header('Location:listeProduits.php');
                        } elseif (isset($_POST['annuler'])){
                                header('Location:listeProduits.php');
                        }
       }
       echo "
       </td>
       </tr>";

}
echo "</table></div>";
?>

