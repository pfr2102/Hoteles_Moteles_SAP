$("#frmAcceso").on('submit', function(e){
	e.preventDefault();
	logina=$("#logina").val();
	clavea=$("#clavea").val();

	$.post("../ajax/usuario.php?op=verificar",
		{"logina":logina, "clavea":clavea},
		function(data){

			if(data !="null"){
				//alert(data);
				$(location).attr("href","usuarioA.php");
			}else{
				Swal.fire({
				  icon: 'error',
				  title: 'Oops...',
				  text: 'Usuario o Password incorrecto!',
				  footer: '<a href="">Quieres comunicarte con el administrador?</a>'
				})
			}
		}
	);
})