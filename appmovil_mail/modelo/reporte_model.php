<?php
class reporte_model{
    private $db;

    public function __construct(){
        $this->db=database::conexion();
    }

    public function get_venta_report_full($fecha){
        try{
            $stmt = $this->db->prepare("SELECT consulta_dni.tUsuario,bdmovilv2.usuarios.medio_tiempo,
            count(*)  as 'Q',
            sum(if(ifnull(tResultado,'') not in ('','TRAMITE REGULAR','SIN RESULTADO')  ,1,0)) as 'Q2' ,
            sum(if(ifnull(tResultado,'') not in ('','TRAMITE REGULAR','SIN RESULTADO') and tResultado = 'VENTA' ,1,0)) as 'Q4' ,
            sum(if(ifnull(tResultado,'') not in ('','TRAMITE REGULAR','SIN RESULTADO') and tResultado = 'SEGUIMIENTO',1,0)) as 'Q5' ,
            sum(if(ifnull(tResultado,'') not in ('','TRAMITE REGULAR','SIN RESULTADO') and tResultado = 'NO DESEA',1,0)) as 'Q6',
            concat(ifnull(round((sum(if(ifnull(tResultado,'') not in ('','TRAMITE REGULAR','SIN RESULTADO') and tResultado = 'VENTA' ,1,0)) * 100)/sum(if(ifnull(tResultado,'') not in ('','TRAMITE REGULAR','SIN RESULTADO'),1,0)),2),'0.00'),'%') as 'Q7',
            concat(ifnull(round((sum(if(ifnull(tResultado,'') not in ('','TRAMITE REGULAR','SIN RESULTADO')  ,1,0)) * 100)/count(*),2),'0.00'),'%') as 'Q3'
             FROM bdmovil.consulta_dni as consulta_dni, bdmovilv2.usuarios
            where usuarios.codusuario = consulta_dni.tUsuario
             and nReporte=1 and ifnull(consulta_dni.tDni,'') not in ('')
            and left(ffechaGrabacion,10)='".$fecha."' AND bdmovilv2.usuarios.medio_tiempo=0 group by consulta_dni.tUsuario ORDER BY Q DESC;");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            unset($stmt);
            return $rows;
        }catch(PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function get_venta_report_part($fecha){
        try{
            $stmt = $this->db->prepare("SELECT consulta_dni.tUsuario,bdmovilv2.usuarios.medio_tiempo,
            count(*)  as 'Q',
            sum(if(ifnull(tResultado,'') not in ('','TRAMITE REGULAR','SIN RESULTADO')  ,1,0)) as 'Q2' ,
            sum(if(ifnull(tResultado,'') not in ('','TRAMITE REGULAR','SIN RESULTADO') and tResultado = 'VENTA' ,1,0)) as 'Q4' ,
            sum(if(ifnull(tResultado,'') not in ('','TRAMITE REGULAR','SIN RESULTADO') and tResultado = 'SEGUIMIENTO',1,0)) as 'Q5' ,
            sum(if(ifnull(tResultado,'') not in ('','TRAMITE REGULAR','SIN RESULTADO') and tResultado = 'NO DESEA',1,0)) as 'Q6',
            concat(ifnull(round((sum(if(ifnull(tResultado,'') not in ('','TRAMITE REGULAR','SIN RESULTADO') and tResultado = 'VENTA' ,1,0)) * 100)/sum(if(ifnull(tResultado,'') not in ('','TRAMITE REGULAR','SIN RESULTADO'),1,0)),2),'0.00'),'%') as 'Q7',
            concat(ifnull(round((sum(if(ifnull(tResultado,'') not in ('','TRAMITE REGULAR','SIN RESULTADO')  ,1,0)) * 100)/count(*),2),'0.00'),'%') as 'Q3'
             FROM bdmovil.consulta_dni as consulta_dni, bdmovilv2.usuarios
            where usuarios.codusuario = consulta_dni.tUsuario
             and nReporte=1 and ifnull(consulta_dni.tDni,'') not in ('')
            and left(ffechaGrabacion,10)='".$fecha."' AND bdmovilv2.usuarios.medio_tiempo=1 group by consulta_dni.tUsuario ORDER BY Q DESC;");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            unset($stmt);
            return $rows;
        }catch(PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function get_totales_x_turno($fecha){
        try{
            $stmt = $this->db->prepare("SELECT consulta_dni.tUsuario,bdmovilv2.usuarios.medio_tiempo,
            count(*)  as 'Q',
            sum(if(ifnull(tResultado,'') not in ('','TRAMITE REGULAR','SIN RESULTADO')  ,1,0)) as 'Q2' ,
            sum(if(ifnull(tResultado,'') not in ('','TRAMITE REGULAR','SIN RESULTADO') and tResultado = 'VENTA' ,1,0)) as 'Q4' ,
            sum(if(ifnull(tResultado,'') not in ('','TRAMITE REGULAR','SIN RESULTADO') and tResultado = 'SEGUIMIENTO',1,0)) as 'Q5' ,
            sum(if(ifnull(tResultado,'') not in ('','TRAMITE REGULAR','SIN RESULTADO') and tResultado = 'NO DESEA',1,0)) as 'Q6',
            concat(ifnull(round((sum(if(ifnull(tResultado,'') not in ('','TRAMITE REGULAR','SIN RESULTADO') and tResultado = 'VENTA' ,1,0)) * 100)/sum(if(ifnull(tResultado,'') not in ('','TRAMITE REGULAR','SIN RESULTADO'),1,0)),2),'0.00'),'%') as 'Q7',
            concat(ifnull(round((sum(if(ifnull(tResultado,'') not in ('','TRAMITE REGULAR','SIN RESULTADO')  ,1,0)) * 100)/count(*),2),'0.00'),'%') as 'Q3'
             FROM bdmovil.consulta_dni as consulta_dni, bdmovilv2.usuarios
            where usuarios.codusuario = consulta_dni.tUsuario
             and nReporte=1 and ifnull(consulta_dni.tDni,'') not in ('')
            and left(ffechaGrabacion,10)='".$fecha."' group by consulta_dni.tUsuario ORDER BY Q DESC;");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            unset($stmt);
            return $rows;
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