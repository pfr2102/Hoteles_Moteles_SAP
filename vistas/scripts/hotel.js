let tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e){
		guardaryeditar(e);	
	})

	//Cargamos los items al select categoria
	$.post("../ajax/hotel.php?op=selectEstado", function(r){
			$("#idestado").html(r);
			$("#idestado").selectpicker('refresh');
	});
	$("imagenmuestra").hide();

}

//Función limpiar
function limpiar(){
	let formulario = document.getElementById('formulario');
  formulario.reset();
	$("#imagenmuestra").hide();
	//$("#print").hide();
	$("#idhotel").val("");

}

//Función mostrar formulario
function mostrarform(flag){
	limpiar();
	if (flag){
		//alert("entro a flag true");
		$("#listadoregistros").hide();
		$("#btnagregar").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled",false);
	}
	else{
		//alert("entro a flag false");	
		$("#formularioregistros").hide();	
		$("#listadoregistros").show();
		$("#btnagregar").show();
	}
}

//Función cancelarform
function cancelarform(){
	limpiar();
	mostrarform(false);
}

//Función Listar
function listar()
{
	tabla=$('#tbllistado').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    buttons: [		          
		            'copyHtml5',
		            'excelHtml5',
		            'csvHtml5',
		            'pdf'
		        ],
		"ajax":
				{
					url: '../ajax/hotel.php?op=listar',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 8,//Paginación
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
}
//Función para guardar o editar

function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	let formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/hotel.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos){       
	      Swal.fire(
				  datos+'!',
				  'operacion exitosa',
				  'success'
				); 		   

	          mostrarform(false);
	          tabla.ajax.reload();
	    }

	});
	limpiar();
}


//es para mostrar los datos de un registro en el formulario
function mostrar(idhotel){
	$.post("../ajax/hotel.php?op=mostrar",{idhotel : idhotel}, function(data, status)
	{
		//alert("entro a mostrar"+idcategoria);
		data = JSON.parse(data);		
		mostrarform(true);

 		$("#idestado").val(data.idestado);
 		$('#idestado').selectpicker('refresh');

		$("#categoria").val(data.categoria);
 		$('#categoria').selectpicker('refresh');

		$("#nombre").val(data.nombre);
		$("#tot_habitaciones").val(data.tot_habitaciones);		
		$("#direccion").val(data.direccion);
		$("#telefono").val(data.telefono);
		$("#email").val(data.email);
		$("#estrellas").val(data.estrellas);
		$("#idhotel").val(data.idhotel);

		$("#imagenmuestra").show();
		$("#imagenmuestra").attr("src","../files/hoteles/"+data.imagen);
		$("#imagenactual").val(data.imagen);
 	})
}

//Funcion para desactivar registro
function desactivar(idhotel){
	  Swal.fire({
      title: 'ESTAS SEGURO DE DESACTIVAR EL HOTEL?',
      text: "al desactivar ya no podras utilizar este hotel!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, desactivo!',
      cancelButtonText: 'Canselar'
      }).then((result) => {
      if(result.value){
          if (result.isConfirmed) {
				$.post("../ajax/hotel.php?op=desactivar",{idhotel : idhotel}, function(e){
					Swal.fire({
	                  title:e+'!',
	                  text:'..........',                                 
	                  icon:'success'
	             	 });
					tabla.ajax.reload();
				});            
          } 
      }
  })
}

function activar(idhotel){
	  Swal.fire({
      title: 'ESTAS SEGURO DE ACTIVAR EL HOTEL?',
      text: "al activar podras utilizar este hotel!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, desactivo!',
      cancelButtonText: 'Canselar'
      }).then((result) => {
      if(result.value){
          if (result.isConfirmed) {
				$.post("../ajax/hotel.php?op=activar",{idhotel : idhotel}, function(e){
					Swal.fire({
	                  title:e+'!',
	                  text:'..........',                                 
	                  icon:'success'
	             	 });
					tabla.ajax.reload();
				});            
          } 
      }
  })
}


init();


