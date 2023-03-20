@extends('layout')

@section('content')
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> 


<div class="container contenedorMayor align-center">
	<div class="row">
		<div class="col-md-9 register-right">
			@csrf

			{{-- Contenedor --}}
			<div class="tab-pane fade show active" id="trabajador" role="tabpanel" aria-labelledby="home-tab">
				<input type="hidden" name="tipoUsuario" value="1" />

				<div style="padding-bottom: 3%">
					<h1 class="display-3" style="color:#ffc107;text-align:center">Indicador</h1>
				</div>

				<div class="form-group form-floating mb-3">
					<input id="nombre" type="text" class="form-control" name="nombre" value="{{ old('nombre') }}" placeholder="Juan Perez"
						required="required" autofocus>
					<label style="color:black" for="floatingName">Nombre</label>
				</div>

				<div class="row">
					<div class="col">
						<div class="form-group form-floating mb-3">
							<input id="codigo" type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Juan Perez"
								required="required" autofocus>
							<label style="color:black" for="floatingName">Código</label>
						</div>
					</div>
					<div class="col">
						<div class="form-group form-floating mb-3">
							<input id="unidadMedida" type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Juan Perez"
								required="required" autofocus>
							<label style="color:black" for="floatingName">Unidad de medida</label>
						</div>
					</div>
				</div>

				<div class="form-group form-floating mb-3">
					<input id="valor" type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Juan Perez"
						required="required" autofocus>
					<label style="color:black" for="floatingNumber">Valor</label>
				</div>

				<div class="form-group form-floating mb-3">
					<input id="fecha" type="date" class="form-control" name="name" value="{{ old('name') }}" placeholder="Juan Perez"
						required="required" autofocus>
					<label style="color:black" for="floatingNumber">Fecha</label>
				</div>

				<div class="form-group form-floating mb-3">
					<button class="w-100 btn btn-lg btn-primary btn-success" onclick="guardar()" id="guardar" type="submit">Guardar cambios</button>
					<br><br>
					<button class="w-100 btn btn-lg btn-primary btn-danger" onclick="volver()" id="volver" type="submit">Volver</button>
				</div>
				<p class="mt-5 mb-3 text-muted">&copy; {{ date('Y') }}</p>
			</div>
		</div>
		{{-- Contenedores --}}
	</div>
</div>

<script>

	function cargarParametros(id) {
		if(id != 0){
			$.ajax({
				type: "GET",
				url: "{{ route('mostrar') }}",
				data: {
					"id": id,
				},
				success: function(response) {
					$('#nombre').val(response.nombreIndicador);
					$('#codigo').val(response.codigoIndicador);
					$('#unidadMedida').val(response.unidadMedidaIndicador);
					$('#valor').val(response.valorIndicador);
					$('#fecha').val(response.fechaIndicador);
				},
				error: function(xhr, status) {
				}
			});
		}
	}

	function guardar() {

		var nombre 	= $('#nombre').val();
		var codigo 	= $('#codigo').val();
		var um 		= $('#unidadMedida').val();
		var valor 	= $('#valor').val();
		var fecha 	= $('#fecha').val();

		if (nombre == '' ) {
			swal.fire({
				icon: 'error',
				title: 'Error',
				text: 'Ingrese un nombre',
			})
			return;
		};
		
		Swal.fire({
			title: 'Está seguro?',
			text: "Recuerde verificar la información",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			cancelButtonText: 'Cancelar',
			confirmButtonText: 'Guardar'
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					type: "post",
					url: "{{ route('guardar') }}",
					dataType: "json",
					contentType: "application/json; charset=utf-8",
					data: JSON.stringify({ 
						'nombreIndicador': nombre,
						'codigoIndicador': codigo,
						'unidadMedidaIndicador': um,
						'valorIndicador': valor,
						'fechaIndicador': fecha,
					}),
					success: function(response) {
						Swal.fire({
							icon: 'success',
							title: 'Exito',
							text: 'Se ha guardado correctamente',
						}).then((result) => {
							window.location = "{{ route('home') }}"
						});
					},
					error: function(xhr, status) {
						Swal.fire({
							icon: 'error',
							title: 'Error',
							text: 'No se pudo guardar el indicador',
						});
					}
				});
			}
		});
	}

	function volver()
	{
		window.location = "{{ route('home')}}";
	}

	$(document).ready(function() {
		let params = new URLSearchParams(location.search);
		cargarParametros(params.get('id'));
    });
	
</script>

@endsection