let tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e){
		guardaryeditar(e);	
	})
	$("imagenmuestra").hide();

	//mostrar los permisos en el form
	$.post("../ajax/usuario.php?op=permisos&id=", function(r){
			$("#permisos").html(r);
	});

}

//Función limpiar
function limpiar(){
	let formulario = document.getElementById('formulario');
  formulario.reset();
	$("#imagenmuestra").hide();
	$("#idusuario").val("");
}

//Función mostrar formulario
function mostrarform(flag){
	limpiar();
	if (flag){
		$('#check6').prop('checked', true);	
		$('#permisos').hide(); 		
		$("#listadoregistros").hide();
		$("#btnagregar").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled",false);
	}
	else{
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
	    					{extend: 'copyHtml5', filename: 'usuario' },		        
		            {extend: 'excelHtml5', filename: 'usuario'},
			          {extend: 'csvHtml5', filename: 'usuario'},
		            {
	                extend: 'pdf',
	                title: 'usuario',
	                filename: 'usuario',
	                customize: function(doc) {
	                    doc.defaultStyle.docTitle = doc.content[0].text;
	                }
            		}
		        ],
		"ajax":
				{
					url: '../ajax/usuario.php?op=listarCapturistas&hotel='+$('#idhotel').val(),
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
		url: "../ajax/usuario.php?op=guardaryeditar",
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
function mostrar(idusuario){
	$.post("../ajax/usuario.php?op=mostrar",{idusuario : idusuario}, function(data, status)
	{
		//alert("entro a mostrar"+idcategoria);
		data = JSON.parse(data);		
		mostrarform(true);

 		$("#nombre").val(data.nombre);
 		$("#idhotel").val(data.idhotel);
 		$("#tipo_documento").val(data.tipo_documento);
 		$("#tipo_documento").selectpicker('refresh');
 		$("#rol").val(data.rol);
 		$("#num_documento").val(data.num_documento);
 		$("#direccion").val(data.direccion);
 		$("#telefono").val(data.telefono);
 		$("#email").val(data.email);
 		$("#cargo").val(data.cargo);
 		$("#login").val(data.login);
 		$("#clave").val(data.clave);
 		$("#imagenmuestra").show();
 		$("#imagenmuestra").attr("src","../files/usuarios/"+data.imagen);
 		$("#imagenactual").val(data.imagen);
 		$("#idusuario").val(data.idusuario);

 	});

 	$.post("../ajax/usuario.php?op=permisos&id="+idusuario, function(r){
 			//alert("hola");
			$("#permisos").html(r);
	});

}

//Funcion para desactivar registro
function desactivar(idusuario){
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
						$.post("../ajax/usuario.php?op=desactivar",{idusuario : idusuario}, function(e){
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

function activar(idusuario){
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
				$.post("../ajax/usuario.php?op=activar",{idusuario : idusuario}, function(e){
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


