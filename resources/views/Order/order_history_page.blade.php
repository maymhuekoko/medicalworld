@extends('master')

@section('title','Order History Page')

@section('place')
@endsection

@section('content')

<section id="plan-features">
    
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between mt-3 mb-5">
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <span class="h3 font-weight-normal mb-0 text-info" style="font-size: 20px;">{{$total_sales??0}} @lang('lang.ks')</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape text-white rounded-circle shadow" style="background-color:#473C70;">
                                        <i class="fas fa-hand-holding-usd"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-success font-weight-normal text-sm">
                                <span>@lang('lang.all_time_sale')</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <span class="h3 font-weight-normal mb-0 text-info" style="font-size: 20px;">{{$daily_sales??0}} @lang('lang.ks')</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape text-white rounded-circle shadow" style="background-color:#473C70;">
                                        <i class="fas fa-hand-holding-usd"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-success font-weight-normal text-sm">
                                <span>@lang('lang.today') @lang('lang.sales')</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <span class="h2 font-weight-normal mb-0 text-info" style="font-size: 25px;">{{$weekly_sales??0}} @lang('lang.ks')</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape text-white rounded-circle shadow" style="background-color:#473C70;">
                                        <i class="fas fa-hand-holding-usd"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-success font-weight-normal text-sm">
                                <span>@lang('lang.this') @lang('lang.week')</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <span class="h3 font-weight-normal mb-0 text-info" style="font-size: 20px;">{{$monthly_sales??0}} @lang('lang.ks')</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape text-white rounded-circle shadow" style="background-color:#473C70;">
                                        <i class="fas fa-hand-holding-usd"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-success font-weight-normal text-sm">
                                <span>@lang('lang.this') @lang('lang.month')</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="row justify-content-start">
        <div class="col-8">
            <div class="mb-4">
                
                    <?php
                    //$from = date('Y-m-d',strtotime(now()));
                    //$to = date('Y-m-d',strtotime(now()));;
                    $from = '2022-05-31';
                    $to = '2022-05-31';
                    $id = 1;
                ?>
                    
                    <div class="row">
                        
                            
                        <div class="col-3">
                            <label class=" ">@lang('lang.from')</label>
                            <input type="date" name="from" id="from" class="form-control form-control-sm" onChange="setFrom(this.value)" required >
                        </div>
                        <div class="col-3">
                            <label class="">@lang('lang.to')</label>
                            <input type="date" name="to" id="to" class="form-control form-control-sm" onChange="setTo(this.value)" required >
                        </div>
                        <div class="col-3">
                            <label class="">Customers</label>
                            <select class="form-control form-control-sm select2" name="customer" id="customer" onChange="setCustomer(this.value)">
                                <option>Select Customers</option>
                                <option value=0 selected>All</option>
                                @foreach($customers as $customer)
                                    <option value="{{$customer->id}}">{{$customer->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        
                        <div class="col-md-2 m-t-30">
                            <button class="btn btn-sm btn-outline-info rounded" id="search_vouchers">
                                <i class="fas fa-search mr-1"></i>Search
                            </button>
                        </div>
                    </div>
                
                
                

            </div>
            
            
            
        </div>
        
        
        
        
                    <div class="col-md-4 mt-4">
                       
                       <form id="exportForm" onsubmit="return exportForm()" method="get">
                 <div class="row">
                <input type="hidden" name="export_from" id="export_from" class="form-control form-control-sm hidden" required>
                <input type="hidden" name="export_to" id="export_to" class="form-control form-control-sm hidden" required>
                <input type="hidden" name="export_customer" id="export_customer" class="form-control form-control-sm hidden" required>
                <div class="col-3">
                     <select name="export_data_type" id="export_data_type" class="form-control form-control-sm select2" style="font-size: 12px;">
                                <option value=1 selected>Vouchers</option>
                                <option value=2 >Items</option>
                        </select>  
                    
                </div>
                <div class="col-3">
                     <select name="export_type" id="export_type" class="form-control form-control-sm select2" style="font-size: 12px;">
                                <option value=1 selected>Excel</option>
                                <option value=2 >PDF</option>
                        </select>  
                    
                </div>
                
                <div class="col-6">
                <input type="submit" class="btn btn-sm rounded btn-outline-info col-4" value=" Export ">
                </div>
                </div>            
                        
            </form>
                       
                         
                    </div>
                
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                
                <div class="row p-2 offset-10">
                        <input  type="text" id="table_search" placeholder="Quick Search" onkeyup="search_table()" >    
                    </div>
                
                <div class="table-responsive text-black" id="slimtest2">
                    <table class="table" id="item_table">
                        <thead class="head">
                        <tr class="text-center text-info">
                            <th>#</th>
                            <th>@lang('lang.voucher') @lang('lang.number')</th>
                            <th>@lang('lang.voucher') @lang('lang.date')</th>
                            <th>Customer</th>
                            <th>Order Date</th>
                            <th>Delivered Date</th>
                            <th>@lang('lang.total') @lang('lang.quantity')</th>
                            <th>@lang('lang.total') @lang('lang.price')</th>
                            <th>Discount</th>
                            <th>Advance</th>
                            <th>Outstanding</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody id="item_list" class="body">
                        <?php
                        $i = 1;
                        ?>
                        @foreach($orderVouchers as $ov)
                            <tr class="text-center" style="font-size: 13px;">
                                <td>{{$i++}}</td>
                                <td>{{$ov->voucher_number??"-"}}</td>
                                <td>{{$ov->voucher_date}}</td>
                                <td>{{$ov->sales_customer_name??""}}</td>
                                <td>{{$ov->order_date}}</td>
                                <td>{{$ov->delivered_date}}</td>
                                <td>{{$ov->total_quantity}}</td>
                                <td>{{$ov->total_price??0}}</td>
                                <td>{{$ov->discount??0}}</td>
                                <td>{{$ov->advance??0}}</td>
                                <td>{{$ov->outstanding - $ov->discount ??0}}</td>
                                <td style="text-align: center;" ><a href="{{route('orderVoucherDetails',$ov->id)}}" class="btn btn-sm rounded btn-outline-info">@lang('lang.details')</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
@section('js')
<script src="{{asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.slimscroll.js')}}"></script>
<script type="text/javascript">

	$(document).ready(function(){
	     const today = new Date();
         var dd = today.getDate();
         var mm = today.getMonth()+1;
         var yyyy= today.getFullYear();
	    $('#export_from').val(yyyy+'-'+mm+'-'+dd);
	    $('#export_to').val(yyyy+'-'+mm+'-'+dd);
	    $('#export_customer').val(0);
	    $('#export_data_type').val(1);
	    $("#export_type").val(1);
	});
	
    $('#slimtest2').slimScroll({
        color: '#000',
        height: '600px'
    });
    
    function search_table(){
            var input, filter, table,tr,td,i;
            input = document.getElementById("table_search");
            filter = input.value.toUpperCase();
            table = document.getElementById("item_table");
            tr = table.getElementsByTagName("tr");
            
            var searchColumn = [1,2,3,4,5,6,7,8,9,10];
            
            for(i = 0; i < tr.length; i++){
                if($(tr[i]).parent().attr('class') == 'head'){
                    continue;
                }
                
                var found = false;
                
                for(var k=0; k < searchColumn.length; k++){
                    td = tr[i].getElementsByTagName("td")[searchColumn[k]];
                    if(td){
                        if(td.innerHTML.toUpperCase().indexOf(filter) > -1){
                            found=true;
                        }
                    }
                }
                if(found == true){
                    tr[i].style.display = "";
                }else{
                    tr[i].style.display = "none";
                }
            }
        }
    
     function setFrom(value){
        $("#exportForm :input[name=export_from]").val(value);
    }
    
     function setTo(value){
        $("#exportForm :input[name=export_to]").val(value);
    }
    
     function setCustomer(value){
        $("#exportForm :input[name=export_customer]").val(value);
    }
    function exportForm(){
       
        //var form = document.getElementById("exportForm");
        //var data = new URLSearchParams(form).toString();
        var from = $("#exportForm :input[name=export_from]").val();
        var to = $("#exportForm :input[name=export_to]").val();
        var id =  $("#exportForm :input[name=export_customer]").val();
        var data_type = $("#exportForm :input[name=export_data_type]").find(":selected").val();
        var type = $("#exportForm :input[name=export_type]").find(":selected").val();
        console.log(from,to,id,data_type,type);
        
        
        
         let url = `/export-orderhistory/${from}/${to}/${id}/${data_type}/${type}`;
         window.location.href= url;
         
         const today = new Date();
         var dd = today.getDate();
         var mm = today.getMonth()+1;
         var yyyy= today.getFullYear();
         if(dd <10){
             dd = '0' + dd;
         }
         if(mm < 10){
             mm = '0' + mm;
         }
          $('#export_from').val(yyyy+'-'+mm+'-'+dd);
	    $('#export_to').val(yyyy+'-'+mm+'-'+dd);
	    $('#export_customer').val(0);
         $('#export_data_type').val(1);
	    $("#export_type").val(1);
        return false;
    };
   
   
    
    $('#search_vouchers').click(function(){
        // let current_Date = $('#current_Date').val();
        // let fb_page = $('#fb_pages').val();
        // let order_type = $('#order_type').val();
        // let url = `/arrived-orders/${current_Date}/${fb_page}/${order_type}`;
        // window.location.href= url;
        
        
        var from = $('#from').val();
        var to = $('#to').val();
        var customer = $("#customer").find(":selected").val();
        console.log(from,to,customer);
        $.ajax({

            type: 'POST',

            url: '{{ route('search_order_history') }}',

            data: {
                "_token": "{{ csrf_token() }}",
                
                "from" : from,
                "to" : to,
                "customer" : customer
            },

            success: function(data) {
                if (data.length >0) {
                    console.log(data);
                    var html = '';
                    $.each(data, function(i, voucher) {
                       
                       
                        var url1 = '{{ route('orderVoucherDetails', ':voucher_id') }}';

                        url1 = url1.replace(':voucher_id', voucher.id);
                        html += `
                    <tr class="text-center" style="font-size: 13px;">
                                <td>${++i}</td>
                                <td>${voucher.voucher_number??"-"}</td>
                                <td>${voucher.voucher_date}</td>
                                <td>${voucher.sales_customer_name??""}</td>
                                <td>${voucher.order_date}</td>
                                <td>${voucher.delivered_date}</td>
                                <td>${voucher.total_quantity}</td>
                                <td>${voucher.total_price??0}</td>
                                <td>${voucher.discount??0}</td>
                                <td>${voucher.advance??0}</td>
                                <td>${voucher.outstanding - voucher.discount ??0}</td>
                                <td style="text-align: center;" ><a href="${url1}" class="btn btn-sm rounded btn-outline-info">@lang('lang.details')</a></td>
                            </tr>
                    `;

                        $('#item_list').empty();
                        $('#item_list').html(html);
                    })
                    
                  // $('#item_table').DataTable().clear().draw();
                    // $('#item_table').DataTable( {

                    //     "paging":   false,
                    //     "ordering": true,
                    //     "info":     false,
                    //     "destroy": true
                    // });

                    // swal({
                    //     toast:true,
                    //     position:'top-end',
                    //     title:"Success",
                    //     text:"Orders Changed!",
                    //     button:false,
                    //     timer:500,
                    //     icon:"success"  
                    // });

                } else {
                    var html = `
                    
                    <tr>
                        <td colspan="9" class="text-danger text-center">No Data Found</td>
                    </tr>

                    `;
                    $('#item_list').empty();
                    $('#item_list').html(html);
                
                }
            },
            });
        
    })
</script>
@endsection
