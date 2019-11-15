<?php 
    require_once("../configuracion/database.php");
    require_once("../modelo/usuario_model.php");
    require_once("../controlador/Mobile_Detect.php");
    $disp = new Mobile_Detect();
    $asdfg = new usuario_model();
    $tipo_reporte = '2';
    $fecha1 = $_POST["f1"];
    $fecha2 = $_POST["f2"];
    $usuario = $_POST["vendedor"];
    $turno = $_POST["turno"];
    $sql_turno = "";

    $t0_total_q = 0;
    $t0_total_q2 = 0;
    $t0_total_q4 = 0;
    $t0_total_q5 = 0;
    $t0_total_q6 = 0;

    $t1_total_q = 0;
    $t1_total_q2 = 0;
    $t1_total_q4 = 0;
    $t1_total_q5 = 0;
    $t1_total_q6 = 0;

    $formulario = "";

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

    if($turno!=""){
        $sql_turno = " AND bdmovilv2.usuarios.medio_tiempo='".$turno."' ";
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
    and   date(ffechaGrabacion) $sqlFecha $sqlUsuario $sql_turno
    group by consulta_dni.tUsuario;");
        $sql->execute();
        $rows = $sql->fetchAll();

        if($rows!=null){
            if(!$disp->isMobile()){
            $formulario.="
            <table class='table table-bordered table-striped table-hover display responsive nowrap' width='100%' cellspacing=0' id='tbl_total'>
                <thead>
                    <tr role='row' class='col_heading'>
                        <th style='background-color:#4c88bb;color:white;'>TURNO</th>
                        <th style='background-color:#4c88bb;color:white;'>C(Q)</th>
                        <th style='background-color:#4c88bb;color:white;'>E(Q)</th>
                        <th style='background-color:#4c88bb;color:white;'>VENTA</th>
                        <th style='background-color:#4c88bb;color:white;'>SEG</th>
                        <th style='background-color:#4c88bb;color:white;'>NO DESEA</th>
                    </tr>
                </thead>
                <tbody>
                    <tr role='row' class='odd'>";
            }else{
                $formulario.="
                <table class='table table-bordered table-striped table-hover display responsive nowrap' width='100%' cellspacing=0' id='tbl_total'>
                    <thead>
                        <tr role='row' class='col_heading'>
                            <th style='background-color:#4c88bb;color:white;'></th>
                            <th style='background-color:#4c88bb;color:white;'>FULL TIME</th>
                            <th style='background-color:#4c88bb;color:white;'>PART TIME</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr role='row' class='odd'>";
            }

            foreach($rows as $data){
                if($data['medio_tiempo']==0){
                    $t0_total_q+=$data['Q'];
                    $t0_total_q2+=$data['Q2'];
                    $t0_total_q4+=$data['Q4'];
                    $t0_total_q5+=$data['Q5'];
                    $t0_total_q6+=$data['Q6'];
                }else{
                    if($data['medio_tiempo']==1){
                        $t1_total_q+=$data['Q'];
                        $t1_total_q2+=$data['Q2'];
                        $t1_total_q4+=$data['Q4'];
                        $t1_total_q5+=$data['Q5'];
                        $t1_total_q6+=$data['Q6'];
                    }
                }
            }

            if(!$disp->isMobile()){
                $formulario.="
                            <td style='text-align:center;'><span class='label label-success'>FULL TIME</span></td>
                            <td>".$t0_total_q."</td>
                            <td>".$t0_total_q2."</td>
                            <td>".$t0_total_q4."</td>
                            <td>".$t0_total_q5."</td>
                            <td>".$t0_total_q6."</td>
                        </tr>
                        <tr>
                            <td style='text-align:center;'><span class='label label-warning'>PART TIME</span></td>
                            <td>".$t1_total_q."</td>
                            <td>".$t1_total_q2."</td>
                            <td>".$t1_total_q4."</td>
                            <td>".$t1_total_q5."</td>
                            <td>".$t1_total_q6."</td>
                        </tr>
                    </tbody>
                </table>";
            }else{
                $formulario.="
                            <td>C(Q)</td>
                            <td>".$t0_total_q."</td>
                            <td>".$t1_total_q."</td>
                        </tr>
                        <tr role='row' class='odd'>
                            <td>E(Q)</td>
                            <td>".$t0_total_q2."</td>
                            <td>".$t1_total_q2."</td>
                        </tr>
                        <tr role='row' class='odd'>
                            <td>VENTA</td>
                            <td>".$t0_total_q4."</td>
                            <td>".$t1_total_q4."</td>
                        </tr>
                        <tr role='row' class='odd'>
                            <td>SEG</td>
                            <td>".$t0_total_q5."</td>
                            <td>".$t1_total_q5."</td>
                        </tr>
                        <tr role='row' class='odd'>
                            <td>NO DESEA</td>
                            <td>".$t0_total_q6."</td>
                            <td>".$t1_total_q6."</td>
                        </tr>
                    </tbody>
                </table>";
            }
        }else{
            if(!$disp->isMobile()){
                $formulario.="
                <table class='table table-bordered table-striped table-hover display responsive nowrap' width='100%' cellspacing=0' id='tbl_total'>
                    <thead>
                        <tr role='row' class='col_heading'>
                            <th style='background-color:#4c88bb;color:white;'>TURNO</th>
                            <th style='background-color:#4c88bb;color:white;'>C(Q)</th>
                            <th style='background-color:#4c88bb;color:white;'>E(Q)</th>
                            <th style='background-color:#4c88bb;color:white;'>VENTA</th>
                            <th style='background-color:#4c88bb;color:white;'>SEG</th>
                            <th style='background-color:#4c88bb;color:white;'>NO DESEA</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>";
            }else{
                $formulario.="
                <table class='table table-bordered table-striped table-hover display responsive nowrap' width='100%' cellspacing=0' id='tbl_total'>
                    <thead>
                        <tr role='row' class='col_heading'>
                            <th style='background-color:#4c88bb;color:white;'></th>
                            <th style='background-color:#4c88bb;color:white;'>FULL TIME</th>
                            <th style='background-color:#4c88bb;color:white;'>PART TIME</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                ";
            }
        }
    }

    echo $formulario;
?>