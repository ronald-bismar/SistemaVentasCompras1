<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<figure class="highcharts-figure">
    <div id="container"></div>
    <p class="highcharts-description">
        Muestra la informacion del stock de cada producto
    </p>
</figure>

<script>
Highcharts.chart('container', {
    chart: {
        type: 'pie'
    },
    title: {
        text: 'Estadistica de Compras'
    },
    tooltip: {
        valueSuffix: '%'
    },
    plotOptions: {
        series: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: [{
                enabled: true,
                distance: 20
            }, {
                enabled: true,
                distance: -40,
                format: '{point.percentage:.1f}%',
                style: {
                    fontSize: '1.2em',
                    textOutline: 'none',
                    opacity: 0.7
                },
                filter: {
                    operator: '>',
                    property: 'percentage',
                    value: 10
                }
            }]
        }
    },
    series: [
        {
            name: 'Porcentaje',
            colorByPoint: true,
            data: [
                <?php 
                foreach($compras as $compra){
                ?>
                {
                    name: '<?php echo $compra['nombre']; ?>',
                    y: <?php echo $compra['cantidad']; ?>
                },
                <?php
                }  
                ?>
            ]
        }
    ]
});



</script>