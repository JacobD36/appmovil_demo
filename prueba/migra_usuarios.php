<?php 
	$dbsystem='mysql';
	$host='mysql';
	$dbname1='bdmovil';
	$dbname2='bdmovilv2';
	$dsn1=$dbsystem.':host='.$host.';dbname='.$dbname1;
	$dsn2=$dbsystem.':host='.$host.';dbname='.$dbname2;
	$username='bay';
	$passwd='bayental2019';
	$connection1 = null;
	$connection2 = null;
	define("MAX_LENGTH", 6);
	$params = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
	try {
		$connection1 = new PDO($dsn1, $username, $passwd);
		$connection2 = new PDO($dsn2 ,$username, $passwd);
	} catch (PDOException $pdoException) {
		$connection1 = null;
		echo 'Error al establecer la conexión: '.$pdoException;
		exit;
	}
	
	$stmt = $connection1->prepare("select * from usuario;");
	$stmt->execute();
	$rows = $stmt->fetchAll();
	$idpersona = 1;
	foreach($rows as $rs){
		$dato = explode(" ",$rs['tNombres']);
		$nombre1 = strtoupper(utf8_encode($dato[0]));
		$nombre2 = "";
		if(sizeof($dato)==2){
			$nombre2 = strtoupper(utf8_encode($dato[1]));
		}
		$apellido1 = strtoupper(utf8_encode($rs['tApeMaterno']));
		$apellido2 = strtoupper(utf8_encode($rs['tApePaterno']));
		$tCodigo = $rs['tCodigo'];
		$codusuario = strtolower($rs['tLogin']);
		$pass_origen = $rs['tPassword'];
		$idperfil = $rs['tNivel'];
		$estado = $rs['lEstado'];
		$aEstado = $rs['aEstado'];
		$tUsuario = $rs['tUsuario'];
		$tPassword2 = $rs['tPassword2'];
		$tDni = $rs['tDni'];
		$cod_equipo = $rs['cod_equipo'];
		$tCex = $rs['tCex'];
		$nReporte = $rs['nReporte'];
		$tCampana = $rs['tCampana'];
		$tCanal_area = $rs['tCanal_area'];
		$tGrupo = $rs['tGrupo'];
		$tSupervisor = $rs['tSupervisor'];
		$tNivel_Grupo = $rs['tNivel_Grupo'];
		
		$stmt1 = $connection2->prepare("insert into usuarios(idpersona,tCodigo,codusuario,idperfil,estado,aEstado,tUsuario,tPassword2,tDni,cod_equipo,tCex,nReporte,tCampana,tCanal_area,tGrupo,tSupervisor,tNivel_Grupo) values ('".$idpersona."','".$tCodigo."','".$codusuario."','".$idperfil."','".$estado."','".$aEstado."','".$tUsuario."','".$tPassword2."','".$tDni."','".$cod_equipo."','".$tCex."','".$nReporte."','".$tCampana."','".$tCanal_area."','".$tGrupo."','".$tSupervisor."','".$tNivel_Grupo."');");
		$stmt1->execute();
		$idpersona++;
		$stmt2 = $connection2->prepare("select id from usuarios order by id desc limit 1;");
		$stmt2->execute();
		$rows2 = $stmt2->fetchAll();
		$idusuario = $rows2[0]['id'];
		
		$stmt3 = $connection2->prepare("insert into personas (idusuario,dni,nombre1,nombre2,apellido1,apellido2) values ('".$idusuario."','".$tDni."','".$nombre1."','".$nombre2."','".$apellido1."','".$apellido2."');");
		$stmt3->execute();
		
		$intermediateSalt = md5(uniqid(rand(), true));
		$salt = substr($intermediateSalt, 0, MAX_LENGTH);
		$hash_val = hash("sha256", $pass_origen.$salt);
	
		$stmt4 = $connection2->prepare("insert into login_code (codusuario,hashcode,salt) values ('".$codusuario."','".$hash_val."','".$salt."');");
		$stmt4->execute();
		
		echo "Migrando persona ".$nombre1." ".$nombre2." ".$apellido1." ".$apellido2." de base bdmovil a bdmovilv2, con cod. usuario: ".$codusuario."<br/>";
	}
?>