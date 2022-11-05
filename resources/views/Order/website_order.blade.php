@extends('master')

@section('title','Order Page')

@section('place')

@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-header">
                <h4 class="font-weight-bold mt-2">Website Order List</h4>
            </div>
            <div class="card-body">
                 <div class="row p-2 offset-10">
                        <input  type="text" id="table_search" placeholder="Quick Search" onkeyup="search_table()" >    
                    </div>
                
                <div class="table-responsive text-black">
                    <table class="table" id="order_table">
                        <thead class="head">
                            <tr>
                                <th>No.</th>
                                <th>Order No.</th>
                                <th>Customer Name</th>
                                <th>Order Address</th>
                                <th>Order Date</th>
                                <th>Order Status</th>
                                <th>Total Qty</th>
                                <th>Total Amount</th>
                                <th> Remark</th>
                                <th class="text-center">@lang('lang.details')</th>
                                <th class="text-center">@lang('lang.action')</th>
                            </tr>
                        </thead>
                        <tbody id="website_order_list" class="body">
                             <?php
                                $i = 0;
                            ?>
                            
                            @foreach($order_lists as $order)
                                <tr>
                                    <td>{{++$i}}</td>
                                	<td>{{$order->order_code}}</td>
                                    <td>{{$order->customer_name}}</td>
                                	<td style="overflow:hidden;white-space: nowrap;">{{$order->deliver_address}}</td>
                                	<td style="overflow:hidden;white-space: nowrap;">{{date('d-m-Y', strtotime($order->order_date))}}</td>
                                	@if($order->order_status == 'received')
                                	<td id="chg_status{{$order->id}}"><span class="badge badge-pill badge-warning font-weight-bold">Pending</span></td>
                                	@elseif($order->order_status == 'confirmed')
                                	<td id="chg_status{{$order->id}}"><span class="badge badge-pill badge-primary font-weight-bold">Confirmed</span></td>
                                	@elseif($order->order_status == 'delivered')
                                	<td id="chg_status{{$order->id}}"><span class="badge badge-pill badge-info font-weight-bold">Delivered</span></td>
                                	@elseif($order->order_status == 'canceled')
                                	<td id="chg_status{{$order->id}}"><span class="badge badge-pill badge-danger font-weight-bold">Canceled</span></td>
                                	@endif
                                	<td>{{$order->total_quantity}}</td>
                                    <td>{{$order->total_amount}}</td>
                                    <td>{{$order->remark}}</td>
                                	<td class="text-center">
                                         <a href="{{route('website_order_details',$order->id)}}" class="btn rounded btn-sm btn-outline-info">Details</a>
                                    </td>
                                    <td class="text-center">
                                        <a href="" class="btn rounded btn-sm btn-outline-info" data-toggle="modal"data-target="#status{{$order->id}}">Change Status</a>
                                    </td>
                                    
                                    <div class="modal fade" id="status{{$order->id}}" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                   <h3 class="modal-title font-bold">Change Order Status</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body p-5">
               
                        <div class="mb-2">
                            <p class="text-center">
                                Please select status that you want!
                            </p>
                            <select class="form-control" id="statusval{{$order->id}}">
                                <option>Choose Status</option>
                                <option value="confirmed" id="con">Confirm</option>
                                <option value="delivered" id="del">Deliver</option>
                                <option value="canceled" id="can">Cancel</option>
                            </select>
                        </div>

                        
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="status_change({{$order->id}})">Save changes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>

            </div>
        </div>
    </div>
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

    <script>
 
    function status_change(id){
        
        let status = $('#statusval'+id).val();
        // alert(status);
         $.ajax({

                type: 'POST',

                url: '{{route('change_website_order_status')}}',

                data: {
                    "_token": "{{ csrf_token() }}",
                    "order_id": id,
                    "status" : status,
                },

                success: function(data) {
                     alert(data.order_status);
                    $('#status'+id).modal('hide');
                    if(data.order_status == 'confirmed'){
                       var html = `
                        <span class="badge badge-pill badge-primary font-weight-bold">Confirmed</span>
                        `;
                        $('#chg_status'+id).html(html);
                    }else if(data.order_status == 'delivered'){
                       var html = `
                        <span class="badge badge-pill badge-info font-weight-bold">Delivered</span>
                        `;
                        $('#chg_status'+id).html(html);
                    }else{
                       var html = `
                        <span class="badge badge-pill badge-danger font-weight-bold">Canceled</span>
                        `;
                        $('#chg_status'+id).html(html);
                    }
                    
                }
         })
    }
      

    </script>
@endsection