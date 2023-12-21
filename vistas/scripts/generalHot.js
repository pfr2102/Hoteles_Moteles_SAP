let tabla;

//Función que se ejecuta al inicio
function init(){	
	//visitasEstados();
	$("#fecha_inicio").change(tarifaOcupacion);
	$("#fecha_fin").change(tarifaOcupacion);
}
///////////////////////////////////
let idhotel = $("#idhotel").val();
//////////////////////////////////

function tarifaOcupacion(){
	let fecha_inicio = $("#fecha_inicio").val();
	let fecha_fin = $("#fecha_fin").val();	

	$.post("../ajax/consultas.php?op=tarifaOcupacionHot",{fecha_inicio: fecha_inicio,fecha_fin: fecha_fin, idhotel: idhotel}, function(data, status){
		data = JSON.parse(data);		
		//alert(idhotel);
		//alert(data.tarifa+'   '+data.ocupacion+ ' '+ fecha_fin);
		$("#ocupacion").text('% '+data.ocupacion);			
		$("#tarifa").text('$ '+data.tarifa);			
	}); 
	
	visitasEstados(fecha_inicio, fecha_fin);
	Motivos(fecha_inicio, fecha_fin);
}



var visitas
//////////////////////////////////////////////////////////////////////////
function visitasEstados(fecha_inicio, fecha_fin){
	 if (visitas) {
	    visitas.destroy();
	  }
	$.post("../ajax/consultas.php?op=visitaEstadosHot",{fecha_inicio: fecha_inicio,fecha_fin: fecha_fin, idhotel: idhotel}, function(data, status){
		//alert(data);
		data = JSON.parse(data);
		// Acceder a las listas del objeto JSON
		let estados = data.estados.split("|");
		let totalEst = data.totalEst.split("|");
		//alert(estados);

		var ctx = document.getElementById("visitas").getContext('2d');
		visitas = new Chart(ctx, {
		    type: 'bar',
		    data: {
		        labels: estados,
		        datasets: [{
		            label: 'Visitas de los estados de Mexico',
		            data: totalEst,
		            backgroundColor: [
		                'rgba(255, 99, 132, 2)',
		                'rgba(54, 162, 235, 2)',
		                'rgba(255, 206, 86, 2)',
		                'rgba(75, 192, 192, 2)',
		                'rgba(153, 102, 255, 2)',
		                'rgba(255, 159, 64, 2)',
		                'rgba(255, 99, 132, 2)',
		                'rgba(54, 162, 235, 2)',
		                'rgba(255, 206, 86, 2)',
		                'rgba(75, 192, 192, 2)'
		            ],
		            borderColor: [
		                'rgba(255,99,132,1)',
		                'rgba(54, 162, 235, 1)',
		                'rgba(255, 206, 86, 1)',
		                'rgba(75, 192, 192, 1)',
		                'rgba(153, 102, 255, 1)',
		                'rgba(255, 159, 64, 1)',
		                'rgba(255,99,132,1)',
		                'rgba(54, 162, 235, 1)',
		                'rgba(255, 206, 86, 1)',
		                'rgba(75, 192, 192, 1)'
		            ],
		            borderWidth: 1
		        }]
		    },
		    options: {
		        scales: {
		            yAxes: [{
		                ticks: {
		                    beginAtZero:true
		                }
		            }]
		        }
		    }
		});	

	})
	
}



var motivos;
//////////////////////////////////////////////////////////////////////////////////////////////////
function Motivos(fecha_inicio, fecha_fin) {
	if (motivos) {
	    motivos.destroy();
	}
  $.post("../ajax/consultas.php?op=motivoHot", {fecha_inicio: fecha_inicio,fecha_fin: fecha_fin, idhotel: idhotel}, function(data, status) {
    //alert(data);
    data = JSON.parse(data);
    // Acceder a las listas del objeto JSON
    let motivo = data.motivo.split("|");
    let total = data.total.split("|");
    //alert(motivo);

    var ctx = document.getElementById("motivos").getContext('2d');
    motivos = new Chart(ctx, {
      type: 'pie',
      data: {
        labels: motivo,
        datasets: [{
          label: 'Motivos de la visita',
          data: total,
          backgroundColor: [
            'rgba(255, 99, 132, 2)',
            'rgba(54, 162, 235, 2)',
            'rgba(255, 206, 86, 2)',
            'rgba(75, 192, 192, 2)',
            'rgba(153, 102, 255, 2)',
            'rgba(255, 159, 64, 2)',
            'rgba(255, 99, 132, 2)',
            'rgba(54, 162, 235, 2)',
            'rgba(255, 206, 86, 2)',
            'rgba(75, 192, 192, 2)'
          ],
        }]
      },
      options: {}
    });
  })
}




init();