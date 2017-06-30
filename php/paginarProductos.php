<?php
	include('conexion.php');


    $nroProductos = mysql_num_rows(mysql_query("SELECT OB.codigo_objeto as codigo_remito, PU.cod_sucursal as local, PD.numero_deposito, OB2.codigo_objeto AS precinto, OB.fecha_ingreso_check_in, PR.fecha_proceso_remito as fecha_proceso,
      PC.fecha_corte, PC.id_proceso_corte as numero_corte, CLI.nombre_cliente, PU.nombre_punto, PU.direccion_punto, PU.idpuntos as id_local, PU.convenio, PD.monto_declarado, PD.monto_diferencia, PD.monto_procesado,
      PCA.id_proceso_modulo_conteo as modulo_conteo,PRO.hora_inicio_proceso, PRO.hora_termino_proceso
  FROM objetos_valorados OB, objetos_valorados OB2, puntos PU, clientes CLI, proceso_remito PR, proceso_cajero PCA,proceso PRO, proceso_deposito PD, proceso_corte PC 
  WHERE 
  PR.fecha_proceso_remito between '".$desde."' and '".$hasta."'
  AND CLI.idcliente = PU.clientes_idcliente
  AND OB.puntos_idpuntos = PU.idpuntos 
  AND OB.integrado_en_corte = PC.id_proceso_corte
  AND PU.clientes_idcliente = CLI.idcliente
  AND OB.idobjetos_valorados = PR.id_objetos_valorados
  AND PR.id_proceso_remito = PRO.id_proceso_remito
  AND PRO.id_proceso_cajero = PCA.id_proceso_cajero
  AND PRO.id_proceso = PD.id_proceso
  AND OB.idobjetos_valorados = OB2.idobjeto_padre 
  AND OB2.idobjetos_valorados = PRO.id_objetos_valorados_bulto ORDER BY PR.fecha_proceso_remito, PU.nombre_punto ASC"));
    $nroLotes = 10;
    $nroPaginas = ceil($nroProductos/$nroLotes);
    $lista = '';
    $tabla = '';

    if($paginaActual > 1){
        $lista = $lista.'<li><a href="javascript:pagination('.($paginaActual-1).');">Anterior</a></li>';
    }
    for($i=1; $i<=$nroPaginas; $i++){
        if($i == $paginaActual){
            $lista = $lista.'<li class="active"><a href="javascript:pagination('.$i.');">'.$i.'</a></li>';
        }else{
            $lista = $lista.'<li><a href="javascript:pagination('.$i.');">'.$i.'</a></li>';
        }
    }
    if($paginaActual < $nroPaginas){
        $lista = $lista.'<li><a href="javascript:pagination('.($paginaActual+1).');">Siguiente</a></li>';
    }
  
  	if($paginaActual <= 1){
  		$limit = 0;
  	}else{
  		$limit = $nroLotes*($paginaActual-1);
  	}

  	$registro = mysql_query("SELECT OB.codigo_objeto as codigo_remito, PU.cod_sucursal as local, PD.numero_deposito, OB2.codigo_objeto AS precinto, OB.fecha_ingreso_check_in, PR.fecha_proceso_remito as fecha_proceso,
      PC.fecha_corte, PC.id_proceso_corte as numero_corte, CLI.nombre_cliente, PU.nombre_punto, PU.direccion_punto, PU.idpuntos as id_local, PU.convenio, PD.monto_declarado, PD.monto_diferencia, PD.monto_procesado,
      PCA.id_proceso_modulo_conteo as modulo_conteo,PRO.hora_inicio_proceso, PRO.hora_termino_proceso
  FROM objetos_valorados OB, objetos_valorados OB2, puntos PU, clientes CLI, proceso_remito PR, proceso_cajero PCA,proceso PRO, proceso_deposito PD, proceso_corte PC LIMIT $limit,$nroLotes
  WHERE 
  PR.fecha_proceso_remito between '".$desde."' and '".$hasta."'
  AND CLI.idcliente = PU.clientes_idcliente
  AND OB.puntos_idpuntos = PU.idpuntos 
  AND OB.integrado_en_corte = PC.id_proceso_corte
  AND PU.clientes_idcliente = CLI.idcliente
  AND OB.idobjetos_valorados = PR.id_objetos_valorados
  AND PR.id_proceso_remito = PRO.id_proceso_remito
  AND PRO.id_proceso_cajero = PCA.id_proceso_cajero
  AND PRO.id_proceso = PD.id_proceso
  AND OB.idobjetos_valorados = OB2.idobjeto_padre 
  AND OB2.idobjetos_valorados = PRO.id_objetos_valorados_bulto ORDER BY PR.fecha_proceso_remito, PU.nombre_punto ASC ");

$a=array();
while($registro2 = mysql_fetch_array($registro,MYSQL_ASSOC)){
$a[]=$registro2;
}
//print_r(mysql_fetch_array($registro,MYSQL_ASSOC));
echo json_encode($a);
exit();

  	
?>