@extends('master')

@section('title','Order Details')

@section('place')
{{--
<div class="col-md-5 col-8 align-self-center">
    <h3 class="text-themecolor m-b-0 m-t-0">@lang('lang.order') @lang('lang.details')</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('index')}}">@lang('lang.back_to_dashboard')</a></li>
        <li class="breadcrumb-item active">@lang('lang.order') @lang('lang.details')</li>
    </ol>
</div> --}}

@endsection

@section('content')

<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="font-weight-bold">Factory PR Details Page</h3>
    </div>
</div>



<div class="row printableArea">
    <div class="col-md-12">
        <div class="card shadow-sm">

            <div class="card-body">
                <h3 class="font-weight-bold text-center my-3">Factory PO Details</h3>
            	<div class="row align-items-center justify-content-center">
            		<div class="col-5">
            			<div class="row">
			              	<div class="font-weight-bold text-primary col-md-4">PO @lang('lang.number')</div>
			              	<h5 class="font-weight-bold col-md-4 mt-1">{{$PO->po_number}}</h5>
				        </div>

            			<div class="row mt-1">
			              	<div class="font-weight-bold text-primary col-md-4">PR @lang('lang.date')</div>
			              	<h5 class="font-weight-bold col-md-4 mt-1">{{date('d-m-Y', strtotime($PO->po_date))}}</h5>
				        </div>

				        <div class="row mt-1">
			              	<div class="font-weight-bold text-primary col-md-4">Required @lang('lang.date')</div>
			              	<h5 class="font-weight-bold col-md-4 mt-1">{{date('d-m-Y', strtotime($PO->receive_date))}}</h5>
				        </div>

                        @if($PO->po_type == 9)
				        <div class="row mt-1">
			              	<div class="font-weight-bold text-primary col-md-4">Requested By</div>
			              	<h5 class="font-weight-bold col-md-4 mt-1">{{$PO->requested_by}}</h5>
				        </div>
				        @endif
				        
				        


            		</div>
                    <div class="col-5">
                        <!--<div class="row mt-1">-->
                        <!--    <div class="font-weight-bold text-primary col-md-4">Approved By</div>-->
                        <!--    <h5 class="font-weight-bold col-md-4 mt-1">{{$PO->approved_by}}</h5>-->
                        <!--</div>-->
                        @if($PO->po_type == 9)
                        <div class="row mt-1">
                            <div class="font-weight-bold text-primary col-md-4">@lang('lang.total') Rolls</div>
                            <h5 class="font-weight-bold col-md-4 mt-1">{{$PO->total_rolls}}</h5>
                        </div>
                        
                        <div class="row mt-1">
                            <div class="font-weight-bold text-primary col-md-4">@lang('lang.total') Yards</div>
                            <h5 class="font-weight-bold col-md-4 mt-1">{{$PO->total_yards}}</h5>
                        </div>
                        @elseif($PO->po_type == 10)
                            <div class="row mt-1">
                            <div class="font-weight-bold text-primary col-md-4">@lang('lang.total') Quantity</div>
                            <h5 class="font-weight-bold col-md-4 mt-1">{{$PO->total_quantity}}</h5>
                        </div>
                        @endif

                        <div class="row mt-1">
                            <div class="font-weight-bold text-primary col-md-4">Total Cost</div>
                            <h5 class="font-weight-bold col-md-4 mt-1">{{$PO->total_price}}</h5>
                        </div>
                        
                        <div class="row mt-1">
                            <div class="font-weight-bold text-primary col-md-4">Status</div>
                            @if($PO->status == 0)
                                <h5 class="font-weight-bold col-md-4 mt-1">Pending</h5>
                            @elseif($PO->status == 1)
                                <h5 class="font-weight-bold col-md-4 mt-1">Approved</h5>
                            @elseif($PO->status == 2)
                                <h5 class="font-weight-bold col-md-4 mt-1">Purchased</h5>
                            @elseif($PO->status == 3)
                                <h5 class="font-weight-bold col-md-4 mt-1">Arrived</h5>
                            @endif

                        </div>


                        
                    </div>

            	</div>
                <div class="row">
                    <div class="col-12">
                        <h4 class="font-weight-bold my-3 text-center">
                            PO @lang('lang.unit') @lang('lang.list')
                        </h4>
                        <div class="table-responsive text-black">
                            <table class="table" id="example23">
                                <thead>
                                @if($PO->po_type == 9)
                                <tr class="text-center text-info h6">
                                    <th>No.</th>
                                    <th>Item Name</th>
                                    <th>Rolls</th>
                                    <th>Yards Per Rolls</th>
                                    <th>Total Yards </th>
                                    <th>Purchase Price</th>
                                    <th>Remark</th>
                                </tr>
                                @elseif($PO->po_type == 10)
                                <tr class="text-center text-info h6">
                                    <th>No.</th>
                                    <th>Item Name</th>
                                    <th>Total Quantity</th>
                                    <th>Purchase Price</th>
                                    <th>Remark</th>
                                </tr>
                                @endif
                                </thead>
                                @php
                                    $i = 0;
                                @endphp
                                <tbody>
                                @foreach($PO->factory_items as $factory_item)
                                    <tr class="text-center" style="font-size: 15px;">
                                        <td>{{++$i}}</td>
                                        <td>{{$factory_item->item_name}}</td>
                                        @if($PO->po_type == 9)
                                        <td>{{$factory_item->pivot->rolls}}</td>
                                        <td>{{$factory_item->pivot->yards_per_roll}}</td>
                                        <td>{{$factory_item->pivot->sub_yards}}</td>
                                        @elseif($PO->po_type == 10)
                                            <td>{{$factory_item->pivot->order_qty}}</td>
                                        @endif
                                        <td>{{$factory_item->pivot->purchase_price}}</td>
                                        <td>{{$factory_item->pivot->remark}}</td>
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
<div class="modal fade" id="attachModal" role="dialog" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-body">
            @php
                $photo = explode('.',$PO->attach_file_path);
                $extension= $photo[1];
                $document_url = "http://http://medicalworldinvpos.kwintechnologykw09.com". $PO->attach_file_path;
            @endphp
            <div id="attachmentwrapper">
                @if($extension=='pdf')
                    <iframe scr="{{$document_url}}" class="img-fluid text-center" id="attachmentpdf" style="width: -webkit-fill-avaiable; height: 100vh;"></iframe>
                @else
                    <img scr="{{$PO->attach_file_path}}" id="attachmentimg" class="img-fluid text-center" style="width: -webkit-fill-avaiable; height: 100vh;">
                @endif
            </div>
        </div>
        
    </div>
    
    
</div>
</div>


<div class="row d-flex justify-content-center">
    
    <form action="{{ route("attachimg") }}" method="post" id="alldouments" >
        @csrf
        <input type="hidden" name="file_path" value="{{$PO->attach_file_path}}">
        <input type="hidden" name="po_id" value="{{$PO->id}}">
    </form>
    
    <div class="col-1">
        <div class="mb-1">
            <button id="print" class="btn btn-info rounded">
                <i class="fas fa-print mr-2"></i>
                Print
            </button>
        </div>
    </div>
    
    <div class="col-1">
        <div class="mb-1">
            <button id="show_attach" class="btn btn-info rounded">
                <i class="fas fa-paperclip mr-2"></i>
                Attach
            </button>
        </div>
    </div>
    
    <div class="col-1 ml-6">
        <div class="mb-1">
            <button id="purchase" data-status="{{$PO->status}}" class="btn btn-warning rounded">
                <i class="mdi mdi-cart mr-2"></i>
                Purchase
            </button>
        </div>
    </div>
</div>
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            $("#print").click(function() {
                var mode = 'iframe'; //popup
                var close = mode == "popup";
                var options = {
                    mode: mode,
                    popClose: close
                };
                $("div.printableArea").printArea(options);
            });
        });
        
        $('#show_attach').click(function(){
            //$('#attachModal').modal('show');
            $('#alldouments').submit();
        });
        
        $('#purchase').click(function(){
            let status = $(this).data('status');
                if(status != 1){
                    swal({
                        title: "Failed!",
                        text: `PO has not been approved yet!`,
                        icon: "error",
                    });
                }else{
                var unit = @json($PO); //voucher
                clearLocalstorage(0);
                var totalPrice = 0;
                var totalQty = 0;

                
                localStorage.removeItem('myprcart');
                localStorage.removeItem('prTotal');
                
                $.each(unit.factory_items,function(i,item){

                        var realPrice = item.pivot.price;
                    console.log("item",item,realPrice);
                    var local_item = {
                        id: item.id,
                        unit_name: item.item_name,
                        qty: item.pivot.order_qty,
                        price: item.pivot.purchase_price,
                        sub_total: (item.pivot.order_qty * item.pivot.purchase_price),
                        
                    };

                    var myprcart = localStorage.getItem('myprcart');
              
                    if (myprcart == null) {

                    myprcart = '[]';

                    var myprcartobj = JSON.parse(myprcart);

                    myprcartobj.push(local_item);

                    localStorage.setItem('myprcart', JSON.stringify(myprcartobj));

                    } else {

                    var myprcartobj = JSON.parse(myprcart);

                    myprcartobj.push(local_item);

                    localStorage.setItem('myprcart', JSON.stringify(myprcartobj));
                    }
                    
                    totalPrice += ( item.pivot.order_qty * item.pivot.purchase_price);
                    totalQty +=  item.pivot.order_qty;
                })
                    var total_amount = {
                        sub_total: totalPrice,
                        total_qty: totalQty,
                    };
                    
                    console.log("grand",total_amount);

                    var prTotal = localStorage.getItem('prTotal');

                    localStorage.setItem('prTotal', JSON.stringify(total_amount));

                    localStorage.setItem('popurchase', 1);  //voucher_id
                    
                    window.location.href = "{{ route('create_purchase')}}";
                }
        });
    </script>
@endsection
