@extends('master')

@section('title','Order Page')

@section('place')

@endsection

@section('content')
    <style>
        th{
            overflow:hidden;
            white-space: nowrap;
        }
        .badge-success{
            background: #5AD669 !important;
        }
    </style>
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h4 class="font-weight-normal text-black">Delivered Factory Order</h4>
        </div>
    </div>
    
    <div class="row justify-content-start">
        <div class="col-8">
           <div class="mb-4">
                <div class="row">
                      <?php
                    //$from = date('Y-m-d',strtotime(now()));
                    //$to = date('Y-m-d',strtotime(now()));;
                    $from = date('Y-m-d',strtotime(now()));
                    $to = date('Y-m-d',strtotime(now()));
                    $id = 0;
                ?>
                    <div class="col-3">
                        <label class="">@lang('lang.from')</label>
                        <input type="date" name="from" id="from" class="form-control form-control-sm" required value="{{$from}}">
                    </div>
                    <div class="col-3">
                        <label class="">@lang('lang.to')</label>
                        <input type="date" name="to" id="to" class="form-control form-control-sm" required value="{{$to}}">
                    </div>
                    
                    
                    <div class="col-3">
                        <label class="">Sales Person</label>
                        <select name="sales_person" id="sales_person" class="form-control form-control-sm select2">
                            <option>Select Sales Person</option>
                                <option value='All' selected>All</option>
                            @foreach(\App\User::where('role','Sales')->orWhere('role','Owner')->get() as $employee)
                                <option value="{{$employee->name}}">{{$employee->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2 m-t-30">
                        <button class="btn btn-sm rounded btn-outline-info" id="search_orders">
                            <i class="fas fa-search mr-2"></i>Search
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-body">
                    <div class="row p-2 offset-10">
                        <input  type="text" id="table_search" placeholder="Quick Search" onkeyup="search_table()" >    
                    </div>
                    
                    <div class="table-responsive text-black">
                        <table class="table" id="order_table">
                            <thead class="head">
                            <tr class="text-center text-primary h6">
                                <th>#</th>
                                <th>Factory Order No</th>
                                <th>Order No</th>
                                <th>Order By</th>
                                <th>Order Date</th>
                                <th>Depart Name</th>
                                
                                <th>Actual Deliver Date</th>
                                
                                <th>Factory Remark</th>
                                <th>Showroom</th>
                                <th>Order Quantity</th>
                                <th>Factory Quantity</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody id="order_list" class="body">
                                <?php
                                    $i = 1;
                                ?>
                            @foreach(\App\FactoryOrder::where('status',2)->orderBy('id','desc')->get() as $factoryOrder)
                                <?php
                                    $factory_item_quantity = 0;
                                ?>
                                @foreach(\App\CustomUnitFactoryOrder::where("factory_order_id",$factoryOrder->id)->get() as $factoryOrderItem)
                                        @php
                                        $factory_item_quantity += $factoryOrderItem->quantity;
                                        @endphp
                                    @endforeach

                                <tr class="text-center" style="font-size: 15px;">
                                    <td>{{$i++}}</td>
                                    <td>{{$factoryOrder->factory_order_number}}</td>
                                    @foreach(\App\Order::where("id",$factoryOrder->order_id)->get() as $order)
                                        <td>{{$order->order_number}}</td>
                                        <td>{{$order->order_by}}</td>
                                        <td>{{$order->order_date}}</td>
                                    @endforeach
                                    <td>{{$factoryOrder->department_name}}</td>
                                    
                                    <td>{{$factoryOrder->delivery_date}}</td>
                                    <td>{{$factoryOrder->delivery_remark?? '-'}}</td>
                                    <td>{{$factoryOrder->showroom}}</td>
                                    <td>{{$factoryOrder->total_quantity}}</td>
                                    <td>{{$factory_item_quantity}}</td>
                                    <td>
                                        <a href="{{route('factoryOrderDetail',$factoryOrder->id)}}" class="btn btn-sm rounded btn-outline-info" title="Factory Order Detail">
                                            <i class="fas fa-info-circle"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('js')

    <script type="text/javascript">

        // $('#example23').DataTable( {

        //     "paging":   false,
        //     "ordering": true,
        //     "info":     false

        // });
        
        // $(document).ready(function(){
        //     $('#table_search').on("keyup",function(){
        //         var value = $(this).val().toLowerCase();
        //         $("#order_table tr").filter(function(){
        //             $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1); 
        //         });
        //     }); 
        // });
        
        function search_table(){
            var input, filter, table,tr,td,i;
            input = document.getElementById("table_search");
            filter = input.value.toUpperCase();
            table = document.getElementById("order_table");
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
        
        $('#search_orders').click(function(){
        // let current_Date = $('#current_Date').val();
        // let fb_page = $('#fb_pages').val();
        // let order_type = $('#order_type').val();
        // let url = `/arrived-orders/${current_Date}/${fb_page}/${order_type}`;
        // window.location.href= url;
        
        
        var from = $('#from').val();
        var to = $('#to').val();
        var sales = $("#sales_person").find(":selected").val();
        var type = 2;
            $.ajax({

            type: 'POST',

            

            url: '{{ route('search_factoryorder_history') }}',

            data: {
                "_token": "{{ csrf_token() }}",
                "from" : from,
                "to" : to,
                "sales" : sales,
                "type" : type
            },

            success: function(data) {
                if (data.length >0) {
                    console.log(data);
                    var html = '';
                    $.each(data, function(i, factoryOrder) {
                        var printstatus = '';
                        if(factoryOrder['print_status'] == 0){
                            printstatus = "Not Printed";
                        }else{
                            printstatus = "Printed";
                        }
                        
                        var url1 = '{{ route('factoryOrderDetail', ':order_id') }}';

                        url1 = url1.replace(':order_id', factoryOrder['id']);
                        
                        html += `
                            <tr class="text-center" style="font-size: 15px;">
                                    <td>${++i}</td>
                                    <td>${factoryOrder['factoryorder_number']}</td>
                                        <td>${factoryOrder['order_number']}</td>
                                    <td>${factoryOrder['order_by'] ?? '-'}</td>
                                    <td>${factoryOrder['order_date']}</td>
                                    <td>${factoryOrder['department_name'] ?? '-'}</td>
                                    <td>${factoryOrder['plan_date'] ?? '-'}</td>
                                    <td>${factoryOrder['remark'] ?? '-'}</td>
                                    <td>${factoryOrder['showroom']}</td>
                                    <td>${factoryOrder['total_quantity']}</td>
                                    <td>${factoryOrder['item_quantity']}</td>
                                    
                                    <td><span class="badge badge-info font-weight-bold">
                                        ${printstatus}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="${url1}" class="btn btn-sm rounded btn-outline-info" title="Factory Order Detail">
                                            <i class="fas fa-info-circle"></i>
                                        </a>
                                    </td>
                                </tr>
                        `;
                        $('#order_list').empty();
                       $('#order_list').html(html);
                    });
                    
                    $('#order_table').DataTable( {

                        "paging":   false,
                        "ordering": true,
                        "info":     false,
                        "destroy": true
                    });
                    
                    
                }
            },
            
            });
            
        });

    </script>



@endsection
