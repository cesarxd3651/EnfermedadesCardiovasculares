<script>
	$(document).ready(function(){
	$('.btn-exit-system').on('click', function(e){
		e.preventDefault();
		var Token=$(this).attr('href');
		swal({
		  	title: 'Estas seguro ?',
		  	text: "Cerrarás tu sesión mano y tendrás que iniciar sesión con tu cuenta de nuevo.",
		  	type: 'warning',
		  	showCancelButton: true,
		  	confirmButtonColor: '#03A9F4',
		  	cancelButtonColor: '#F44336',
		  	confirmButtonText: '<i class="zmdi zmdi-run"></i> Sí, SALIR!',
		  	cancelButtonText: '<i class="zmdi zmdi-close-circle"></i> No, Cancelar!'
		}).then(function () {
			$.ajax({
				url:'<?php echo SERVERURL; ?>ajax/loginAjax.php?Token='+Token,
				success:function(data){
					//en el login modelo, cerrar sesion() la variable $respuesta tiene el true o el false

					//si es verdadero, es por que se ha cerrado satisfactoriamente la sesion
					if (data=="true") {
						window.location.href="<?php echo SERVERURL; ?>login/"; 
					}else{
						swal(
								"Ocurrio un error brr",
								"No se pudo cerrar la sesion",
								"error"
							);
					}
				}
			});
		});

	});	
});
</script>
