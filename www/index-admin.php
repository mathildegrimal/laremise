<?php
session_start();
if (isset($_SESSION['Utilisateur'])){
    require_once 'commons/entete.php';
    entete('Connexion');
    $nav_en_cours="administration";
    require_once 'commons/menu-admin.php';
    require_once 'commons/bandeau.php';

    $id=$_SESSION['Utilisateur']['id'];
    $req=$DB->select1('SELECT cpt_grade FROM compte WHERE cpt_id = :id', array('id' => $id));

    if ($req->cpt_grade != 1){
        header('Location:../index.php');
    }
    ?>

    <section id="accueil-admin">
        <?php echo "Bonjour ".$_SESSION['Utilisateur']['login']." </br> Que voulez-vous faire ? </br> Selectionnez dans le menu l'action à effectuer.";?>
        <form action='index.php' method='post'>
            <button class='submit-bouton' type='submit' name='accuil'>Accueil site</button>
        </form>

        <form action='deconnexion.php' method='post'>
            <button class='admin-deconnexion-bouton' type='submit' name='deconnexion'>Deconnexion</button>
        </form>
    </section>
    <?php
}
require_once 'commons/pieddepage.php';
?>

