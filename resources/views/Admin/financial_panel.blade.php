@extends('master')

@section('title','Financial Report')

@section('place')
{{--
<div class="col-md-5 col-8 align-self-center">
    <h3 class="text-themecolor m-b-0 m-t-0">@lang('lang.financial')</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('index')}}">@lang('lang.back_to_dashboard')</a></li>
        <li class="breadcrumb-item active">@lang('lang.financial')</li>
    </ol>
</div> --}}

@endsection

@section('content')

<div class="page-wrapper">
    <div class="container-fluid">
        <div class="card">
          <div class="card-body">
            <div class="card ">
                <div class="card-body">
                    <h3 class="text-center font-weight-bold">Total Incomes</h3>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" id="inc_total_pro">100%</div>
                    </div>
                    <span class="font-weight-bold mt-1 float-right" id="inc_total"></span>
                </div>
            </div>
            <div class="row">
            <div class="col-md-4">
                <div class="card py-5 px-2 mt-1">
            	<h2 class="card-title text-success font-weight-bold">@lang('lang.financial') @lang('lang.list')</h2>
                <ul class="nav nav-pills nav-tabs m-t-30 m-b-30">
                    <li class=" nav-item">
                        <a href="#navpills-1" class="nav-link active" data-toggle="tab" aria-expanded="false">@lang('lang.daily')</a>
                    </li>
                    <li class="nav-item">
                        <a href="#navpills-2" class="nav-link" data-toggle="tab" aria-expanded="false">@lang('lang.weekly')</a>
                    </li>
                    <li class="nav-item">
                        <a href="#navpills-3" class="nav-link" data-toggle="tab" aria-expanded="false">@lang('lang.monthly')</a>
                    </li>
                </ul><br/>
                <div class="tab-content br-n pn">
                    <div id="navpills-1" class="tab-pane active">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                     <label class="control-label text-success font-weight-bold">@lang('lang.daily')</label>
                                    <input type="date" class="form-control" id="daily">
                                    
                                    
                                </div>
                            </div>

                            <div class="col-md-3 pull-right mt-3">
                                <button class="btn btn-success btn-submit" type="submit" onclick="showDailySale()">
                                	@lang('lang.search')
                                </button>
                            </div>
                        </div>
                    </div>

                    <div id="navpills-2" class="tab-pane">
                    	<div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label text-success font-weight-bold">@lang('lang.weekly')</label>
                                    <select class="form-control custom-select" id="weekly">
                                        <option value="">@lang('lang.select_week')</option>
                                        <option value="1">@lang('lang.one_week')</option>
                                        <option value="2">@lang('lang.two_week')</option>
                                        <option value="3">@lang('lang.three_week')</option>
                                        <option value="4">@lang('lang.four_week')</option>
                                    </select>
                                    
                                    
                                </div>
                            </div>

                            <div class="col-md-3 pull-right mt-3">
                                <button class="btn btn-success btn-submit" type="submit" onclick="showWeeklySale()">
                                	@lang('lang.search')
                                </button>
                            </div>
                        </div>
                    </div>

                    <div id="navpills-3" class="tab-pane">
                    	<div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
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
                            </div>

                            <div class="col-md-3 pull-right mt-3">
                                <button class="btn btn-success btn-submit" type="submit" onclick="showMonthlySale()">
                                	@lang('lang.search')
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            <div class="col-md-8">

               <div class="row mt-2">
                <div class="col-md-4">
                    <div class="card ">
                        <button class="btn light default" onclick="total_income()">
                        <div class="card-body">
                            <h4 class="text-center font-weight-bold">Sales Revenues<h4>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="sale_money_pro">0%</div>
                            </div>
                            <span class="font-weight-bold mt-1 float-right" id="sale_money"></span>
                        </div>
                        </button>
                    </div>
                </div>
                
                 <div class="col-md-4">
                    <div class="card ">
                        <button class="btn light default" onclick="show_order()">
                        <div class="card-body">
                            <h4 class="text-center font-weight-bold">Order Revenues</h4>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="order_money_pro">0%</div>
                            </div>
                            <span class="font-weight-bold mt-1 float-right" id="order_money"></span>
                        </div>
                        </button>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card">
                        <button class="btn light default" onclick="other_income()">
                        <div class="card-body">
                            <h4 class="text-center font-weight-bold">Other Incomes</h4>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="other_inc_pro">0%</div>
                        </div>
                        <span class="font-weight-bold mt-1 float-right" id="other_inc"></span>
                        </div>
                        </button>
                    </div>
                </div>
               </div>
               <div class="row mt-4">
                <div class="col-md-4">
                    <div class="card">
                        <button class="btn light default" onclick="total_income()">
                        <div class="card-body">
                            <h4 class="text-center font-weight-bold">COGS</h4>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="inv_pro">0%</div>
                        </div>
                        <span class="font-weight-bold mt-1 float-right" id="inv_money"></span>
                        </div>
                        </button>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card ">
                        <button class="btn light default" onclick="show_transaction()">
                        <div class="card-body">
                            <h4 class="text-center font-weight-bold">Order Transactions</h4>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="order_trans_pro">0%</div>
                            </div>
                            <span class="font-weight-bold mt-1 float-right" id="order_trans"></span>
                        </div>
                        </button>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card">
                        <button class="btn light default" onclick="other_expense()">
                        <div class="card-body">
                            <h4 class="text-center font-weight-bold">Other Expenses</h4>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="other_exp_pro">0%</div>
                        </div>
                        <span class="font-weight-bold mt-1 float-right" id="other_exp"></span>
                        </div>
                        </button>
                    </div>
                </div>
               </div>
               <div class="row mt-4">
                <div class="col-md-4">
                    <div class="card">
                        <button class="btn light default" onclick="total_income()">
                        <div class="card-body">
                            <h4 class="text-center font-weight-bold">Gross Profit</h4>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="tprofit_pro">0%</div>
                        </div>
                        <span class="font-weight-bold mt-1 float-right" id="total_profit"></span>
                        </div>
                        </button>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card ">
                        <button class="btn light default" onclick="show_purchase()">
                        <div class="card-body">
                            <h4 class="text-center font-weight-bold">Material Purchase</h4>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="raw_purchase_pro">0%</div>
                            </div>
                            <span class="font-weight-bold mt-1 float-right" id="raw_purchase"></span>
                        </div>
                        </button>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card">
                        <button class="btn light default" onclick="">
                        <div class="card-body">
                            <h4 class="text-center font-weight-bold">Net Profit</h4>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="nprofit_pro">0%</div>
                        </div>
                        <span class="font-weight-bold mt-1 float-right" id="net_profit"></span>
                        </div>
                        </button>
                    </div>
                </div>
               </div>
        </div>
       </div>
     </div>
    </div>

    <div class="row" id="hide_date">
        <div class="col-md-3">
            <h4 class="text-success font-weight-bold">
                @lang('lang.from')
                <input type="date" name="from_date" id="from_date" class="border border-light text-secondary ml-2">
            </h4>
        </div>
        <div class="col-md-3">
            <h4 class="text-success font-weight-bold">
                @lang('lang.to')
                <input type="date" name="to_date" id="to_date" class="border border-light text-secondary ml-2">
            </h4>
        </div>
        <div class="col-md-4">
            <button class="btn btn-success" id="date_fil" onclick="fil_date()">
                @lang('lang.search')
            </button>
        </div>
    </div>
        <div class="card mt-3" id="report">
        	<div class="card-body">
        		<div class="row mt-2">
	                <div class="col-md-6">
	                    <h4 class="text-success font-weight-bold">
	                    	@lang('lang.total') @lang('lang.sales') -
	                    	<span class="badge badge-pill badge-success" id="total_sales"></span>
	                    </h4>
	                </div>
	                <div class="col-md-6">
	                    <h4 class="text-success font-weight-bold float-right">
	                    	@lang('lang.total') @lang('lang.profit') -
	                    	<span class="badge badge-pill badge-success" id="profit"></span>
	                    </h4>
	                </div>

	                <div class="col-md-12 mt-3">
	                    <table class="table" id="vou_table">
                            <thead>
                                <tr>
                                    <th class="font-weight-bold text-success">
                                    	@lang('lang.voucher') @lang('lang.number')
                                    </th>
                                    
                                    <th>Customer Name</th>
                                    <th>Customer Phone</th>
                                    <th class="font-weight-bold text-success">
                                    	@lang('lang.total') @lang('lang.amount')
                                    </th>
                                    <th class="font-weight-bold text-success">
                                    	@lang('lang.total') @lang('lang.quantity')
                                    </th>
                                    <th>Discount</th>
                                    <th class="font-weight-bold text-success">
                                    	@lang('lang.date')
                                    </th>
                                    <th class="font-weight-bold text-success">
                                    	@lang('lang.action')
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="sale_table">

                            </tbody>
                        </table>
	                </div>
	            </div>
        	</div>
        </div>
        
        <div class="card mt-3" id="order_report">
        	<div class="card-body">
        		<div class="row mt-2">
	                <div class="col-md-6">
	                    <h4 class="text-success font-weight-bold">
	                    	@lang('lang.total') @lang('lang.sales') -
	                    	<span class="badge badge-pill badge-success" id="total_sales"></span>
	                    </h4>
	                </div>
	                <div class="col-md-6">
	                    <h4 class="text-success font-weight-bold float-right">
	                    	@lang('lang.total') @lang('lang.profit') -
	                    	<span class="badge badge-pill badge-success" id="profit"></span>
	                    </h4>
	                </div>

	                <div class="col-md-12 mt-3">
	                    <table class="table" id="vou_table">
                            <thead>
                                <tr>
                                    <th class="font-weight-bold text-success">
                                    	@lang('lang.voucher') @lang('lang.number')
                                    </th>
                                    <th>Showroom</th>
                                    <th>Customer Name</th>
                                    <th>Customer Phone</th>
                                    <th class="font-weight-bold text-success">
                                    	@lang('lang.total') @lang('lang.amount')
                                    </th>
                                    <th class="font-weight-bold text-success">
                                    	@lang('lang.total') @lang('lang.quantity')
                                    </th>
                                    <th>Discount</th>
                                    <th>Advance</th>
                                    <th>Outstanding</th>
                                    <th class="font-weight-bold text-success">
                                    	@lang('lang.date')
                                    </th>
                                    <th class="font-weight-bold text-success">
                                    	@lang('lang.action')
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="order_table">

                            </tbody>
                        </table>
	                </div>
	            </div>
        	</div>
        </div>
        
        <div class="card mt-3" id="inc_exp">
        	<div class="card-body">
        		<div class="row mt-2">
	                {{-- <div class="col-md-6">
	                    <h4 class="text-success font-weight-bold">
	                    	@lang('lang.total') @lang('lang.sales') -
	                    	<span class="badge badge-pill badge-success" id="total_sales"></span>
	                    </h4>
	                </div>
	                <div class="col-md-6">
	                    <h4 class="text-success font-weight-bold float-right">
	                    	@lang('lang.total') @lang('lang.profit') -
	                    	<span class="badge badge-pill badge-success" id="profit"></span>
	                    </h4>
	                </div> --}}

	                <div class="col-md-12 mt-3">
	                    <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Type</th>
                                    <th>@lang('lang.period')</th>
                                    <th>@lang('lang.date')</th>
                                    <th>@lang('lang.title')</th>
                                    <th>@lang('lang.description')</th>
                                    <th>@lang('lang.amount')</th>
                                </tr>
                            </thead>
                            <tbody id="inc_exp_table">

                            </tbody>
                        </table>
	                </div>
	            </div>
        	</div>
        </div>
        
        <div class="card mt-3" id="purchase">
        	<div class="card-body">
        		<div class="row mt-2">
	                {{-- <div class="col-md-6">
	                    <h4 class="text-success font-weight-bold">
	                    	@lang('lang.total') @lang('lang.sales') -
	                    	<span class="badge badge-pill badge-success" id="total_sales"></span>
	                    </h4>
	                </div>
	                <div class="col-md-6">
	                    <h4 class="text-success font-weight-bold float-right">
	                    	@lang('lang.total') @lang('lang.profit') -
	                    	<span class="badge badge-pill badge-success" id="profit"></span>
	                    </h4>
	                </div> --}}

	                <div class="col-md-12 mt-3">
	                    <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Purchase No.</th>
                                    <th>Purchase Date</th>
                                    <th>Supplier Name</th>
                                    <th>Total Quantity</th>
                                    <th>Total Price</th>
                                    <th>Credit Amount</th>
                                    <th>Purchase Remark</th>
                                    <th>Details</th>
                                </tr>
                            </thead>
                            <tbody id="purchase_table">

                            </tbody>
                        </table>
	                </div>
	            </div>
        	</div>
        </div>
        
        <div class="card mt-3" id="transaction">
        	<div class="card-body">
        		<div class="row mt-2">
	                {{-- <div class="col-md-6">
	                    <h4 class="text-success font-weight-bold">
	                    	@lang('lang.total') @lang('lang.sales') -
	                    	<span class="badge badge-pill badge-success" id="total_sales"></span>
	                    </h4>
	                </div>
	                <div class="col-md-6">
	                    <h4 class="text-success font-weight-bold float-right">
	                    	@lang('lang.total') @lang('lang.profit') -
	                    	<span class="badge badge-pill badge-success" id="profit"></span>
	                    </h4>
	                </div> --}}

	                <div class="col-md-12 mt-3">
	                    <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Order No.</th>
                                    <th>Bank Account</th>
                                    <th>Amount</th>
                                    <th>Remark</th>
                                    
                                </tr>
                            </thead>
                            <tbody id="transaction_table">

                            </tbody>
                        </table>
	                </div>
	            </div>
        	</div>
        </div>
        
        
        
        
        
    </div>
</div>

@endsection

@section('js')

<script>

	$(document).ready(function() {

        $('#inc_exp').hide();
	    $('#report').hide();
	    $('#order_report').hide();
	    $('#purchase').hide();
	    $('#transaction').hide();
        $('#hide_date').hide();

	});

	function showDailySale() {

        $('#other_inc').empty();

        $('#other_exp').empty();

        $('#hide_date').hide();

		$('#total_sales').empty();

		$('#total_sales').empty();

        $('#sale_money').empty();
        
        $('#order_money').empty();
        
        $('#order_trans').empty();
        
        $('#raw_purchase').empty();

        $('#inv_money').empty();

        $('#net_profit').empty();

        $('#inc_total').empty();

        $('#total_profit').empty();

		$('#sale_table').empty();

        $('#inc_exp_table').empty();

		var  daily = $('#daily').val();

        // alert(daily);

		var  type  = 1;

		$.ajax({
           type:'POST',
           url:'/getTotalSaleReport',
           data:{
            "value": daily,
            "type": type,
            "_token":"{{csrf_token()}}"
           },

           	success:function(data){

            	console.log(data);

                // alert(data.voucher_lists);
                $('#inc_exp').hide();
                
                $('#purchase').hide();
                
                $('#transaction').hide();
                
                $('#order_report').hide();

                var inv = data.total_sales - data.total_profit ;
                
                var inv_percent = (inv / data.total_sales) * 100;
                
                var total_profit_percent = (data.total_profit / data.total_sales) *100;

                var net_profit = (data.total_profit + data.other_incomes + data.total_transaction) - (data.other_expenses-data.total_purchase);
                
                
                
                var income_total = data.total_sales + data.other_incomes+data.total_transaction;
                
                var total_sales_percent =  (data.total_sales / income_total) * 100;
                
                //var order_money_percent = (data.total_order/income_total) * 100;
                
                var other_inc_percent = (data.other_incomes / income_total) * 100;
                
                var other_exp_percent = (data.other_expenses / income_total) * 100;
                
                var order_trans_percent = (data.total_transaction / income_total) *100;
                
                var raw_purchase_percent = (data.total_purchase/income_total) * 100;
                
                
                var net_profit_percent = (net_profit / income_total) *100;
                
                

                $('#inc_total').append(income_total).append($('<strong>').text('MMK'));

                $('#net_profit').append(net_profit).append($('<strong>').text('MMK'));
                
                 $('#nprofit_pro').width(net_profit_percent+"%").attr('aria-valuenow',net_profit_percent).text(net_profit_percent.toFixed(2)+ "%");

                $('#inv_money').append(inv).append($('<strong>').text('MMK'));
                
                 $('#inv_pro').width(inv_percent+"%").attr('aria-valuenow',inv_percent).text(inv_percent.toFixed(2)+ "%");

                $('#sale_money').append(data.total_sales).append($('<strong>').text('MMK'));
                
                $('#sale_money_pro').width(total_sales_percent+"%").attr('aria-valuenow',total_sales_percent).text(total_sales_percent.toFixed(2)+ "%");
                
                $('#order_money').append(data.total_order).append($('<strong>').text('MMK'));
                
                //$('#order_money_pro').width(order_money_percent+"%").attr('aria-valuenow',order_money_percent).text(order_money_percent.toFixed(2)+ "%");
                
                $('#order_trans').append(data.total_transaction).append($('<strong>').text('MMK'));
                
                $('#order_trans_pro').width(order_trans_percent+"%").attr('aria-valuenow',order_trans_percent).text(order_trans_percent.toFixed(2)+ "%");
                
                
                $('#raw_purchase').append(data.total_purchase).append($('<strong>').text('MMK'));
                
                 $('#raw_purchase_pro').width(raw_purchase_percent+"%").attr('aria-valuenow',raw_purchase_percent).text(raw_purchase_percent.toFixed(2)+ "%");

                $('#total_sales').text(data.total_sales);

                $('#total_profit').append(data.total_profit).append($('<strong>').text('MMK'));
                
                $('#tprofit_pro').width(total_profit_percent+"%").attr('aria-valuenow',total_profit_percent).text(total_profit_percent.toFixed(2)+ "%");

                $('#other_inc').append(data.other_incomes).append($('<strong>').text('MMK'));
                
                $('#other_inc_pro').width(other_inc_percent+"%").attr('aria-valuenow',other_inc_percent).text(other_inc_percent.toFixed(2)+ "%");

                $('#other_exp').append(data.other_expenses).append($('<strong>').text('MMK'));
                
                $('#other_exp_pro').width(other_exp_percent+"%").attr('aria-valuenow',other_exp_percent).text(other_exp_percent.toFixed(2)+ "%");

            	$('#profit').text(data.total_profit);

		        $.each(data.voucher_lists,function(i,value){

		            let url = "{{url('/Sale/Voucher-Details')}}/"+value.id;

		            let button = `<a href="${url}" class="btn btn-success">@lang('lang.details')</a>`

		             $('#sale_table').append($('<tr>')).append($('<td>').text(value.voucher_code)).append($('<td>').text(value.sales_customer_name)).append($('<td>').text(value.sales_customer_phone)).append($('<td>').text(value.total_price)).append($('<td>').text(value.total_quantity)).append($('<td>').text(value.discount_value)).append($('<td>').text(value.voucher_date)).append($('<td>').append($(button)));

		        });
		        
		        $.each(data.order_lists,function(i,value){

		            let url = "{{url('/Order/orderVoucherDetails')}}/"+value.id;

		            let button = `<a href="${url}" class="btn btn-success">@lang('lang.details')</a>`

		             $('#order_table').append($('<tr>')).append($('<td>').text(value.order_number)).append($('<td>').text(value.showroom)).append($('<td>').text(value.name)).append($('<td>').text(value.phone ?? '-')).append($('<td>').text(value.est_price)).append($('<td>').text(value.total_quantity)).append($('<td>').text(value.total_discount_value)).append($('<td>').text(value.advance_pay)).append($('<td>').text(value.collect_amount)).append($('<td>').text(value.order_date)).append($('<td>').append($(button)));

		        });
		        
		        
		        
		        

		        $('#report').show();
            }
        });
	}

	function showWeeklySale() {

        $('#other_inc').empty();

        $('#other_exp').empty();

        $('#hide_date').show();

		$('#total_sales').empty();

		$('#total_sales').empty();

        $('#sale_money').empty();
        
        $('#order_money').empty();
         
          $('#order_trans').empty();
          
           $('#raw_purchase').empty();


        $('#inv_money').empty();

        $('#total_profit').empty();

        $('#inc_total').empty();

        $('#net_profit').empty();

		$('#sale_table').empty();

        $('#inc_exp_table').empty();

		var  daily = $('#weekly').val();

		var  type  = 2;

		$.ajax({
           type:'POST',
           url:'/getTotalSaleReport',
           data:{
            "value": daily,
            "type": type,
            "_token":"{{csrf_token()}}"
           },

           	success:function(data){

            	console.log(data);

                $('#inc_exp').hide();
                
                $('#purchase').hide();
                
                $('#transaction').hide();
                
                $('#order_report').hide();

                var inv = data.total_sales - data.total_profit ;

                var inv_percent = (inv / data.total_sales) * 100;
                
                var total_profit_percent = (data.total_profit / data.total_sales) *100;

                var net_profit = (data.total_profit + data.other_incomes + data.total_transaction) - (data.other_expenses-data.total_purchase);
                
                
                
                var income_total = data.total_sales + data.other_incomes+data.total_transaction;
                
                var total_sales_percent =  (data.total_sales / income_total) * 100;
                
               // var order_money_percent = (data.total_order/income_total) * 100;
                
                var other_inc_percent = (data.other_incomes / income_total) * 100;
                
                var other_exp_percent = (data.other_expenses / income_total) * 100;
                
                var order_trans_percent = (data.total_transaction / income_total) *100;
                
                var raw_purchase_percent = (data.total_purchase/income_total) * 100;
                
                
                var net_profit_percent = (net_profit / income_total) *100;                

                $('#inc_total').append(income_total).append($('<strong>').text('MMK'));

                $('#net_profit').append(net_profit).append($('<strong>').text('MMK'));
                
                 $('#nprofit_pro').width(net_profit_percent+"%").attr('aria-valuenow',net_profit_percent).text(net_profit_percent.toFixed(2)+ "%");

                $('#inv_money').append(inv).append($('<strong>').text('MMK'));
                
                 $('#inv_pro').width(inv_percent+"%").attr('aria-valuenow',inv_percent).text(inv_percent.toFixed(2)+ "%");

                $('#sale_money').append(data.total_sales).append($('<strong>').text('MMK'));
                
                $('#sale_money_pro').width(total_sales_percent+"%").attr('aria-valuenow',total_sales_percent).text(total_sales_percent.toFixed(2)+ "%");
                
                $('#order_money').append(data.total_order).append($('<strong>').text('MMK'));
                
               // $('#order_money_pro').width(order_money_percent+"%").attr('aria-valuenow',order_money_percent).text(order_money_percent.toFixed(2)+ "%");
                
                $('#order_trans').append(data.total_transaction).append($('<strong>').text('MMK'));
                
                $('#order_trans_pro').width(order_trans_percent+"%").attr('aria-valuenow',order_trans_percent).text(order_trans_percent.toFixed(2)+ "%");
                
                
                $('#raw_purchase').append(data.total_purchase).append($('<strong>').text('MMK'));
                
                 $('#raw_purchase_pro').width(raw_purchase_percent+"%").attr('aria-valuenow',raw_purchase_percent).text(raw_purchase_percent.toFixed(2)+ "%");

                $('#total_sales').text(data.total_sales);

                $('#total_profit').append(data.total_profit).append($('<strong>').text('MMK'));
                
                $('#tprofit_pro').width(total_profit_percent+"%").attr('aria-valuenow',total_profit_percent).text(total_profit_percent.toFixed(2)+ "%");

                $('#other_inc').append(data.other_incomes).append($('<strong>').text('MMK'));
                
                $('#other_inc_pro').width(other_inc_percent+"%").attr('aria-valuenow',other_inc_percent).text(other_inc_percent.toFixed(2)+ "%");

                $('#other_exp').append(data.other_expenses).append($('<strong>').text('MMK'));
                
                $('#other_exp_pro').width(other_exp_percent+"%").attr('aria-valuenow',other_exp_percent).text(other_exp_percent.toFixed(2)+ "%");

            	$('#profit').text(data.total_profit);

		        $.each(data.voucher_lists,function(i,value){

		            let url = "{{url('/Sale/Voucher-Details')}}/"+value.id;

		            let button = `<a href="${url}" class="btn btn-success">@lang('lang.details')</a>`

		             $('#sale_table').append($('<tr>')).append($('<td>').text(value.voucher_code)).append($('<td>').text(value.sales_customer_name)).append($('<td>').text(value.sales_customer_phone)).append($('<td>').text(value.total_price)).append($('<td>').text(value.total_quantity)).append($('<td>').text(value.discount_value)).append($('<td>').text(value.voucher_date)).append($('<td>').append($(button)));

		        });
		        
		        $.each(data.order_lists,function(i,value){

		            let url = "{{url('/Order/orderVoucherDetails')}}/"+value.id;

		            let button = `<a href="${url}" class="btn btn-success">@lang('lang.details')</a>`

		             $('#order_table').append($('<tr>')).append($('<td>').text(value.order_number)).append($('<td>').text(value.showroom)).append($('<td>').text(value.name)).append($('<td>').text(value.phone ?? '-')).append($('<td>').text(value.est_price)).append($('<td>').text(value.total_quantity)).append($('<td>').text(value.total_discount_value)).append($('<td>').text(value.advance_pay)).append($('<td>').text(value.collect_amount)).append($('<td>').text(value.order_date)).append($('<td>').append($(button)));

		        });

		        $('#report').show();
            }
        });
	}

	function showMonthlySale() {

        $('#other_inc').empty();

        $('#other_exp').empty();

        $('#hide_date').show();

		$('#total_sales').empty();

		$('#total_sales').empty();

        $('#sale_money').empty();
        
         $('#order_money').empty();
         
          $('#order_trans').empty();
          
           $('#raw_purchase').empty();

        $('#inv_money').empty();

        $('#total_profit').empty();

        $('#inc_total').empty();

        $('#net_profit').empty();

		$('#sale_table').empty();

        $('#inc_exp_table').empty();

		var  daily = $('#monthly').val();

		var  type  = 3;

		$.ajax({
           type:'POST',
           url:'/getTotalSaleReport',
           data:{
            "value": daily,
            "type": type,
            "_token":"{{csrf_token()}}"
           },

           	success:function(data){

            	console.log(data);

                $('#inc_exp').hide();
                
                $('#purchase').hide();
                
                $('#transaction').hide();
                
                $('#order_report').hide();

                var inv = data.total_sales - data.total_profit ;
                
                var inv_percent = (inv / data.total_sales) * 100;
                
                var total_profit_percent = (data.total_profit / data.total_sales) *100;

                var net_profit = (data.total_profit + data.other_incomes + data.total_transaction) - (data.other_expenses-data.total_purchase);
                
                
                
                var income_total = data.total_sales + data.other_incomes+data.total_transaction;
                
                var total_sales_percent =  (data.total_sales / income_total) * 100;
                
                //var order_money_percent = (data.total_order/income_total) * 100;
                
                var other_inc_percent = (data.other_incomes / income_total) * 100;
                
                var other_exp_percent = (data.other_expenses / income_total) * 100;
                
                var order_trans_percent = (data.total_transaction / income_total) *100;
                
                var raw_purchase_percent = (data.total_purchase/income_total) * 100;
                
                
                var net_profit_percent = (net_profit / income_total) *100;
                
                

                $('#inc_total').append(income_total).append($('<strong>').text('MMK'));

                $('#net_profit').append(net_profit).append($('<strong>').text('MMK'));
                
                 $('#nprofit_pro').width(net_profit_percent+"%").attr('aria-valuenow',net_profit_percent).text(net_profit_percent.toFixed(2)+ "%");

                $('#inv_money').append(inv).append($('<strong>').text('MMK'));
                
                 $('#inv_pro').width(inv_percent+"%").attr('aria-valuenow',inv_percent).text(inv_percent.toFixed(2)+ "%");

                $('#sale_money').append(data.total_sales).append($('<strong>').text('MMK'));
                
                $('#sale_money_pro').width(total_sales_percent+"%").attr('aria-valuenow',total_sales_percent).text(total_sales_percent.toFixed(2)+ "%");
                
                $('#order_money').append(data.total_order).append($('<strong>').text('MMK'));
                
                //$('#order_money_pro').width(order_money_percent+"%").attr('aria-valuenow',order_money_percent).text(order_money_percent.toFixed(2)+ "%");
                
                $('#order_trans').append(data.total_transaction).append($('<strong>').text('MMK'));
                
                $('#order_trans_pro').width(order_trans_percent+"%").attr('aria-valuenow',order_trans_percent).text(order_trans_percent.toFixed(2)+ "%");
                
                
                $('#raw_purchase').append(data.total_purchase).append($('<strong>').text('MMK'));
                
                 $('#raw_purchase_pro').width(raw_purchase_percent+"%").attr('aria-valuenow',raw_purchase_percent).text(raw_purchase_percent.toFixed(2)+ "%");

                $('#total_sales').text(data.total_sales);

                $('#total_profit').append(data.total_profit).append($('<strong>').text('MMK'));
                
                $('#tprofit_pro').width(total_profit_percent+"%").attr('aria-valuenow',total_profit_percent).text(total_profit_percent.toFixed(2)+ "%");

                $('#other_inc').append(data.other_incomes).append($('<strong>').text('MMK'));
                
                $('#other_inc_pro').width(other_inc_percent+"%").attr('aria-valuenow',other_inc_percent).text(other_inc_percent.toFixed(2)+ "%");

                $('#other_exp').append(data.other_expenses).append($('<strong>').text('MMK'));
                
                $('#other_exp_pro').width(other_exp_percent+"%").attr('aria-valuenow',other_exp_percent).text(other_exp_percent.toFixed(2)+ "%");

            	$('#profit').text(data.total_profit);

		        $.each(data.voucher_lists,function(i,value){

		            let url = "{{url('/Sale/Voucher-Details')}}/"+value.id;

		            let button = `<a href="${url}" class="btn btn-success">@lang('lang.details')</a>`

		            $('#sale_table').append($('<tr>')).append($('<td>').text(value.voucher_code)).append($('<td>').text(value.sales_customer_name)).append($('<td>').text(value.sales_customer_phone)).append($('<td>').text(value.total_price)).append($('<td>').text(value.total_quantity)).append($('<td>').text(value.discount_value)).append($('<td>').text(value.voucher_date)).append($('<td>').append($(button)));

		        });
		        
		        $.each(data.order_lists,function(i,value){

		            let url = "{{url('/Order/orderVoucherDetails')}}/"+value.id;

		            let button = `<a href="${url}" class="btn btn-success">@lang('lang.details')</a>`

		             $('#order_table').append($('<tr>')).append($('<td>').text(value.order_number)).append($('<td>').text(value.showroom)).append($('<td>').text(value.name)).append($('<td>').text(value.phone ?? '-')).append($('<td>').text(value.est_price)).append($('<td>').text(value.total_quantity)).append($('<td>').text(value.total_discount_value)).append($('<td>').text(value.advance_pay)).append($('<td>').text(value.collect_amount)).append($('<td>').text(value.order_date)).append($('<td>').append($(button)));

		        });

		        $('#report').show();
            }
        });

	}

function fil_date(){

        // $('#other_inc').empty();

        // $('#other_exp').empty();

        $('#total_sales').empty();

		$('#total_sales').empty();

        $('#sale_money').empty();

        $('#inv_money').empty();

        $('#total_profit').empty();

        $('#inc_total').empty();

        $('#net_profit').empty();

		$('#sale_table').empty();

    if($('.nav-tabs .active').text() == 'Weekly'){
        // alert('nav2');
        var type = 2;
        var  daily = $('#weekly').val();
    }
    else if($('.nav-tabs .active').text() == 'Monthly'){
        // alert('nav3');
        var type = 3;
        var  daily = $('#monthly').val();
    }

    var from_date = $('#from_date').val();
    var to_date = $('#to_date').val();

    $.ajax({
           type:'POST',
           url:'/getTotalSaleReport',
           data:{
            "type": type,
            "value" : daily,
            "from_date" : from_date,
            "to_date" : to_date,
            "_token":"{{csrf_token()}}"
           },

           	success:function(data){
                // alert(data.date_fil_lists);
                $('#inc_exp').hide();
                var inv = data.total_sales - data.total_profit ;

                var net_profit = (data.total_profit + data.other_incomes) - data.other_expenses;

                var income_total = data.total_sales + data.other_incomes ;

                $('#inc_total').append(income_total).append($('<strong>').text('MMK'));

                $('#net_profit').append(net_profit).append($('<strong>').text('MMK'));

                $('#inv_money').append(inv).append($('<strong>').text('MMK'));

                $('#sale_money').append(data.total_sales).append($('<strong>').text('MMK'));

                $('#total_sales').text(data.total_sales);

                $('#total_profit').append(data.total_profit).append($('<strong>').text('MMK'));

                    $('#profit').text(data.total_profit);

                    $.each(data.date_fil_lists,function(i,value){

                    let url = "{{url('/Order/Voucher-Details')}}/"+value.id;

                    let button = `<a href="${url}" class="btn btn-success">@lang('lang.details')</a>`

                    $('#sale_table').append($('<tr>')).append($('<td>').text(value.voucher_code)).append($('<td>').text(value.total_price)).append($('<td>').text(value.total_quantity)).append($('<td>').text(value.voucher_date)).append($('<td>').append($(button)));

                });
            $('#report').show();
        }
    });
}

 function total_income(){
    //  alert('hello');
	//  showDailySale();
    if($('.nav-tabs .active').text() == 'Daily'){
        showDailySale();
    }
    else if($('.nav-tabs .active').text() == 'Weekly'){
        // if($('#date_fil').clicked == false){
        //     showWeeklySale();
        // }else{
        //     fil_date();
        // }
        showWeeklySale();
    }
    else if($('.nav-tabs .active').text() == 'Monthly'){
        // if($('#date_fil').clicked == false){
        //     showMonthlySale();
        // }else{
        //     fil_date();
        // }
        showMonthlySale();
    }

 }

function other_income(){
    // alert('income');
        $('#hide_date').hide();

        $('#total_sales').empty();

        $('#sale_table').empty();

        $('#inc_exp_table').empty();

        if($('.nav-tabs .active').text() == 'Weekly'){
        // alert('nav2');
        var type = 2;
        var  daily = $('#weekly').val();
        }
        else if($('.nav-tabs .active').text() == 'Monthly'){
        // alert('nav3');
        var type = 3;
        var  daily = $('#monthly').val();
        }
        else{
            var type = 1;
            var  daily = $('#daily').val();
        }
        $.ajax({
           type:'POST',
           url:'/getTotalIncome',
           data:{
            "value": daily,
            "type": type,
            "_token":"{{csrf_token()}}"
           },

           	success:function(data){
                // alert('hello');
                $('#report').hide();
                $('#purchase').hide();
                $('#transaction').hide();
                $('#inc_exp').show();
                if(data.time == 1){
                $.each(data.income_lists,function(i,value){
                    // if(type == 1){
                    if(value.type == 1 && value.period == 1){
                        var type = 'Fixed';
                        var period = 'Daily';
                        var amount = value.amount;
                        var amount_text = ' ';
                    }
                    else if(value.type == 1 && value.period == 2){
                        var type = 'Fixed';
                        var period = 'Weekly';
                        var amount = parseInt(value.amount/7);
                        var amount_text = '(Divided By 7)';
                    }
                    else if(value.type == 1 && value.period == 3){
                        var type = 'Fixed';
                        var period = 'Monthly';
                        var amount = parseInt(value.amount/30);
                        var amount_text = '(Divided By 30)';
                    }
                    else{
                        var type = 'Variable';
                        var period = 'Monthly';
                        var amount = value.amount;
                        var amount_text = ' ';
                    }

                    $('#inc_exp_table').append($('<tr>')).append($('<td>').text(++i)).append($('<td>').text(type)).append($('<td>').text(period)).append($('<td>').text(value.date)).append($('<td>').text(value.title)).append($('<td>').text(value.description)).append($('<td>').text(amount+' '+amount_text));

                });
                }
                else if(data.time == 2){
                    // alert(data.income_lists);
                    $.each(data.income_lists,function(i,value){

                    if(value.type == 1 && value.period == 1){
                        var type = 'Fixed';
                        var period = 'Daily';
                        var amount = value.amount * 7;
                        var amount_text = '(Mutiplied By 7)';
                    }
                    else if(value.type == 1 && value.period == 2){
                        var type = 'Fixed';
                        var period = 'Weekly';
                        var amount = value.amount;
                        var amount_text = ' ';
                    }
                    else if(value.type == 1 && value.period == 3){
                        var type = 'Fixed';
                        var period = 'Monthly';
                        var amount = parseInt(value.amount/4);
                        var amount_text = '(Divided By 4)';
                    }
                    else{
                        var type = 'Variable';
                        var period = 'Monthly';
                        var amount = value.amount;
                        var amount_text = ' ';
                    }

                    $('#inc_exp_table').append($('<tr>')).append($('<td>').text(++i)).append($('<td>').text(type)).append($('<td>').text(period)).append($('<td>').text(value.date)).append($('<td>').text(value.title)).append($('<td>').text(value.description)).append($('<td>').text(amount+' '+amount_text));

                });
                }
                else{
                    $.each(data.income_lists,function(i,value){
                    // if(type == 1){
                    if(value.type == 1 && value.period == 1){
                        var type = 'Fixed';
                        var period = 'Daily';
                        var amount = value.amount * 30;
                        var amount_text = '(Mutiplied By 30)';
                    }
                    else if(value.type == 1 && value.period == 2){
                        var type = 'Fixed';
                        var period = 'Weekly';
                        var amount = value.amount * 4;
                        var amount_text = '(Mutiplied By 4)';
                    }
                    else if(value.type == 1 && value.period == 3){
                        var type = 'Fixed';
                        var period = 'Monthly';
                        var amount = value.amount;
                        var amount_text = ' ';
                    }
                    else{
                        var type = 'Variable';
                        var period = 'Monthly';
                        var amount = value.amount;
                        var amount_text = ' ';
                    }

                    $('#inc_exp_table').append($('<tr>')).append($('<td>').text(++i)).append($('<td>').text(type)).append($('<td>').text(period)).append($('<td>').text(value.date)).append($('<td>').text(value.title)).append($('<td>').text(value.description)).append($('<td>').text(amount+' '+amount_text));

                });
                }

            }
        });
}

function other_expense(){
    // alert('income');
        $('#hide_date').hide();

        $('#total_sales').empty();

        $('#sale_table').empty();

        $('#inc_exp_table').empty();

        if($('.nav-tabs .active').text() == 'Weekly'){
        // alert('nav2');
        var type = 2;
        var  daily = $('#weekly').val();
        }
        else if($('.nav-tabs .active').text() == 'Monthly'){
        // alert('nav3');
        var type = 3;
        var  daily = $('#monthly').val();
        }
        else{
            var type = 1;
            var  daily = $('#daily').val();
        }
        $.ajax({
           type:'POST',
           url:'/getTotalIncome',
           data:{
            "value": daily,
            "type": type,
            "_token":"{{csrf_token()}}"
           },

           	success:function(data){
                // alert('hello');
                $('#report').hide();
                $('#purchase').hide();
                $('#transaction').hide();
                $('#inc_exp').show();
                // alert(data.time);
                if(data.time == 1){
                $.each(data.expense_lists,function(i,value){
                    // if(type == 1){
                        if(value.type == 1 && value.period == 1){
                        var type = 'Fixed';
                        var period = 'Daily';
                        var amount = value.amount;
                        var amount_text = ' ';
                    }
                    else if(value.type == 1 && value.period == 2){
                        var type = 'Fixed';
                        var period = 'Weekly';
                        var amount = parseInt(value.amount/7);
                        var amount_text = '(Divided By 7)';
                    }
                    else if(value.type == 1 && value.period == 3){
                        var type = 'Fixed';
                        var period = 'Monthly';
                        var amount = parseInt(value.amount/30);
                        var amount_text = '(Divided By 30)';
                    }
                    else{
                        var type = 'Variable';
                        var period = 'Monthly';
                        var amount = value.amount;
                        var amount_text = ' ';
                    }

                    $('#inc_exp_table').append($('<tr>')).append($('<td>').text(++i)).append($('<td>').text(type)).append($('<td>').text(period)).append($('<td>').text(value.date)).append($('<td>').text(value.title)).append($('<td>').text(value.description)).append($('<td>').text(amount+' '+amount_text));

                });
                }
                else if(data.time == 2){
                    $.each(data.expense_lists,function(i,value){
                    // alert('hello');
                    if(value.type == 1 && value.period == 1){
                        var type = 'Fixed';
                        var period = 'Daily';
                        var amount = value.amount * 7;
                        var amount_text = '(Mutiplied By 7)';
                    }
                    else if(value.type == 1 && value.period == 2){
                        var type = 'Fixed';
                        var period = 'Weekly';
                        var amount = value.amount;
                        var amount_text = ' ';
                    }
                    else if(value.type == 1 && value.period == 3){
                        var type = 'Fixed';
                        var period = 'Monthly';
                        var amount = parseInt(value.amount/4);
                        var amount_text = '(Divided By 4)';
                    }
                    else{
                        var type = 'Variable';
                        var period = 'Monthly';
                        var amount = value.amount;
                        var amount_text = ' ';
                    }

                    $('#inc_exp_table').append($('<tr>')).append($('<td>').text(++i)).append($('<td>').text(type)).append($('<td>').text(period)).append($('<td>').text(value.date)).append($('<td>').text(value.title)).append($('<td>').text(value.description)).append($('<td>').text(amount+' '+amount_text));

                });
                }
                else{
                    $.each(data.expense_lists,function(i,value){
                    // if(type == 1){
                        if(value.type == 1 && value.period == 1){
                        var type = 'Fixed';
                        var period = 'Daily';
                        var amount = value.amount * 30;
                        var amount_text = '(Mutiplied By 30)';
                    }
                    else if(value.type == 1 && value.period == 2){
                        var type = 'Fixed';
                        var period = 'Weekly';
                        var amount = value.amount * 4;
                        var amount_text = '(Mutiplied By 4)';
                    }
                    else if(value.type == 1 && value.period == 3){
                        var type = 'Fixed';
                        var period = 'Monthly';
                        var amount = value.amount;
                        var amount_text = ' ';
                    }
                    else{
                        var type = 'Variable';
                        var period = 'Monthly';
                        var amount = value.amount;
                        var amount_text = ' ';
                    }

                    $('#inc_exp_table').append($('<tr>')).append($('<td>').text(++i)).append($('<td>').text(type)).append($('<td>').text(period)).append($('<td>').text(value.date)).append($('<td>').text(value.title)).append($('<td>').text(value.description)).append($('<td>').text(amount+' '+amount_text));

                });
                }

            }
        });
}

function show_purchase(){
    // alert('income');
        $('#hide_date').hide();

        //$('#total_sales').empty();

        //$('#sale_table').empty();

        $('#purchase_table').empty();

        if($('.nav-tabs .active').text() == 'Weekly'){
        // alert('nav2');
        var type = 2;
        var  daily = $('#weekly').val();
        }
        else if($('.nav-tabs .active').text() == 'Monthly'){
        // alert('nav3');
        var type = 3;
        var  daily = $('#monthly').val();
        }
        else{
            var type = 1;
            var  daily = $('#daily').val();
        }
        $.ajax({
           type:'POST',
           url:'/getTotalPurchase',
           data:{
            "value": daily,
            "type": type,
            "_token":"{{csrf_token()}}"
           },

           	success:function(data){
                // alert('hello');
                $('#report').hide();
                $('#order_report').hide();
                $('#inc_exp').hide();
                $('#transaction').hide();
                $('#purchase').show();
                
                $.each(data.purchase_lists,function(i,value){
                    // if(type == 1){
                    let url = "{{url('/Purchase/Details')}}/"+value.id;

		            let button = `<a href="${url}" class="btn btn-success">@lang('lang.details')</a>`

                $('#purchase_table').append($('<tr>')).append($('<td>').text(++i)).append($('<td>').text(value.purchase_number)).append($('<td>').text(value.purchase_date)).append($('<td>').text(value.supplier.name)).append($('<td>').text(value.total_quantity)).append($('<td>').text(value.total_price)).append($('<td>').text(value.credit_amount)).append($('<td>').text(value.purchase_remark)).append($('<td>').append($(button)));

                });
                
                

            }
        });
}

function show_order(){
    $('#report').hide();
                $('#inc_exp').hide();
                $('#purchase').hide();
                $('#transaction').hide();
                $('#order_report').show();
}

function show_transaction(){
    // alert('income');
        $('#hide_date').hide();

        //$('#total_sales').empty();

        //$('#sale_table').empty();

        $('#transaction_table').empty();

        if($('.nav-tabs .active').text() == 'Weekly'){
        // alert('nav2');
        var type = 2;
        var  daily = $('#weekly').val();
        }
        else if($('.nav-tabs .active').text() == 'Monthly'){
        // alert('nav3');
        var type = 3;
        var  daily = $('#monthly').val();
        }
        else{
            var type = 1;
            var  daily = $('#daily').val();
        }
        $.ajax({
           type:'POST',
           url:'/getTotalTransaction',
           data:{
            "value": daily,
            "type": type,
            "_token":"{{csrf_token()}}"
           },

           	success:function(data){
                // alert('hello');
                $('#report').hide();
                $('#order_report').hide();
                $('#inc_exp').hide();
                $('#purchase').hide();
                $('#transaction').show();
                
                $.each(data.transaction_lists,function(i,value){
                    // if(type == 1){
                
                
                $('#transaction_table').append($('<tr>')).append($('<td>').text(++i)).append($('<td>').text(value.tran_date)).append($('<td>').text(value.order.order_number)).append($('<td>').text(value.bank_account.bank_name + ' ' + value.bank_account.account_number)).append($('<td>').text(value.pay_amount)).append($('<td>').text(value.remark));

                });
                
                

            }
        });
}

</script>

@endsection
