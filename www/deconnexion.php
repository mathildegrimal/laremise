<?php
    session_start();
    $_SESSION['Utilisateur']=null;
    $_SESSION['panier']=null;
    unset ($_SESSION['Utilisateur']);
    unset ($_SESSION['panier']);
    /*
    setcookie("mdp","--", time()-1);*/
    header("Location:index.php");
?>
