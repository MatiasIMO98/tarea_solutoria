@extends('layout')

@section('content')
<div class='row'>
    <div class='col-12'>
        <div  style="padding-bottom: 3%; ">
            <h3 class="display-3" style="color:#ffc107;text-align:left">Información Histórica</h3>
        </div>
        <div id="app" class="table-responsive h-80 w-80 flex items-center justify-center">
            <table id='tablaIndicadores' class="table table-bordered" style="color:antiquewhite">
                <thead>
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
            <div id="pagination" data-url="{{ route('pagination') }}">
            </div>
        </div>

        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>

        <div style="padding-bottom: 3%">
            <h1 class="display-3" style="color:#ffc107">Datos Graficados</h1>
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
                                "<button onclick='formulario("+ item.id+")' type='button' class='btn btn-success btn-outline-warning' id='modificar"+i+"'>"+
                                    "<span style='color:white' class='glyphicon glyphicon-edit'>Modificar</span>"+
                                "</button>"+"  "+
                                "<button type='button' class='btn btn-danger btn-outline-light' id='eliminar"+i+"'>"+
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

    $(document).ready(function() {
        cargarDatos(1);
    });

</script>

@endsection