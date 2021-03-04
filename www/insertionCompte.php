<?php
require_once("commons/_header.php");

if (isset($_POST['motdepasse']) && $_POST['motdepasse']!="" && isset($_POST['confirmPass']) && $_POST['confirmPass']!="") {

    $pass = $_POST['motdepasse'];
    $confpass= $_POST['confirmPass'];
    if ($pass!=$confpass) {
        header('Location:creation.php?err=2');
    } else {
        $login=$_POST['login'];
        $pass = $_POST['motdepasse'];
        $reshash = password_hash($pass, PASSWORD_DEFAULT);
        $email=$_POST['email'];



        $toCommit = true;

        $checkEmail= $DB->select1('SELECT cpt_email FROM compte WHERE cpt_email = :email', array('email'=>$email));

        if ($checkEmail){
            header('Location:creation.php?err=3');
        } else {
            $checkLogin = $DB->select1('SELECT cpt_login FROM compte WHERE cpt_login = :login', array('login'=>$login));
            if ($checkLogin){
                header('Location:creation.php?err=4');
            } else {
                $compte= $DB->insert('INSERT into compte VALUES (NULL, :login, :password, :email, :grade, :recovmdp)', array('login'=>$login,'password'=>$reshash,'email'=>$email,'grade'=>0, 'recovmdp'=>NULL));

                $reqidcpt= $DB->select1('SELECT * FROM compte WHERE `cpt_login` = :login',array('login'=>$login));
                $id=$reqidcpt->cpt_id;

                $client= $DB->insert('INSERT into client VALUES (:id, :nom, :prenom, :adresse, :ville, :CP)', array('id'=>$id,
                'nom'=>$_POST['nom'],
                'prenom'=>$_POST['prenom'],
                'adresse'=>$_POST['adresse'],
                'ville'=>$_POST['ville'],
                'CP'=>$_POST['CP']
                ));

                if($client && $compte){
                    header('Location:connexion.php?err=0');
                }

                else
                {
                    header('Location:creation.php?err=1');
                }
            }
        }
    }
} else { echo "erreur";}
