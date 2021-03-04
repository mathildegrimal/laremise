<?php
session_start();
require 'commons/_header.php';

if(isset($_SESSION['Utilisateur']['id']) && $_SESSION['Utilisateur']['id']<0)
{
    header("Location:index.php");
}
else {

    $nomDeCompte = $_POST['ndc'];
    $pass=$_POST['mdp'];

    $reqCompte = $DB->select1("SELECT * FROM compte WHERE cpt_login = :login",array('login'=>$nomDeCompte));
    if(!$reqCompte){
        header('Location:connexion.php?err=1');
    } else {
        if ($reqCompte->cpt_grade!=1){
            $reqNomclient = $DB->select1("SELECT cli_nom, cli_prenom FROM compte, client WHERE compte.`cpt_id` = client.`cpt_id` AND compte.`cpt_login`= :login", array('login'=>$nomDeCompte));
        }

        if(!password_verify($pass, $reqCompte->cpt_password)){
                header('Location:connexion.php?err=2');
        } else {

        $_SESSION['Utilisateur']=array();

        $_SESSION['Utilisateur']['id'] = $reqCompte->cpt_id;
        $_SESSION['Utilisateur']['login'] = $reqCompte->cpt_login;
        $_SESSION['Utilisateur']['email'] = $reqCompte->cpt_email;
        $_SESSION['Utilisateur']['nom'] = $reqNomclient->cli_nom;
        $_SESSION['Utilisateur']['prenom'] = $reqNomclient->cli_prenom;
            if ($reqCompte->cpt_grade==1){
                header('Location:index-admin.php');
            } else if ($reqCompte->cpt_grade!=1){
                header('Location:espaceclient.php');
            }
        }
    }
}
?>
