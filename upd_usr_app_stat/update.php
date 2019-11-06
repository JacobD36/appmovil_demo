<?php
	require_once("PHPMailer/PHPMailerAutoload.php");
	date_default_timezone_set("America/Lima");
	$hoy = date("Y-m-d");
	$dbsystem='mysql';
	$host='10.22.8.238';
	$dbname='bdmovilv2';
	$dsn=$dbsystem.':host='.$host.';dbname='.$dbname;
	$username='root';
	$passwd='bay9856';
	$connection = null;
	$params = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
	try {
		$connection = new PDO($dsn, $username, $passwd, $params);
	} catch (PDOException $pdoException) {
		$connection = null;
		echo 'Error al establecer la conexión: '.$pdoException;
		exit;
	}
	
	$mail = new PHPMailer();
	$mail->isSMTP();
	$mail->Host = '173.201.192.229';
	$mail->Port = 25;
	$mail->SMTPDebug  = 2;
	$mail->SMTPAuth = true;
	$mail->Username = 'bayental.reporting09@bayental.net';
	$mail->Password = '.rb*2016';
	$mail->From = 'webmaster@bpu.com.pe';
	$mail->FromName = "Webmaster BPU";
	$mail->addAddress('francisco.cuyubamba@bayental.com','Francisco Cuyubamba');
	$mensaje = utf8_decode("Se han desactivado los siguientes usuarios: <br/><br/>");
	$asunto = utf8_decode("Actualización de estado de usuarios AppMovil");
	
	$stmt = $connection->prepare("SELECT DISTINCT(idusuario) FROM bdmovilv2.actividad;");
	$stmt->execute();
	$rows = $stmt->fetchAll();
	
	$usuarios = "";
	$resultado = 0;
	
	foreach($rows as $rs){
		$resultado = "";
		$stmt1 = $connection->prepare("SELECT * FROM bdmovilv2.actividad WHERE idusuario='".$rs['idusuario']."' ORDER BY id DESC LIMIT 1;");
		$stmt1->execute();
		$row = $stmt1->fetchAll();
		$datetime1 = new DateTime(strftime('%Y-%m-%d',strtotime(date($row[0]['fecha']))));
		$datetime2 = new DateTime(strftime('%Y-%m-%d',strtotime(date('Y-m-d'))));
		$interval = $datetime1->diff($datetime2);
		$d = $interval->format('%a');
		if($d>15){
			$stmt2 = $connection->prepare("SELECT * FROM bdmovilv2.usuarios WHERE id='".$rs['idusuario']."' AND idperfil=3 AND estado=1;");
			$stmt2->execute();
			$row2 = $stmt2->fetchAll();
			if($row2!=null){
				$resultado = 1;
				$stmt3 = $connection->prepare("UPDATE bdmovilv2.usuarios SET estado=0 WHERE id='".$rs['idusuario']."';");
				$stmt3->execute();
				$usuarios.="- ".strtoupper($row2[0]['codusuario'])."<br/>";
			}
		}
	}
	
	$mensaje.=$usuarios."<br/>Saludos.";
	
	$mail->addAttachment($mensaje);
	$mail->isHTML(true);
	$mail->Subject = ''.$asunto;
	$mail->Body = $mensaje;
	if($resultado==1){
		$mail->send();
	}
?>