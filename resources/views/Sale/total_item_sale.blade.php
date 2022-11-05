@extends('master')

@section('title','Item List')

@section('place')

{{-- <div class="col-md-5 col-8 align-self-center">
    <h3 class="text-themecolor m-b-0 m-t-0">@lang('lang.branch')</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('index')}}">@lang('lang.back_to_dashboard')</a></li>
        <li class="breadcrumb-item active">@lang('lang.item') @lang('lang.list')</li>
    </ol>
</div> --}}

@endsection

@section('content')

{{-- <div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h4 class="font-weight-normal">@lang('lang.item') @lang('lang.list')</h4>
    </div>
</div> --}}



<div class="row">
    <div class="col-md-12">

            <div class="card-body">

                            <div class="clearfix"></div>

                            <h4 class="card-title text-success m-4">Item Sale Count</h4>

                                <div class="row ml-4 m-3">
                                        @csrf
                                        <div class="col-md-2">
                                            <label class="control-label font-weight-bold">@lang('lang.from')</label>
                                            <input type="date" name="from" id="from_date" class="form-control" value="{{ $from_date }}" required>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="control-label font-weight-bold">@lang('lang.to')</label>
                                            <input type="date" name="from" id="to_date" class="form-control" value="{{ $to_date }}" required>
                                        </div>
                                        <div class="col-md-2 m-t-30">
                                            <select name="order_type" class="form-control" id="order_type">
                                                <option value="sale"
                                                @if ($order_type=="sale")
                                                    selected
                                                @endif
                                                >Sale</option>
                                                <option value="order" 
                                                @if ($order_type=="order")
                                                selected
                                            @endif
                                                >Order</option>
                                            </select>
                                        </div>
                                        <div class="col-md-1 m-t-30">
                                            <button class="btn btn-info px-4" id="search_orders">Search</button>
                                        </div>
                                    </div>
                                    <div class="container-fluid">
                                        <div class="card">
                                            <div class="card-body">
                                                <ul class="nav nav-pills m-t-30 m-b-30">
                                                    <li class=" nav-item"> 
                                                        <a href="#navpills-1" class="nav-link active" data-toggle="tab" aria-expanded="false">Sale Counts</a> 
                                                    </li>
                                                    <li class="nav-item"> 
                                                        <a href="#navpills-2" class="nav-link" data-toggle="tab" aria-expanded="false">Best Sales-10</a> 
                                                    </li>
                                                    <li class="nav-item"> 
                                                        <a href="#navpills-3" class="nav-link" data-toggle="tab" aria-expanded="false">Worst Sale-10</a> 
                                                    </li>
                                                </ul><br/>
                                                <div class="tab-content br-n pn">
                                                    <div id="navpills-1" class="tab-pane active">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                        <div class="table-responsive text-black" id="slimtest2">
                                                                            <table class="table" id="item_table">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th>#</th>
                                                                                        <th style="overflow:hidden;white-space: nowrap;"> @lang('lang.itemname')</th>
                                                                                        <th>Item Code</th>
                                                                                       <th>Sale Price</th>
                                                                                      <th style="overflow:hidden;white-space: nowrap;">Sale Count</th>
                        
                        
                                                                                    </tr>
                                                                                </thead>
                                                                                <br>
                                                                                <tbody>
                                                                                   <?php $i=1;?>
                        
                                                                                    @foreach($items as $item)
                                                                                    <tr>
                                                                                        <td>{{$i++}}</td>
                                                                                        <td style="overflow:hidden;white-space: nowrap;">{{$item['item_name']}}</td>
                                                                                        <td style="overflow:hidden;white-space: nowrap;">{{$item['item_code']}}</td>
                                                                                        <td>{{$item['price']}}</td>
                                                                                       <td>{{$item['quantity']}}</td>
                        
                                                                                    </tr>
                                                                                    @endforeach
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                            </div>
                                                        </div> 
                                                    </div>
                                
                                                    <div id="navpills-2" class="tab-pane">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="table-responsive text-black" id="slimtest2">
                                                                    <table class="table" id="item_table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>#</th>
                                                                                <th style="overflow:hidden;white-space: nowrap;"> @lang('lang.itemname')</th>
                                                                                <th>Item Code</th>
                                                                                
                                        <th>Sale Price</th>
                                                                                <th style="overflow:hidden;white-space: nowrap;">Sale Count</th>
                
                
                                                                            </tr>
                                                                        </thead>
                                                                        <br>
                                                                        <tbody>
                                                                           <?php $i=1;?>
                
                                                                            @foreach($item_best_sell_10 as $item)
                                                                            <tr>
                                                                                <td>{{$i++}}</td>
                                                                                <td style="overflow:hidden;white-space: nowrap;">{{$item['item_name']}}</td>
                                                                                <td style="overflow:hidden;white-space: nowrap;">{{$item['item_code']}}</td>
                                                                            
                                          
                                          <td>{{$item['price']}}</td>
                                                                               <td>{{$item['quantity']}}</td>
                
                                                                            </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>                        
                                                    </div>
                                
                                                    <div id="navpills-3" class="tab-pane">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="table-responsive text-black" id="slimtest2">
                                                                    <table class="table" id="item_table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>#</th>
                                                                                <th style="overflow:hidden;white-space: nowrap;"> @lang('lang.itemname')</th>
                                                                                <th>Item Code</th>
                                         
                                        <th>Sale Price</th>                                       
                                                                                <th style="overflow:hidden;white-space: nowrap;">Sale Count</th>
                
                
                                                                            </tr>
                                                                        </thead>
                                                                        <br>
                                                                        <tbody>
                                                                           <?php $i=1;?>
                
                                                                            @foreach($item_worst_sell_10 as $item)
                                                                            <tr>
                                                                                <td>{{$i++}}</td>
                                                                                <td style="overflow:hidden;white-space: nowrap;">{{$item['item_name']}}</td>
                                                                                <td style="overflow:hidden;white-space: nowrap;">{{$item['item_code']}}</td>
                                                                                
                                        <td>{{$item['price']}}</td>
                                        
                                        <td>{{$item['quantity']}}</td>
                
                                                                            </tr>
                                                                            @endforeach
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
            </div>
        </div>
    </div>

    @endsection

    @section('js')
    <script src="{{asset('js/jquery.PrintArea.js')}}" type="text/JavaScript"></script>

    <script>
        $(document).ready(function() {
            var inventorytotal=$("#alltotal").val();
            console.log(inventorytotal);
            $('#inventorytotal').text(inventorytotal);

                //print button
            $("#print").click(function() {
            var mode = 'iframe'; //popup
            var close = mode == "popup";
            var options = {
                mode: mode,
                popClose: close
            };
            $("div.printableArea").printArea(options);
        });


            $(".select2").select2();

            $('#example23').DataTable({

                "paging": false,
                "ordering": true,
                "info": false,

            });
        });

        $('#item_table').DataTable( {

        "paging":   true,
        "ordering": true,
        "info":     true

        });


    $('#slimtest2').slimScroll({
        color: '#00f',
        height: '600px'
    });

    $('#search_orders').click(function(){
       let from_date=  $("#from_date").val();
       let to_date=  $("#to_date").val();
       let order_type=  $("#order_type").val();
       console.log(from_date,to_date,order_type);
       let url = `/SaleCount/${from_date}/${to_date}/${order_type}`;
       window.location.href = url;
    })


</script>
 @endsection
