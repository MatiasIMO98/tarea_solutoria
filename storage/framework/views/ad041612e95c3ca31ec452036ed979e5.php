

<?php $__env->startSection('content'); ?>
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
            <div id="pagination" data-url="<?php echo e(route('pagination')); ?>">
            </div>
        </div>

        <br> <br> <br> <br> <br> <br> <br> <br>

        <div style="padding-bottom: 3%">
            <h1 class="display-3" style="color:#ffc107">Datos Graficados</h1>
        </div>

        <div class='container mt-5'>
            <div class="row">
                <div class="col">
                    <div id="grafico"></div>
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
            url: "<?php echo e(route('getTableData')); ?>?page=" + page,
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
                text: 'UF (Pesos)'
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
                name: 'Installation & Developers',
                data: [43934, 48656, 65165, 81827, 112143, 142383,
                    171533, 165174, 155157, 161454, 154610]
            }, {
                name: 'Manufacturing',
                data: [24916, 37941, 29742, 29851, 32490, 30282,
                    38121, 36885, 33726, 34243, 31050]
            }, {
                name: 'Sales & Distribution',
                data: [11744, 30000, 16005, 19771, 20185, 24377,
                    32147, 30912, 29243, 29213, 25663]
            }, {
                name: 'Operations & Maintenance',
                data: [null, null, null, null, null, null, null,
                    null, 11164, 11218, 10077]
            }, {
                name: 'Other',
                data: [21908, 5548, 8105, 11248, 8989, 11816, 18274,
                    17300, 13053, 11906, 10073]
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

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\el_ma\OneDrive\Escritorio\tarea_solutoria\resources\views/main/principal.blade.php ENDPATH**/ ?>