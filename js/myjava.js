function filtrarLocal(){
		var desde = $('#bd-desde').val();
		var hasta = $('#bd-hasta').val();
		var url = '../php/busca_producto_fecha.php';
		var tablaPrev='<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">'+
						'<thead>'+
        				'<tr>'+
            		  '<th width="50">Codigo Remito</th>'+
			          '<th width="50">Local</th>'+
			          '<th width="50">Nro Deposito</th>'+
			          '<th width="50">Nro Sobre</th>'+
			          '<th width="50">Und Sobre</th>'+
			          '<th width="50">Precinto</th>'+
                	  '<th width="50">Fecha Retiro</th>'+
                	  '<th width="50">Hora Recepcion</th>'+
                	  '<th width="50">Fecha Proceso</th>'+
               		  '<th width="50">Fecha Corte</th>'+
                	  '<th width="50">Nom Cliente</th>'+
                	  '<th width="50">Direc. Punto</th>'+
                	  '<th width="50">Id Local</th>'+
               		  '<th width="50">Nom Punto</th>'+
               		  '<th width="50">Tipo Proceso</th>'+
                	  '<th width="50">Monto declarado</th>'+
                	  '<th width="50">Monto Diferencia</th>'+
                	  '<th width="50">Monto Procesado</th>'+
                	  '<th width="50">Id Procesado</th>'+
                	  '<th width="50">Modulo Conteo</th>'+
                	  '<th width="50">Hora Inicio Proceso</th>'+
                	  '<th width="50">Hora Termino Proceso</th>'+
                	  '<th width="50">Nro Corte</th>'+
                	  '<th width="50">Estado Remesa</th>'+
                	'<th width="50">Convenio</th>'+
            '</tr><thead>'
		$.ajax({
		type:'POST',
		url:url,
		data:'desde='+desde+'&hasta='+hasta,
		success: function(datos){
			var jsonData = JSON.parse(datos);
			var obtenido=null;
			var auxiliar=" ";
			var final=null;
		
			for (var i = 0; i < jsonData.length; i++) {
				obtenido="<tfoot><tr>"+
							"<td>"+jsonData[i.toString()]['codigo_remito']+"</td>"+
							"<td>"+jsonData[i.toString()]['local']+"</td>"+
							"<td>"+jsonData[i.toString()]['numero_deposito']+"</td>"+
							"<td>"+jsonData[i.toString()]['numero_sobre']+"</td>"+
							"<td>"+jsonData[i.toString()]['unidad_sobre']+"</td>"+
							"<td>"+jsonData[i.toString()]['precinto']+"</td>"+
							"<td>"+jsonData[i.toString()]['fecha_retiro']+"</td>"+
							"<td>"+jsonData[i.toString()]['hora_recepcion']+"</td>"+
							"<td>"+jsonData[i.toString()]['fecha_proceso']+"</td>"+
							"<td>"+jsonData[i.toString()]['fecha_corte']+"</td>"+
							"<td>"+jsonData[i.toString()]['nombre_cliente']+"</td>"+
							"<td>"+jsonData[i.toString()]['direccion_punto']+"</td>"+
							"<td>"+jsonData[i.toString()]['id_local']+"</td>"+
							"<td>"+jsonData[i.toString()]['nombre_punto']+"</td>"+
							"<td>"+jsonData[i.toString()]['tipo_proceso']+"</td>"+
							"<td>"+jsonData[i.toString()]['monto_declarado']+"</td>"+
							"<td>"+jsonData[i.toString()]['monto_diferencia']+"</td>"+
							"<td>"+jsonData[i.toString()]['monto_procesado']+"</td>"+
							"<td>"+jsonData[i.toString()]['id_procesado']+"</td>"+
							"<td>"+jsonData[i.toString()]['modulo_conteo']+"</td>"+
							"<td>"+jsonData[i.toString()]['hora_inicio_proceso']+"</td>"+
							"<td>"+jsonData[i.toString()]['hora_termino_proceso']+"</td>"+
							"<td>"+jsonData[i.toString()]['numero_corte']+"</td>"+
							"<td>"+jsonData[i.toString()]['estado_remesa']+"</td>"+
							"<td>"+jsonData[i.toString()]['convenio']+"</td>"+
						  "</tr> </tfoot>";
			
			auxiliar=auxiliar+" "+obtenido;
			}

			final=tablaPrev+auxiliar+"</table>"
		   $('#agrega-registros').html(final);
		    $('#example').DataTable();

		}
	});
	return false;

}

function reportePDF(){
	var desde = $('#bd-desde').val();
	var hasta = $('#bd-hasta').val();
	window.open('../php/productos.php?desde='+desde+'&hasta='+hasta);
}
