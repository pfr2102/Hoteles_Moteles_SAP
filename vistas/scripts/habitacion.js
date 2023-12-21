let tabla;

//Función que se ejecuta al inicio
function init(){
	listar();

	$("#formulario").on("submit",function(e){
		guardaryeditar(e);	
	})
}

//Función limpiar
function limpiar(){
	let formulario = document.getElementById('formulario');
  formulario.reset();
  $("#idhabitacion").val("");
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
					url: '../ajax/habitacion.php?op=listar&hotel='+$('#idhotel').val(),
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
		url: "../ajax/habitacion.php?op=guardaryeditar",
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
function mostrar(idhabitacion){
	$.post("../ajax/habitacion.php?op=mostrar",{idhabitacion : idhabitacion}, function(data, status){
		data = JSON.parse(data);		
		$("#btnGuardar").prop("disabled",false);

		$("#tipo").val(data.tipo);
		$("#personas").val(data.personas);
		$("#tarifa_dia").val(data.tarifa_dia);
		$("#cantidad").val(data.cantidad);
		$("#idhabitacion").val(data.idhabitacion);
	})
}

//Funcion para desactivar registro
function desactivar(idhabitacion){
	  Swal.fire({
      title: 'ESTAS SEGURO DE DESACTIVAR ESTE USUARIO?',
      text: "al desactivar ya no podras utilizar este usuario!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, desactivo!',
      cancelButtonText: 'Canselar'
      }).then((result) => {
      if(result.value){
          if (result.isConfirmed) {
						$.post("../ajax/habitacion.php?op=desactivar",{idhabitacion : idhabitacion}, function(e){
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

function activar(idhabitacion){
	  Swal.fire({
      title: 'ESTAS SEGURO DE ACTIVAR EL USUARIO?',
      text: "al activar podras utilizar este usuario!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, desactivo!',
      cancelButtonText: 'Canselar'
      }).then((result) => {
      if(result.value){
          if (result.isConfirmed) {
				$.post("../ajax/habitacion.php?op=activar",{idhabitacion : idhabitacion}, function(e){
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