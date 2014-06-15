<script>
var chart;
$(function () {
    chart = new Highcharts.Chart({
        chart: {
        	renderTo: 'container',
            zoomType: 'x',
            type: 'spline'
        },
        title: {
            text: '<?php echo ucfirst($allocText).'e'; ?> Plätze in den Bibliotheken des KIT'
        },
        subtitle: {
            text: document.ontouchstart === undefined ?
                'Click and drag in the plot area to zoom in' :
                'Pinch the chart to zoom in'
        },
        xAxis: {
            type: 'datetime',
           	minRange: 3*3600000 // min half a day
        },
        yAxis: {
            title: {
                text: '<?php echo ucfirst($allocText)."e"; ?> Plätze [<?php echo ($_GET["type"] == "percent" ? "%" : "Plätze"); ?>]'
            },
            min: 0	
            <?php echo ($_GET["type"] == "percent" ? ", max: 100" : ""); ?>        
        },
        tooltip: {
            valueSuffix: '<?php echo ($_GET["type"] == "percent" ? "% ".$allocText : " ".$allocText."e Plätze");?>'
        },
        legend: {
            borderRadius: 0,
            enabled: true,
            margin: 30,
            itemMarginTop: 2,
            itemMarginBottom: 2,
            width: 960,
            itemWidth:320,
            itemStyle: {
              width:280
            }
        },
        plotOptions: {
            series: {
                marker: {
                    enabled: false
                }
            }
        },
        rangeSelector: {
	    	enabled: true,
	    	buttons: [{
                type: 'day',
                count: 1,
                text: '1 Tag'
            },{
                type: 'day',
                count: 3,
                text: '3 Tage'
            }, {
                type: 'week',
                count: 1,
                text: '1 Woche'
            }, {
                type: 'month',
                count: 1,
                text: '1 Monat'
            }, {
                type: 'month',
                count: 6,
                text: '6 Monate'
            }, {
                type: 'year',
                count: 1,
                text: '1 Jahr'
            }, {
                type: 'all',
                text: 'Alles'
            }],
            buttonTheme: { // styles for the buttons
                fill: 'none',
                stroke: 'none',
                style: {
                    color: '#039',
                    fontWeight: '400',
                    fontSize:'.8em'
                },
                states: {
                    hover: {
                        fill: 'white'
                    },
                    select: {
                        style: {
                            color: 'green'
                        }
                    }
                },
                width: null,
                padding: 2
            },
            inputStyle: {
                color: '#039',
                fontWeight: 'bold'
            },
            labelStyle: {
                color: 'silver',
                fontWeight: 'bold'
            },
            selected: 0
	    },

        series: [{
            name: 'KIT-Bib Lehrbuchsammlung (EG/1.OG)',
            
            data: [<?php echo $dataLBSstring ?>]
        },{
            name: 'Fachbibliothek Informatik',
            
            data: [<?php echo $dataFBIstring ?>]
        },{
            name: 'Mathematische Bibliothek',
            
            data: [<?php echo $dataFBMstring ?>]
        },{
            name: 'KIT-Bib Lesesaal WiWi. und Info. (1.OG)',
            
            data: [<?php echo $dataLSWstring ?>]
        },{
            name: 'Fachbibliothek Chemie',
            
            data: [<?php echo $dataFBCstring ?>]
        },{
            name: 'TheaBib im bad. Staatstheater',
            
            data: [<?php echo $dataTheaBibstring ?>]
        },{
            name: 'KIT-Bib Lesesaal Technik (2.OG)',
            
            data: [<?php echo $dataLSTstring ?>]
        },{
            name: 'Fachbibliothek Physik',
            
            data: [<?php echo $dataFBPstring ?>]
        },{
            name: 'Fachbibliothek Hochschule Karlsruhe',
            
            data: [<?php echo $dataFBHstring ?>]
        },{
            name: 'KIT-Bib Lesesaal Naturwissen. (2.OG)',
            
            data: [<?php echo $dataLSNstring ?>]
        },{
            name: 'Fakultätsbibliothek Architektur',
            
            data: [<?php echo $dataFBAstring ?>]
        },{
            name: 'KIT-Bib Campus Nord',
            
            data: [<?php echo $dataBIBNstring ?>]
        },{
            name: 'KIT-Bib Lesesaal Geisteswissen (3.OG)',
            
            data: [<?php echo $dataLSGstring ?>]
        },{
            name: 'Fakultätsbibliothek WiWi',
            
            data: [<?php echo $dataFBWstring ?>]
        }]
    });
});

function showGraphs(array){
	var i = 0;
	while(i < chart.series.length){
		if( jQuery.inArray(i, array) != -1){
			chart.series[i].show();
		}else{
			chart.series[i].hide();
		}
		i++;
	}	
}

function showRows(array){
    for (var i = 0; i < 15; i ++) {
        if( jQuery.inArray(i, array) != -1){
            $('tr#'+i).show();
        }else{
            $('tr#'+i).hide();
        }        
    };
}

$(document).ready(function(){
  	$('select').on('change', function (e) {
	    var optionSelected = $("option:selected", this);
        var value = this.value;
        if(value.substr(value.length - 1) == 'P'){
            value = value.slice(0,-1) + '&type=percent';
        }
	    window.location.href = window.location.pathname + '?alloc=' + value;
	});

	$('#onlyBib').click(function() {
		showGraphs([0,3,6,9,12]);
        showRows([0,1,2,3,4]);
	});

	$('#onlyFak').click(function() {
		showGraphs([1,2,4,7,10,13]);
        showRows([5,6,7,8,9,10]);
	});

	$('#others').click(function() {
		showGraphs([5,8,11]);
        showRows([11,12,13]);
	});

	$('#all').click(function() {
		showGraphs([0,1,2,3,4,5,6,7,8,9,10,11,12,13]);
        showRows([0,1,2,3,4,5,6,7,8,9,10,11,12,13]);
	});

    $('#none').click(function() {
        showGraphs([]);
        showRows([]);
    });
});
</script>