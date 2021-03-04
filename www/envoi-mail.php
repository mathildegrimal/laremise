<?php
        $mel = $_POST['email'];

        $sujet = $_POST['subject'];

        $message = $_POST['message'];
        $destinataire = "noobdev34@gmail.com";


        $headers = "From: \"Bot Noob Dev\"<mon.mail@mail.fr>\n";
        $headers .= "Reply-To: no-reply@noreply.com\n";
        $headers .= "Content-Type: text/html; charset=\"utf-8\"";

        $mailing=mail($destinataire,$sujet,$message,$headers);
        if($mailing)
                header("Location:index.html");
        else
                echo "erreur d'envoi de l'email";

?>
