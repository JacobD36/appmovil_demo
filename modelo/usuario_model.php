<?php
class usuario_model{
    private $db;
    private $db_1;

    public function __construct(){
        $this->db=database::conexion();
        $this->db_1=database::conexion_1();
    }

    public function valida_acceso($user,$pass){
        $busqueda = array();
        $valor_hash=$this->get_hash($user);
        if($valor_hash!=null) {
            $hash_x = hash('sha256',$pass.$valor_hash[0]['salt']);
            if ($valor_hash[0]['hashcode'] == $hash_x) {
                try{
                    $stmt = $this->db->prepare("select * from usuarios where codusuario='".$user."' and estado=1 limit 1;");
                    $stmt->execute();
                    $rows = $stmt->fetchAll();
                    foreach($rows as $rs){
                        $busqueda[] = $rs;
                    }
                    unset($stmt);
                    return $busqueda;
                }catch(PDOException $e){
                    print "Error!: " . $e->getMessage() . "<br/>";
                    die();
                }
            } else {
                return "";
            }
        } else {
            return "";
        }
    }

    public function get_hash($codusuario) {
        $busqueda = array();
        try{
            $stmt = $this->db->prepare("select hashcode,salt from login_code where codusuario='".$codusuario."' limit 1;");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            foreach($rows as $rs){
                $busqueda[] = $rs;
            }
            unset($stmt);
        }catch(PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
        return $busqueda;
    }

    public function get_all_personas(){
        try{
            $stmt = $this->db->prepare("SELECT u.id,u.tCodigo,CONCAT(p.nombre1,' ',p.nombre2) AS nombre,p.apellido1,p.apellido2,u.codusuario,(SELECT descripcion FROM perfiles WHERE id=u.idperfil) AS nivel,u.cod_equipo,u.estado FROM usuarios u,personas p WHERE u.id=p.idusuario;");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            unset($stmt);
            return $rows;
        }catch(PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function get_edit_persona($id){
        try{
            $stmt = $this->db->prepare("SELECT u.id,u.tCodigo,p.nombre1,p.nombre2,p.apellido1,p.apellido2,u.codusuario,idperfil,u.tCex,u.tCorreo,u.cod_equipo,u.estado,u.aEstado,u.fFecha,tDni,u.nReporte FROM usuarios u,personas p WHERE u.id=p.idusuario AND u.id='".$id."';");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            unset($stmt);
            return $rows;
        }catch(PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function get_personal_info($idusuario){
        try{
            $stmt = $this->db->prepare("select * from personas where idusuario='".$idusuario."' order by id desc limit 1;");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            unset($stmt);
            return $rows;
        }catch(PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function get_user_info($idusuario){
        try {
            $stmt = $this->db->prepare("select * from usuarios where id='".$idusuario."' order by id desc limit 1;");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            unset($stmt);
            return $rows;
        }catch(PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function get_perfiles(){
        try{
            $stmt = $this->db->prepare("select * from perfiles where estado=1;");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            unset($stmt);
            return $rows;
        }catch(PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function get_rate_info($codusuario){
        try{
            $usr = strtoupper($codusuario);
            $stmt = $this->db_1->prepare("SELECT COUNT(*) AS Q1,IFNULL(SUM(IF(ifnull(tResultado,'') not in ('','TRAMITE REGULAR'),1,0)),0) as Q2 FROM bdmovil.consulta_dni  where date(ffechaGrabacion) = date(now()) and tusuario = '".$usr."'  and ifnull(tDni,'') not in ('');");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            unset($stmt);
            return $rows;
        }catch(PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function get_tbl_datos_info($codusuario){
        try{
            $stmt = $this->db_1->prepare("SELECT COUNT(*) AS Q3 from bdmovil.tbl_datos where date(fec_reg) = date(now()) and usuario = '".$codusuario."';");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            unset($stmt);
            return $rows;
        }catch(PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function get_combo_elem_1(){
        try{
            $stmt = $this->db_1->prepare("select id_zona,descripcion from bdmovil.tbl_zona where estado='1';");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            unset($stmt);
            return $rows;
        }catch(PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function get_lista1($codusuario){
        try{
            $stmt = $this->db_1->prepare("SELECT tDni,fFechaGrabacion,if(tcampana ='1','SI','NO') AS tipo  FROM bdmovil.consulta_dni where   tUsuario = '".$codusuario."' and date(ffechaGrabacion) = date(now()) and ifnull(tDni,'') not in ('');");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            unset($stmt);
            return $rows;
        }catch(PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function get_lista2($codusuario){
        try{
            $stmt = $this->db_1->prepare("SELECT tDni,fFechaGrabacion,if(tcampana ='1','SI','NO') AS tipo  FROM bdmovil.consulta_dni where   tUsuario = '".$codusuario."' and date(ffechaGrabacion) = date(now()) and ifnull(tDni,'') not in ('') and tCampana = '1';");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            unset($stmt);
            return $rows;
        }catch(PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function existe_user($codusuario){
        try {
            $stmt = $this->db->prepare("select * from bdmovilv2.usuarios where codusuario='".$codusuario."';");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            unset($stmt);
            if($rows!=null){
                return true;
            } else {
                return false;
            }
        }catch(PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function set_new_user($codigo,$nombre1,$nombre2,$apellido1,$apellido2,$correo,$dni,$cex,$password1,$equipo,$nivel,$estado_l,$estado,$fecha,$nReporte){
        $codusuario = substr($nombre1,0,1);
        $ape1 = $apellido1;
        $apellido1 = str_replace("Ñ","N",$apellido1);
        $first_c = substr($apellido2,0,1);
        $codusuario.=$apellido1;
        if($this->existe_user($codusuario)==true){$codusuario.=$first_c;}
        if ($this->existe_user($codusuario)==false) {
            try {
                $codusuario = strtolower($codusuario);
                $stmt = $this->db->prepare("select id from bdmovilv2.personas order by id desc limit 1;");
                $stmt->execute();
                $rows = $stmt->fetchAll();
                $stmt1 = $this->db->prepare("insert into bdmovilv2.usuarios (idpersona,tCodigo,codusuario,idperfil,estado,aEstado,tUsuario,tPassword2,tDni,cod_equipo,tCex,fFecha,tCorreo,nReporte) values ('".$rows[0]['id']."','".$codigo."','".$codusuario."','".$nivel."','".$estado_l."','".$estado."','".strtoupper($codusuario)."','','".$dni."','".$equipo."','".$cex."','".$fecha."','".$correo."','".$nReporte."');"); 
                $stmt1->execute();
                $stmt2 = $this->db->prepare("select id from bdmovilv2.usuarios where codusuario='".$codusuario."' order by id desc limit 1;");
                $stmt2->execute();
                $rows2 = $stmt2->fetchAll();
                $stmt3 = $this->db->prepare("insert into bdmovilv2.personas (idusuario,dni,nombre1,nombre2,apellido1,apellido2) values ('".$rows2[0]['id']."','".$dni."','".$nombre1."','".$nombre2."','".$ape1."','".$apellido2."');");
                $stmt3->execute();
                $stmt4 = $this->db_1->prepare("");
                $this->genera_hash($codusuario,$password1);
                unset($stmt);
                unset($stmt1);
                unset($sttm2);
                unset($stmt3);
                return $codusuario;
            } catch (PDOException $e) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
        } else {
            return "existe";
        }
    }

    public function genera_hash($codusuario,$password){
        try{
            $pass_salt = $this->generateHashWithSalt($password);
            $pass_salt_val = explode("|",$pass_salt);
            $hash = $pass_salt_val[0];
            $salt = $pass_salt_val[1];
            $stmt = $this->db->prepare("insert into bdmovilv2.login_code (codusuario,hashcode,salt) values ('".$codusuario."','".$hash."','".$salt."');");
            $stmt->execute();
            unset($stmt);
        }catch(PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function actualiza_password($codusuario,$password){
        try{
            $pass_salt = $this->generateHashWithSalt($password);
            $pass_salt_val = explode("|",$pass_salt);
            $hash = $pass_salt_val[0];
            $salt = $pass_salt_val[1];
            $stmt = $this->db->prepare("update login_code set hashcode='".$hash."',salt='".$salt."' where codusuario='".$codusuario."';");
            $stmt->execute();
            unset($stmt);
        } catch(PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function actualiza_persona($id,$nombre1,$nombre2,$apellido1,$apellido2,$correo,$dni,$cex,$equipo,$nivel,$estado_l,$estado,$nReporte){
        try{
            $stmt = $this->db->prepare("update bdmovilv2.usuarios set idperfil='".$nivel."',estado='".$estado_l."',aEstado='".$estado."',tDni='".$dni."',cod_equipo='".$equipo."',tCex='".$cex."',tCorreo='".$correo."',nReporte='".$nReporte."' where id='".$id."';");
            $stmt->execute();
            $stmt1 = $this->db->prepare("update bdmovilv2.personas set dni='".$dni."',nombre1='".$nombre1."',nombre2='".$nombre2."',apellido1='".$apellido1."',apellido2='".$apellido2."' where idusuario='".$id."';");
            $stmt1->execute();
            unset($stmt);
            unset($stmt1);
        }catch(PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function get_new_code(){
        try{
            $stmt = $this->db->prepare("select max(tCodigo) as maximo from bdmovilv2.usuarios");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            $tCodigo = $rows[0]['maximo']+1;
            $tCodigo = str_pad($tCodigo,4,"0000",STR_PAD_LEFT);
            unset($stmt);
            return $tCodigo;
        }catch(PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    function generateHashWithSalt($password) {
        define("MAX_LENGTH", 6);
        $intermediateSalt = md5(uniqid(rand(), true));
        $salt = substr($intermediateSalt, 0, MAX_LENGTH);
        return hash("sha256", $password . $salt)."|".$salt;
    }

    function getRealIP(){
        if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
            $client_ip = (!empty($_SERVER['REMOTE_ADDR']))?$_SERVER['REMOTE_ADDR']:(( !empty($_ENV['REMOTE_ADDR']))?$_ENV['REMOTE_ADDR']:"unknown");
            $entries = split('[, ]', $_SERVER['HTTP_X_FORWARDED_FOR']);
            reset($entries);
            while (list(, $entry) = each($entries)){
                $entry = trim($entry);
                if (preg_match("/^([0-9]+\.[0-9]+\.[0-9]+\.[0-9]+)/", $entry, $ip_list)){
                    // http://www.faqs.org/rfcs/rfc1918.html
                    $private_ip = array(
                        '/^0\./',
                        '/^127\.0\.0\.1/',
                        '/^192\.168\..*/',
                        '/^172\.((1[6-9])|(2[0-9])|(3[0-1]))\..*/',
                        '/^10\..*/');
                    $found_ip = preg_replace($private_ip, $client_ip, $ip_list[1]);
                    if ($client_ip != $found_ip){
                        $client_ip = $found_ip;
                        break;
                    }
                }
            }
        } else {
            $client_ip = (!empty($_SERVER['REMOTE_ADDR']))?$_SERVER['REMOTE_ADDR']:((!empty($_ENV['REMOTE_ADDR']))?$_ENV['REMOTE_ADDR']:"unknown" );
        }
        return $client_ip;
    }

    public function registra_actividad($usuario,$ip,$motivo,$fecha,$hora){
        try{
            $stmt = $this->db->prepare("insert into bdmovilv2.actividad (idusuario,ip,idmotivo,fecha,hora) values ('".$usuario."','".$ip."','".$motivo."','".$fecha."','".$hora."');");
            $stmt->execute();
            unset($stmt);
        }catch(PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function registra_ubicacion($id,$latitud,$longitud,$tipo,$fecha,$hora){
        try{
            $stmt = $this->db->prepare("insert into bdmovilv2.ubicacion (idusuario,latitud,longitud,tipo,fecha,hora) values ('".$id."','".$latitud."','".$longitud."','".$tipo."','".$fecha."','".$hora."');");
            $stmt->execute();
            unset($stmt);
            unset($stmt1);
        }catch(PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function cambia_estado_login($id,$estado){
        try{
            $stmt = $this->db->prepare("update bdmovilv2.usuarios set login_state='".$estado."' where id='".$id."';");
            $stmt->execute();
            unset($stmt);
        }catch(PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function esta_logueado($id){
        $resultado = 0;
        try{
            $stmt = $this->db->prepare("select bdmovilv2.login_state from usuarios where id='".$id."' order by id desc limit 1;");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            if($rows[0]['login_state']==1){
                $resultado = 1;
            }
            return $resultado;
        }catch(PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function get_all_regs($user,$f1,$f2){
        try{
            $stmt = "";
            $user = strtoupper($user);
            if ($f1=="" && $f2=="") {
                //$stmt = $this->db_1->prepare("SELECT DATE_FORMAT(fFechaGrabacion,'%d/%m/%Y') AS FECHA,count(*)  as CONSULTA,SUM(if(tCampana='1',1,0)) AS 'EFECTIVOS' FROM bdmovil.consulta_dni where tUsuario = '".$user."' and ifnull(tDni,'') not in ('') group by DATE(ffechaGrabacion);");
                $stmt = $this->db_1->prepare("SELECT DATE_FORMAT(fFechaGrabacion,'%d/%m/%Y') AS FECHA,count(*)  as CONSULTA, SUM(if(ifnull(tResultado,'') not in ('','TRAMITE REGULAR'),1,0)) AS 'EFECTIVOS' FROM bdmovil.consulta_dni where tUsuario = '".$user."' and ifnull(tDni,'') not in ('') group by DATE(ffechaGrabacion);");
                //$this->guarda_log("SELECT DATE_FORMAT(fFechaGrabacion,'%d/%m/%Y') AS FECHA,count(*)  as CONSULTA, SUM(if(ifnull(tResultado,'') not in ('','TRAMITE REGULAR'),1,0)) AS 'EFECTIVOS' FROM bdmovil.consulta_dni where tUsuario = '".$user."' and ifnull(tDni,'') not in ('') group by DATE(ffechaGrabacion);");
            }
            if($f1!="" && $f2==""){
                //$stmt = $this->db_1->prepare("SELECT DATE_FORMAT(fFechaGrabacion,'%d/%m/%Y') AS FECHA,count(*)  as CONSULTA,SUM(if(tCampana='1',1,0)) AS 'EFECTIVOS' FROM bdmovil.consulta_dni where tUsuario = '".$user."' and date(fFechaGrabacion)>='".$f1."' and ifnull(tDni,'') not in ('') group by DATE(ffechaGrabacion);");
                $stmt = $this->db_1->prepare("SELECT DATE_FORMAT(fFechaGrabacion,'%d/%m/%Y') AS FECHA,count(*)  as CONSULTA, SUM(if(ifnull(tResultado,'') not in ('','TRAMITE REGULAR'),1,0)) AS 'EFECTIVOS' FROM bdmovil.consulta_dni where tUsuario = '".$user."' and date(fFechaGrabacion)>='".$f1."' and ifnull(tDni,'') not in ('') group by DATE(ffechaGrabacion);");
                //$this->guarda_log("SELECT DATE_FORMAT(fFechaGrabacion,'%d/%m/%Y') AS FECHA,count(*)  as CONSULTA, SUM(if(ifnull(tResultado,'') not in ('','TRAMITE REGULAR'),1,0)) AS 'EFECTIVOS' FROM bdmovil.consulta_dni where tUsuario = '".$user."' and date(fFechaGrabacion)>='".$f1."' and ifnull(tDni,'') not in ('') group by DATE(ffechaGrabacion);");
            }
            if($f1=="" && $f2!=""){
                //$stmt = $this->db_1->prepare("SELECT DATE_FORMAT(fFechaGrabacion,'%d/%m/%Y') AS FECHA,count(*)  as CONSULTA,SUM(if(tCampana='1',1,0)) AS 'EFECTIVOS' FROM bdmovil.consulta_dni where tUsuario = '".$user."' and ifnull(tDni,'') not in ('') group by DATE(ffechaGrabacion);");
                $stmt = $this->db_1->prepare("SELECT DATE_FORMAT(fFechaGrabacion,'%d/%m/%Y') AS FECHA,count(*)  as CONSULTA, SUM(if(ifnull(tResultado,'') not in ('','TRAMITE REGULAR'),1,0)) AS 'EFECTIVOS' FROM bdmovil.consulta_dni where tUsuario = '".$user."' and ifnull(tDni,'') not in ('') group by DATE(ffechaGrabacion);");
                //$this->guarda_log("SELECT DATE_FORMAT(fFechaGrabacion,'%d/%m/%Y') AS FECHA,count(*)  as CONSULTA, SUM(if(ifnull(tResultado,'') not in ('','TRAMITE REGULAR'),1,0)) AS 'EFECTIVOS' FROM bdmovil.consulta_dni where tUsuario = '".$user."' and ifnull(tDni,'') not in ('') group by DATE(ffechaGrabacion);");
            }
            if($f1!="" && $f2!=""){
                //$stmt = $this->db_1->prepare("SELECT DATE_FORMAT(fFechaGrabacion,'%d/%m/%Y') AS FECHA,count(*)  as CONSULTA,SUM(if(tCampana='1',1,0)) AS 'EFECTIVOS' FROM bdmovil.consulta_dni where tUsuario = '".$user."' and ifnull(tDni,'') not in ('') and date(fFechaGrabacion) between '".$f1."' and '".$f2."' group by DATE(ffechaGrabacion);");
                $stmt = $this->db_1->prepare("SELECT DATE_FORMAT(fFechaGrabacion,'%d/%m/%Y') AS FECHA,count(*)  as CONSULTA, SUM(if(ifnull(tResultado,'') not in ('','TRAMITE REGULAR'),1,0)) AS 'EFECTIVOS' FROM bdmovil.consulta_dni where tUsuario = '".$user."' and ifnull(tDni,'') not in ('') and date(fFechaGrabacion) between '".$f1."' and '".$f2."' group by DATE(ffechaGrabacion);");
                //$this->guarda_log("SELECT DATE_FORMAT(fFechaGrabacion,'%d/%m/%Y') AS FECHA,count(*)  as CONSULTA, SUM(if(ifnull(tResultado,'') not in ('','TRAMITE REGULAR'),1,0)) AS 'EFECTIVOS' FROM bdmovil.consulta_dni where tUsuario = '".$user."' and ifnull(tDni,'') not in ('') and date(fFechaGrabacion) between '".$f1."' and '".$f2."' group by DATE(ffechaGrabacion);");
            }
            $stmt->execute();
            $rows = $stmt->fetchAll();
            unset($stmt);
            return $rows;
        }catch(PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function get_geo_data($id,$f1,$f2){
        try{
            $stmt = "";
            $sql1 = "";
            if($id!=""){$sql1=" and idusuario='".$id."' ";}
            if($f1=="" && $f2==""){
                $stmt = $this->prepare("select * from bdmovilv2.ubicacion where fecha is not null".$sql1."order by id asc;");
            }
            if($f1!="" && $f2==""){
                $stmt = $this->db->prepare("select * from bdmovilv2.ubicacion where fecha>='".$f1."'".$sql1."order by id asc;");
            }
            if($f1=="" && $f2!=""){
                $stmt = $this->db->prepare("select * from bdmovilv2.ubicacion where fecha is not null".$sql1."order by id asc;");
            }
            if($f1!="" && $f2!=""){
                $stmt = $this->db->prepare("select * from bdmovilv2.ubicacion where fecha between '".$f1."' and '".$f2."'".$sql1."order by id asc;");
            }
            $stmt->execute();
            $rows = $stmt->fetchAll();
            unset($stmt);
            return $rows;
        }catch(PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function get_res_values(){
        try{
            $stmt = $this->db_1->prepare("select 'TODO' as tTipo UNION ALL SELECT 'VENTA' UNION ALL SELECT 'SEGUIMIENTO' UNION ALL SELECT 'NO DESEA' UNION ALL SELECT 'TRAMITE REGULAR';");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            unset($stmt);
            return $rows;
        }catch(PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function get_abord_values(){
        try{
            //$stmt = $this->db_1->prepare("SELECT tLogin from bdmovil.usuario where lEstado = 1 and nReporte=1 and cod_equipo = 'BAY' order by tLogin;");
            $stmt = $this->db->prepare("SELECT codusuario from bdmovilv2.usuarios where estado = 1 and nReporte=1 and cod_equipo = 'BAY' order by codusuario;");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            unset($stmt);
            return $rows;
        }catch(PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function set_abordamiento($usuario,$zona){
        try{
            $stmt = $this->db_1->prepare("insert into bdmovil.tbl_datos(usuario,dni,estado,fec_reg,tZona) values ('".$usuario."','','NO',now(),'".$zona."');");
            $stmt->execute();
            $stmt1 = $this->db_1->prepare("SELECT COUNT(*) AS Q3 from bdmovil.tbl_datos where date(fec_reg) = date(now()) and usuario = '".$usuario."';");
            $stmt1->execute();
            $row = $stmt1->fetchAll();
            unset($stmt);
            unset($stmt1);
            return $row[0]['Q3'];
        }catch(PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function guarda_log($dato){
        $fp = fopen("../logs/querys.txt", "a");
        fputs($fp, $dato."\r\n");
        fclose($fp);
    }
}
?>