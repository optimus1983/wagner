<?php
include('conexion.php');

$desde = $_POST['desde'];
$hasta = $_POST['hasta'];


//COMPROBAMOS QUE LAS FECHAS EXISTAN
if(isset($desde)==false){
	$desde = $hasta;
}

if(isset($hasta)==false){
	$hasta = $desde;
}

//EJECUTAMOS LA CONSULTA DE BUSQUEDA

$registro = mysql_query(" SELECT OB.codigo_objeto as codigo_remito, PU.cod_sucursal as local, PD.numero_deposito, OB2.codigo_objeto AS precinto, OB.fecha_ingreso_check_in, PR.fecha_proceso_remito as fecha_proceso,
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
  AND OB2.idobjetos_valorados = PRO.id_objetos_valorados_bulto ORDER BY PR.fecha_proceso_remito, PU.nombre_punto ASC");

$a=array();
while($registro2 = mysql_fetch_array($registro,MYSQL_ASSOC)){
$a[]=$registro2;
}
//print_r(mysql_fetch_array($registro,MYSQL_ASSOC));
echo json_encode($a);
exit();

//CREAMOS NUESTRA VISTA Y LA DEVOLVEMOS AL AJAX
