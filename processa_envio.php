<?php
require './bibliotecas/PHPMailer/Exception.php';
require './bibliotecas/PHPMailer/OAuth.php';
require './bibliotecas/PHPMailer/PHPMailer.php';
require './bibliotecas/PHPMailer/POP3.php';
require './bibliotecas/PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;



class Mensagem{
	private $para=null;
	private $assunto=null;
	private $mensagem=null;
	public $status=['codigo_status'=>null, 'descricao_status'=>""];

	public function __get($atributos){
		return $this->$atributos;
	}
	public function __set($atributos, $valor){
		$this->$atributos= $valor;
	}

	public function ValidaEmail(){
		
		if (empty($this->para) || empty($this->assunto) || empty($this->mensagem)) {
			
			return false;
		}else{
			return true;
		}

	}
}

	$obj= new Mensagem();
	$obj->__set('para', $_POST['para']);
	$obj->__set('assunto', $_POST['assunto']);
	$obj->__set('mensagem', $_POST['mensagem']);
	if(!$obj->ValidaEmail()){
		echo "Mensagem não é valida";
		die();
	}


	$mail = new PHPMailer(true);
	
	try {
		//Server settings
		$mail->SMTPDebug = false;                      //Enable verbose debug output
		$mail->isSMTP();                                            //Send using SMTP
		$mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
		$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
		$mail->Username   = 'infoshac@gmail.com';                     //SMTP username
		$mail->Password   = 'dgiweojhoblryhbw';                               //SMTP password
		$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
		$mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
	
		//Recipients
		$mail->setFrom($obj->__get('para'), 'Shac desenvolvimento');
		$mail->addAddress($obj->__get('para'), 'Shac');     //Add a recipient
		//$mail->addAddress('ellen@example.com');               //Name is optional
		//$mail->addReplyTo('info@example.com', 'Information');
		//$mail->addCC('cc@example.com');
		//$mail->addBCC('bcc@example.com');
	
		//Attachments
		//$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
		//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
	
		//Content
		$mail->isHTML(true);                                  //Set email format to HTML
		$mail->Subject = $obj->__get('assunto');
		$mail->Body    = $obj->__get('mensagem');
		$mail->AltBody = $obj->__get('mensagem');
	
		$mail->send();
		$obj->status["codigo_status"]= 1;
		$obj->status["descricao_status"]= "Enviada encaminhada com exito";
		

		//echo 'Message has been sent';
	} catch (Exception $e) {

		$obj->status["codigo_status"]= 2;
		$obj->status["descricao_status"]= "Não foi possivel enviar este e-mail por favor verifique".$mail->ErrorInfo;
		
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>
<body>
	<div id="container">
	<div class="py-3 text-center">
				<img class="d-block mx-auto mb-2" src="logo.png" alt="" width="72" height="72">
				<h2>Send Mail</h2>
				<?php
					if ($obj->status["codigo_status"]== 1) {
					?>
					<div class="alert alert-success" role="alert">
						<h5>Email encaminhado com sucesso</h5>
						<a href="#" class="btn btn-success" tabindex="-1" role="button" aria-disabled="true">Retornar</a>
					</div>
					<?php	
					}
				?>
			</div>	
	</div>
			
</body>
</html>