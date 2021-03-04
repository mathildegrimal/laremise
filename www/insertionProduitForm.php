<?php
require_once 'commons/entete.php';
entete("Insérer un produit");
$nav_en_cours="insertion";
require_once 'fonctionsProduits.php';
require_once 'commons/menu-admin.php';
require_once 'commons/bandeau.php';
?>
<div class="form-insert">
    <?php

    if (isset($_POST['insertProduit'])){
     echo insertProduit($DB);
 }?>
</div>
<form id="form-insert" class="form-insert" action="#" method="post" onsubmit='return verifForm(this)' enctype="multipart/form-data">
    <h1 class="titre-form"> Entrez les données du produit à insérer</h1>

    <div class="insert-form-group">
        <div class="nowrap">

            <label for="nom">Nom du produit :</label> </br>
            <input id="nom_produit" type="text" name="nom" onblur="verifLength(this,'nom_produit','nom produit',1,150)" required>
            <div id='errnom_produit'></div>

        </div>
        <div class="nowrap">
            <label for="marque">Marque :</label> </br>
            <input id="marque" type="text" name="marque">
        </div>
    </div>

    <div class="insert-form-group">
        <div class="nowrap">
            <label for="poids">Poids :</label> </br>
            <input id="poids" type="text" name="poids" onblur="verifLength(this,'poids','poids',1,10)" required>
            <div id='errpoids'></div>

        </div>
        <div class="nowrap">
            <label for="prix_unitaire">Prix unitaire HT:</label> </br>
            <input id="prix_unitaire" type="text" name="prixu" onblur="verifLength(this,'prix_unitaire','prix unitaire',1,10)" required>
            <div id='errprix_unitaire'></div>

        </div>
        <div class="nowrap">
            <label for="stock">Stock :</label> </br>
            <input id="stock" type="text" name="stock" onblur="verifLength(this,'stock','stock',1,10)"required>
            <div id='errstock'></div>

        </div>
    </div>

    <label for="description">Description :</label> </br>
    <textarea class="textarea-form-insert" id="descriptionPdt" type="text" name="description" rows="7" onblur="verifLength(this,'description','description',0,1000)" required/>Description (1000 caractères max.)</textarea>
    <div id='errdescription'></div>

    <div class="insert-form-group">

        <label for="tva_id_tva">Selectionnez la valeur de la TVA : </label>
        <select id="tva_id_tva" type="text" name="tva">
            <?php
            $tvas=$DB->query('SELECT * FROM `tva`');
            foreach ($tvas as $tva) {?>
                <option value="<?=$tva->tva_id?>"><?=$tva->tva_valeur?></option>
            <?php } ?>
        </select>

        <label for="categorie">Sélectionnez la catégorie : </label>
        <select id="categorie" type="text" name="categorie">
            <?php
            $categories=$DB->query('SELECT * FROM categorie');
            foreach ($categories as $categorie){?>
                <option value="<?=$categorie->cat_id; ?>"> <?=$categorie->cat_libelle?></option>
            <?php } ?>
        </select>
        <label for="admin">admin</label> </br>
        <input id="admin" type="text" name="admin"required value="1">
    </div>
    <div class="insert-form-group">
        <label for="insert-image">Choisissez une image :</label>
        <input id="insert-image" type="file" name="imgUpload" required><br>
    </div>
    <div class="insert-form-group">
        <button class="submit-bouton" type="submit" name="insertProduit"> Enregistrer </button>
    </div>

</form>
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
