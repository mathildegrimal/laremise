<?php
require 'commons/_header.php';
if (isset($_POST["motdepasse"]) && $_POST["motdepasse"]!="" && isset($_POST["confirmPass"]) && $_POST["confirmPass"]!=""){
    $newPwd = $_POST["motdepasse"];
    $newPwd2 = $_POST["confirmPass"];
    $code = $_GET["code"];
    if($newPwd == $newPwd2){

//$2y$10$22waAL4JIYIBxzaQg2YoR.6Gh42/j5xSL8fRb2zUrc7VXZjtTnLRW
//$2y$10$22waAL4JIYIBxzaQg2YoR.6Gh42/j5xSL8fRb2zUrc7VXZjtTnLRW
        var_dump($DB);
        $pass=password_hash($newPwd, PASSWORD_DEFAULT);
        $req = $DB->update("UPDATE compte SET cpt_password= :mdp, cpt_recovmdp = NULL WHERE cpt_recovmdp = :code", array('mdp'=>$pass, 'code'=>$code));

        if($req)
            header("Location:connexion.php?err=4");
        else
            header("Location:changement-mdp.php?code=".$code."&err=2");
    }
    else
    {
       header("Location:changement-mdp.php?code=".$code."&err=1");
    }
}
?>
