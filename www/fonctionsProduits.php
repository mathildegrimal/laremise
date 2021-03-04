<?php

function getProduit($DB,$idpdt){

 $req = $DB->select1("SELECT * FROM image, produit WHERE image.`img_id`= produit.`pdt_image` AND `pdt_id` =:id", array('id'=>$idpdt));
 return $req;
}

function returnValue($DB, $champ){
    $pdt=getProduit($DB,(int) $_GET['modifier']);
    $valueChamp="";
    if (isset($_GET['modifier'])){
        $valueChamp= $pdt->$champ;
    } else { $valueChamp="";}
    return $valueChamp;
}


function verifChamps() {
    $resultat=false;
    $champErreur=array();

    if (!isset($_POST['nom']) || strlen($_POST['nom'])> 150){
        $champ="nom produit";
        array_push($champErreur, $champ);
    }
    if (!isset($_POST['poids']) || $_POST['poids']> 5 || !floatval($_POST['poids']) || $_POST['poids'] ==0 ){
        $champ="poids";
        array_push($champErreur, $champ);
    }
    if (!isset($_POST['prixu']) || strlen($_POST['prixu'])> 5 || !floatval($_POST['prixu']) || $_POST['prixu'] ==0){
        $champ="prix unitaire";
        array_push($champErreur, $champ);
    }
    if (!isset($_POST['stock']) || !intval($_POST['stock'])){
        $champ="stock";
        array_push($champErreur, $champ);
    }
    if(!isset($_POST['description']) || $_POST['description']>150){
        $champ="description";
        array_push($champErreur, $champ);
    }
    return $champErreur;
}




function updateProduit ($DB){
    $msgErreurImage="";
    $msgErreurTVA="";
    $msgErreurPdt="";
    $msgErreurInput="";
    if(!isset($_POST['tva'])|| $_POST['tva']==""){
        $msgErreurTVA="<div class='erreur'>Attention, la TVA n'a pas été selectionnée, veuillez recommencer.</br></div>";
        return $msgErreurTVA;
    } else {
        $verifchamps=verifchamps();
        if (!empty($verifchamps)) {
            $msgErreurInput="<div class='erreur'>Le(s) champ(s)".implode(", ", $verifchamps)." n'a/n'ont pas été saisi(s) correctement, veuillez recommencer.</br></div>";
        } else {
    //s'il n'a pas de fichier à importer mais qu'on veut juste modifier les autres données du produit

            if(!isset($_FILES["imgUpload"]["name"]) || $_FILES["imgUpload"]["name"] == null) {

                $reqtva= $DB->select1('SELECT * FROM tva WHERE tva_id=:pdttva', array('pdttva'=>$_POST['tva']));

                $puht=floatval($_POST['prixu']);

                $tvaVal=floatval($reqtva->tva_valeur);
                $puttc=$puht*(1+($tvaVal/100));
                $poids=floatval($_POST['poids']);
                $pkg=round($puttc/$poids,2);

                $update=$DB->update("UPDATE `produit` SET `pdt_nom`=:nom,`pdt_marque`=:marque,`pdt_poids`=:poids,
                    `pdt_prixht`=:prix_unitaire,`pdt_prixttc`=:prixttc,`pdt_prixkg`=:prix_kilo,`pdt_description`=:description,
                    `pdt_tva`=:tva,`pdt_id_categorie`=:categorie,`pdt_admin`=:admin,`pdt_stock`=:stock WHERE `pdt_id`=:id",
                    array('nom'=>$_POST['nom'],'marque'=>$_POST['marque'],'poids'=>$_POST['poids'],'prix_unitaire'=>$puht,
                        'prixttc'=>$puttc,'prix_kilo'=>$pkg,'description'=>$_POST['description'],'tva'=>$_POST['tva'],
                        'categorie'=>$_POST['categorie'],'admin'=>$_POST['admin'],'stock'=>$_POST['stock'],'id'=>$_POST['id']));

                if($update){
                    $msgErreurPdt= "Le produit a bien été modifié dans la base de données.</br>";
                    $msgErreurImage="<div class='erreur'>Attention : l'image n'a pas été modifiée.</div>";
                } else {
                    $msgErreurPdt= "<div class='erreur'>Echec de la modification du produit</br></div>";
                }
            } else {
            //si on veut changer l'image du produit et ses données :
                $target_dir = "uploads/";
                $target_file = $target_dir . basename($_FILES["imgUpload"]["name"]);
                $uploadOk = true;

                $check = getimagesize($_FILES["imgUpload"]["tmp_name"]);
                if($check == false){
                    $msgErreurImage= "<div class='erreur'>Ce fichier n'est pas une image.</br></div>";
                    $uploadOk = false;
                }

                // Allow certain file formats
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                if($imageFileType != "jpg" && $imageFileType != "png"){
                    $msgErreurImage= "<div class='erreur'>Désolé, seuls les fichiers JPG & PNG sont autorisés. </br></div>";
                    $uploadOk = false;
                }
                // Check if file already exists
                if (file_exists($target_file)) {
                    $msgErreurImage= "<div class='erreur'>Désolé, le fichier existe déja dans votre dossier upload. </br></div>";
                    $uploadOk = false;
                }
                // Check file size
                if ($_FILES["imgUpload"]["size"] > 500000){
                    $msgErreurImage= "<div class='erreur'>Désolé, votre fichier est trop lourd.</br></div>";
                    $uploadOk = false;
                }
                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == false){
                    $msgErreurImage= "<div class='erreur'>Désolé, votre fichier n'a pas pu être téléchargé dans le dossier upload.</br></div>";
                } else {
                    $msgErreurImage="Fichier téléchargé dans le dossier upload</br>";
                }
                        // le fichier est dans le dossier upload, on peut l'importer dans la base de données
                        //d'abord on verifie qu'il n'est pas déja dans la bdd

                $reqImage = $DB->select1("SELECT img_id FROM image WHERE img_nom = :titre", array('titre'=>$target_file));
            //si l'image est déja présente
                if($reqImage) {
                    $iditem=NULL;
                    $msgErreurImage= "<div class='erreur'>L'image existe déjà dans la base de données</br></div>";
                    return $iditem;
                } else {
                    $fp = fopen($_FILES["imgUpload"]['tmp_name'], 'rb');

                    if(!move_uploaded_file($_FILES["imgUpload"]["tmp_name"], $target_file)) {
                        $msgErreurImage= "<div class='erreur'>Désolé, Impossible d'ajouter l'image dans la base</br></div>";
                        $iditem=NULL;
                    } else {
                        $reqIdItem = $DB->select1("SELECT max(img_id)+1 AS iditem FROM image");
                        $reqIdType = $DB->select1("SELECT typeimg_id AS idtype FROM type_img WHERE typeimg_libelle='$imageFileType'");
                        $reqBlob = $DB->insert("INSERT INTO image (`img_id`, `img_nom`, `img_blob`, `img_type`) VALUES (:id, :titre, :blob, :type)", array('id' => $reqIdItem->iditem, 'titre' => $target_file,'blob' => $fp, 'type'=> $reqIdType->idtype));
                        if($reqBlob){
                            $iditem=$reqIdItem->iditem;
                            $msgErreurImage= "L'image a bien été ajoutée dans la base</br>";
                            $reqTva= $DB->select1('SELECT * FROM tva WHERE tva_id=:pdttva', array('pdttva'=>$_POST['tva']));

                            $puht=floatval($_POST['prixu']);
                            $tvaVal=floatval($reqTva->tva_valeur);
                            $puttc=$puht*(1+($tvaVal/100));
                            $poids=floatval($_POST['poids']);
                            $pkg=round($puttc/$poids,2);

                            $update=$DB->update("UPDATE `produit` SET `pdt_nom`=:nom,`pdt_marque`=:marque, `pdt_poids`=:poids,
                                `pdt_prixht`=:prixht, `pdt_prixttc`=:prixttc, `pdt_prixkg`=:prix_kilo,`pdt_description`=:description,
                                `pdt_tva`=:tva, `pdt_id_categorie`=:categorie,`pdt_admin`=:admin, `pdt_image`=:image,
                                `pdt_stock`=:stock WHERE `pdt_id`=:id",
                                array('nom'=>$_POST['nom'],'marque'=>$_POST['marque'],'poids'=>$_POST['poids'],'prixht'=>$puht,
                                    'prixttc'=>$puttc,'prix_kilo'=>$pkg,'description'=>$_POST['description'],'tva'=>$_POST['tva'],
                                    'categorie'=>$_POST['categorie'],'admin'=>$_POST['admin'],'image'=>$iditem,'stock'=>$_POST['stock'],
                                    'id'=>$_POST['id']));
                            if($update){
                                $msgErreurPdt= "Le produit a bien été modifié dans la base de données</br>";
                            } else {
                                $msgErreurPdt= "<div class='erreur'>Echec de la modification du produit.</br></div>";
                            }

                        } else {
                            $msgErreurImage= "<div class='erreur'>Désolé, Impossible d'ajouter l'image dans la base</br></div>";
                        }

                    }
                }

            }
        }
    }
    return $msgErreurTVA." ".$msgErreurInput." ".$msgErreurPdt." ".$msgErreurImage;
}


function supprimer($DB,$idpdt){

 $req = $DB->delete("DELETE FROM produit WHERE `pdt_id` =:id",array('id'=>$idpdt));
}

function stock($stock,$produit_id){
    if (isset($_SESSION['panier'][$produit_id])){
        $stock=$stock-$_SESSION['panier'][$produit_id];
    }
}


function insertProduit($DB){

    $msgErreurImage="";
    $msgErreurTVA="";
    $msgErreurPdt="";
    $msgErreurInput="";


    if(!isset($_POST['tva']) || $_POST['tva']==""){
        $msgErreurTVA= "<div class='erreur'>Attention la tva n'a pas été selectionnée. Echec de l'insertion du produit.</div>";
        return $msgErreurTVA;
    } else {
        $verifchamps=verifchamps();
        if (!empty($verifchamps)) {
            $msgErreurInput="<div class='erreur'>Le(s) champ(s)".implode(", ", $verifchamps)." n'ont pas été saisis correctement, veuillez recommencer.</br></div>";
        } else {

            if (!isset($_FILES["imgUpload"]["name"]) || $_FILES["imgUpload"]["name"] == null) {
                $msgErreurImage= "<div class='erreur'>Erreur pas d'image à insérer</br>";
            } else {
                $target_dir = "uploads/";
                $target_file = $target_dir . basename($_FILES["imgUpload"]["name"]);
                $uploadOk = true;
                $check = getimagesize($_FILES["imgUpload"]["tmp_name"]);

                if($check == false){
                    $msgErreurImage= "<div class='erreur'>Ce fichier n'est pas une image.</br></div>";
                    $uploadOk = false;
                }

            // Allow certain file formats
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                if($imageFileType != "jpg" && $imageFileType != "png"){
                    $msgErreurImage= "<div class='erreur'>Désolé, seules les images JPG & PNG sont autorisés. </br></div>";
                    $uploadOk = false;
                }
            // Check if file already exists
                if (file_exists($target_file)) {
                    $msgErreurImage= "<div class='erreur'>Désolé, l'image existe déja.</br></div>";
                    $uploadOk = false;
                }
            // Check file size
                if ($_FILES["imgUpload"]["size"] > 5000000){
                    $msgErreurImage= "<div class='erreur'>Désolé, votre image est trop lourde.</br></div>";
                    $uploadOk = false;
                }
            // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == false){
                    $msgErreurImage= "<div class='erreur'>Désolé, votre image n'a pas pu être téléchargé.</br></div>";
                } else {
                    $msgErreurImage="Image téléchargée </br>";
                    $reqImage = $DB->select1("SELECT img_id FROM image WHERE img_nom = :titre", array('titre'=>$target_file));

                    if($reqImage) {
                        $iditem=NULL;
                        $msgErreurImage= "<div class='erreur'>L'image existe déjà dans la base de données</br></div>";
                        return $iditem;
                    } else {
                        $fp = fopen($_FILES["imgUpload"]['tmp_name'], 'rb');
                        if(!move_uploaded_file($_FILES["imgUpload"]["tmp_name"], $target_file)) {
                            $msgErreurImage= "<div class='erreur'>Désolé, Impossible d'ajouter l'image dans la base</br></div>";
                            $iditem=NULL;
                        } else {
                            $reqIdItem = $DB->select1("SELECT max(img_id)+1 AS iditem FROM image");
                            $reqIdType = $DB->select1("SELECT typeimg_id AS idtype FROM type_img WHERE typeimg_libelle='$imageFileType'");
                            $reqBlob = $DB->insert("INSERT INTO image (`img_id`, `img_nom`, `img_blob`, `img_type`) VALUES (:id, :titre, :blob, :type)", array('id' => $reqIdItem->iditem, 'titre' => $target_file,'blob' => $fp, 'type'=> $reqIdType->idtype));
                            if($reqBlob){
                                $iditem=$reqIdItem->iditem;
                                $msgErreurImage= "L'image a bien été ajoutée dans la base</br>";
                                $reqTva= $DB->select1('SELECT * FROM tva WHERE tva_id=:pdttva', array('pdttva'=>$_POST['tva']));

                                $puht=floatval($_POST['prixu']);
                                $tvaVal=floatval($reqTva->tva_valeur);
                                $puttc=$puht*(1+($tvaVal/100));
                                $poids=floatval($_POST['poids']);
                                $pkg=round($puttc/$poids,2);

                                $insertPdt= $DB->insert('INSERT into produit VALUES (NULL, :nom_produit, :marque, :poids, :prixht, :prixttc, :prix_kilo, :description, :tva_id_tva, :categorie, 1, :iditem,:stock)', array('nom_produit' => $_POST['nom'], 'marque' => $_POST['marque'], 'poids' => $_POST['poids'], 'prixht'=> $puht, 'prixttc' => $puttc, 'prix_kilo'=> $pkg, 'description'=> $_POST['description'],
                                    'tva_id_tva'=>$_POST['tva'], 'categorie' => $_POST['categorie'], 'stock' => $_POST['stock'],
                                    'iditem' => $iditem));

                                if($insertPdt) {
                                    $msgErreurPdt= "<div>Le produit a bien été ajouté dans la base de données.</br></div>";
                                } else {
                                    $msgErreurPdt= "<div class='erreur'>Echec de l'insertion du produit.</br></div>";
                                }

                            } else {
                                $msgErreurImage= "<div class='erreur'>Désolé, Impossible d'ajouter l'image dans la base</br></div>";
                            }
                        }//fin else if moveupload file = true
                    }//fin else $reqimage(si image pas deja présente dans la bdd)
                }// fin si image a été téléchargée ($uploadok=true);
            }//fin si image a télécharger
        }//fin verfi champs
    }//fin tva set
    return $msgErreurTVA." ".$msgErreurInput." ".$msgErreurPdt." ".$msgErreurImage;
}
?>
