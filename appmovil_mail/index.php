<?php 
    require_once("./configuracion/database.php");
    require_once("./modelo/reporte_model.php");
    require_once("./modelo/PHPMailer/PHPMailerAutoload.php");
    $rep = new reporte_model();
    date_default_timezone_set("America/Lima");
    $fecha_actual = date("Y-m-d");
    $reporte_totales = $rep->get_totales_x_turno($fecha_actual);
    $reporte_info = $rep->get_venta_report_full($fecha_actual);
    $reporte_info_p = $rep->get_venta_report_part($fecha_actual);

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

    $resultado = true;

    $mail = new PHPMailer();
    $mail->isSMTP();

    $Nombre="";
    $Nombre1="";

    $mail->SMTPDebug  = 2;
    $mail->SMTPAuth = true;
    $mail->Host = "173.201.192.229";
    $mail->Username = 'bayental.reporting02@bayental.net';
    $mail->Password = '.rb*2016';
    $mail->Port = 25;

    $mail->From="bayental.reporting@bayental.net";
    $mail->FromName="Bayental Reporting";
    $mail->Sender="bayental.reporting@bayental.net";
    $mail->AddAddress("jaime.perez@bayental.com","Jaime Pérez");
    $mail->AddCC("jperezfrias33@gmail.com","jperezfrias33");
    $mail->AddCC("luis.paz@bayental.com","Luis Paz");
    $mail->AddCC("iris.venegas@scotiabank.com.pe","Iris Venegas");
    $mail->AddCC("raul.samaniego@bayental.com","Raul Samaniego");
    $mail->AddCC("leonel.villanueva@bayental.com","Leonel Villanueva");
    $mail->AddCC("jorge.buamsche@bayental.com","Jorge Buamsche");
    $mail->AddCC("juan.urbina@bayental.com","Juan Urbina");
    $mail->AddCC("olinda.tamayo@bayental.com","Olinda Tamayo");

    $mail->Subject = "Reporte de Gestión F2F Plaza Norte - ".$fecha_actual."";

    $mail->IsHTML(true);
    $mail->AddEmbeddedImage('./imagenes/cabecera.jpg', 'cabecera', 'cabecera.jpg');
    $mail->AddEmbeddedImage('./imagenes/firma_reporting2.png', 'footer', 'firma_reporting2.png');
    $mail->CharSet = 'UTF-8';

    if($reporte_totales!=null){
        foreach($reporte_totales as $data){
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
    }

    $mensaje = "
    <div style='text-align:center;'>
        <table style='width:980px;'>
            <thead>
                <tr>
                    <img src='cid:cabecera' width: 100% height: 100% />
                </tr>
            </thead>
            <tbody>
                <tr><td style='color:purple;text-align:center;'><h1>REPORTE GENERADO</h1></td></tr>
                <tr><td>&nbsp;</td></tr>
                <tr><td style='font-size:23px;'>Estimado Cliente: <strong>SCOTIABANK PERÚ</strong><br/>Recordarle que sus Reportes de Gestión <strong style='color:purple;'>F2F - Plaza Norte</strong>, se encuentran en línea y siempre disponibles.</h2></tr>
                <tr><td>&nbsp;</td></tr>
            </tbody>
        </table>
        <table style='width:980px;border: 1px solid #ddd;'>
            <thead>
                <tr><th colspan='6' style='background-color:#4c88bb;color:white;border: 1px solid #ddd; border-style: dotted;'>TOTALES</th></tr>
                <tr>
                    <th style='background-color:#4c88bb;color:white;width:20%;border: 1px solid #ddd; border-style: dotted;'>TURNO</th>
                    <th style='background-color:#4c88bb;color:white;width:16%;border: 1px solid #ddd; border-style: dotted;'>C(Q)</th>
                    <th style='background-color:#4c88bb;color:white;width:16%;border: 1px solid #ddd; border-style: dotted;'>E(Q)</th>
                    <th style='background-color:#4c88bb;color:white;width:16%;border: 1px solid #ddd; border-style: dotted;'>VENTA</th>
                    <th style='background-color:#4c88bb;color:white;width:16%;border: 1px solid #ddd; border-style: dotted;'>SEG</th>
                    <th style='background-color:#4c88bb;color:white;width:16%;border: 1px solid #ddd; border-style: dotted;'>NO DESEA</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style='text-align:center;background-color:green;color:white;border: 1px solid #ddd; border-style: dotted;'>FULL TIME</td>
                    <td style='text-align:center;border: 1px solid #ddd; border-style: dotted;'>".$t0_total_q."</td>
                    <td style='text-align:center;border: 1px solid #ddd; border-style: dotted;'>".$t0_total_q2."</td>
                    <td style='text-align:center;border: 1px solid #ddd; border-style: dotted;'>".$t0_total_q4."</td>
                    <td style='text-align:center;border: 1px solid #ddd; border-style: dotted;'>".$t0_total_q5."</td>
                    <td style='text-align:center;border: 1px solid #ddd; border-style: dotted;'>".$t0_total_q6."</td>
                </tr>
                <tr>
                    <td style='text-align:center;background-color:orange;color:white;border: 1px solid #ddd; border-style: dotted;'><span class='label label-warning'>PART TIME</span></td>
                    <td style='text-align:center;border: 1px solid #ddd; border-style: dotted;'>".$t1_total_q."</td>
                    <td style='text-align:center;border: 1px solid #ddd; border-style: dotted;'>".$t1_total_q2."</td>
                    <td style='text-align:center;border: 1px solid #ddd; border-style: dotted;'>".$t1_total_q4."</td>
                    <td style='text-align:center;border: 1px solid #ddd; border-style: dotted;'>".$t1_total_q5."</td>
                    <td style='text-align:center;border: 1px solid #ddd; border-style: dotted;'>".$t1_total_q6."</td>
                </tr>
            </tbody>
        </table>
        <p>&nbsp;</p>
        <table style='width:980px;border: 1px solid #ddd;'>
        <thead>
            <tr>
                <th style='background-color:#4c88bb;color:white;width:20%;border: 1px solid #ddd; border-style: dotted;'>USUARIO</th>
                <th style='background-color:#4c88bb;color:white;width:10%;border: 1px solid #ddd; border-style: dotted;'>TURNO</th>
                <th style='background-color:#4c88bb;color:white;width:10%;border: 1px solid #ddd; border-style: dotted;'>C(Q)</th>
                <th style='background-color:#4c88bb;color:white;width:10%;border: 1px solid #ddd; border-style: dotted;'>E(Q)</th>
                <th style='background-color:#4c88bb;color:white;width:10%;border: 1px solid #ddd; border-style: dotted;'>VENTA</th>
                <th style='background-color:#4c88bb;color:white;width:10%;border: 1px solid #ddd; border-style: dotted;'>SEG</th>
                <th style='background-color:#4c88bb;color:white;width:10%;border: 1px solid #ddd; border-style: dotted;'>NO DESEA</th>
                <th style='background-color:#4c88bb;color:white;width:10%;border: 1px solid #ddd; border-style: dotted;'>%VENTA</th>
                <th style='background-color:#4c88bb;color:white;width:10%;border: 1px solid #ddd; border-style: dotted;'>%EFECT</th>
            </tr>
        </thead>
        <tbody>";

        if($reporte_info!=null){
            foreach($reporte_info as $lista){
                $mensaje.= "
                <tr>
                    <td style='border: 1px solid #ddd; border-style: dotted;'>".$lista['tUsuario']."</td>";
                    if($lista['medio_tiempo']==1){
                        $mensaje.="<td style='text-align:center;background-color:orange;color:white'>PART TIME</td>";
                    }else{
                        $mensaje.="<td style='text-align:center;background-color:green;color:white'>FULL TIME</td>";
                    }
                    $mensaje.="
                    <td style='text-align:center;border: 1px solid #ddd; border-style: dotted;'>".$lista['Q']."</td>
                    <td style='text-align:center;border: 1px solid #ddd; border-style: dotted;'>".$lista['Q2']."</td>
                    <td style='text-align:center;border: 1px solid #ddd; border-style: dotted;'>".$lista['Q4']."</td>
                    <td style='text-align:center;border: 1px solid #ddd; border-style: dotted;'>".$lista['Q5']."</td>
                    <td style='text-align:center;border: 1px solid #ddd; border-style: dotted;'>".$lista['Q6']."</td>
                    <td style='text-align:center;border: 1px solid #ddd; border-style: dotted;'>".$lista['Q7']."</td>
                    <td style='text-align:center;border: 1px solid #ddd; border-style: dotted;'>".$lista['Q3']."</td>
                </tr>";
            }
        }

    $mensaje.="
        </tbody>
        </table>
        <p>&nbsp;</p>
        <table style='width:980px;border: 1px solid #ddd;'>
            <thead>
            <tr>
                <th style='background-color:#4c88bb;color:white;width:20%;border: 1px solid #ddd; border-style: dotted;'>USUARIO</th>
                <th style='background-color:#4c88bb;color:white;width:10%;border: 1px solid #ddd; border-style: dotted;'>TURNO</th>
                <th style='background-color:#4c88bb;color:white;width:10%;border: 1px solid #ddd; border-style: dotted;'>C(Q)</th>
                <th style='background-color:#4c88bb;color:white;width:10%;border: 1px solid #ddd; border-style: dotted;'>E(Q)</th>
                <th style='background-color:#4c88bb;color:white;width:10%;border: 1px solid #ddd; border-style: dotted;'>VENTA</th>
                <th style='background-color:#4c88bb;color:white;width:10%;border: 1px solid #ddd; border-style: dotted;'>SEG</th>
                <th style='background-color:#4c88bb;color:white;width:10%;border: 1px solid #ddd; border-style: dotted;'>NO DESEA</th>
                <th style='background-color:#4c88bb;color:white;width:10%;border: 1px solid #ddd; border-style: dotted;'>%VENTA</th>
                <th style='background-color:#4c88bb;color:white;width:10%;border: 1px solid #ddd; border-style: dotted;'>%EFECT</th>
            </tr>
            </thead>
            <tbody>";

            if($reporte_info_p!=null){
                foreach($reporte_info_p as $lista){
                    $mensaje.="
                    <tr>
                        <td style='border: 1px solid #ddd; border-style: dotted;'>".$lista['tUsuario']."</td>";
                        if($lista['medio_tiempo']==1){
                            $mensaje.="<td style='text-align:center;background-color:orange;color:white'>PART TIME</td>";
                        }else{
                            $mensaje.="<td style='text-align:center;background-color:green;color:white'>FULL TIME</td>";
                        }
                        $mensaje.="
                        <td style='text-align:center;border: 1px solid #ddd; border-style: dotted;'>".$lista['Q']."</td>
                        <td style='text-align:center;border: 1px solid #ddd; border-style: dotted;'>".$lista['Q2']."</td>
                        <td style='text-align:center;border: 1px solid #ddd; border-style: dotted;'>".$lista['Q4']."</td>
                        <td style='text-align:center;border: 1px solid #ddd; border-style: dotted;'>".$lista['Q5']."</td>
                        <td style='text-align:center;border: 1px solid #ddd; border-style: dotted;'>".$lista['Q6']."</td>
                        <td style='text-align:center;border: 1px solid #ddd; border-style: dotted;'>".$lista['Q7']."</td>
                        <td style='text-align:center;border: 1px solid #ddd; border-style: dotted;'>".$lista['Q3']."</td>
                    </tr>";
                }
            }
    
    $mensaje.="
            </tbody>
        </table>
        <table style='width:980px;'>
            <thead>
                <tr>
                    <img src='cid:footer' width: 100% height: 100% />
                </tr>
            </thead>
        </table>
    </div>";

    $mail->Body = $mensaje;

    if(!$mail->send()){
        $resultado = true;
    }
?>