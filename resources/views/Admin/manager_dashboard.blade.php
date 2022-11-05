@extends('master')
@section('title', 'Dashboard')
@section('content')

<style>

</style>
<div class="content">
    <div class="row">
            <div class="col-xl-3 col-lg-6">
                <div class="card card-stats mb-4">
                    <div class="card-body">
                        <p class="mt-1 mb-0 text-success font-weight-normal text-sm">
                        <span>Total Inventory</span>
                        </p>
                        <div class="row mt-2">
                            <div class="col">
                            <span class="h3 font-weight-normal mb-0 text-info" style="font-size: 20px;">{{$total_inventory}}  @lang('lang.ks')</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape text-white rounded-circle shadow" style="background-color:#473C70;">
                                <i class="fas fa-hand-holding-usd"></i>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6">
                <div class="card card-stats mb-4 mb-xl-0">
                    <div class="card-body">
                         <p class="mt-1 mb-0 text-success font-weight-normal text-sm">
                        <span>Total Receivable</span>
                        </p>
                        <div class="row mt-2">
                            <div class="col">
                                <span class="h3 font-weight-normal mb-0 text-info" style="font-size: 20px;">{{$total_receivable}} @lang('lang.ks')</span>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape text-white rounded-circle shadow" style="background-color:#473C70;">
                                    <i class="fas fa-hand-holding-usd"></i>
                                </div>
                            </div>
                        </div>
                       
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6">
                <div class="card card-stats mb-4 mb-xl-0">
                    <div class="card-body">
                        <p class="mt-1 mb-0 text-success font-weight-normal text-sm">
                        <span>Total Payable</span>
                        </p>
                        <div class="row mt-2">
                            <div class="col">
                                <span class="h2 font-weight-normal mb-0 text-info" style="font-size: 20px;">{{$total_payable}} @lang('lang.ks')</span>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape text-white rounded-circle shadow" style="background-color:#473C70;">
                                    <i class="fas fa-hand-holding-usd"></i>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6">
                <div class="card card-stats mb-4 mb-xl-0">
                    <div class="card-body">
                        <p class="mt-1 mb-0 text-success font-weight-normal text-sm">
                        <span>Total Cash/Bank</span>
                        </p>
                        <div class="row mt-2">
                            <div class="col">
                            <span class="h3 font-weight-normal mb-0 text-info" style="font-size: 20px;">{{$total_cash}} @lang('lang.ks')</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape text-white rounded-circle shadow" style="background-color:#473C70;">
                                <i class="fas fa-hand-holding-usd"></i>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
    </div>

    <div class="row md-12">
		<div class="col-md-4">
            <div class="card card-stats mb-4" >
                <div class="card-body font-weight-bold">
                    <h5>Today Status</h5>
                    <div class="row mt-5" style="margin-top:20px">
                        <div class="col-md-8">
                            Total Sales
                        </div>
                        <div class="col-md-4">
                            {{$daily_sales_count}} ({{$daily_sales_amt}} Ks)
                        </div>
                    </div>
                    <div class="row mt-5" style="margin-top:20px">
                        <div class="col-md-8">
                            Total Order
                        </div>  
                        <div class="col-md-4">
                            {{$daily_order_count}} ({{$daily_order_amt}} Ks)
                        </div>
                    </div>
                    <div class="row mt-5" style="margin-top:20px">
                        <div class="col-md-8">
                            Total Factory Order
                        </div>
                        <div class="col-md-4">
                           {{$daily_factoryorder_count}} ({{$daily_factoryorder_itemcount}} Items)
                        </div>
                    </div>
                    
                    <div class="row mt-5" style="margin-top:20px">
                        <div class="col-md-8">
                            Total Factory PO
                        </div>
                        <div class="col-md-4" id="testcolor">
                            {{$daily_factorypo_count}} ({{$daily_factorypo_itemcount}} Items)
                        </div>
                    </div>
                    
                    <div class="row mt-5" style="margin-top:20px">
                        <div class="col-md-8">
                            Total Purchase
                        </div>
                        <div class="col-md-4" id="testcolor">
                            {{$daily_purchase_count}} ({{$daily_purchase_amt}} Ks)
                        </div>
                    </div>
                    
                    <div class="row mt-5" style="margin-top:20px">
                        <div class="col-md-8">
                            Total Transaction
                        </div>
                        <div class="col-md-4" id="testcolor">
                            {{$daily_transaction_count}} ({{$daily_transaction_amt}} Ks)
                        </div>
                    </div>
                    
                </div>
            </div>
		</div>
        

        <div class="col-md-8">
        <div class="card">
            
            <div class="row ml-1">
                <div class="col-md-3 mt-2">
                    <label style="color:rgb(34, 190, 241)" class="pl-4 ml-3 pt-2 font-weight-bold  ">Data Type</label>
                    <select class="form-control rounded border border-primary" id="data_type" style="font-size: 12px;" onchange="">
                    <option>Type</option>
                        <option value="1">All</option>
                        <option value="2">Sales</option>
                        <option value="3">Order</option>
                    </select>
                </div>
                
                <div class="col-md-3 mt-2 st_week" style="padding-left:50">
                    <label style="color:rgb(34, 190, 241)" class="pl-4 ml-2 pt-2 font-weight-bold  ">Week</label>
                    <input type="week" name="receive_week" id="receive_week" class="border border-outline border-primary pl-3 pr-3 pt-2 pb-2 ml-1" style="border-radius: 7px;" onchange="getweek(this.value)">
                </div>
                
                <div class="col-md-3 mt-2 st_month">
                    <label style="color:rgb(34, 190, 241)" class="pl-4 ml-3 pt-2 font-weight-bold  ">Month</label>
                    <input type="month" name="receive_month" id="receive_month" class="border border-outline border-primary pl-3 pr-3 pt-2 pb-2" style="border-radius: 7px;" onchange="getmonth(this.value)">
                </div>
                
            </div>
            
            <div class="main">
                <canvas id="lineChart"></canvas>
            </div>
        </div>
        </div>

	</div>
	
	<div class="row md-12">
	    
	    <div class="col-md-6">
        <div class="card">
            
            <div class="row ml-1">
                <div class="col-md-3 mt-2">
                    <label style="color:rgb(34, 190, 241)" class="pl-4 ml-3 pt-2 font-weight-bold  ">Data Type</label>
                    <select class="form-control rounded border border-primary" id="data_type" style="font-size: 12px;" onchange="search_compare_data(this.value)">
                    <option>Type</option>
                        <option value="1">Order Fulfillment</option>
                        <option value="2">Cash Collection</option>
                        <option value="3">Supplier Repayment</option>
                        <option value="4">Inventory Level</option>
                    </select>
                </div>
                
            </div>
            
            <div class="main">
                <canvas id="barChart"></canvas>
            </div>
        </div>
        </div>
	    
	    
		<div class="col-md-6">
		   <div class="card">
            <div class="col-md-3 mt-2">
                                
                <label class="control-label text-success font-weight-bold">@lang('lang.monthly')</label>
                <select class="form-control custom-select" id="monthly">
                    <option value="">@lang('lang.select_month')</option>
                    <option value="01">January</option>
                    <option value="02">February</option>
                    <option value="03">March</option>
                    <option value="04">April</option>
                    <option value="05">May</option>
                    <option value="06">June</option>
                    <option value="07">July</option>
                    <option value="08">August</option>
                    <option value="09">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                </select>
                    
            </div>
            
            <div class="main">
                <canvas id="pieChart"></canvas>
            </div>
            
          </div>
		</div>
        

        

	</div>
    <input type="hidden" id="total_sales" value="{{$total_sales}}">
   <input type="hidden" id="total_order" value="{{$total_order}}">
   <input type="hidden" id="total_profit" value="{{$total_profit}}">
   <input type="hidden" id="total_purchase" value="{{$total_purchase}}">
   <input type="hidden" id="total_transaction" value="{{$total_transaction}}">
   <input type="hidden" id="other_income" value="{{$other_income}}">
   <input type="hidden" id="other_expense" value="{{$other_expense}}">

                

</div>



@endsection

@section('js')

<script>

    $('#slimtest1').slimScroll({
        height: '400px'
    });

    $('#slimtest2').slimScroll({
        height: '400px'
    });
    
    $(document).ready(function(){
        $.ajax({
           type:'POST',
           url:'/getOrderFullfill',
           dataType:'json',
           data:{
                "_token": "{{ csrf_token() }}",
            },

           success:function(data){
               console.log(data);
            //    alert(data.f_done);
            //    begin chart
              
              
              
              
            var canvas = document.getElementById("barChart");
            var ctx = canvas.getContext("2d");

// Global Options:
                Chart.defaults.global.defaultFontColor = "#2097e1";
                Chart.defaults.global.defaultFontSize = 11;

                // Data with datasets options
                var data = {
                    labels: [
                        "January",
                        "Febuary",
                        "March",
                        "April",
                        "May",
                        "June",
                        "July",
                        "August",
                        "September",
                        "October",
                        "November",
                        "December",
                    ],
                    datasets: [
                        {
                            label: "Incoming Order",
                            fill: false,
                            backgroundColor: 'rgba(54,162,235,0.6)',
                                
                            data: [data.jan_income,data.feb_income,data.mar_income,data.apr_income,data.may_income,data.jun_income,data.jul_income,data.aug_income,data.sep_income,data.oct_income,data.nov_income,data.dec_income]
                        },
                        {
                            label: "Delivered Order",
                            fill: false,
                            backgroundColor: 'rgba(255,99,132,0.6)',
                            data: [data.jan_deliver,data.feb_deliver,data.mar_deliver,data.apr_deliver,data.may_deliver,data.jun_deliver,data.jul_deliver,data.aug_deliver,data.sep_deliver,data.oct_deliver,data.nov_deliver,data.dec_deliver]
                        }
                    ]
                };

        //         // Notice how nested the beginAtZero is
                var options = {
                    title: {
                        display: true,
                        text: "Monthly Order Fulfillment",
                        position: "top",
                        fontSize: 20
                    },
                    scales: {
                        xAxes: [
                            {
                                gridLines: {
                                    display: true,
                                    drawBorder: true,
                                    drawOnChartArea: false
                                }
                            }
                        ],
                        yAxes: [
                            {
                                ticks: {
                                    precision: 0
                                    // beginAtZero: true
                                }
                            }
                        ]
                    }
                };

        //         // added custom plugin to wrap label to new line when \n escape sequence appear
                var labelWrap = [
                    {
                        beforeInit: function (chart) {
                            chart.data.labels.forEach(function (e, i, a) {
                                if (/\n/.test(e)) {
                                    a[i] = e.split(/\n/);
                                }
                            });
                        }
                    }
                ];

        //         // Chart declaration:
                var myBarChart = new Chart(ctx, {
                    type: 'bar',
                    data: data,
                    options: options,
                    plugins: labelWrap
                });

        //     // end chart
           }
        });
        
        $.ajax({
           type:'POST',
           url:'/getMonth',
           dataType:'json',
           data:{
                "_token": "{{ csrf_token() }}",
                "receive_month":'2022-06',
            },

           success:function(data){
               console.log(data);
            //    alert(data.f_done);
            //    begin chart
              var first_week_salesamt = data.first_week_salesamt;
              var second_week_salesamt = data.second_week_salesamt;
              var third_week_salesamt = data.third_week_salesamt;
              var fourth_week_salesamt = data.fourth_week_salesamt;
              var first_week_ordersamt = data.first_week_ordersamt;
              var second_week_ordersamt = data.second_week_ordersamt;
              var third_week_ordersamt = data.third_week_ordersamt;
              var fourth_week_ordersamt = data.fourth_week_ordersamt;
              
              
              
            var canvas = document.getElementById("lineChart");
            var ctx = canvas.getContext("2d");

// Global Options:
                Chart.defaults.global.defaultFontColor = "#2097e1";
                Chart.defaults.global.defaultFontSize = 11;

                // Data with datasets options
                var data = {
                    labels: [
                        "First Week",
                        "Second Week",
                        "Third Week",
                        "Last Week",
                        
                    ],
                    datasets: [
                        {
                            label: "Sales Revenues",
                            fill: false,
                            backgroundColor:'rgba(75,192,192,0.6)',
                            data: [first_week_salesamt, second_week_salesamt, third_week_salesamt, fourth_week_salesamt]
                        },
                        {
                            label: "Orders Revenues",
                            fill: false,
                            backgroundColor: 'rgba(153,102,255,0.6)',
                            data: [first_week_ordersamt, second_week_ordersamt, third_week_ordersamt, fourth_week_ordersamt]
                        }
                    ]
                };

        //         // Notice how nested the beginAtZero is
                var options = {
                    title: {
                        display: true,
                        text: "Monthly Sales and Orders Revenues",
                        position: "top",
                        fontSize: 20
                    },
                    scales: {
                        xAxes: [
                            {
                                gridLines: {
                                    display: true,
                                    drawBorder: true,
                                    drawOnChartArea: false
                                }
                            }
                        ],
                        yAxes: [
                            {
                                ticks: {
                                    precision: 0
                                    // beginAtZero: true
                                }
                            }
                        ]
                    }
                };

        //         // added custom plugin to wrap label to new line when \n escape sequence appear
                var labelWrap = [
                    {
                        beforeInit: function (chart) {
                            chart.data.labels.forEach(function (e, i, a) {
                                if (/\n/.test(e)) {
                                    a[i] = e.split(/\n/);
                                }
                            });
                        }
                    }
                ];

        //         // Chart declaration:
                var myLineChart = new Chart(ctx, {
                    type: 'bar',
                    data: data,
                    options: options,
                    plugins: labelWrap
                });

        //     // end chart
           }
        });
        
        var total_sales = parseInt($('#total_sales').val());
        var total_order = parseInt($('#total_order').val());
        var total_profit = parseInt($('#total_profit').val());
        var total_purchase = parseInt($('#total_purchase').val());
        var total_transaction = parseInt($('#total_transaction').val());
        var other_income = parseInt($('#other_income').val());
        var other_expense = parseInt($('#other_expense').val());
        
        console.log(total_sales,total_order,total_profit,total_purchase,total_transaction,other_income,other_expense);
        
        var inv = total_sales - total_profit ;
                
                var inv_percent = (inv / total_sales) * 100;
                
                var total_profit_percent = (total_profit / total_sales) *100;

                var net_profit = (total_profit + other_income + total_transaction) - (other_expense-total_purchase);
                
                
                
                var income_total = total_sales + other_income+total_transaction;
                
                var total_sales_percent =  (total_sales / income_total) * 100;
                
                //var order_money_percent = (data.total_order/income_total) * 100;
                
                var other_inc_percent = (other_income / income_total) * 100;
                
                var other_exp_percent = (other_expense / income_total) * 100;
                
                var order_trans_percent = (total_transaction / income_total) *100;
                
                var raw_purchase_percent = (total_purchase/income_total) * 100;
                
                
                var net_profit_percent = (net_profit / income_total) *100;
                
                var canvas = document.getElementById("pieChart");
            var ctx = canvas.getContext("2d");

// Global Options:
                Chart.defaults.global.defaultFontColor = "#2097e1";
                Chart.defaults.global.defaultFontSize = 11;

                // Data with datasets options
                var data = {
                    labels: [
                        "Total Sales (" + total_sales + " Ks)",
                        "COGS (" + inv + " Ks)",
                        "Total Profit (" + total_profit + " Ks)",
                        "Total Transaction (" + total_transaction + " KS)",
                        "Total Purchase (" + total_purchase + " Ks)",
                        "Other Income (" + other_income + " Ks)",
                        "Other Expense (" + other_expense + " Ks)",
                        "Net Profit (" + net_profit + " Ks)"
                    ],
                    datasets: [
                        {
                            label: "Monthly Total Income(" + income_total + "Ks)",
                            fill: false,
                            backgroundColor: [
        
                                'rgba(255,99,132,0.6)',
                                'rgba(54,162,235,0.6)',
                                'rgba(255,206,86,0.6)',
                                'rgba(75,192,192,0.6)',
                                'rgba(153,102,255,0.6)',
                                'rgba(255,159,64,0.6)',
                                'rgba(255,99,132,0.6)',
                                'rgba(255,79,152,0.6)',
                                'rgba(45,50,77,0.6)'
                        
                            ],
                            data: [total_sales_percent.toFixed(2),inv_percent.toFixed(2),total_profit_percent.toFixed(2),order_trans_percent.toFixed(2),raw_purchase_percent.toFixed(2),other_inc_percent.toFixed(2),other_exp_percent.toFixed(2),net_profit_percent.toFixed(2)]
                        }
                    ]
                };

        //         // Notice how nested the beginAtZero is
                var options = {
                    title: {
                        display: true,
                        text: "Profit and Loss",
                        position: "top",
                        fontSize: 20
                    },
                    legend:{
                        position: 'right'
                    },
                    scales: {
                        xAxes: [
                            {
                                gridLines: {
                                    display: true,
                                    drawBorder: true,
                                    drawOnChartArea: false
                                }
                            }
                        ],
                        yAxes: [
                            {
                                ticks: {
                                    precision: 0
                                    // beginAtZero: true
                                }
                            }
                        ]
                    }
                };

        //         // added custom plugin to wrap label to new line when \n escape sequence appear
                var labelWrap = [
                    {
                        beforeInit: function (chart) {
                            chart.data.labels.forEach(function (e, i, a) {
                                if (/\n/.test(e)) {
                                    a[i] = e.split(/\n/);
                                }
                            });
                        }
                    }
                ];

        //         // Chart declaration:
                var myLineChart = new Chart(ctx, {
                    type: 'pie',
                    data: data,
                    options: options,
                    plugins: labelWrap
                });

        
        
    })
    
    function search_compare_data(value)
{
    // alert(value);
    if(value ==1)
    { 
        // alert("two");
        
        
        $.ajax({
           type:'POST',
           url:'/getOrderFullfill',
           dataType:'json',
           data:{
                "_token": "{{ csrf_token() }}",
            },

           success:function(data){
               console.log(data);
            //    alert(data.f_done);
            //    begin chart
              
              
              
              
            var canvas = document.getElementById("barChart");
            var ctx = canvas.getContext("2d");

// Global Options:
                Chart.defaults.global.defaultFontColor = "#2097e1";
                Chart.defaults.global.defaultFontSize = 11;

                // Data with datasets options
                var data = {
                    labels: [
                        "January",
                        "Febuary",
                        "March",
                        "April",
                        "May",
                        "June",
                        "July",
                        "August",
                        "September",
                        "October",
                        "November",
                        "December",
                    ],
                    datasets: [
                        {
                            label: "Incoming Order",
                            fill: false,
                            backgroundColor: "#2097e1",
                            data: [data.jan_income,data.feb_income,data.mar_income,data.apr_income,data.may_income,data.jun_income,data.jul_income,data.aug_income,data.sep_income,data.oct_income,data.nov_income,data.dec_income]
                        },
                        {
                            label: "Delivered Order",
                            fill: false,
                            backgroundColor: "#bdd9e6",
                            data: [data.jan_deliver,data.feb_deliver,data.mar_deliver,data.apr_deliver,data.may_deliver,data.jun_deliver,data.jul_deliver,data.aug_deliver,data.sep_deliver,data.oct_deliver,data.nov_deliver,data.dec_deliver]
                        }
                    ]
                };

        //         // Notice how nested the beginAtZero is
                var options = {
                    title: {
                        display: true,
                        text: "Monthly Order Fulfillment",
                        position: "top"
                    },
                    scales: {
                        xAxes: [
                            {
                                gridLines: {
                                    display: true,
                                    drawBorder: true,
                                    drawOnChartArea: false
                                }
                            }
                        ],
                        yAxes: [
                            {
                                ticks: {
                                    precision: 0
                                    // beginAtZero: true
                                }
                            }
                        ]
                    }
                };

        //         // added custom plugin to wrap label to new line when \n escape sequence appear
                var labelWrap = [
                    {
                        beforeInit: function (chart) {
                            chart.data.labels.forEach(function (e, i, a) {
                                if (/\n/.test(e)) {
                                    a[i] = e.split(/\n/);
                                }
                            });
                        }
                    }
                ];

        //         // Chart declaration:
                var myBarChart = new Chart(ctx, {
                    type: 'bar',
                    data: data,
                    options: options,
                    plugins: labelWrap
                });

        //     // end chart
           }
        });
        
    } else if(value ==2)
    { 
        // alert("two");
        
       
        $.ajax({
           type:'POST',
           url:'/getCashCollect',
           dataType:'json',
           data:{
                "_token": "{{ csrf_token() }}",
            },

           success:function(data){
               console.log(data);
            //    alert(data.f_done);
            //    begin chart
              
              
              
              
            var canvas = document.getElementById("barChart");
            var ctx = canvas.getContext("2d");

// Global Options:
                Chart.defaults.global.defaultFontColor = "#2097e1";
                Chart.defaults.global.defaultFontSize = 11;

                // Data with datasets options
                var data = {
                    labels: [
                        "January",
                        "Febuary",
                        "March",
                        "April",
                        "May",
                        "June",
                        "July",
                        "August",
                        "September",
                        "October",
                        "November",
                        "December",
                    ],
                    datasets: [
                        {
                            label: "Order Amount",
                            fill: false,
                            backgroundColor: "#2097e1",
                            data: [data.jan_order_cash,data.feb_order_cash,data.mar_order_cash,data.apr_order_cash,data.may_order_cash,data.jun_order_cash,data.jul_order_cash,data.aug_order_cash,data.sep_order_cash,data.oct_order_cash,data.nov_order_cash,data.dec_order_cash,]
                        },
                        {
                            label: "Transaction Amount",
                            fill: false,
                            backgroundColor: "#bdd9e6",
                            data: [data.jan_tran_amt,data.feb_tran_amt,data.mar_tran_amt,data.apr_tran_amt,data.may_tran_amt,data.jun_tran_amt,data.jul_tran_amt,data.aug_tran_amt,data.sep_tran_amt,data.oct_tran_amt,data.nov_tran_amt,data.dec_tran_amt,]
                        }
                    ]
                };

        //         // Notice how nested the beginAtZero is
                var options = {
                    title: {
                        display: true,
                        text: "Monthly Cash Collection",
                        position: "top"
                    },
                    scales: {
                        xAxes: [
                            {
                                gridLines: {
                                    display: true,
                                    drawBorder: true,
                                    drawOnChartArea: false
                                }
                            }
                        ],
                        yAxes: [
                            {
                                ticks: {
                                    precision: 0
                                    // beginAtZero: true
                                }
                            }
                        ]
                    }
                };

        //         // added custom plugin to wrap label to new line when \n escape sequence appear
                var labelWrap = [
                    {
                        beforeInit: function (chart) {
                            chart.data.labels.forEach(function (e, i, a) {
                                if (/\n/.test(e)) {
                                    a[i] = e.split(/\n/);
                                }
                            });
                        }
                    }
                ];

        //         // Chart declaration:
                var myBarChart = new Chart(ctx, {
                    type: 'bar',
                    data: data,
                    options: options,
                    plugins: labelWrap
                });

        //     // end chart
           }
        });
        
    }else if(value ==3)
    { 
        // alert("two");
        
       
        $.ajax({
           type:'POST',
           url:'/getSupplierRepayment',
           dataType:'json',
           data:{
                "_token": "{{ csrf_token() }}",
            },

           success:function(data){
               console.log(data);
            //    alert(data.f_done);
            //    begin chart
              
              
              
              
            var canvas = document.getElementById("barChart");
            var ctx = canvas.getContext("2d");

// Global Options:
                Chart.defaults.global.defaultFontColor = "#2097e1";
                Chart.defaults.global.defaultFontSize = 11;

                // Data with datasets options
                var data = {
                    labels: [
                        "January",
                        "Febuary",
                        "March",
                        "April",
                        "May",
                        "June",
                        "July",
                        "August",
                        "September",
                        "October",
                        "November",
                        "December",
                    ],
                    datasets: [
                        {
                            label: "Purchase Amount",
                            fill: false,
                            backgroundColor: "#2097e1",
                            data: [data.jan_purchase_amt,data.feb_purchase_amt,data.mar_purchase_amt,data.apr_purchase_amt,data.may_purchase_amt,data.jun_purchase_amt,data.jul_purchase_amt,data.aug_purchase_amt,data.sep_purchase_amt,data.oct_purchase_amt,data.nov_purchase_amt,data.dec_purchase_amt]
                        },
                        {
                            label: "Credit Repayment Amount",
                            fill: false,
                            backgroundColor: "#bdd9e6",
                            data: [data.jan_paycredit_amt,data.feb_paycredit_amt,data.mar_paycredit_amt,data.apr_paycredit_amt,data.may_paycredit_amt,data.jun_paycredit_amt,data.jul_paycredit_amt,data.aug_paycredit_amt,data.sep_paycredit_amt,data.oct_paycredit_amt,data.nov_paycredit_amt,data.dec_paycredit_amt]
                        }
                    ]
                };

        //         // Notice how nested the beginAtZero is
                var options = {
                    title: {
                        display: true,
                        text: "Monthly Supplier Repayment",
                        position: "top",
                        fontSize: 20
                    },
                    scales: {
                        xAxes: [
                            {
                                gridLines: {
                                    display: true,
                                    drawBorder: true,
                                    drawOnChartArea: false
                                }
                            }
                        ],
                        yAxes: [
                            {
                                ticks: {
                                    precision: 0
                                    // beginAtZero: true
                                }
                            }
                        ]
                    }
                };

        //         // added custom plugin to wrap label to new line when \n escape sequence appear
                var labelWrap = [
                    {
                        beforeInit: function (chart) {
                            chart.data.labels.forEach(function (e, i, a) {
                                if (/\n/.test(e)) {
                                    a[i] = e.split(/\n/);
                                }
                            });
                        }
                    }
                ];

        //         // Chart declaration:
                var myBarChart = new Chart(ctx, {
                    type: 'bar',
                    data: data,
                    options: options,
                    plugins: labelWrap
                });

        //     // end chart
           }
        });
        
    }
    
}

    
    
    // var canvas = document.getElementById("barChart");
    // var ctx = canvas.getContext("2d");
    
    // Chart.defaults.global.defaultFontFamily = 'Lato';
    // Chart.defaults.global.defaultFontSize = 18;
    // Chart.defaults.global.defaultFontColor = '#777';
    
    // var testChart = new Chart(ctx,{
    //      type: 'bar',
    //      data: {
    //          labels: ['Boston','Worcester','Springfield','Lowell','Cambridge','New Bedford'],
    //          datasets: [{
    //              label: 'Sale',
    //              data: [
    //                 617594,181045,153060,106519,105162,95072     
    //             ],
    //             backgroundColor: 'blue',
    //             borderWidth: 1,
    //             borderColor: '#777',
    //             hoverBorderWidth: 3,
    //             hoverBorderColor: '#000'
    //          },
    //          {
    //              label: 'Order',
    //              data: [
    //                 817594,381045,353060,306519,305162,205072     
    //             ],
    //             backgroundColor: 'red',
    //             borderWidth: 1,
    //             borderColor: '#777',
    //             hoverBorderWidth: 3,
    //             hoverBorderColor: '#000'
    //          }],
             
    //      },
    //      options: {
    //          title: {
    //              display: true,
    //              text: 'City Population',
    //              position: 'top'
    //          },
    //          legend:{
    //              display: true,
    //              position: 'right',
    //              labels:{
    //                  fontColor:'#000'
    //              }
    //          },
    //          layout:{
    //              padding: {
    //                  left: 10,
    //                  right: 0,
    //                  bottom: 0,
    //                  top: 0
    //              }
    //          },
    //          tooltips:{
    //              enable:false
    //          }
    //      }
    // });
    
    function getweek(week)
    {

        $.ajax({
           type:'POST',
           url:'/getWeek',
           dataType:'json',
           data:{
                "_token": "{{ csrf_token() }}",
                "receive_week":week,
                
            },

           success:function(data){

              var canvas = document.getElementById("lineChart");
            var ctx = canvas.getContext("2d");

// Global Options:
                Chart.defaults.global.defaultFontColor = "#2097e1";
                Chart.defaults.global.defaultFontSize = 11;

                // Data with datasets options
                var data = {
                    labels: [
                        data.first_day,
                        data.second_day,
                        data.third_day,
                        data.fourth_day,
                        data.fifth_day,
                        data.sixth_day,
                        data.seventh_day
                        
                    ],
                    datasets: [
                        {
                            label: "Sales Reveneus",
                            fill: true,
                            backgroundColor: 'rgba(75,192,192,0.6)',
                            data: [data.firstday_sales_amt,data.secondday_sales_amt,data.thirdday_sales_amt,data.fourthday_sales_amt,data.fifthday_sales_amt,data.sixthday_sales_amt,data.seventhday_sales_amt]
                        },
                        {
                            label: "Order Revenues",
                            fill: true,
                            backgroundColor: 'rgba(153,102,255,0.6)',
                            data: [data.firstday_orders_amt,data.secondday_orders_amt,data.thirdday_orders_amt,data.fourthday_orders_amt,data.fifthday_orders_amt,data.sixthday_orders_amt,data.seventhday_orders_amt]
                        }

                    ]
                };

                // Notice how nested the beginAtZero is
                var options = {
                    title: {
                        display: true,
                        text: "Weekly Sales and Orders Revenue",
                        position: "top",
                        fontSize: 20
                    },
                    scales: {
                        xAxes: [
                            {
                                gridLines: {
                                    display: true,
                                    drawBorder: true,
                                    drawOnChartArea: false
                                }
                            }
                        ],
                        yAxes: [
                            {
                                ticks: {
                                    precision: 0
                                    // beginAtZero: true
                                }
                            }
                        ]
                    }
                };

                // added custom plugin to wrap label to new line when \n escape sequence appear
                var labelWrap = [
                    {
                        beforeInit: function (chart) {
                            chart.data.labels.forEach(function (e, i, a) {
                                if (/\n/.test(e)) {
                                    a[i] = e.split(/\n/);
                                }
                            });
                        }
                    }
                ];

                // Chart declaration:
                var myBarChart = new Chart(ctx, {
                    type: "bar",
                    data: data,
                    options: options,
                    plugins: labelWrap
                });
           }

        });
    }
    
    function getmonth(month)
    {
        
        $.ajax({
           type:'POST',
           url:'/getMonth',
           dataType:'json',
           data:{
                "_token": "{{ csrf_token() }}",
                "receive_month":month,
            },

           success:function(data){
               console.log(data);
            //    alert(data.f_done);
            //    begin chart
              var first_week_salesamt = data.first_week_salesamt;
              var second_week_salesamt = data.second_week_salesamt;
              var third_week_salesamt = data.third_week_salesamt;
              var fourth_week_salesamt = data.fourth_week_salesamt;
              var first_week_ordersamt = data.first_week_ordersamt;
              var second_week_ordersamt = data.second_week_ordersamt;
              var third_week_ordersamt = data.third_week_ordersamt;
              var fourth_week_ordersamt = data.fourth_week_ordersamt;
              
              
              
            var canvas = document.getElementById("lineChart");
            var ctx = canvas.getContext("2d");

// Global Options:
                Chart.defaults.global.defaultFontColor = "#2097e1";
                Chart.defaults.global.defaultFontSize = 11;

                // Data with datasets options
                var data = {
                    labels: [
                        "First Week",
                        "Second Week",
                        "Third Week",
                        "Last Week",
                        
                    ],
                    datasets: [
                        {
                            label: "Sales Revenues",
                            fill: false,
                            backgroundColor: 'rgba(75,192,192,0.6)',
                                
                            data: [first_week_salesamt, second_week_salesamt, third_week_salesamt, fourth_week_salesamt]
                        },
                        {
                            label: "Orders Revenues",
                            fill: false,
                            backgroundColor: 'rgba(153,102,255,0.6)',
                            data: [first_week_ordersamt, second_week_ordersamt, third_week_ordersamt, fourth_week_ordersamt]
                        }
                    ]
                };

        //         // Notice how nested the beginAtZero is
                var options = {
                    title: {
                        display: true,
                        text: "Monthly Sales and Orders Revenues",
                        position: "top"
                    },
                    scales: {
                        xAxes: [
                            {
                                gridLines: {
                                    display: true,
                                    drawBorder: true,
                                    drawOnChartArea: false
                                }
                            }
                        ],
                        yAxes: [
                            {
                                ticks: {
                                    precision: 0
                                    // beginAtZero: true
                                }
                            }
                        ]
                    }
                };

        //         // added custom plugin to wrap label to new line when \n escape sequence appear
                var labelWrap = [
                    {
                        beforeInit: function (chart) {
                            chart.data.labels.forEach(function (e, i, a) {
                                if (/\n/.test(e)) {
                                    a[i] = e.split(/\n/);
                                }
                            });
                        }
                    }
                ];

        //         // Chart declaration:
                var myLineChart = new Chart(ctx, {
                    type: 'bar',
                    data: data,
                    options: options,
                    plugins: labelWrap
                });

        //     // end chart
           }
        });
    }


</script>

@endsection

