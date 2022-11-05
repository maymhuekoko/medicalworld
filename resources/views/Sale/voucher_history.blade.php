@extends('master')

@section('title','Voucher Summary Main')



@section('content')

<style>
    td{
        text-align:left;
        font-size:15px;
        font-weight:bold; 
    }
    th{
        text-align:left;
        font-size:15px;
        overflow:hidden;
        white-space: nowrap;
    }
    h6{
        font-size:15px;
        font-weight:600;
    }
</style>

<div class="page-wrapper">
    <div class="container-fluid">
        {{-- <div class="row page-titles">
            <div class="col-md-5 col-8 align-self-center">
                <h3 class="text-themecolor m-b-0 m-t-0">Voucher Summary Main</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="">Main Dashboard</a></li>
                    <li class="breadcrumb-item active">Voucher Summary Main</li>
                </ol>
            </div>
        </div> --}}
        <section id="plan-features">
                <div class="container">
                    <div class="card">
                        <div class="card-body shadow">
                            <!--<h3 class=" font-weight-bold text-left text-themecolor">@lang('lang.voucher') @lang('lang.list')</h3><hr>-->
                            <ul class="nav nav-pills m-t-30 m-b-30">
                                <li class=" nav-item"> 
                                    <a href="#navpills-1" class="nav-link active" data-toggle="tab" aria-expanded="false">Daily Item Sales List</a> 
                                </li>
                                <!--<li class="nav-item"> -->
                                <!--    <a href="#navpills-2" class="nav-link" data-toggle="tab" aria-expanded="false">@lang('lang.voucher') @lang('lang.list')</a> -->
                                <!--</li>-->
                            </ul><br/>
                            <div class="tab-content br-n pn">
                                <div id="navpills-1" class="tab-pane active">
                                    <form action="{{route('search_item_sales_by_date')}}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="text" id="mdate" class="form-control" name="date" placeholder="Search Daily Sales Item">
                                            </div>
                                            <div class=" col-md-6">
                                                <button type="submit" class="btn btn-success mb-1">Search</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>
</div>


@endsection

@section('js')

<script src="{{asset('master/js/jquery.PrintArea.js')}}" type="text/JavaScript"></script>

<script type="text/javascript">

    $('#mdate').bootstrapMaterialDatePicker({ weekStart: 0, time: false });
    
    $('#mdate1').bootstrapMaterialDatePicker({ weekStart: 0, time: false });
        

    // $("#print").click(function() {

    //         var mode = 'iframe'; //popup
    //         var close = mode == "popup";
    //         var options = {
    //             mode: mode,
    //             popClose: close
    //         };
    //         $("div.printableArea").printArea(options);

           
    // });

    // function searchByDate(value){
        
    //     $('#voucher_list').empty();
        
    //      $.ajax({

    //       type:'POST',

    //       url:'/searchByDate',
           
    //       data:{
    //         "_token":"{{csrf_token()}}",
    //         "date":value,
    //       },

    //         success:function(data){
                
    //             console.log(data);
                
    //             var html = "";
                
    //             $.each(data,function(i, v){
                    
    //                 var id=v.id;
                    
    //                 var items = v.items;
                    
    //                 let item_name = "";
                    
    //                 $.each(items, function(b, a){
                        
    //                     item_name += a.item_name + "*" + "("  + a.quantity + ")" + ",";
                        
    //                 });
                    
    //                 var total_price=v.total_price;
                    
    //                 var total_quantity=v.total_quantity;
                    
    //                 var voucher_number = v.voucher_code;
                    
    //                 html += `<tr>
    //                             <td style="font-size: 15px;">
    //                                 <span class="text-info" style="font-size:13px;">${voucher_number}</span><br/>
    //                                 ${item_name}
    //                             </td>
    //                             <td>${total_quantity}</td>
    //                             <td>${total_price}</td>
    //                         </tr>`
                    
    //             });
                
    //             $('#voucher_list').html(html);
                
    //         }
    //     });
    // }
        
</script>

@endsection