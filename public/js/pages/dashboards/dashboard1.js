/*
Template Name: Admin Pro Admin
Author: Wrappixel
Email: niravjoshi87@gmail.com
File: js
*/
$(function() {
    "use strict";

    // ============================================================== 
    // sales ratio
    // ============================================================== 
    var chart = new Chartist.Line('#chartA', {
        labels: ['2019', '2018','2017', '2016', '2015', '2014', '2013', '2012', '2011','2010'],
        series: [
            [10, 20, 50, 20, 17, 10, 40, 100,40,50,10],
            [10, 80, 20, 70, 30, 40, 10, 100,10,50,10]
        ]
    }, {
        high: 100,
        low: 10,
        showArea: true,
        fullWidth: true,
        plugins: [
            Chartist.plugins.tooltip()
        ], // As this is axis specific we need to tell Chartist to use whole numbers only on the concerned axis
        axisY: {
            onlyInteger: true,
            offset: 30,
            labelInterpolationFnc: function(value) {
                return (value / 1) ;
            }
        },
    });

    // Offset x1 a tiny amount so that the straight stroke gets a bounding box
    // Straight lines don't get a bounding box 
    // Last remark on -> http://www.w3.org/TR/SVG11/coords.html#ObjectBoundingBox
    chart.on('draw', function(ctx) {
        if (ctx.type === 'area') {
            ctx.element.attr({
                x1: ctx.x1 + 0.001
            });
        }
    });

    // Create the gradient definition on created event (always after chart re-render)
    chart.on('created', function(ctx) {
        var defs = ctx.svg.elem('defs');
        defs.elem('linearGradient', {
            id: 'gradient',
            x1: 0,
            y1: 1,
            x2: 0,
            y2: 0
        }).elem('stop', {
            offset: 0,
            'stop-color': '#2ddeff'
        }).parent().elem('stop', {
            offset: 1,
            'stop-color': '#7f9bff'
        });
    });


    var chartB = new Chartist.Line('#chartB', {
        labels: ['2019', '2018','2017', '2016', '2015', '2014', '2013', '2012', '2011','2010'],
        series: [
            [10, 20, 50, 20, 17, 10, 40, 100,40,50,10],
            [10, 80, 20, 70, 30, 40, 10, 100,10,50,10]
        ]
    }, {
        high: 100,
        low: 10,
        showArea: true,
        fullWidth: true,
        plugins: [
            Chartist.plugins.tooltip()
        ], // As this is axis specific we need to tell Chartist to use whole numbers only on the concerned axis
        axisY: {
            onlyInteger: true,
            offset: 30,
            labelInterpolationFnc: function(value) {
                return (value / 1);
            }
        }
    });

    // Offset x1 a tiny amount so that the straight stroke gets a bounding box
    // Straight lines don't get a bounding box
    // Last remark on -> http://www.w3.org/TR/SVG11/coords.html#ObjectBoundingBox
    chartB.on('draw', function(ctx) {
        if (ctx.type === 'area') {
            ctx.element.attr({
                x1: ctx.x1 + 0.001
            });
        }
    });

    // Create the gradient definition on created event (always after chart re-render)
    chartB.on('created', function(ctx) {
        var defs = ctx.svg.elem('defs');
        defs.elem('linearGradient', {
            id: 'gradient',
            x1: 0,
            y1: 1,
            x2: 0,
            y2: 0
        }).elem('stop', {
            offset: 0,
            'stop-color': '#2ddeff'
        }).parent().elem('stop', {
            offset: 1,
            'stop-color': '#7f9bff'
        });
    });



    var chart = [chart];
    var chartB = [chartB];

    var sparklineLogin = function() {
        $('.spark-count').sparkline([2019, 5, 0, 10, 9, 12, 4, 9, 4, 5, 3, 10, 9, 12, 10, 9], {
            type: 'bar',
            width: '100%',
            height: '70',
            barWidth: '2',
            resize: true,
            barSpacing: '6',
            barColor: '#a880fa'
        });

        $('.spark-count2').sparkline([20, 40, 30], {
            type: 'pie',
            height: '80',
            resize: true,
            sliceColors: ['#f370b0', '#a77ff9', '#f6d22f']
        });
    }
    var sparkResize;

    sparklineLogin();
});