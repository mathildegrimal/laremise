<?php
require 'commons/entete.php';
$idcpt=$_SESSION['Utilisateur']['id'];
$totalpanier=$panier->total();
date_default_timezone_set('Europe/Paris');
$dateNow = date('Y-m-d_h-i-s');
$daterecup=$_POST['daterecup'];
$heurerecup=$_POST['heurerecup'];
$idcmd = str_replace(["-","_"], "", $idcpt.$dateNow);

$commande= $DB->insert('INSERT into commande VALUES (:id, :datecommande, :total, :datedrive, :heuredrive, :compte)', array(
'id'=>$idcmd,'datecommande'=>$dateNow,'total'=>$totalpanier,'datedrive'=>$daterecup,'heuredrive'=>$heurerecup,'compte'=>$idcpt));

if ($commande) {
    $ids = array_keys($_SESSION['panier']);

    if(empty($ids)){
        $products = array();
    }else{
        $products = $DB->query('SELECT * FROM produit WHERE pdt_id IN ('.implode(',',$ids).')');
    }
    foreach($products as $product){
        if($_SESSION['panier'][$product->pdt_id]!=0){
            $quantite=$_SESSION['panier'][$product->pdt_id];
            $nompdt=$product->pdt_nom;
            $prix_u=$product->pdt_prixttc;
            $idpdt=$product->pdt_id;
            $montant_ligne=$prix_u*$quantite;
            $stockbefore=intval($product->pdt_stock);

            $panier= $DB->insert('INSERT into panier VALUES (:produit, :idcommande, :quantite, :montant)', array('produit'=>$idpdt,'idcommande'=>$idcmd,'quantite'=>$quantite, 'montant'=>$montant_ligne));
            $stockafter=$stockbefore-intval($quantite);

            $setstock=$DB->update('UPDATE produit SET pdt_stock = :stock WHERE pdt_id = :produit', array('stock'=>$stockafter,'produit'=>$idpdt,));
         }
     }
 }

if($panier && $setstock){
    $date = DateTime::createFromFormat('m-d-Y', $daterecup);
    $mel = $_SESSION['Utilisateur']['email'];

    $sujet = "Votre commande n° ".$idcmd;

    $message = "Bonjour,<br> Votre commande n° ".$idcmd." sur le site internet de La Remise a bien été prise en compte. Vous pourrez venir la récupérer le ".$date->format('d/m/Y')." à partir de ".$heurerecup.".<br>Merci de bien vouloir téléphoner au 04 67 92 37 10 au maximum le jour de votre drive, avant 8h00,  si vous souhaitez annuler la commande ou changer l'heure de récupération.<br> Vous pouvez consulter votre commande ou télécharger la facture sur votre espace client, rubrique 'Mes commandes'.<br> Toute l'équipe de La Remise vous remercie pour votre commande ! <br> A bientôt au magasin ou sur <a href='https://laremise.alwaysdata.net'>le site internet de La Remise </a> !<br><br> La Remise <br> 53 bd des arceaux 34000 Montpellier<br> 04-67-92-37-10<br> Ouvert tous les jours de 8h à 19h30, en juillet et aout fermé de 13h à 16h";
    $destinataire = $mel;


        $headers = "From: \"Bot La Remise\"<mon.mail@mail.fr>\n";
        $headers .= "Reply-To: no-reply@laremise.com\n";
        $headers .= "Content-Type: text/html; charset=\"utf-8\"";
        $mailing=mail($destinataire,$sujet,$message,$headers);
        $_SESSION['panier']=array();
        header('Location:commande-validation.php?cmdid='.$idcmd);
} else {
    /* a completer */
}
require 'commons/pieddepage.php'; ?>
