<?php 

function phpmailertest($file){
	include_once('class/class-phpmailer.php');
	$mail = new PHPMailer(true);
  
	try {
		//Server settings
		$mail->SMTPDebug = 0;                                               //Enable verbose debug output
		$mail->isSMTP();                                                   //Send using SMTP
		$mail->Host       = 'smtp.gmail.com';                     		  //Set the SMTP server to send through
		$mail->SMTPAuth   = true;                                   	 //Enable SMTP authentication
		$mail->Username   = 'angelprueba2297@gmail.com';                //SMTP username
		$mail->Password   = 'Leo123456';                               //SMTP password
		$mail->SMTPSecure = 'tls';      						      //Enable implicit TLS encryption
		$mail->Port       = 587;                           	       
		//Recipients
		$mail->setFrom('angelprueba2297@gmail.com', 'angel');
		$mail->addAddress('angelprueba2297@gmail.com');     //Add a recipient             //Name is optional
	
	
		//Attachments
		$mail->addAttachment($file);         //Add attachments
		
	
		//Content
		$mail->isHTML(true);                                  //Set email format to HTML
		$mail->Subject = 'Tu empleo Wao';
		$mail->Body    = 'Desde aqui puedes descargar las imagenes Wao de tu oferta de trabajo';
		$mail->AltBody = 'Desde aqui puedes descargar las imagenes Wao de tu oferta de trabajo';
	
		$mail->send();
		echo 'Message has been sent';
	} catch (Exception $e) {
		echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}
  }
  


class Archivo {
	public function subeimagen64temp($img, $nombre) {

		if (!is_dir('imagenes_post/')) {
			mkdir('imagenes_post/', 0777, true);
		}

		//$img.= date('His') . rand(100);
		$carpetaDestino = "imagenes_post/";
		$img = str_replace('data:image/png;base64,', '', $img);
		$img = str_replace(' ', '+', $img);
		$data = base64_decode($img);
		$file = $carpetaDestino . $nombre . '.png';
		$success = file_put_contents($file, $data);
		phpmailertest($file);
		unlink($file);
		return $success;
	}

	public function printImg($img, $nombre) {

		if (!is_dir('imagenes_post/')) {
			mkdir('imagenes_post/', 0777, true);
		}

		//$img.= date('His') . rand(100);
		$carpetaDestino = "imagenes_post/";
		$img = str_replace('data:image/png;base64,', '', $img);
		$img = str_replace(' ', '+', $img);
		$data = base64_decode($img);
		$file = $carpetaDestino . $nombre . '.png';
		$success = file_put_contents($file, $data);
		phpmailertest($file);
		//unlink($file);
		return $file;
	}

}

if (isset($_POST['print'])) {
	$img = $_POST['img'];
	$nombre= $_POST['nombre'];
	$Archivo = new Archivo();
	echo $Archivo->printImg($img, $nombre);
}else{
	$img = $_POST['img'];
	$nombre= $_POST['nombre'] . date('His') . rand(100);

	$Archivo = new Archivo();

	echo $Archivo->subeimagen64temp($img, $nombre);
}

?>