<?php
    require_once("commons/_header.php");
    $mel = $_POST['mel'];
    $reqCompte = $DB->select1("SELECT cpt_id FROM compte WHERE cpt_email = :mail",array('mail'=> $mel));

    if($reqCompte)
    {
        $idutil=$reqCompte->cpt_id;
        $codeAleatoire = rand(1000000, 10000000);
        $updateCompte = $DB->query("UPDATE `compte` SET `cpt_recovmdp`=$codeAleatoire WHERE `cpt_id` = :idutil", array('idutil' => $idutil));

        $sujet = "Changement de votre mot de passe - La Remise";

        $message = "<h1>Bonjour,</h1><br>Pour changer votre mot de passe rendez-vous à l'adresse suivante :<br><a href='http://laremise.alwaysdata.net/changement-mdp.php?code=$codeAleatoire'>http://laremise.alwaysdata.net/changement-mdp.php?code=$codeAleatoire</a>";
        $destinataire = $mel;


        $headers = "From: \"Bot La Remise\"<mon.mail@mail.fr>\n";
        $headers .= "Reply-To: no-reply@laremise.com\n";
        $headers .= "Content-Type: text/html; charset=\"utf-8\"";

        mail($destinataire,$sujet,$message,$headers);
        header("Location:connexion.php?err=3&mail=".$mel);
    }
    else
    {
        header('Location:connexion.php?err=5&mail='.$mel);
    }
?>

