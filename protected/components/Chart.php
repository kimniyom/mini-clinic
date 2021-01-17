<?php

class Chart {

    function BarChart($chartid, $title, $subtitle, $text, $name, $data) {
        $chart = "<script type='text/javascript'>";
        $chart .= 'Highcharts.chart("' . $chartid . '", {
    chart: {
        type: "column"
    },
    title: {
        text: "' . $title . '"
    },
    credits: false,
    subtitle: {
        text: "' . $subtitle . '"
    },
    xAxis: {
        type: "category",
        labels: {
            rotation: -45,
            style: {
                fontSize: "13px",
                fontFamily: "Verdana, sans-serif"
            }
        }
    },
    yAxis: {
        min: 0,
        allowDecimals: false,
        title: {
            text: "' . $text . '"
        },
        labels: {
            formatter: function() {
                return this.value;
            },
        }
    },
    legend: {
        enabled: false
    },
    tooltip: {
        pointFormat: "'.$text.' <b>{point.y} </b>"
    },
    series: [{
        name: "' . $name . '",
        colorByPoint: true,
        data: [' . $data . '],
        dataLabels: {
            enabled: true,
            rotation: -90,
            color: "#FFFFFF",
            align: "right",
            format: "{point.y}", // one decimal
            y: 10, // 10 pixels down from the top
            style: {
                fontSize: "13px",
                fontFamily: "Verdana, sans-serif"
            }
        }
    }]
});';
        
$chart .= "</script>";
        return $chart;
    }

    function SplineChart($chartid, $title, $subtitle, $text, $name, $data) {
        $chart = "<script type='text/javascript'>";
        $chart .= 'Highcharts.chart("' . $chartid . '", {
    chart: {
        type: "spline"
    },
    title: {
        text: "' . $title . '"
    },
    credits: false,
    subtitle: {
        text: "' . $subtitle . '"
    },
    xAxis: {
        type: "category",
        labels: {
            rotation: -45,
            style: {
                fontSize: "13px",
                fontFamily: "Verdana, sans-serif"
            }
        }
    },

    yAxis: {
        min: 0,
        allowDecimals: false,
        title: {
            text: "' . $text . '"
        },
        labels: {
        formatter: function() {
            return this.value;
        }
    }
    },
    legend: {
        enabled: false
    },
    tooltip: {
        pointFormat: "'.$text.' <b>{point.y} </b>"
    },
    series: [{
        name: "' . $name . '",
        data: [' . $data . '],
        dataLabels: {
            enabled: true,
            rotation: 0,
            color: "#FFFFFF",
            align: "right",
            format: "{point.y}", // one decimal
            y: 10, // 10 pixels down from the top
            style: {
                fontSize: "13px",
                fontFamily: "Verdana, sans-serif"
            }
        }
    }]
});';
        
$chart .= "</script>";
        return $chart;
    }

}
