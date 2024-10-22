<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<figure class="highcharts-figure">
    <div id="container"></div>
    <p class="highcharts-description">
        Chart designed to highlight 3D column chart rendering options.
        Move the sliders below to change the basic 3D settings for the chart.
        3D column charts are generally harder to read than 2D charts, but provide
        an interesting visual effect.
    </p>
    <div id="sliders">
        <table>
            <tr>
                <td><label for="alpha">Alpha Angle</label></td>
                <td><input id="alpha" type="range" min="0" max="45" value="15"/> <span id="alpha-value" class="value"></span></td>
            </tr>
            <tr>
                <td><label for="beta">Beta Angle</label></td>
                <td><input id="beta" type="range" min="-45" max="45" value="15"/> <span id="beta-value" class="value"></span></td>
            </tr>
            <tr>
                <td><label for="depth">Depth</label></td>
                <td><input id="depth" type="range" min="20" max="100" value="50"/> <span id="depth-value" class="value"></span></td>
            </tr>
        </table>
    </div>
</figure>

<script>
    // Set up the chart
const chart = new Highcharts.Chart({
    chart: {
        renderTo: 'container',
        type: 'column',
        options3d: {
            enabled: true,
            alpha: 15,
            beta: 15,
            depth: 50,
            viewDistance: 25
        }
    },
    xAxis: {

        
        categories: [
            <?php 
                foreach($productos as $producto){
                   
                ?>
                    '<?php echo $producto['nombre']; ?>',

                <?php
                
                }  
                ?>
        ]
    },
    yAxis: {
        title: {
            enabled: false
        }
    },
    tooltip: {
        headerFormat: '<b>{point.key}</b><br>',
        pointFormat: 'Cars sold: {point.y}'
    },
    title: {
        text: 'Sold passenger cars in Norway by brand, January 2021',
        align: 'left'
    },
    subtitle: {
        text: 'Source: ' +
            '<a href="https://ofv.no/registreringsstatistikk"' +
            'target="_blank">OFV</a>',
        align: 'left'
    },
    legend: {
        enabled: false
    },
    plotOptions: {
        column: {
            depth: 25
        }
    },
    series: [{
        data: [<?php 
                foreach($productos as $producto){
                   
                ?>
                    <?php echo $producto['precio']; ?>,

                <?php
                
                }  
                ?>],
        colorByPoint: true
    }]
});

function showValues() {
    document.getElementById(
        'alpha-value'
    ).innerHTML = chart.options.chart.options3d.alpha;
    document.getElementById(
        'beta-value'
    ).innerHTML = chart.options.chart.options3d.beta;
    document.getElementById(
        'depth-value'
    ).innerHTML = chart.options.chart.options3d.depth;
}

// Activate the sliders
document.querySelectorAll(
    '#sliders input'
).forEach(input => input.addEventListener('input', e => {
    chart.options.chart.options3d[e.target.id] = parseFloat(e.target.value);
    showValues();
    chart.redraw(false);
}));

showValues();

</script>