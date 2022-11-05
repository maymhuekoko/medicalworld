

 @extends('master')

@section('title','Sale Discount Record List')

@section('place')

@endsection
@section('content')
<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-12 col-8 align-self-center">


               <div class="container">
                <h3 class="text-themecolor m-b-5 m-t-0">Sale Discount Record Lists</h3>
                <form action="{{route('search_sale_discount_record')}}" method="POST" class="form">
                    @csrf
                <div class="row">
                    <div class="col-md-3 mt-4 pt-2">
                        <select id="select_type" class="form-control" onchange="show_selection(this.value)">
                            <option value="0" selected disabled hidden>ALL</option>
                            <option value="1">FOC</option>
                            <option value="2">Item Discount</option>
                            <option value="3">Voucher Discount</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="control-label font-weight-bold">@lang('lang.from')</label>
                        <input type="date" name="from" class="form-control" required>
                    </div>

                    <div class="col-md-3">
                        <label class="font-weight-bold">@lang('lang.to')</label>
                        <input type="date" name="to" class="form-control" required>
                    </div>

                    <div class="col-md-2 mt-4 pt-2">
                        <input type="submit" name="btnsubmit" class="btnsubmit float-right btn btn-primary btn-block" value="@lang('lang.search')">
                    </div>
                </div>
                </form>
               </div>
            </div>

        </div>
        <section id="plan-features">
                <div class="container">
                    <div class="card">
                        <div class="card-body shadow">

                            <div class="tab-content br-n pn">
                                <div id="navpills-1" class="tab-pane active">
                                    <table class="table table-striped text-black">
                                        <thead class="bg-info text-white">
                                            <tr>
                                            <th>#</th>
                                            <th>Voucher Code</th>
                                            <th>Voucher Date</th>
                                            <th>Customer Name</th>
                                            <th>Discount Type</th>
                                            <th>Action</th>



                                            </tr>
                                        </thead>
                                        <tbody id="place_discount">
                                            <?php $i=1; ?>
                                            @if ($all == 1)
                                            @foreach($discount_main as $dis_main)
                                            <input type="hidden" id="dismain_id" value="{{$dis_main->id}}">

                                            <tr>
                                                <td>{{$i++}}</td>
                                                <td>{{$dis_main->voucher_code}}</td>
                                                <td>{{$dis_main->voucher_date}}</td>
                                                <td>{{$dis_main->sale_customer_name}}</td>
                                                @if($dis_main->discount_type == 1)
                                                <td class="font-weight-bold"><span class="badge badge-danger">Item Discount</span></td>
                                                @elseif($dis_main->discount_type == 2)
                                                <td class="font-weight-bold"><span class="badge badge-secondary">FOC</span></td>
                                                @elseif($dis_main->discount_type == 3)
                                                <td class="font-weight-bold"><span class="badge badge-warning">Voucher Discount</span></td>
                                                @elseif($dis_main->discount_type == 4)
                                                <td class="font-weight-bold"><span class="badge badge-secondary">FOC</span>
                                                <span class="badge badge-warning">Voucher Discount</span></td>
                                                @elseif($dis_main->discount_type == 5)
                                                <td class="font-weight-bold"><span class="badge badge-danger">Item Discount</span>
                                                <span class="badge badge-warning">Voucher Discount</span></td>
                                                @elseif($dis_main->discount_type == 7)
                                                <td class="font-weight-bold"><span class="badge badge-danger">Item Discount</span>
                                                <span class="badge badge-secondary">FOC</span></td>
                                                @elseif($dis_main->discount_type == 6)
                                                <td class="font-weight-bold"><span class="badge badge-danger">Item Discount</span>
                                                <span class="badge badge-secondary">FOC</span>
                                                <span class="badge badge-warning">Voucher Discount</span></td>
                                                @endif
                                                
                                                <td><button type="button" class="btn btn-primary" onclick="totalVou('{{$dis_main->id}}','{{$dis_main->total_voucher_amount}}')" data-toggle="modal" data-target="#discount_detail{{$dis_main->id}}">Details</button></td>


                                            </tr>

                                            @endforeach
                                          @elseif ($all == 2)
                                          @foreach($between as $bet)
                                            <input type="hidden" id="dismain_id" value="{{$bet->id}}">

                                            <tr>
                                                <td>{{$i++}}</td>
                                                <td>{{$bet->voucher_code}}</td>
                                                <td>{{$bet->voucher_date}}</td>
                                                <td>{{$bet->sale_customer_name}}</td>
                                                @if($dis_main->discount_type == 1)
                                                <td class="font-weight-bold"><span class="badge badge-danger">Item Discount</span></td>
                                                @elseif($dis_main->discount_type == 2)
                                                <td class="font-weight-bold"><span class="badge badge-secondary">FOC</span></td>
                                                @elseif($dis_main->discount_type == 3)
                                                <td class="font-weight-bold"><span class="badge badge-warning">Voucher Discount</span></td>
                                                @elseif($dis_main->discount_type == 4)
                                                <td class="font-weight-bold"><span class="badge badge-secondary">FOC</span>
                                                <span class="badge badge-warning">Voucher Discount</span></td>
                                                @elseif($dis_main->discount_type == 5)
                                                <td class="font-weight-bold"><span class="badge badge-danger">Item Discount</span>
                                                <span class="badge badge-warning">Voucher Discount</span></td>
                                                @elseif($dis_main->discount_type == 7)
                                                <td class="font-weight-bold"><span class="badge badge-danger">Item Discount</span>
                                                <span class="badge badge-secondary">FOC</span></td>
                                                @elseif($dis_main->discount_type == 6)
                                                <td class="font-weight-bold"><span class="badge badge-danger">Item Discount</span>
                                                <span class="badge badge-secondary">FOC</span>
                                                <span class="badge badge-warning">Voucher Discount</span></td>
                                                @endif
                                                <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#discount_detail{{$bet->id}}">Details</button></td>


                                            </tr>

                                            @endforeach
                                          @endif

                                        </tbody>
                                    </table>
                                            @foreach($discount_main as $dis_main)
                                            <div class="modal fade bd-example-modal-lg" id="discount_detail{{$dis_main->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                  <div class="modal-content">
                                                      
                                                        <div class="modal-body">
                                                            <div class="col-md-12">
                                                                <div class="row bg-info text-white">
                                                                    <div class="col-md-1">
                                                                        <label>#</label>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <label>Item Name</label>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <label>Counting Unit Name</label>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <label>Original Price</label>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <label>Each Item Amount</label>
                                                                    </div>
                                                                    <!-- <div class="col-md-2">
                                                                        <label class="font-weight-bold">Total Voucher Amount</label>
                                                                    </div> -->
                                                                </div>
                                                                <?php $i=1; ?>
                                                                @foreach($discounts as $discount)
                                                                @if($discount->discount_main_id == $dis_main->id)
                                                                <div class="row">
                                                                    <div class="col-md-1">
                                                                        <span>{{$i++}}</span>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <span>{{$discount->item_name}}</span>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <span>{{$discount->counting_unit_name}}</span>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <span>{{$discount->original_price}}</span>
                                                                    </div>
                                                                    @if($discount->discount_flag == 1 && $discount->discount_voucher_amount == null)
                                                                    <div class="col-md-2">
                                                                       <span> FOC </span>
                                                                    </div>
                                                                    <!-- <div class="col-md-2">
                                                                        <span>FOC</span>
                                                                    </div> -->
                                                                    @elseif($discount->discount_flag == 1 && $discount->discount_voucher_amount != null)
                                                                    <div class="col-md-3">
                                                                        <span> FOC </span>
                                                                     </div>
                                                                     <!-- <div class="col-md-3">
                                                                         <span>{{$discount->discount_voucher_amount}}</span>
                                                                     </div> -->
                                                                    @elseif($discount->discount_flag == 0 && $discount->discount_voucher_amount != null)
                                                                    <div class="col-md-3">
                                                                        <?php if($discount->discount_item_amount != null)
                                                                                {
                                                                                    echo $discount->discount_item_amount;
                                                                                }
                                                                                else {
                                                                                     echo "-";
                                                                                }
                                                                        ?>
                                                                    </div>
                                                                    <!-- <div class="col-md-2">
                                                                        <span>{{$discount->discount_voucher_amount}}</span>
                                                                    </div> -->
                                                                    @else
                                                                    <div class="col-md-3">
                                                                        <span>{{$discount->discount_item_amount}}</span>
                                                                    </div>
                                                                    <!-- <div class="col-md-2">
                                                                        -
                                                                    </div> -->
                                                                    @endif
                                                                </div>
                                                                @endif
                                                                @endforeach
                                                            </div>
                                                            <hr>
                                                            <div class="row">
                                                                <div class="col-md-9">
                                                                <label class="font-weight-bold float-right">Voucher Amount &nbsp;&nbsp;&nbsp;- </label>
                                                                </div>
                                                                <div class="col-md-3">
                                                                <span id="total{{$dis_main->id}}" class="float-left"></span>
                                                                </div>
                                                            </div>
                                                           
                                                        </div>
                                                        <!-- <div class="modal-footer">
                                                            <div class="row">
                                                                <div class="col-md-8">
                                                                <label class="font-weight-bold">Voucher Amount - </label>
                                                                </div>
                                                                <div class="col-md-3">
                                                                <span id="total{{$dis_main->id}}"></span>
                                                                </div>
                                                                
                                                            </div>
                                                            
                                                        </div> -->
                                                  </div>
                                                </div>
                                            </div>

                                            @endforeach
                                            @foreach($discount_main as $dis_main)
                                            {{-- Begin Ajax FOC Modal --}}
                                            <div class="modal fade bd-example-modal-lg" id="discount_detail_foc{{$dis_main->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                  <div class="modal-content">
                                                        <div class="modal-header">

                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="col-md-12">
                                                                <div class="row bg-info text-white">
                                                                    <div class="col-md-1">
                                                                        <label>#</label>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <label>Item Name</label>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <label>Counting Unit Name</label>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <label>Original Price</label>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <label>Each Item Amount</label>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <label>Voucher Amount</label>
                                                                    </div>
                                                                </div>
                                                                <div class="row" id="foc_body{{$dis_main->id}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                  </div>
                                                </div>
                                            </div>
@endforeach
@foreach($discount_main as $dis_main)
                                            {{-- End Ajax FOC Modal --}}
                                            {{-- Begin Ajax Item Modal --}}
                                            <div class="modal fade bd-example-modal-lg" id="discount_detail_item{{$dis_main->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                  <div class="modal-content">
                                                        <div class="modal-header">

                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="col-md-12">
                                                                <div class="row bg-info text-white">
                                                                    <div class="col-md-1">
                                                                        <label>#</label>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <label>Item Name</label>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <label>Counting Unit Name</label>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <label>Original Price</label>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <label>Each Item Amount</label>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <label>Voucher Amount</label>
                                                                    </div>
                                                                </div>
                                                                <div class="row" id="item_body{{$dis_main->id}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                  </div>
                                                </div>
                                            </div>
@endforeach
@foreach($discount_main as $dis_main)
                                            {{-- End Ajax Item Modal --}}
                                            {{-- Begin Ajax Voucher Modal --}}
                                            <div class="modal fade bd-example-modal-lg" id="discount_detail_vou{{$dis_main->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                  <div class="modal-content">
                                                        <div class="modal-header">

                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="col-md-12">
                                                                <div class="row bg-info text-white">
                                                                    <div class="col-md-1">
                                                                        <label>#</label>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <label>Item Name</label>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <label>Counting Unit Name</label>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <label>Original Price</label>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <label>Each Item Amount</label>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <label>Voucher Amount</label>
                                                                    </div>
                                                                </div>
                                                                <div class="row" id="vou_body{{$dis_main->id}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                  </div>
                                                </div>
                                            </div>

                                            {{-- End Ajax Voucher Modal --}}
                                            @endforeach

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
<script>
function show_selection(value)
{


    $.ajax({

        type:'POST',

        url:'/get_discount_main_type',

        data:{
        "_token":"{{csrf_token()}}",
        "discount_type":value,
        },

        success:function(data){
            if(data.type == 1)
            {
                var htmlfoc = "";

                $.each(data.disco,function(i,v){
                    htmlfoc+=`
                    <tr>
                        <td>${i+1}</td>
                        <td>${v.voucher_code}</td>
                        <td>${v.voucher_date}</td>
                        <td>${v.sale_customer_name}</td>`;
                        if(v.discount_type == 1)
                        {
                        htmlfoc+=`
                        <td class="font-weight-bold"><span class="badge badge-danger">Item Discount</span></td>
                        <td><button type="button" class="btn btn-primary" onclick="totalVou('${v.id}','${v.total_voucher_amount}')" data-toggle="modal" data-target="#discount_detail${v.id}">Details</button></td>
                    </tr>
                        `;
                        }
                        else if(v.discount_type == 2)
                        {
                            htmlfoc += `
                            <td class="font-weight-bold"><span class="badge badge-secondary">FOC</span></td>
                            <td><button type="button" class="btn btn-primary" onclick="totalVou('${v.id}','${v.total_voucher_amount}')" data-toggle="modal" data-target="#discount_detail${v.id}">Details</button></td>
                    </tr>
                            `;
                        }
                        else if(v.discount_type == 3)
                        {
                            htmlfoc += `
                            <td class="font-weight-bold"><span class="badge badge-warning">Voucher Discount</span></td>
                            <td><button type="button" class="btn btn-primary" onclick="totalVou('${v.id}','${v.total_voucher_amount}')" data-toggle="modal" data-target="#discount_detail${v.id}">Details</button></td>
                    </tr>
                            `;
                        }
                        else if(v.discount_type == 4)
                        {
                            htmlfoc +=`
                            <td class="font-weight-bold"><span class="badge badge-secondary">FOC</span>
                            <span class="badge badge-warning">Voucher Discount</span></td>
                            <td><button type="button" class="btn btn-primary" onclick="totalVou('${v.id}','${v.total_voucher_amount}')" data-toggle="modal" data-target="#discount_detail${v.id}">Details</button></td>
                    </tr>
                            `;
                        }
                       else if(v.discount_type == 5)
                       {
                            htmlfoc +=`
                            <td class="font-weight-bold"><span class="badge badge-danger">Item Discount</span>
                        <span class="badge badge-warning">Voucher Discount</span></td>
                        <td><button type="button" class="btn btn-primary" onclick="totalVou('${v.id}','${v.total_voucher_amount}')" data-toggle="modal" data-target="#discount_detail${v.id}">Details</button></td>
                    </tr>
                            `;
                       }
                       else if(v.discount_type == 6)
                       {
                           htmlfoc += `
                           <td class="font-weight-bold"><span class="badge badge-danger">Item Discount</span>
                        <span class="badge badge-secondary">FOC</span>
                        <span class="badge badge-warning">Voucher Discount</span></td>
                        <td><button type="button" class="btn btn-primary" onclick="totalVou('${v.id}','${v.total_voucher_amount}')" data-toggle="modal" data-target="#discount_detail${v.id}">Details</button></td>
                    </tr>
                           `;
                       }
                       else if(v.discount_type == 7)
                       {
                           htmlfoc +=`
                           <td class="font-weight-bold"><span class="badge badge-danger">Item Discount</span>
                        <span class="badge badge-secondary">FOC</span></td>
                        <td><button type="button" class="btn btn-primary" onclick="totalVou('${v.id}','${v.total_voucher_amount}')" data-toggle="modal" data-target="#discount_detail${v.id}">Details</button></td>
                    </tr>
                           `;
                       }
 
                });

                $('#place_discount').html(htmlfoc);

            }
            else if(data.type == 2)
            {
                var htmlitem ="";
                $.each(data.disco,function(i,v){
                    htmlitem+=`
                    <tr>
                        <td>${i+1}</td>
                        <td>${v.voucher_code}</td>
                        <td>${v.voucher_date}</td>
                        <td>${v.sale_customer_name}</td>`;
                        if(v.discount_type == 1)
                        {
                        htmlitem+=`
                        <td class="font-weight-bold"><span class="badge badge-danger">Item Discount</span></td>
                        <td><button type="button" class="btn btn-primary" onclick="totalVou('${v.id}','${v.total_voucher_amount}')" data-toggle="modal" data-target="#discount_detail${v.id}">Details</button></td>
                    </tr>
                        `;
                        }
                        else if(v.discount_type == 2)
                        {
                            htmlitem += `
                            <td class="font-weight-bold"><span class="badge badge-secondary">FOC</span></td>
                            <td><button type="button" class="btn btn-primary" onclick="totalVou('${v.id}','${v.total_voucher_amount}')" data-toggle="modal" data-target="#discount_detail${v.id}">Details</button></td>
                    </tr>
                            `;
                        }
                        else if(v.discount_type == 3)
                        {
                            htmlitem += `
                            <td class="font-weight-bold"><span class="badge badge-warning">Voucher Discount</span></td>
                            <td><button type="button" class="btn btn-primary" onclick="totalVou('${v.id}','${v.total_voucher_amount}')" data-toggle="modal" data-target="#discount_detail${v.id}">Details</button></td>
                    </tr>
                            `;
                        }
                        else if(v.discount_type == 4)
                        {
                            htmlitem +=`
                            <td class="font-weight-bold"><span class="badge badge-secondary">FOC</span>
                            <span class="badge badge-warning">Voucher Discount</span></td>
                            <td><button type="button" class="btn btn-primary" onclick="totalVou('${v.id}','${v.total_voucher_amount}')" data-toggle="modal" data-target="#discount_detail${v.id}">Details</button></td>
                    </tr>
                            `;
                        }
                       else if(v.discount_type == 5)
                       {
                            htmlitem +=`
                            <td class="font-weight-bold"><span class="badge badge-danger">Item Discount</span>
                        <span class="badge badge-warning">Voucher Discount</span></td>
                        <td><button type="button" class="btn btn-primary" onclick="totalVou('${v.id}','${v.total_voucher_amount}')" data-toggle="modal" data-target="#discount_detail${v.id}">Details</button></td>
                    </tr>
                            `;
                       }
                       else if(v.discount_type == 6)
                       {
                           htmlitem += `
                           <td class="font-weight-bold"><span class="badge badge-danger">Item Discount</span>
                        <span class="badge badge-secondary">FOC</span>
                        <span class="badge badge-warning">Voucher Discount</span></td>
                        <td><button type="button" class="btn btn-primary" onclick="totalVou('${v.id}','${v.total_voucher_amount}')" data-toggle="modal" data-target="#discount_detail${v.id}">Details</button></td>
                    </tr>
                           `;
                       }
                       else if(v.discount_type == 7)
                       {
                           htmlitem +=`
                           <td class="font-weight-bold"><span class="badge badge-danger">Item Discount</span>
                        <span class="badge badge-secondary">FOC</span></td>
                        <td><button type="button" class="btn btn-primary" onclick="totalVou('${v.id}','${v.total_voucher_amount}')" data-toggle="modal" data-target="#discount_detail${v.id}">Details</button></td>
                    </tr>
                           `;
                       }


                });

                $('#place_discount').html(htmlitem);
            }
            else if(data.type == 3)
            {
                var htmlvou ="";
                $.each(data.disco,function(i,v){
                   htmlvou+=`
                    <tr>
                        <td>${i+1}</td>
                        <td>${v.voucher_code}</td>
                        <td>${v.voucher_date}</td>
                        <td>${v.sale_customer_name}</td>`;
                        if(v.discount_type == 1)
                        {
                       htmlvou+=`
                        <td class="font-weight-bold"><span class="badge badge-danger">Item Discount</span></td>
                        <td><button type="button" class="btn btn-primary" onclick="totalVou('${v.id}','${v.total_voucher_amount}')" data-toggle="modal" data-target="#discount_detail${v.id}">Details</button></td>
                    </tr>
                        `;
                        }
                        else if(v.discount_type == 2)
                        {
                           htmlvou += `
                            <td class="font-weight-bold"><span class="badge badge-secondary">FOC</span></td>
                            <td><button type="button" class="btn btn-primary" onclick="totalVou('${v.id}','${v.total_voucher_amount}')" data-toggle="modal" data-target="#discount_detail${v.id}">Details</button></td>
                    </tr>
                            `;
                        }
                        else if(v.discount_type == 3)
                        {
                           htmlvou += `
                            <td class="font-weight-bold"><span class="badge badge-warning">Voucher Discount</span></td>
                            <td><button type="button" class="btn btn-primary" onclick="totalVou('${v.id}','${v.total_voucher_amount}')" data-toggle="modal" data-target="#discount_detail${v.id}">Details</button></td>
                    </tr>
                            `;
                        }
                        else if(v.discount_type == 4)
                        {
                           htmlvou +=`
                            <td class="font-weight-bold"><span class="badge badge-secondary">FOC</span>
                            <span class="badge badge-warning">Voucher Discount</span></td>
                            <td><button type="button" class="btn btn-primary" onclick="totalVou('${v.id}','${v.total_voucher_amount}')" data-toggle="modal" data-target="#discount_detail${v.id}">Details</button></td>
                    </tr>
                            `;
                        }
                       else if(v.discount_type == 5)
                       {
                           htmlvou +=`
                            <td class="font-weight-bold"><span class="badge badge-danger">Item Discount</span>
                        <span class="badge badge-warning">Voucher Discount</span></td>
                        <td><button type="button" class="btn btn-primary" onclick="totalVou('${v.id}','${v.total_voucher_amount}')" data-toggle="modal" data-target="#discount_detail${v.id}">Details</button></td>
                    </tr>
                            `;
                       }
                       else if(v.discount_type == 6)
                       {
                          htmlvou += `
                           <td class="font-weight-bold"><span class="badge badge-danger">Item Discount</span>
                        <span class="badge badge-secondary">FOC</span>
                        <span class="badge badge-warning">Voucher Discount</span></td>
                        <td><button type="button" class="btn btn-primary" onclick="totalVou('${v.id}','${v.total_voucher_amount}')" data-toggle="modal" data-target="#discount_detail${v.id}">Details</button></td>
                    </tr>
                           `;
                       }
                       else if(v.discount_type == 7)
                       {
                          htmlvou +=`
                           <td class="font-weight-bold"><span class="badge badge-danger">Item Discount</span>
                        <span class="badge badge-secondary">FOC</span></td>
                        <td><button type="button" class="btn btn-primary" onclick="totalVou('${v.id}','${v.total_voucher_amount}')" data-toggle="modal" data-target="#discount_detail${v.id}">Details</button></td>
                    </tr>
                           `;
                       }


                })

                $('#place_discount').html(htmlvou);
            }
        }
    });
}
function detail_foc(value)
{
    alert(value);
    $.ajax({

            type:'POST',

            url:'/get_foc',

            data:{
            "_token":"{{csrf_token()}}",
            "dismain_id":value,
            },

            success:function(data){
                var htmlfocdata = "";
                $.each(data,function(i,v){
                    if(v.discount_flag == 1)
                    {
                    htmlfocdata +=`
                    <div class="col-md-1">
                        <span>${i+1}</span>
                    </div>
                    <div class="col-md-2">
                        <span>${v.item_name}</span>
                    </div>
                    <div class="col-md-3">
                        <span>${v.counting_unit_name}</span>
                    </div>
                    <div class="col-md-2">
                        <span>${v.original_price}</span>
                    </div>
                    <div class="col-md-2">
                        <span> FOC </span>
                    </div>
                    <div class="col-md-2">
                        <span> FOC </span>
                    </div>
                    `;
                    }
                });
                $('#foc_body'+value).html(htmlfocdata);
            }
    });

}
function detail_item(value)
{
    alert(value);
    $.ajax({

            type:'POST',

            url:'/get_item',

            data:{
            "_token":"{{csrf_token()}}",
            "dismain_id":value,
            },

            success:function(data){
                var htmlitemdata = "";

                $.each(data,function(i,v){
                    if(v.discount_flag == 0 && v.discount_item_amount != 0)
                    {

                    htmlitemdata +=`
                    <div class="col-md-1">
                        <span>${i+1}</span>
                    </div>
                    <div class="col-md-2">
                        <span>${v.item_name}</span>
                    </div>
                    <div class="col-md-3">
                        <span>${v.counting_unit_name}</span>
                    </div>
                    <div class="col-md-2">
                        <span>${v.original_price}</span>
                    </div>
                    <div class="col-md-2">
                        <span>${v.discount_item_amount}</span>
                    </div>
                    <div class="col-md-2">
                        <span> - </span>
                    </div>
                    `;
                    }
                });
                $('#item_body'+value).html(htmlitemdata);
            }
    });

}
function detail_vou(value)
{
    alert(value);
    $.ajax({

            type:'POST',

            url:'/get_vou',

            data:{
            "_token":"{{csrf_token()}}",
            "dismain_id":value,
            },

            success:function(data){
                var htmlvoudata = "";

                $.each(data,function(i,v){
                    if(v.discount_voucher_amount != 0)
                    {

                    htmlvoudata +=`
                    <div class="col-md-1">
                        <span>${i+1}</span>
                    </div>
                    <div class="col-md-2">
                        <span>${v.item_name}</span>
                    </div>
                    <div class="col-md-3">
                        <span>${v.counting_unit_name}</span>
                    </div>
                    <div class="col-md-2">
                        <span>${v.original_price}</span>
                    </div>
                    `;
                    if(v.discount_flag==1)
                    {
                    htmlvoudata+=`
                    <div class="col-md-2">
                        <span>FOC</span>
                    </div>`;
                    }
                    else if(v.discount_item_amount == 0)
                    {
                        htmlvoudata+=`
                    <div class="col-md-2">
                        <span> - </span>
                    </div>`;
                    }
                    else
                    {
                        htmlvoudata+=`
                    <div class="col-md-2">
                        <span>${v.discount_item_amount}</span>
                    </div>`;
                    }
                    htmlvoudata+=`
                    <div class="col-md-2">
                        <span>${v.discount_voucher_amount} </span>
                    </div>
                    `;
                    }
                });
                $('#vou_body'+value).html(htmlvoudata);
            }
    });

}
function show_date(value)
{
    alert(value);
    $.ajax({

            type:'POST',

            url:'/get_date',

            data:{
            "_token":"{{csrf_token()}}",
            "date":value,
            },

            success:function(data){
                var htmldate = "";
                $.each(data,function(i,v)
                {
                    htmldate+=`
                    <tr>
                        <td>${i+1}</td>
                        <td>${v.voucher_code}</td>
                        <td>${v.voucher_date}</td>
                        <td>${v.sale_customer_name}</td>
                        <td class="font-weight-bold">${v.discount_type}</td>
                        <td><button type="button" class="btn btn-primary"  data-toggle="modal" data-target="#discount_detail${v.id}">Details</button></td>
                    </tr>

                    `;

                })
                $('#place_discount').html(htmldate);
            }

            });

}
function totalVou(dm_id,total)
{
    var htmltotal = "";
    htmltotal +=`
    <span class="text-danger font-weight-bold">${total} </span><span class="font-weight-bold">MMK</span>
    `;
    $('#total'+dm_id).html(htmltotal);
}
</script>
@endsection













