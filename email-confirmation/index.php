

<?php 

function phpmailertest($email, $param, $name){
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
		$mail->addAddress($email);     //Add a recipient             //Name is optional
	
	
		//Attachments
		//$mail->addAttachment($file);         //Add attachments
		
	
		//Content
		$mail->isHTML(true);                                  //Set email format to HTML
		$mail->Subject = 'Activa tu cuenta.';
		//$mail->Body    = "This is the HTML message body <a> https://www.google.com/ </a>";
        $email_template = './email-confirmation/email_confirmation_template.php';
		$tag_a = '<a href="http://104.207.146.163:8000/email_confirmed.php?code=' . $_SESSION['confirmation_code'] . $param . '">Clic aqui para confirmar tu correo.</a>'; 
		
        $message = file_get_contents($email_template);
        $message = str_replace('%tag-a-%', $tag_a, $message);
		$message = str_replace('%username%', $name, $message);
        $mail->MsgHTML($message);
	
		$mail->send();
		//echo 'Message has been sent';
	} catch (Exception $e) {
		//echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}
  }

  
  
