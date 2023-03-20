@extends('layout')

@section('content')
<div class='row'>
    <div class='col-12'>
        <div  style="padding-bottom: 1%; ">
            <h3 class="display-3" style="color:#ffc107;text-align:center">Información Histórica</h3>
        </div>
        <div id="app" style="padding: 0% 5%" class=" h-80 w-80 flex items-center justify-center">
            <table id='tablaIndicadores' class="table table-bordered" style="color:antiquewhite">
                <thead style="background:#ffc107; color:black">
                    <tr>
                        <th>Nombre</th>
                        <th>Codigo</th>
                        <th>Unidad de Medida</th>
                        <th>Valor</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody >

                </tbody>
            </table>
            <div id="pagination" data-url="{{ route('pagination') }}"> </div>
            
        </div> 
        <div style="padding-right: 70%">
            <button onclick='formulario(0)' type='button' class='btn btn-success btn-outline-success' id='crear'>
                <span style='color:white' class='glyphicon glyphicon-edit'>Agregar indicador</span>
            </button>
        </div>

        <br> <br> <br>

        <div style="padding-bottom: 1%">
            <h1 class="display-3" style="color:#ffc107;text-align:center">Datos Graficados</h1>
        </div>

        <div class='container mt-5' style="padding-bottom: 3%">
            <div class="row" id='filtro' style="align-items: left">
                <div class="col">
                    <div class="form-group form-floating mb-3">
                        <input id="fechaDesde" type="date" class="form-control" required="required" autofocus>
                        <label style="color:black" for="floatingDate">Desde</label>
                    </div>
                </div>
                <br>
                <div class="col">
                    <div class="form-group form-floating mb-3">
                        <input id="fechaHasta" type="date" class="form-control" required="required" autofocus>
                        <label style="color:black" for="floatingDate">Hasta</label>
                    </div>
                </div>
                <div id="grafico">

                </div>
            </div>
        </div>

    </div>
</div>

<script>

    function getData(page) {
        var url = $('#pagination').data('url') + '?page=' + page;
        cargarDatos(page);
        $.get(url, function(response) {
            

            var totalPages = response.data['lastPage'];
            var currentPage = response.data['currentPage'];
            var pagination = '';
            for (var i = 1; i <= totalPages; i++) {
                if (i == currentPage) {
                    pagination += '<button disabled>' + i + '</button>';
                } else {
                    pagination += '<button onclick="getData(' + i + ')">' + i + '</button>';
                }
            }
            $('#pagination').html(pagination);
        });
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function cargarDatos(page) {
        $.ajax({
            url: "{{ route('getTableData') }}?page=" + page,
            type: "GET",
            success: function(response) {
                var tbody = $('#tablaIndicadores tbody');

                $.each(response.data, function(i, item) {
                    tbody.append(
                        "<tr>"+
                            "<td>"+item.nombreIndicador+"</td>"+
                            "<td>"+item.codigoIndicador+"</td>"+
                            "<td>"+item.unidadMedidaIndicador+"</td>"+
                            "<td>"+item.valorIndicador+"</td>"+
                            "<td>"+item.fechaIndicador+"</td>"+
                            "<td>"+
                                "<button onclick='formulario("+ item.id+")' type='button' class='btn btn-primary btn-outline-success' id='modificar"+i+"'>"+
                                    "<span style='color:white' class='glyphicon glyphicon-edit'>Modificar</span>"+
                                "</button>"+"  "+
                                "<button onclick='borrar("+ item.id+")' type='button' class='btn btn-danger btn-outline-light' id='eliminar"+i+"'>"+
                                    "<span class='glyphicon glyphicon-tras'>Eliminar</span>"+
                                "</button>"+
                            "</td>"+
                        "</tr>")});
            },
            error: function(xhr, status) {
                //console.log(response);
            }
        });
    }

    function formulario(id){
        window.location.href = "/formulario?id="+id
    }

    function borrar(id){
        Swal.fire({
			title: 'Está seguro?',
			text: "Recuerde verificar la información",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#red',
			cancelButtonColor: '#yellow',
			cancelButtonText: 'Cancelar',
			confirmButtonText: 'Eliminar'
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					type: "post",
					url: "{{ route('borrar') }}",
					dataType: "json",
					contentType: "application/json; charset=utf-8",
					data: JSON.stringify({ 
						'id': id,
					}),
					success: function(response) {
						Swal.fire({
							icon: 'success',
							title: 'Exito',
							text: 'Se ha eliminado correctamente correctamente',
						}).then((result) => {
							window.location = "{{ route('home') }}"
						});
					},
					error: function(xhr, status) {
						Swal.fire({
							icon: 'error',
							title: 'Error',
							text: 'No se pudo eliminar el indicador',
						});
					}
				});
			}
		});
    }

    $(document).ready(function() {
        cargarDatos(1);
    });

    Highcharts.chart('grafico', {

        title: {
            text: 'Información histórica de la UF',
            align: 'left'
        },

        subtitle: {
            text: '',
            align: 'left'
        },

        yAxis: {
            title: {
                text: 'Valor (Pesos)'
            }
        },

        xAxis: {
            accessibility: {
                rangeDescription: 'Fecha'
            }
        },

        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle'
        },

        plotOptions: {
            series: {
                label: {
                    connectorAllowed: false
                },
                pointStart: 2010
            }
        },

        series: [
            {
                name: 'Unidad de fomento (UF)',
                data: [43934, 48656, 65165, 81827, 112143, 142383,
                    171533, 165174, 155157, 161454, 154610]
            }],

        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOptions: {
                    legend: {
                        layout: 'horizontal',
                        align: 'center',
                        verticalAlign: 'bottom'
                    }
                }
            }]
        }

    });

</script>

@endsection