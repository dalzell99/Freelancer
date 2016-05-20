<?php
require_once("phpmailer/class.phpmailer.php");
require_once("global.php");

function sendErrorEmail($message) {
    sendEmail('dalzell99@hotmail.com', $noReplyEmail, 'HostKeep Error', $message);
}

function sendEmail($to, $from, $subject, $message) {
    $mail = new PHPMailer;


    $mail->IsSMTP();                                      // Set mailer to use SMTP
    //$mail->SMTPDebug  = 1;
    $mail->Host = "box306.bluehost.com";                 // Specify main and backup server
    $mail->Port = 465;                                    // Set the SMTP port
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = $from;                // SMTP username
    $mail->Password = "@+sP2YgbF%rOE";                  // SMTP password
    $mail->SMTPSecure = "ssl";                            // Enable encryption, 'ssl' also accepted


    $mail->From = $from;
    $mail->FromName = "HostKeep";

    $mail->addAddress($to);

    $mail->isHTML(true);

    $mail->Subject = $subject;
    $mail->Body = $message;

    if(!$mail->send()) {
        return "Mailer Error: " . $mail->ErrorInfo;
    } else {
        return "success";
    }
}

?>
