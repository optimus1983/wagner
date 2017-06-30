<?php

if(strlen($_GET['desde'])>0 and strlen($_GET['hasta'])>0){
	$desde = $_GET['desde'];
	$hasta = $_GET['hasta'];

	$verDesde = date('d/m/Y', strtotime($desde));
	$verHasta = date('d/m/Y', strtotime($hasta));
}else{
	$desde = '1111-01-01';
	$hasta = '9999-12-30';

	$verDesde = '__/__/____';
	$verHasta = '__/__/____';
}
require('../fpdf/fpdf.php');
require('conexion.php');

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);
$pdf->Image('../recursos/tienda.gif' , 10 ,8, 10 , 13,'GIF');
$pdf->Cell(18, 10, '', 0);
$pdf->Cell(150, 10, 'Reportes Procesos Wagner', 0);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(50, 10, 'Hoy: '.date('d-m-Y').'', 0);
$pdf->Ln(15);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(70, 8, '', 0);
$pdf->Cell(100, 8, 'Reportes ', 0);
$pdf->Ln(10);
$pdf->Cell(60, 8, '', 0);
$pdf->Cell(100, 8, 'Desde: '.$verDesde.' hasta: '.$verHasta, 0);
$pdf->Ln(23);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(15, 8, 'Item', 0);
$pdf->Cell(70, 8, 'Nombre', 0);
$pdf->Cell(40, 8, 'Tipo', 0);



$pdf->Ln(8);
$pdf->SetFont('Arial', '', 8);
//CONSULTA
$productos = mysql_query("SELECT OB.codigo_objeto as codigo_remito, PU.cod_sucursal as local, PD.numero_deposito, OB2.codigo_objeto AS precinto, OB.fecha_ingreso_check_in, PR.fecha_proceso_remito as fecha_proceso,
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
$item = 0;
$totaluni = 0;
$totaldis = 0;
while($productos2 = mysql_fetch_array($productos)){
	$item = $item+1;
	$pdf->Cell(15, 8, $item, 0);
	$pdf->Cell(70, 8,  $productos2['codigo_remito'], 0);
	$pdf->Cell(40, 8,  $productos2['local'], 0);
	$pdf->Cell(25, 8,  $productos2['numero_deposito'], 0);
	$pdf->Cell(25, 8,  $productos2['numero_sobre'], 0);
	$pdf->Cell(25, 8, $productos2['unidad_sobre'], 0);
	$pdf->Cell(25, 8, $productos2['precinto'], 0);
	$pdf->Cell(25, 8, date('d/m/Y', strtotime($productos2['fecha_retiro'])), 0);
	$pdf->Cell(25, 8, $productos2['hora_recepcion'], 0);
	$pdf->Cell(25, 8, date('d/m/Y', strtotime($productos2['fecha_proceso'])), 0);
	$pdf->Cell(25, 8, date('d/m/Y', strtotime($productos2['fecha_corte'])), 0);
	$pdf->Cell(25, 8, $productos2['nombre_cliente'], 0);
	$pdf->Cell(40, 8, $productos2['direccion_punto'], 0);
	$pdf->Cell(25, 8, $productos2['id_local'], 0);
	$pdf->Cell(25, 8, $productos2['nombre_punto'], 0);
	$pdf->Cell(25, 8, $productos2['tipo_proceso'], 0);
	$pdf->Cell(25, 8, $productos2['monto_declarado'], 0);
	$pdf->Cell(40, 8, $productos2['monto_diferencia'], 0);
	$pdf->Cell(25, 8, $productos2['monto_procesado'], 0);
	$pdf->Cell(25, 8, $productos2['id_procesado'], 0);
	$pdf->Cell(25, 8, $productos2['modulo_conteo'], 0);
	$pdf->Cell(25, 8, $productos2['hora_inicio_proceso'], 0);
	$pdf->Cell(25, 8, $productos2['hora_termino_proceso'], 0);
	$pdf->Cell(25, 8, $productos2['numero_corte'], 0);
	$pdf->Cell(25, 8, $productos2['estado_remesa'], 0);
	$pdf->Cell(25, 8, $productos2['convenio'], 0);
	$pdf->Ln(8);
}
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(104,8,'',0);

$pdf->Output('reporte.pdf','D');
?>