<?php

include_once('./class/class-phpmailer.php');
$mail = new PHPMailer(true);

try {
  //Server settings
  $mail->SMTPDebug = 0;                                               //Enable verbose debug output
  $mail->isSMTP();                                                   //Send using SMTP
  $mail->Host       = 'smtp.gmail.com';                     		  //Set the SMTP server to send through
  $mail->SMTPAuth   = true;                                   	 //Enable SMTP authentication
  $mail->Username   = 'hola@waojobs.com';                //SMTP username
  $mail->Password   = 'Wao12345678';                               //SMTP password
  $mail->SMTPSecure = 'tls';      						      //Enable implicit TLS encryption
  $mail->Port       = 587;                           	       
  //Recipients
  $mail->setFrom('hola@waojobs.com', 'waojobs');
  $mail->addAddress('legiy71765@robhung.com');     //Add a recipient             //Name is optional


  //Attachments
  //$mail->addAttachment($file);         //Add attachments
  

  //Content
  $mail->isHTML(true);                                  //Set email format to HTML
  $mail->Subject = '$email_subject';
  $mail->Body    = '$email_text';
  
  $mail->send();
  echo 'Message has been sent';
} catch (Exception $e) {
  echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

?>