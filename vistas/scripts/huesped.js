let tabla;

//Función que se ejecuta al inicio
function init(){
	listar();

	$("#formulario").on("submit",function(e){
		guardaryeditar(e);	
	})

	//listar los tipos de habitaciones en el conbobox
	$.post("../ajax/huesped.php?op=selectHabitacion&hotel="+$("#idhotel").val(), function(r){
			$("#idhabitacion").html(r);
			$("#idhabitacion").selectpicker('refresh');
	});
	//listar los estados en el conbobox
	$.post("../ajax/huesped.php?op=selectEstado", function(r){
			$("#idestado").html(r);
			$("#idestado").selectpicker('refresh');
	});
	
}

//Función limpiar
function limpiar(){
	let formulario = document.getElementById('formulario');
  formulario.reset();
  $("#idregistro_huesped").val("");
}

//Función mostrar formulario para un nuevo registro
function mostrarform(){
	limpiar();
	$("#btnGuardar").prop("disabled",false);
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
					url: '../ajax/huesped.php?op=listar&hotel='+$('#idhotel').val()+'&usuario='+$('#idusuario').val(),
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
		url: "../ajax/huesped.php?op=guardaryeditar",
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

	         $('#cancelar').click();
	          tabla.ajax.reload();
	    }

	});
	limpiar();
}


//es para mostrar los datos de un registro en el formulario
function mostrar(idregistro_huesped){
	$.post("../ajax/huesped.php?op=mostrar",{idregistro_huesped : idregistro_huesped}, function(data, status){
		data = JSON.parse(data);		
		$("#btnGuardar").prop("disabled",false);

		$("#idregistro_huesped").val(data.idregistro_huesped);
		$("#fecha_ingreso").val(data.fecha_ingreso);
		$("#fecha_salida").val(data.fecha_salida);
		$("#costo_reserva").val(data.costo_reserva);

		$("#motivo").val(data.motivo);
 		$("#motivo").selectpicker('refresh');

		$("#idestado").val(data.idestado);
 		$("#idestado").selectpicker('refresh');

		$("#idhabitacion").val(data.idhabitacion);
 		$("#idhabitacion").selectpicker('refresh');
	})
}

//Funcion para eliminar registro
function eliminar(idregistro_huesped){
	  Swal.fire({
      title: '¿ESTÁS SEGURO DE ELIMINAR LA PERSONA?',
      text: "Al eliminar, no podrás recuperar esta información!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, eliminar!',
      cancelButtonText: 'Cancelar'
      }).then((result) => {
      if(result.value){
          if (result.isConfirmed) {
				$.post("../ajax/huesped.php?op=eliminar",{idregistro_huesped : idregistro_huesped}, function(e){
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