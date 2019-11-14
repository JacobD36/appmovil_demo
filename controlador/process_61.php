<?php 
    require_once("../configuracion/database.php");
    require_once("../modelo/usuario_model.php");
    $qwerty = new usuario_model();
    $tipo_reporte = '2';
    $fecha1 = $_GET["fecha1"];
    $fecha2 = $_GET["fecha2"];
    $usuario = $_GET["usuario"];

    if ($fecha2!=""){
        $sqlFecha ="   between '".$fecha1."' and '".$fecha2."' ";
    } else{
        $sqlFecha ="   = '".$fecha1."' ";
    }

    if($fecha1 == ""){
        $sqlFecha ="  =date(now()) ";
    }

    if($usuario=="0")
        $sqlUsuario="";
    else
        $sqlUsuario=" and consulta_dni.tUsuario in ('".$usuario."')";

    if ($usuario=="") {
        $sqlUsuario="";
    } else {
        $sqlUsuario=" and consulta_dni.tUsuario in ('".$usuario."')";
    }

    if ($tipo_reporte=='2') {
        $sql = database::conexion_1()->prepare("SELECT consulta_dni.tUsuario,bdmovilv2.usuarios.medio_tiempo,
    count(*)  as 'Q',
    sum(if(ifnull(tResultado,'') not in ('','TRAMITE REGULAR')  ,1,0)) as 'Q2' ,
    sum(if(ifnull(tResultado,'') not in ('','TRAMITE REGULAR') and tResultado = 'VENTA' ,1,0)) as 'Q4' ,
    sum(if(ifnull(tResultado,'') not in ('','TRAMITE REGULAR') and tResultado = 'SEGUIMIENTO',1,0)) as 'Q5' ,
    sum(if(ifnull(tResultado,'') not in ('','TRAMITE REGULAR') and tResultado = 'NO DESEA',1,0)) as 'Q6',
    concat(ifnull(round((sum(if(ifnull(tResultado,'') not in ('','TRAMITE REGULAR') and tResultado = 'VENTA' ,1,0)) * 100)/sum(if(ifnull(tResultado,'') not in ('','TRAMITE REGULAR'),1,0)),2),'0.00'),'%') as 'Q7',
    concat(ifnull(round((sum(if(ifnull(tResultado,'') not in ('','TRAMITE REGULAR')  ,1,0)) * 100)/count(*),2),'0.00'),'%') as 'Q3'
     FROM bdmovil.consulta_dni as consulta_dni, bdmovilv2.usuarios
    where usuarios.codusuario = consulta_dni.tUsuario
     and nReporte=1 and ifnull(consulta_dni.tDni,'') not in ('')
    and   date(ffechaGrabacion) $sqlFecha $sqlUsuario
    group by consulta_dni.tUsuario;");
        $sql->execute();
        $rows = $sql->fetchAll();

        if ($rows!=null) {
            foreach ($rows as $data) {
                if ($data[3]>= 25) {
                    $img="<img src='./vista/img/verde3.png'/>";
                } elseif ($data[3] >= 20) {
                    $img="<img src='./vista/img/amarillo3.png'/>";
                } else {
                    $img="<img src='./vista/img/rojo3.png'/>";
                }

                if ($data[4]>= 3) {
                    $img2="<img src='./vista/img/verde3.png'/>";
                } elseif ($data[4] >= 2) {
                    $img2="<img src='./vista/img/amarillo3.png'/>";
                } else {
                    $img2="<img src='./vista/img/rojo3.png'/>";
                }

                $arreglo["data"][] = array($data['tUsuario'],$data['medio_tiempo'],$data['Q'],$data['Q2'],$data['Q4'],$data['Q5'],$data['Q6'],$data['Q7'],$data['Q3']);
            }
        } else {
            $arreglo["data"][] = array('SIN REGISTROS','','','','','','','','');
        }
        echo json_encode($arreglo);
    }

    /*if($tipo_reporte=='1'){
                $sql = database::conexion_1()->prepare("select upper(tabgeneral.tUsuario) AS AGENTE,
                IFNULL((select IF(lEstado=1,'ACTIVO','CESADO') from bayental.usuario where tProyecto ='000002' and tLogin = tabgeneral.tusuario limit 1),'CESADO') AS ESTADO,
                CONCAT(ROUND(IFNULL((select DATEDIFF(DATE(NOW()),CONCAT(MID(tIngreso,7,4),'-',MID(tIngreso,4,2),'-',MID(tIngreso,1,2))) from bayental.usuario where tProyecto ='000002' and tLogin = tabgeneral.tusuario limit 1),0)/30,0),'') as ANTIGUEDAD,
                IFNULL((select tTurno from bayental.usuario where tProyecto ='000002' and tLogin = tabgeneral.tusuario limit 1),'') AS TURNO,
                IFNULL((select nivel from bayental.usuario where tProyecto ='000002' and tLogin = tabgeneral.tusuario limit 1),'-') AS RANGO,
                sum(if(tResultado2 in ('01','37'),1,0))   as VENTA,
                sum(if(tResultado2 in ('01','04','08','27','01','37','53','56','55','54','50','52','51','57','58'),1,0)) as 'CET',
                CONCAT(IFNULL(ROUND(((sum(if(tResultado2 in ('01','04','08','27','01','37','53','56','55','54','50','52','51','57','58'),1,0)) * 100) / sum(if(tResultado2 in ('01','37','04','06','07','08','09','11','12','13','16','18','27','30','35','36','53','56','55','54','50','52','51','57','58','60'),1,0))),2),'0.00'),'%') as '%CET',
                CONCAT(IFNULL(ROUND(((sum(if(tResultado2 in ('01','37'),1,0)) * 100) / sum(if(tResultado2 in ('01','04','08','27','01','37','53','56','55','54','50','52','51','57','58'),1,0))),2),'0.00'),'%') as '%CIERRE',
                0 as CARGADA,
                sum(if(tResultado2 not in ('00'),1,0)) as GESTIONADOS,
                0 as PENDIENTES
                from   scotiabank.tabgeneral join scotiabank.bases
                on  scotiabank.tabgeneral.tBase = bases.tCodigo
                where
                tResultado2 not in ('00') and bases.lEstado=1
                and if(tResultado2 in ('01','37'),date(fFechaGrabacion),date(fVigencia)) $sqlFecha    group by AGENTE order by ROUND(sum(if(tResultado2 in ('01','37'),1,0)),0) DESC;");
        $sql->execute();
        $rows = $sql->fetchAll();

        foreach($rows as $data){
            if($data[8]>= 25)
            $img="<img src='./vista/img/verde3.png'/>";
            else if ($data[8] >= 20)
            $img="<img src='./vista/img/amarillo3.png'/>";
            else
            $img="<img src='./vista/img/rojo3.png'/>";

            if($data[9]>= 3)
            $img2="<img src='./vista/img/verde3.png'/>";
            else if ($data[9] >= 2)
            $img2="<img src='./vista/img/amarillo3.png'/>";
            else
            $img2="<img src='./vista/img/rojo3.png'/>";

            $venta="".$data[5]."";
            $cet="".$data[6]."";
            $cetpor="<div align=right>".$data[7]." ".$img."&nbsp;&nbsp;&nbsp;</div>";
            $cierrepor="<div align=right>".$data[8]." ".$img2."&nbsp;&nbsp;&nbsp;</div>";

            $tot="".$data[9]."";
            $ges="".$data[10]."";
            $pend="".$data[11]."";
            if($data[2]== 1)
            $antiguedad=$data[2]." Mes";
            else
            $antiguedad=$data[2]." Meses";

		    $arreglo["data"][] = array ($i,$data['tUsuario'],$data['Q'],$antiguedad,utf8_encode($data[3]),$data[4],$venta,$cet,$cetpor,$cierrepor,$tot,$ges,$pend);
        }
        echo json_encode($arreglo);
    }*/

    if($tipo_reporte=='3'){
        $sql = database::conexion_1()->prepare("select hour(if(tResultado2 in ('01','37'),fFechaGrabacion,fVigencia)) AS HORA,
        sum(if(tResultado2 in ('01','37'),1,0))   as VENTA,
        sum(if(tResultado2 in ('01','04','08','27','01','37','53','56','55','54','50','52','51','57','58'),1,0)) as 'CET',
        CONCAT(IFNULL(ROUND(((sum(if(tResultado2 in ('01','04','08','27','01','37','53','56','55','54','50','52','51','57','58'),1,0)) * 100) / sum(if(tResultado2 in ('01','37','04','06','07','08','09','11','12','13','16','18','27','30','35','36','53','56','55','54','50','52','51','57','58','60'),1,0))),2),'0.00'),'%') as '%CET',
        CONCAT(IFNULL(ROUND(((sum(if(tResultado2 in ('01','37'),1,0)) * 100) / sum(if(tResultado2 in ('01','04','08','27','01','37','53','56','55','54','50','52','51','57','58'),1,0))),2),'0.00'),'%') as '%CIERRE',
        
        0 as CARGADA,
        sum(if(tResultado2 not in ('00'),1,0)) as GESTIONADOS,
        0 as PENDIENTES
        
        from   scotiabank.tabgeneral join scotiabank.bases
        on  scotiabank.tabgeneral.tBase = bases.tCodigo
        where
        tResultado2 not in ('00') and bases.lEstado=1
        and if(tResultado2 in ('01','37'),date(fFechaGrabacion),date(fVigencia)) $sqlFecha    group by HORA order by ROUND(HORA,0);");
        $sql->execute();
        $rows = $sql->fetchAll();

        foreach($rows as $data){
            if($data[3]>= 25)
            $img="<img src='./vista/img/verde3.png'/>";
            else if ($data[3] >= 20)
            $img="<img src='./vista/img/amarillo3.png'/>";
            else
            $img="<img src='./vista/img/rojo3.png'/>";

            if($data[4]>= 3)
            $img2="<img src='./vista/img/verde3.png'/>";
            else if ($data[4] >= 2)
            $img2="<img src='./vista/img/amarillo3.png'/>";
            else
            $img2="<img src='./vista/img/rojo3.png'/>";

            $venta="".$data[1]."";
            $cet="".$data[2]."";
            $cetpor="<div align=right>".$data[3]." ".$img."&nbsp;&nbsp;&nbsp;</div>";
            $cierrepor="<div align=right>".$data[4]." ".$img2."&nbsp;&nbsp;&nbsp;</div>";

            $tot="".$data[5]."";
            $ges="".$data[6]."";
            $pend="".$data[7]."";

            $arreglo["data"][] = array ($i,$data[0],'','','','',$venta,$cet,$cetpor,$cierrepor,$tot,$ges,$pend);
        }
        echo json_encode($arreglo);
    }
?>