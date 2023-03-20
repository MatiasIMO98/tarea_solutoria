@extends('layouts.head')

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> 


<div class="container contenedorMayor">
	<div class="row">
		<div class="col-md-3 register-left">
			<div class="col">
				<br><br>
				{{-- Imagen --}}
			</div>
		</div>
		<div class="col-md-9 register-right" style="padding-left: 7%">
			@csrf

			{{-- Contenedor --}}
			<div class="tab-pane fade show active" id="trabajador" role="tabpanel" aria-labelledby="home-tab">
				<input type="hidden" name="tipoUsuario" value="1" />

				<h1 class="h3 mb-3 fw-normal p-4">Indicador</h1>

				<div class="form-group form-floating mb-3">
					<input id="nombre" type="text" class="form-control" name="nombre" value="{{ old('nombre') }}" placeholder="Juan Perez"
						required="required" autofocus>
					<label for="floatingName">Nombre</label>
					@if ($errors->has('nombre'))
						<span class="text-danger text-left">{{ $errors->first('nombre') }}</span>
					@endif
				</div>

				<div class="row">
					<div class="col">
						<div class="form-group form-floating mb-3">
							<input id="codigo" type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Juan Perez"
								required="required" autofocus>
							<label for="floatingName">Código</label>
							@if ($errors->has('name'))
								<span class="text-danger text-left">{{ $errors->first('name') }}</span>
							@endif
						</div>
					</div>
					<div class="col">
						<div class="form-group form-floating mb-3">
							<input id="unidadMedida" type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Juan Perez"
								required="required" autofocus>
							<label for="floatingName">Unidad de medida</label>
							@if ($errors->has('name'))
								<span class="text-danger text-left">{{ $errors->first('name') }}</span>
							@endif
						</div>
					</div>
				</div>

				<div class="form-group form-floating mb-3">
					<input id="valor" type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Juan Perez"
						required="required" autofocus>
					<label for="floatingNumber">Valor</label>
					@if ($errors->has('name'))
						<span class="text-danger text-left">{{ $errors->first('name') }}</span>
					@endif
				</div>

				<div class="form-group form-floating mb-3">
					<input id="fecha" type="date" class="form-control" name="name" value="{{ old('name') }}" placeholder="Juan Perez"
						required="required" autofocus>
					<label for="floatingNumber">Fecha</label>
					@if ($errors->has('name'))
						<span class="text-danger text-left">{{ $errors->first('name') }}</span>
					@endif
				</div>

				<button class="w-100 btn btn-lg btn-primary" onclick="guardar()" id="registrar" type="submit">Guardar cambios</button>

				<p class="mt-5 mb-3 text-muted">&copy; {{ date('Y') }}</p>
			</div>
		</div>
		{{-- Contenedores --}}
	</div>
</div>

<script>

	function listarComuna() {
		$.ajax({
			type: "GET",
			success: function(response) {
				$.each(response.data, function(indice, fila) {
					$('#comuna').append("<option id='idComuna' value='" + fila.id + "'>" + fila.comu_nombre + "</option>")
				});
			},
			error: function(xhr, status) {
				swal.fire({
					icon: 'error',
					title: 'Error',
					text: 'no se cargan las comunas',
				});
			}
		});
	}

	function ingresar(email, pass) {
		$.ajax({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				type: "post",
				data: {
					"_token": "{{ csrf_token() }}",
					'email': email,
					'pass': pass,
				},
				success: function(response) {
					if (response.success == true) {
						window.location = "{{ route('home') }}"
					} else {
						Swal.fire({
							icon: 'error',
							title: 'Error',
							text: 'Su información no es válida',
						})
					}
				},
				error: function(xhr, status) {
					Swal.fire({
						icon: 'error',
						title: 'Error',
						text: 'Su información no es válida',
					})
				}
			});
	}

	function cargarParametros(id) {
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
						
					},
					error: function(xhr, status) {
						Swal.fire({
							icon: 'error',
							title: 'Error',
							text: 'No se pudo editar el indicador',
						})
					}
				});
			}
		});
	}

	$(document).ready(function() {
		let params = new URLSearchParams(location.search);
		cargarParametros(params.get('id'));
    });
	
</script>