<?php
require_once "phpmailer/class.phpmailer.php";

function sendErrorEmail($message) {
    sendEmail($webAdminEmail, $noReplyEmail, 'HostKeep Error', $message);
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

    $mail->From = $from;
    $mail->FromName = "HostKeep.com";

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
