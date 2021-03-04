<?php
$nav_en_cours="";
require_once 'commons/entete.php';
entete('panier');
require_once 'commons/bandeauconnexion.php';
require_once 'commons/menu.php';
navencours($nav_en_cours);
require_once 'commons/bandeau.php';
if (isset($_SESSION['Utilisateur']) && isset($_GET['cmdid'])) {
    $idcpt=$_SESSION['Utilisateur']['id'];
    $idcmd=$_GET['cmdid'];


$commande= $DB->select1('SELECT * FROM commande WHERE cmd_id = :idcmd AND cmd_compte = :idutil', array('idcmd'=>$idcmd, 'idutil'=>$idcpt));


$date = DateTime::createFromFormat('m-d-Y', $commande->cmd_date_drive);?>
<div class="form-insert">
        <div class="titre-form">
                Commande validée !
        </div>
    Votre commande n° <?= $idcmd ?> d'un montant de <?= $commande->cmd_total ?> € a bien été prise en compte. </br>
    Vous allez recevoir un email de confirmation.
    N'oubliez pas de venir récupérer vos produits le <?= $date->format('d/m/Y') ?> à  <?= $commande->cmd_heure_drive ?> </br>
    Vous pouvez dès à présent consulter le recapitulatif de vos commandes et télécharger votre facture sur votre espace client à la section <a href="espaceclient.php?id=commandes"> Mes commandes </a>
</div>
<?php }
require_once'commons/pieddepage.php'; ?>
