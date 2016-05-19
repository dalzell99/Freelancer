<?php
require_once("phpmailer/class.phpmailer.php");
require_once("global.php");

function sendErrorEmail($message) {
    sendEmail('dalzell99@hotmail.com', $noReplyEmail, 'HostKeep Error', $message);
}

function sendEmail($to, $from, $subject, $message) {
    $mail = new PHPMailer;

    /*
    $mail->IsSMTP();                                      // Set mailer to use SMTP
    //$mail->SMTPDebug  = 1;
    $mail->Host = "";                 // Specify main and backup server
    $mail->Port = 26;                                    // Set the SMTP port
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = $from;                // SMTP username
    $mail->Password = "";                  // SMTP password
    //$mail->SMTPSecure = "ssl";                            // Enable encryption, 'ssl' also accepted
    */

    $mail->From = 'noreply@hostkeep.com.au';
    $mail->FromName = "HostKeep.com.au";

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
