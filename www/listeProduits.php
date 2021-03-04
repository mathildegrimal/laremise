<?php
require_once 'commons/entete.php';
entete("Produits");
require_once 'fonctionsProduits.php';
$nav_en_cours="listitem";
require_once 'commons/menu-admin.php';
require_once 'commons/bandeau.php';
?>
<div class="form-insert">
        <?php
        if (isset($_POST['updateProduit'])){
                echo updateProduit($DB);
        }?>
        <form action="" method="post">
                <button class="submit-bouton" type="submit" name="listePdts">Afficher la liste</button>
        </form>
        <?php if (isset($_POST['listePdts'])){
                header('Location:listeProduits.php');
        }
        ?>

</div>
<?php
if (isset($_GET['modifier'])) {

        ?>

        <form class="form-insert" action="" method="post" enctype="multipart/form-data">
                <h1 class="titre-form"> Données à modifier </h1>
                <div class="insert-form-group">
                        <div class="nowrap">
                                <label for="idpdt">Numéro produit :</label> </br>
                                <input id="idpdt" type="text" name="id" required value="<?php echo returnValue($DB,'pdt_id');
                                ?>">
                                <label for="nom">Nom du produit :</label> </br>
                                <input id="nom_produit" type="text" name="nom" onblur="verifLength(this,'nom_produit','nom produit',1,150)" required value="<?php echo returnValue($DB,'pdt_nom');?>">
                                <div id='errnom_produit'></div>
                        </div>
                        <div class="nowrap">
                                <label for="marque">Marque :</label> </br>
                                <input id="marque" type="text" name="marque" value="<?php echo returnValue($DB,'pdt_marque');?>">
                        </div>
                </div>

                <div class="insert-form-group">
                        <div class="nowrap">
                                <label for="poids">Poids :</label> </br>
                                <input id="poids" type="text" name="poids"required onblur="verifLength(this,'poids','poids',1,10)" value="<?php echo returnValue($DB,'pdt_poids');?>">
                                <div id='errpoids'></div>
                        </div>
                        <div class="nowrap">
                                <label for="prix_unitaire">Prix unitaire HT:</label> </br>
                                <input id="prix_unitaire" type="text" name="prixu" onblur="verifLength(this,'prix_unitaire','prix unitaire',1,10)" required value="<?php echo returnValue($DB,'pdt_prixht');?>">
                                <div id='errprix_unitaire'></div>
                        </div>
                        <div class="nowrap">
                                <label for="stock">Stock :</label> </br>
                                <input id="stock" type="text" name="stock" onblur="verifLength(this,'stock','stock',1,10)" required value="<?php echo returnValue($DB,'pdt_stock');?>">
                                <div id='errstock'></div>
                        </div>

                </div>

                <label for="description">Description :</label> </br>
                <textarea class="textarea-form-insert" id="description" type="text" name="description" rows="7" onblur="verifLength(this,'description','description',0,1000)" required><?php echo returnValue($DB,'pdt_description');?></textarea>
                <div id='errdescription'></div>

                <div class="insert-form-group">

                        <label for="tva_id_tva">Selectionnez la valeur de la TVA : </label>
                        <select id="tva_id_tva" type="text" name="tva">
                                <?php $tvas=$DB->query('SELECT * FROM `tva`');
                                foreach ($tvas as $tva) {?>
                                        <option value="<?php echo $tva->tva_id; ?>"><?=$tva->tva_valeur?> </option>
                                <?php } ?>
                        </select>
                        <label for="categorie">Sélectionnez la catégorie : </label>
                        <select id="categorie" type="text" name="categorie">
                                <?php $categories=$DB->query('SELECT * FROM categorie');
                                foreach($categories as $categorie){?>
                                        <option value="<?php echo $categorie->cat_id; ?>"> <?=$categorie->cat_libelle?></option>
                                <?php } ?>
                        </select>
                        <label for="admin">admin</label> </br>
                        <input id="admin" type="text" name="admin"required value="1">
                </div>

                <div class="insert-form-group">
                        Image actuelle :
                        <img class='aff-produit-img-update'src= <?php echo "'uploads\\".explode('/',returnValue($DB,'img_nom'))[1]."'"?> ></img>
                        <label for="insert-image">Choisissez une image :</label>
                        <input id="insert-image" type="file" name="imgUpload"><br>
                </div>
                <div class="insert-form-group">
                        <button class="submit-bouton" type="submit" name="updateProduit"> Enregistrer </button>
                </div>

        </form>
        <?php
}?>
<div class='aff-pdt'>
        <table class='aff-pdt'>
                <tr class='aff-pdt'>
                        <th>N° produit</th>
                        <th>Nom</th>
                        <th>Marque</th>
                        <th>Poids</th>
                        <th>Prix unitaire HT</th>
                        <th>Prix unitaire TTC</th>
                        <th>Prix au kilo</th>
                        <th>Description</th>
                        <th>TVA</th>
                        <th>Catégorie</th>
                        <th>Stock</th>
                        <th>Image</th>
                        <th>Action</th>
                </tr>

                <?php $reqItem=$DB->query("SELECT * FROM image, produit, tva, categorie where image.`img_id`= produit.`pdt_image` AND `tva_id`= `pdt_tva` AND `cat_id`= `pdt_id_categorie`");


                foreach($reqItem as $i)
                {?>
                        <tr>
                                <td><?=$i->pdt_id?></td>
                                <td><?=$i->pdt_nom?></td>
                                <td><?=$i->pdt_marque?></td>
                                <td><?=$i->pdt_poids?></td>
                                <td><?=$i->pdt_prixht?></td>
                                <td><?=$i->pdt_prixttc?></td>
                                <td><?=$i->pdt_prixkg?></td>
                                <td><?=$i->pdt_description?></td>
                                <td><?=$i->tva_valeur?></td>
                                <td><?=$i->cat_libelle?></td>
                                <td><?=$i->pdt_stock?></td>

                                <td>
                                        <img class='aff-produit-img'src='uploads\\<?=explode('/',$i->img_nom)[1]?>'></img>
                                </td>
                                <td>

                                        <a href='?modifier=<?=$i->pdt_id?>'> Modifier </a>
                                </td>
                        </tr>

                <?php } ?>
        </table>
</div>
<script type="text/javascript">


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

function verifForm(f)
{
    var nomOK= verifLength(this,'nom_produit','nom produit',1,150);
    var poidsOK=verifLength(this,'poids','poids',1,10);
    var prixOK=verifLength(this,'prix_unitaire','prix unitaire',1,10);
    var stockOK=verifLength(this,'stock','stock',1,10);
    var descriptionOK=verifLength(this,'description','description',0,1000);

    if(nomOK && poidsOK && prixOK && stockOK && descriptionOK)
      return true;
  else
  {
      alert("Veuillez remplir correctement tous les champs");
      return false;
  }
}
</script>
<?php
require_once 'commons/pieddepage.php';
?>


