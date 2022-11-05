@extends('master')

@section('title', 'Transition Vouchers')

@section('place')

    <div class="col-md-5 col-8 align-self-center">
        <h4 class="text-themecolor m-b-0 m-t-0"></h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">@lang('lang.back_to_dashboard')</a></li>
            <li class="breadcrumb-item active">Receivable and Payable Lists</li>
        </ol>
    </div>

@endsection

@section('content')
    <section id="plan-features">

        <div class="container">
            <div class="card">
                <div class="card-body shadow">
                    
                    <div class="row">
                    <div class="col-12">
                        <ul class="nav nav-pills m-t-30 m-b-30 ">
                            <li class="nav-item">
                                <a href="#navpills-1" class="nav-link active" data-toggle="tab" aria-expanded="false">
                                    Receivable
                                </a>
                            </li>
                            <li class=" nav-item">
                                <a href="#navpills-2" class="nav-link" data-toggle="tab" aria-expanded="false">
                                    Payable
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content br-n pn">
                            
                            <div id="navpills-1" class="tab-pane active">
                                
                                
                            <div class="clearfix"></div>
                                <div class="row">

                                    <div class="col-md-12">
                                        <div class="card shadow">
                                            
                                            <div class="card-header">
                                                <div class="row mt-3">
            @csrf
            <div class="col-md-2">
                <label class="control-label font-weight-bold">From Date</label>
                <input type="date" name="receive_from_date" id="receive_from_date" class="form-control" value="{{ $current_Date }}" onChange="setRFrom(this.value)" required>
            </div>
            <div class="col-md-2">
                <label class="control-label font-weight-bold">To Date</label>
                <input type="date" name="receive_to_date" id="receive_to_date" class="form-control" value="{{ $current_Date }}" onChange="setRTo(this.value)" required>
            </div>
            
            <div class="col-md-2">
                <label class="control-label font-weight-bold">Customers</label>
                <select class="form-control" id="customer_select" onChange="setRCustomer(this.value)">
                    <option value="0">All</option>
                    @foreach ($customers as $customer)
                        <option value="{{$customer->id}}">{{ $customer->name  }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-1 m-t-30">
                <button class="btn btn-info px-4" id="receive_search_orders">Search</button>
            </div>
            <div class="col-md-1 m-t-30">
                <button class="btn btn-success px-4" id="receive_print" onclick="receive_print()">Print</button>
            </div>
            
            <div class="col-md-1 mt-4">
             
             <form id="exportRForm" onsubmit="return exportRForm()" method="get">
                 <div class="row ml-2 mt-1">
                <input type="hidden" name="rexport_from" id="rexport_from" class="form-control form-control-sm hidden" required>
                <input type="hidden" name="rexport_to" id="rexport_to" class="form-control form-control-sm hidden" required>
                <input type="hidden" name="rexport_customer" id="rexport_customer" class="form-control form-control-sm hidden" required>
                
                
                <div class="ml-2 mt-2">
                <input type="submit" class="btn btn-sm rounded btn-outline-info" value=" Export ">
                </div>
                
                </div>            
                        
            </form>
            
        </div>
        
        <div class="col-md-2 ml-4 m-t-30 p-2">
                        <input  type="text" id="rtable_search" placeholder="Quick Search" onkeyup="search_rtable()" >    
                    </div>
            
        </div>
        
        
         
                                            </div>
                                            
                                            <div class="card-body receive_printableArea">
                                                
                                                
                                                <div style="text-align: center;" id="rlogo_area">
         <img src="{{asset('image/medical_world_logo_update.jpg')}}" class="m-l-120 m-b-10" height="150px">
    </div>
    
        <div class="col-md-6 ml-3" >
            <p class="font-weight-bold mt-2" style="font-size: 23px">Receivable Report</p> 
        </div>
         
         <div class="col-md-6 ml-3" id="rname_area">
            <p class="font-weight-bold mt-2" style="font-size: 20px">Report Name: {{$name}}</p> 
        </div>
        
        <div class="col-md-6 ml-3" id="rdate_area">
            <p class="font-weight-bold mt-2" style="font-size: 20px" id="rreport_date">Report Date: {{$current_Date}} </p> 
        </div>
                                                
                                                
                                               <div class="table-responsive text-black" id="slimtest2">
                                <table class="table" id="order_table">
                                    <thead class="head">
                                        <tr class="text-center">
                                            <th>@lang('lang.number')</th>
                                            
                                            <th>Order No.</th>
                                            <th>Order Date</th>
                                            <th>Status</th>
                                            <th>Customer Name</th>
                                            <th>Customer Phone</th>
                                            <th>Total Amount</th>
                                            <th>Advance Payment</th>
                                            <th>Oustanding</th>
                                           
                                            <th class="text-center rdetails">@lang('lang.details')</th>
                                            {{-- <th class="text-center">@lang('lang.action')</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody id="order_list" class="body">
                                        <?php
                                        $i = 1;
                                        $order_total = 0;
                                        $receivable_total = 0;
                                        ?>
                                        @foreach ($unpaid_orders as $key=>$order)
                                            <tr class="text-center">
                                                <td>{{ $i++ }}</td>
                                                
                                                <td>{{ $order['order_code'] }}</td>
                                                <td>{{ $order['order_date'] }}</td>
                                                <td>@if ($order['order_status']==1)
                            Incoming
                            @elseif($order['order_status']==2)
                            Confirmed
                            @elseif($order['order_status']==3)
                            Changed Order
                            @elseif($order['order_status']==4)
                            Delivered
                            @elseif($order['order_status']==5)
                            Canceled
                            @else
                            Prepaid Partial
                        @endif</td>
                                                <td>{{$order['customer_name']}}</td>
                                                <td>{{$order['customer_phone']}}</td>
                                                <td>{{$order['total_amount']}}</td>
                                                <td>{{$order['paid_amount']}}</td>
                                                <td>{{$order['total_amount']- $order['paid_amount'] - $order['discount_amount']}}</td>
                                                
                                                <?php
                                                    $order_total+= $order['total_amount'];
                                                    $receivable_total += $order['total_amount'] - $order['paid_amount'];
                                                ?>
                                                
                                                <td class="text-center rdetails"><a
                                                        href="{{ route('order_details', $order['order_id']) }}"
                                                        class="btn btn-sm btn-outline-info">Details</a>
                                                </td>
                                                
                                            </tr>
                                        @endforeach
                                        <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="text-info">Order Total</td>
                                <td class="text-right font-bold">{{$order_total}}</td>
                                <td class="text-info">Receivable Total</td>
                                <td class="text-right font-bold">{{$receivable_total}}</td>
                            </tr>
                                        
                                    </tbody>
                                </table>
                            </div>

                                                
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                
                                
                                
                                
                            </div>
                            
                            
                            <div id="navpills-2" class="tab-pane">
                            
                            
                            <div class="clearfix"></div>
                                <div class="row">

                                    <div class="col-md-12">
                                        <div class="card shadow">
                                            
                                            <div class="card-header">
                                                <div class="row ml-4 mt-3">
            @csrf
            <div class="col-md-2">
                <label class="control-label font-weight-bold">From Date</label>
                <input type="date" name="pay_from_date" id="pay_from_date" class="form-control" value="{{ $current_Date }}" onChange="setPFrom(this.value)" required>
            </div>
            <div class="col-md-2">
                <label class="control-label font-weight-bold">To Date</label>
                <input type="date" name="pay_to_date" id="pay_to_date" class="form-control" value="{{ $current_Date }}" onChange="setPTo(this.value)" required>
            </div>
            
            <div class="col-md-2">
                <label class="control-label font-weight-bold">Suppliers</label>
                <select class="form-control" id="supplier_select" onChange="setPCustomer(this.value)">
                    <option value="0">All</option>
                    @foreach ($suppliers as $supplier)
                        <option value="{{$supplier->id}}">{{ $supplier->name  }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-1 m-t-30">
                <button class="btn btn-info px-4" id="pay_search_orders">Search</button>
            </div>
            <div class="col-md-1 m-t-30">
                <button class="btn btn-success px-4" id="pay_print" onclick="pay_print()">Print</button>
            </div>
            
            <div class="col-md-1 mt-4">
             
             <form id="exportPForm" onsubmit="return exportPForm()" method="get">
                 <div class="row ml-2 mt-1">
                <input type="hidden" name="pexport_from" id="pexport_from" class="form-control form-control-sm hidden" required>
                <input type="hidden" name="pexport_to" id="pexport_to" class="form-control form-control-sm hidden" required>
                <input type="hidden" name="pexport_customer" id="pexport_customer" class="form-control form-control-sm hidden" required>
                
                
                <div class="ml-2 mt-2">
                <input type="submit" class="btn btn-sm rounded btn-outline-info" value=" Export ">
                </div>
                
                </div>            
                        
            </form>
            
            
        </div>
        
        <div class="col-md-2 ml-4 m-t-30 p-2">
                        <input  type="text" id="ptable_search" placeholder="Quick Search" onkeyup="search_ptable()" >    
                    </div>
            
        </div>
                                                
                                            </div>
                                            
                                            <div class="card-body pay_printableArea">
                                                
                                                <div style="text-align: center;" id="plogo_area">
         <img src="{{asset('image/medical_world_logo_update.jpg')}}" class="m-l-120 m-b-10" height="150px">
    </div>
    
        <div class="col-md-6 ml-3" >
            <p class="font-weight-bold mt-2" style="font-size: 23px">Payable Report</p> 
        </div>
         
         <div class="col-md-6 ml-3" id="pname_area">
            <p class="font-weight-bold mt-2" style="font-size: 20px">Report Name: {{$name}}</p> 
        </div>
        
        <div class="col-md-6 ml-3" id="pdate_area">
            <p class="font-weight-bold mt-2" style="font-size: 20px" id="preport_date">Report Date: {{$current_Date}} </p> 
        </div>
                                                
                                               <div class="table-responsive text-black" id="slimtest2">
                                <table class="table" id="purchase_table">
                                    <thead class="head">
                                        <tr class="text-center">
                                            <th>@lang('lang.number')</th>
                                            
                                            <th>Purchase No.</th>
                                            <th>Purchase Date</th>
                                            <th>Type</th>
                                            <th>Supplier Name</th>
                                            <th>Supplier Phone</th>
                                            <th>Total Amount</th>
                                            <th>Credit Amount</th>
                                            <th>Repayment</th>
                                            <th>Remaining Credit</th>
                                           
                                            <th class="text-center pdetails">@lang('lang.details')</th>
                                            {{-- <th class="text-center">@lang('lang.action')</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody id="purchase_list" class="body">
                                        <?php
                                        $i = 1;
                                        $purchase_total = 0;
                                        $payable_total =0;
                                        ?>
                                        @foreach ($credit_purchases as $key=>$purchase)
                                            <tr class="text-center">
                                                <td>{{ $i++ }}</td>
                                                
                                                <td>{{ $purchase['purchase_code'] }}</td>
                                                <td>{{ $purchase['purchase_date'] }}</td>
                                                <td>@if ($purchase['purchase_type']==1)
                            Sales Product Receive
                            @elseif($purchase['purchase_type']==2)
                            Factory Item Purchase
                            @else
                            Factory Item Purchase
                        @endif</td>
                                                <td>{{$purchase['supplier_name']}}</td>
                                                <td>09</td>
                                                <td>{{$purchase['total_amount']}}</td>
                                                <td>{{$purchase['credit_amount']}}</td>
                                                <td>{{$purchase['total_repay_amount']}}</td>
                                                <td>{{$purchase['credit_amount']}} - {{$purchase['total_repay_amount']}}</td>
                                                
                                                <?php
                                                    $purchase_total += $purchase['total_amount'];
                                                    $payable_total += ($purchase['credit_amount']-$purchase['total_repay_amount']);
                                                ?>
                                                
                                                <td class="text-center pdetails"><a
                                                        href="{{ route('purchase_details', $purchase['purchase_id']) }}"
                                                        class="btn btn-sm btn-outline-info">Details</a>
                                                </td>
                                                
                                            </tr>
                                        @endforeach
                                        
                                        <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="text-info">Purchase Total</td>
                                <td class="text-center font-bold">{{$purchase_total}}</td>
                                <td class="text-info">Payable Total</td>
                                <td class="text-center font-bold">{{$payable_total}}</td>
                            </tr>
                                        
                                    </tbody>
                                </table>
                            </div>

                                                
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            
                            
                            </div>
                            
                        </div>
                    </div>
                </div>
                    
                    
                    
                </div>
            </div>
        </div>

        
    </section>

@endsection

@section('js')

    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>

    {{-- <script src="{{asset('assets/js/jquery.slimscroll.js')}}"></script> --}}
    <script src="{{ asset('js/jquery.PrintArea.js') }}" type="text/JavaScript"></script>

    <script type="text/javascript">
    
    $(document).ready(function() {
        
        $('#rlogo_area').hide();
        $('#rname_area').hide();
        $('#rdate_area').hide();
        
        $('#plogo_area').hide();
        $('#pname_area').hide();
        $('#pdate_area').hide();
        const today = new Date();
         var dd = today.getDate();
         var mm = today.getMonth()+1;
         var yyyy= today.getFullYear();
	    $('#rexport_from').val(yyyy+'-'+mm+'-'+dd);
	    $('#rexport_to').val(yyyy+'-'+mm+'-'+dd);
	    $('#rexport_customer').val(0);
	    
	    $('#pexport_from').val(yyyy+'-'+mm+'-'+dd);
	    $('#pexport_to').val(yyyy+'-'+mm+'-'+dd);
	    $('#pexport_customer').val(0);
            
        });
        
    function setRFrom(value){
        $("#exportRForm :input[name=rexport_from]").val(value);
    }
    
     function setRTo(value){
        $("#exportRForm :input[name=rexport_to]").val(value);
    }
    
     function setRCustomer(value){
        $("#exportRForm :input[name=rexport_customer]").val(value);
    }
    
    function exportRForm(){
       
        //var form = document.getElementById("exportForm");
        //var data = new URLSearchParams(form).toString();
        var from = $("#exportRForm :input[name=rexport_from]").val();
        var to = $("#exportRForm :input[name=rexport_to]").val();
        var id =  $("#exportRForm :input[name=rexport_customer]").val();
        
        console.log(from,to,id);
        
        // fetch("http://medicalworldinvpos.kwintechnologykw09.com/Sale/Voucher/HistoryExport/${from}/${to}/${id}",{
        //     method: "get"
        // }).then(()=>{console.log('Export Success');})
        // .catch((err)=>{console.log(err);});
         let url = `/export-receivehistory/${from}/${to}/${id}`;
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
          $('#rexport_from').val(yyyy+'-'+mm+'-'+dd);
	    $('#rexport_to').val(yyyy+'-'+mm+'-'+dd);
	    $('#rexport_customer').val(0);

        return false;
    };
    
     function setPFrom(value){
        $("#exportPForm :input[name=pexport_from]").val(value);
    }
    
     function setPTo(value){
        $("#exportPForm :input[name=pexport_to]").val(value);
    }
    
     function setPCustomer(value){
        $("#exportPForm :input[name=pexport_customer]").val(value);
    }
    
    function exportPForm(){
       
        //var form = document.getElementById("exportForm");
        //var data = new URLSearchParams(form).toString();
        var from = $("#exportPForm :input[name=pexport_from]").val();
        var to = $("#exportPForm :input[name=pexport_to]").val();
        var id =  $("#exportPForm :input[name=pexport_customer]").val();
        
        console.log(from,to,id);
        
        // fetch("http://medicalworldinvpos.kwintechnologykw09.com/Sale/Voucher/HistoryExport/${from}/${to}/${id}",{
        //     method: "get"
        // }).then(()=>{console.log('Export Success');})
        // .catch((err)=>{console.log(err);});
         let url = `/export-payhistory/${from}/${to}/${id}`;
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
          $('#pexport_from').val(yyyy+'-'+mm+'-'+dd);
	    $('#pexport_to').val(yyyy+'-'+mm+'-'+dd);
	    $('#pexport_customer').val(0);

        return false;
    };
    
    function search_rtable(){
            var input, filter, table,tr,td,i;
            input = document.getElementById("rtable_search");
            filter = input.value.toUpperCase();
            table = document.getElementById("order_table");
            tr = table.getElementsByTagName("tr");
            
            var searchColumn = [1,2,3,4,5,6,7,8];
            
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
        
    function search_ptable(){
            var input, filter, table,tr,td,i;
            input = document.getElementById("ptable_search");
            filter = input.value.toUpperCase();
            table = document.getElementById("purchase_table");
            tr = table.getElementsByTagName("tr");
            
            var searchColumn = [1,2,3,4,5,6,7,8];
            
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
        
    function receive_print(){
        console.log('printing');
        var mode = 'iframe'; //popup
                var close = mode == "popup";
                var options = {
                    mode: mode,
                    popClose: close
                };
                $('#rlogo_area').show();
        $('#rname_area').show();
        $('#rdate_area').show();
        $('.rdetails').addClass('d-none');
                $("div.receive_printableArea").printArea(options);
                setInterval(() => {
                
                     $('#rlogo_area').hide();
        $('#rname_area').hide();
        $('#rdate_area').hide();
        $('.rdetails').removeClass('d-none');
                }, 3000);
    }
    
    function pay_print(){
        console.log('printing');
        var mode = 'iframe'; //popup
                var close = mode == "popup";
                var options = {
                    mode: mode,
                    popClose: close
                };
                $('#plogo_area').show();
        $('#pname_area').show();
        $('#pdate_area').show();
        $('.pdetails').addClass('d-none');
                $("div.pay_printableArea").printArea(options);
                setInterval(() => {
                
                     $('#plogo_area').hide();
        $('#pname_area').hide();
        $('#pdate_area').hide();
        $('.pdetails').removeClass('d-none');
                }, 3000);
    }
    
    $('#receive_search_orders').click(function(){
            
            var value = $('#customer_select').val();
            var from = $('#receive_from_date').val();
            var to = $('#receive_to_date').val();
            
            console.log(from,to,value);
            $.ajax({

            type: 'POST',

            url: '{{ route('search_receivable_bydate') }}',

            data: {
                "_token": "{{ csrf_token() }}",
                'to' : to,
                "from" : from,
                "value":value
            },

            success: function(data) {
                console.log(data);
                if (data.length >0) {
                    var html = '';
                    var orderTotal = 0;
                    var receivableTotal = 0;
                    var status = '';
                    $.each(data, function(i, order) {
                        orderTotal += order.total_amount;
                        if(order.order_status == 1){
                            status = 'Incoming';
                        }else if(order.order_status == 2){
                            status = 'Confirmed';
                        }else if(order.order_status == 3){
                            status = 'Changed';
                        }else if(order.order_status == 4){
                            status = 'Delivered';
                        }else if(order.order_status == 5){
                            status = 'Canceled';
                        }else{
                            status = 'Incoming';
                        }
                        
                        receivableTotal += (order.total_amount - order.paid_amount);
                        var url1 = '{{ route('order_details', ':order_id') }}';

                        url1 = url1.replace(':order_id', order.order_id);
                        html += `
                    <tr class="text-center">
                                                <td>${++i}</td>
                                                
                                                <td>${order.order_code}</td>
                                                <td>${order.order_date}</td>
                                                <td>${status}</td>
                                                <td>${order.customer_name}</td>
                                                <td>${order.customer_phone}</td>
                                                <td>${order.total_amount}</td>
                                                <td>${order.paid_amount}</td>
                                                <td>${order.total_amount- order.paid_amount - order.discount_amount}</td>
                                                <td class="text-center rdetails"><a
                                                        href="${url1}"
                                                        class="btn btn-sm btn-outline-info">Details</a>
                                                </td>
                                                
                                            </tr>
                    `;
                    

                    })
                    
                    html+=`
                    <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="text-info">Order Total</td>
                                <td class="text-right font-bold">${orderTotal}</td>
                                <td class="text-info">Receivable Total</td>
                                <td class="text-right font-bold">${receivableTotal}</td>
                            </tr>
                    `;
                    
                    $('#order_list').empty();
                        $('#order_list').html(html);
                        $('#rreport_date').text("Report Date: "+ from + " to " + to);
                        

                } else {
                    var html = `
                    
                    <tr>
                        <td colspan="9" class="text-danger text-center">No Data Found</td>
                    </tr>

                    `;
                    $('#order_list').empty();
                    $('#order_list').html(html);
                
                }
            },
            });
        })
        
        
        $('#pay_search_orders').click(function(){
            
            var value = $('#supplier_select').val();
            var from = $('#pay_from_date').val();
            var to = $('#pay_to_date').val();
            
            console.log(from,to,value);
            $.ajax({

            type: 'POST',

            url: '{{ route('search_payable_bydate') }}',

            data: {
                "_token": "{{ csrf_token() }}",
                'to' : to,
                "from" : from,
                "value":value
            },

            success: function(data) {
                console.log(data);
                if (data.length >0) {
                    var html = '';
                    var purchaseTotal = 0;
                    var payableTotal = 0;
                    var remain_amount = 0;
                    var purchase_type  = '';
                    $.each(data, function(i, purchase) {
                       purchaseTotal += purchase.total_amount;
                       remain_amount = purchase.credit_amount - purchase.total_repay_amount;
                       payableTotal += (purchase.credit_amount-purchase.total_repay_amount);
                       if(purchase.purchase_type == 1){
                           purchase_type = 'Sales Products Receive';
                       }else if(purchase.purchase_type == 2){
                           purchase_type = 'Factory Items Purchase';
                       }else{
                           purchase_type = 'Factory Items Purchase';
                       }
                        var url1 = '{{ route('purchase_details', ':purchase_id') }}';

                        url1 = url1.replace(':purchase_id', purchase.purchase_id);
                        html += `
                    <tr class="text-center">
                                                <td>${++i}</td>
                                                
                                                <td>${purchase.purchase_code}</td>
                                                <td>${purchase.purchase_date}</td>
                                                <td>${purchase_type}</td>
                                                <td>${purchase.supplier_name}</td>
                                                <td>09</td>
                                                <td>${purchase.total_amount}</td>
                                                <td>${purchase.credit_amount}</td>
                                                <td>${purchase.total_repay_amount}</td>
                                                <td>${remain_amount}</td>
                                                <td class="text-center pdetails"><a
                                                        href="${url1}"
                                                        class="btn btn-sm btn-outline-info">Details</a>
                                                </td>
                                                
                                            </tr>
                    `;
                    

                    })
                    
                    html+=`
                    <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="text-info">Purchase Total</td>
                                <td class="text-right font-bold">${purchaseTotal}</td>
                                <td class="text-info">Payable Total</td>
                                <td class="text-right font-bold">${payableTotal}</td>
                            </tr>
                    `;
                    
                    $('#purchase_list').empty();
                        $('#purchase_list').html(html);
                        $('#preport_date').text("Report Date: "+ from + " to " + to);
                        

                } else {
                    var html = `
                    
                    <tr>
                        <td colspan="9" class="text-danger text-center">No Data Found</td>
                    </tr>

                    `;
                    $('#purchase_list').empty();
                    $('#purchase_list').html(html);
                
                }
            },
            });
        })
        
    </script>

@endsection
