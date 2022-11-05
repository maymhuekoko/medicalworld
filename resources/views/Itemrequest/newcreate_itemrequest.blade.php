@extends('master')

@section('title', 'Order Page')

@section('place')
    <style>
        .editprice {
            cursor: pointer
        }

        .discount {
            cursor: pointer
        }

    </style>

@endsection

@section('content')
    @php
    $from_id = session()->get('from');
    @endphp

    <?php
    $itemss = '<span id="lenn"></span>';

    ?>


    <div class="row mb-3">
        <input type="hidden" id="fid" value="{{ $from_id }}">

        <div class="col-md-2">
            <form action="{{ route('get_voucher') }}" method="post" id="vourcher_page">
                @csrf
                <input type="hidden" id="item" name="item">

                <input type="hidden" id="grand" name="grand">

                <input type="hidden" name="right_now_customer" id="right_now_customer">

                <input type="hidden" id="discount" name="discount">

                <input type="hidden" id="foc_flag" name="foc_flag">

                <input type="hidden" id="has_dis" name="has_dis">

            </form>
        </div>
    </div>
    <!--Begin Sale Page -->
    
    <div class="row offset-3">
        <div class="col-12 d-flex justify-content-start mb-2">
            <div class="col-md-4">
                <select style="width: 210px" name="category" class="form-control" id="category" onchange="searchSubCategory(this.value)">
                    <option value="">Category</option>
                    @foreach($categories as $cat)
                        <option value="{{$cat->id}}">{{$cat->category_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <select style="width: 210px" name="subcategory" class="form-control" id="subcategory" onchange="searchCountingUnit(this.value)">
                    <option value="">Subcategory</option>
                    @foreach($sub_categories as $sub_category)
                        <option value="{{$sub_category->id}}">
                            {{$sub_category->name}}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

    </div>
    
    <div class="row justify-content-center">
        <div class="col-10 pr-0">
            <div class="row mt-1 mb-2">
                <label class="col-md-2 pl-4">အမျိုးအမည်</label>
                <div class="col-md-8 col-sm-12 d-block" id="search_wif_typing">
                    <select class="p-4 select form-control text-black" name="item" id="counting_unit_select">
                        <option></option>
                        @foreach ($items as $item)
                                    <option class="text-black"
                                        data-itemname="{{ $item->item_name }}"
                                        data-normal="{{ $item->purchase_price }}"
                                        data-currentqty="{{ $item->instock_qty }}" value="{{ $item->id }}">
                                        {{ $item->item_code }}-
                                        {{ $item->item_name }}&nbsp;&nbsp;
                                        {{ $item->purchase_price }}ကျပ်</option>


                        @endforeach
                    </select>
                </div>
                <div class="col-md-8 col-sm-12 d-none" id="search_wif_barcode">
                    <input class="form-control" type="text" onchange="QRcodeTest(this.value)" id="qr_code" autofocus>
                </div>
                <button onclick="qrSearch()"
                    class="col-md-1 btn-sm btn-success ml-5 pl-1 d-none d-sm-none d-md-block d-lg-block " style="padding:0">
                    <i class="fas fa-barcode p-0 text-white" style="font-size: 25px"></i>

                </button>
            </div>
        </div>
        <!-- <div class="col-md-5 mt-1 pl-0">
            <div class="col-md-10 mb-1">
                <select id="price_type" class="form-control" style="font-size: 14px">
                    <option value="1">Showroom Order</option>
                    <option value="2">Agent Order</option>
                    <option value="3">Mandalay Order</option>
                </select>

            </div>
        </div> -->


        <div class="col-10 pr-0">

            {{-- refresh here --}}
            <div class="col-md-12 pr-0" style="">
                <div class="card" style="border-radius: 0px;min-height:500px">
                    <div class="card-title">
                        <a href="" class="text-success px-2" onclick="deleteItems()"><i class="fas fa-sync"></i> Refresh
                            Here &nbsp</a>
                        <div class="row justify-content-center align-items-center">
                            <div class="col ml-5">
                                <label class="control-label text-black col-6 font14">PO Number: </label>
                                <input type="text" class="form-control col-6 font14 text-black" id="po_number" value="{{$po_code}}"
                                placeholder="Name">
                             </div>

                             <div class="col">
                                <label class="control-label text-black col-6 font14">PO Date:</label>
                                <input type="date" id="po_date" class="form-control col-6 font14 text-black" required
                                 value="{{ date('Y-m-d', $today_date) }}">
                             </div>

                            <div class="col">
                                <label class="control-label text-black col-6 font14">Required Date:</label>
                                <input type="date" id="receive_date" class="form-control col-6 font14 text-black" required
                                value="{{ date('Y-m-d', $today_date) }}">
                            </div>
                        </div>



                       <div class="row">

                         </div>


                    </div>

                    <div class="card-body salepageheight">
                        <h5 class="now_customer text-warning">Customer <span id="now_customer_no"></span></h5>
                        <input type="hidden" name="now_customer" value="0" id="now_customer">

                        <div class="row justify-content-center">
                            <table class="table text-black table-bordered">
                                <thead>
                                    <tr class="text-center" id="display_fabricrow">
                                        <th class="text-black">@lang('lang.item') @lang('lang.name')</th>
                                        <th class="text-black">Rolls</th>
                                        <th class="text-black">Yards Per Roll</th>
                                        
                                        <th class="text-black">@lang('lang.price')</th>
                                        <th class="text-black">Sub Total</th>
                                        <th class="text-black">Remark</th>
                                    </tr>
                                    <tr class="text-center d-none" id="display_itemrow">
                                        <th class="text-black">@lang('lang.item') @lang('lang.name')</th>
                                        <th class="text-black">Quantity</th>
                                        
                                        <th class="text-black">@lang('lang.price')</th>
                                        <th class="text-black">Sub Total</th>
                                        <th class="text-black">Remark</th>
                                    </tr>
                                </thead>
                                <tbody id="sale">
                                    <tr class="text-center">

                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr class="text-center" id="display_rolls">
                                        <td class="text-black" colspan="4">@lang('lang.total') Rolls
                                        </td>
                                        <td class="text-black" id="total_rolls">0</td>
                                    </tr>
                                    
                                    <tr class="text-center" id="display_yards">
                                        <td class="text-black" colspan="4">@lang('lang.total') Yards
                                        </td>
                                        <td class="text-black" id="total_yards">0</td>
                                    </tr>
                                    
                                    <tr class="text-center d-none" id="display_quantity">
                                        <td class="text-black" colspan="4">@lang('lang.total') Quantity
                                        </td>
                                        <td class="text-black" id="total_quantity">0</td>
                                    </tr>
                                    
                                    <tr class="text-center">
                                        <td class="text-black" colspan="4">@lang('lang.total')</td>
                                        <td class="text-black" id="total_amount">0</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="row ml-2 justify-content-center">

                            <!-- <div class="col-md-8"> -->

                            <div class="modal fade" id="customer_order" role="dialog" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">@lang('lang.add_customer_order')</h4>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label class="font-weight-bold">@lang('lang.select_customer')</label>
                                                <select class="form-control m-b-10" id="customer_id" style="width: 100%"
                                                    required onchange="getCustomerInfo(this.value)">
                                                    @foreach ($customers as $customer)

                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label class="font-weight-bold">@lang('lang.phone')</label>
                                                <input type="number" id="phone" class="form-control" required>
                                            </div>

                                            <div class="form-group">
                                                <label class="font-weight-bold">@lang('lang.delivered_date')</label>
                                                <input type="datetime-local" id="delivered_date" class="form-control"
                                                    required value="{{ date('Y-m-d\TH:i', $today_date) }}">

                                                <div class="form-group">
                                                    <label class="font-weight-bold">@lang('lang.order_date')</label>
                                                    <input type="date" id="order_date" class="form-control" required
                                                        value="{{ date('Y-m-d', $today_date) }}">
                                                </div>

                                                <div class="form-group">
                                                    <label class="font-weight-bold">@lang('lang.address')</label>
                                                    <input type="text" id="address" class="form-control" required>

                                                </div>

                                                <div class="form-group">
                                                    <label class="font-weight-bold">Select Employee</label>
                                                    <select class="form-control m-b-10" id="employee" style="width: 100%"
                                                        required>
                                                        <option value="">Please Choose Employee</option>
                                                        @foreach ($employees as $emp)
                                                            @if ($emp->user->role == 'Delivery_Person')
                                                                <option value="{{ $emp->id }}">
                                                                    {{ $emp->user->name }}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <a href="#" class="btn btn-success" onclick="storeCustomerOrder()">
                                                    <i class="fas fa-calendar-check"></i> @lang('lang.store_order')
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- </div> -->

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2 offset-4">
                                <button id="print" class="ml-2 btn btn-success d-none d-sm-none d-md-block d-lg-block "
                                type="button">
                                <span><i class="fa fa-print"></i> Print</span> </button>
                            </div>

                            <div class="col-md-4 d-none d-sm-none d-md-block d-lg-block ">
                                {{-- for web --}}
                                <button class="btn btn-danger store_order" type="button" onclick="storePurchaseOrder()">
                                <span><i class="fa fa-calendar-check"></i> Store Orders</span> </button>
                             </div>
                        </div>

                    </div>

                    <div class="card_footer">

                    <div class="row justify-content-center align-items-center mb-3">
                            <div class="col">
                                <label for="" class="text-black font14">Request by: </label>
                                <input type="text" class="form-control col-6 font14 text-black" id="requested_by" value="name"
                                placeholder="Name">
                             </div>
                            <div class="col">
                                <label class="text-black font14">Approved by: </label>
                                <input type="text" id="approved_by" class="form-control col-6 font14 text-black" required
                                 value="name">
                            </div>
                            <div class="col">
                                <label for="" class="text-black font14">Attach File: </label>
                                <input type="file" id="attach_file" name="attach_file" class="form-control form-control-sm w-50">
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            <div class="col-md-6 offset-md-6">
                <div class="pending-voucher row">

                </div>
            </div>
            <div class="modal fade" id="editprice" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Item Price</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                id="#close_modal">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <input type="hidden" id="po_type" value=9>
        <!--End Sale Page -->

    </div>   <!-- All row end -->
    @endsection

    @section('js')

        <script type="text/javascript">
            $('#table_1').DataTable({

                "paging": false,
                "ordering": true,
                "info": false,
                scrollY: 700,

            });

            $('#table_2').DataTable({

                "paging": false,
                "ordering": true,
                "info": false,
                scrollY: 700,

            });

            $('#table_3').DataTable({

                "paging": false,
                "ordering": true,
                "info": false,
                scrollY: 700,

            });
            $('#table_4').DataTable({

                "paging": false,
                "ordering": true,
                "info": false,
                scrollY: 700,

            });

            $(".select").select2({
                placeholder: "ရှာရန်",
            });

            $(document).ready(function() {

                $('#a5_last').hide();
                $('#a5_middle').hide();

                //     var mycart = localStorage.getItem('mycart');
                //     setInterval(() => {
                //     $.ajax({

                //         type:'POST',

                //         url:'/getItemForA5',

                //         data:{
                //             "_token":"{{ csrf_token() }}",
                //             "items":mycart,
                //         },

                //         success:function(data){
                //             console.log("10");
                //         }
                //     });
                // },1000);
                var mycart = localStorage.getItem('mycart');
                var mycartobj = JSON.parse(mycart);
                var arr = [];




                $('.now_customer').hide();
                showmodal();
                local_customer_lists();

            });
            
            function searchSubCategory(value){
                    let cat_id = value;
                    // alert(cat_id);
                    if(cat_id == 9){
                    if ($("#display_fabricrow").hasClass("d-none")) {
                    $("#display_fabricrow").removeClass("d-none");
                    $("#display_itemrow").addClass("d-none");
                    
                }
                    if($("#display_rolls").hasClass("d-none") && $("#display_yards").hasClass("d-none")){
                         $("#display_rolls").removeClass("d-none");
                         $("#display_yards").removeClass("d-none");
                    $("#display_quantity").addClass("d-none");
                    }
                        
                        
                    }else if(cat_id == 10){
                    if ($("#display_itemrow").hasClass("d-none")) {
                    $("#display_itemrow").removeClass("d-none");
                    $("#display_fabricrow").addClass("d-none");
                    
                }
                    if($("#display_quantity").hasClass("d-none") ){
                         $("#display_rolls").addClass("d-none");
                         $("#display_yards").addClass("d-none");
                    $("#display_quantity").removeClass("d-none");
                    }
                }
                
                    $('#po_type').val(cat_id);
                    $('#subcategory').empty();

                    $.ajax({
                        type: 'POST',
                        url: '/subcategory_search',
                        dataType: 'json',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "category_id": cat_id,
                        },

                        success: function(data) {
                            console.log(data);
                            if(data.length > 0){
                                $('#subcategory').append($('<option>').text('Subcategory'));
                                $.each(data, function(i, value) {
                                    $('#subcategory').append($('<option>').text(value.name).attr('value', value.id));
                                });
                            }else{
                                $('#subcategory').append($('<option>').text('No Subcategory'));
                            }
                        },

                        error: function(status) {
                            swal({
                                title: "Something Wrong!",
                                text: "Error in subcategory search",
                                icon: "error",
                            });
                        }

                    });

                }
                
            function searchCountingUnit(value){

                    let sub_id = value;
                    let cat_id = $('#category').val();
                    $('#counting_unit_select').empty();
                    $.ajax({
                        type: 'POST',
                        url: '/item_search',
                        dataType: 'json',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "category_id" : cat_id,
                            "subcategory_id": sub_id,
                        },

                        success: function(data) {
                            console.log(data);
                            if(data.length > 0){
                                $('#counting_unit_select').append($('<option>').text('Factory Items'));
                                $.each(data, function(i, value) {
                                    $('#counting_unit_select').append($('<option>').text(value.item_code + '-' + value.item_name + '  ' + value.purchase_price+ 'ကျပ်').attr('value', value.id).data('itemname',value.item_name ?? '').data('normal',value.purchase_price ?? 0).data('currentqty',value.instock_qty ?? 0));
                                });
                            }else{
                                $('#factory_item_select').append($('<option>').text('No Items'));
                            }
                        },

                        error: function(status) {
                            swal({
                                title: "Something Wrong!",
                                text: "Error in searching items",
                                icon: "error",
                            });
                        }

                    });
                }

            function deleteItems() {
                clearLocalstorage(0);
            }

            function qrSearch() {
                if ($("#search_wif_typing").hasClass("d-block")) {
                    $("#search_wif_typing").removeClass("d-block");
                    $("#search_wif_typing").addClass("d-none");
                    $("#search_wif_barcode").removeClass("d-none");
                    $("#search_wif_barcode").addClass("d-block");
                } else {
                    $("#search_wif_typing").removeClass("d-none");
                    $("#search_wif_typing").addClass("d-block");
                    $("#search_wif_barcode").removeClass("d-block");
                    $("#search_wif_barcode").addClass("d-none");
                }
                document.getElementById("qr_code").focus();
            }

            function QRcodeTest(value) {
                let sale_type = $("#price_type").val();
                $.ajax({

                    type: 'POST',

                    url: '/getCountingUnitsByItemCode',

                    data: {
                        "_token": "{{ csrf_token() }}",
                        "unit_code": value,
                    },

                    success: function(data) {

                        var item_name = data.item.item_name;

                        var id = data.id;

                        var name = data.unit_name;

                        var qty = parseInt(data.current_quantity);

                        if (sale_type == 1) {

                            var price = data.normal_sale_price;

                        } else if (sale_type == 2) {

                            var price = data.normal_sale_price;

                        } else {

                            var price = data.order_price;

                        }
                        var value = 1;
                        if (qty == 0) {


                            swal({
                                title: "Can't Add",
                                text: "Your Input is higher than Current Quantity!",
                                icon: "info",
                            });

                        } else {

                            var total_price = price * value;

                            var item = {
                                id: id,
                                item_name: item_name,
                                unit_name: name,
                                current_qty: qty,
                                order_qty: value,
                                selling_price: price
                            };

                            var total_amount = {
                                sub_total: total_price,
                                total_qty: value
                            };

                            var mycart = localStorage.getItem('mycart');

                            var grand_total = localStorage.getItem('grandTotal');

                            if (mycart == null) {

                                mycart = '[]';

                                var mycartobj = JSON.parse(mycart);

                                mycartobj.push(item);

                                localStorage.setItem('mycart', JSON.stringify(mycartobj));

                            } else {

                                var mycartobj = JSON.parse(mycart);

                                var hasid = false;

                                $.each(mycartobj, function(i, v) {

                                    if (v.id == id) {

                                        hasid = true;

                                        v.order_qty = parseInt(value) + parseInt(v.order_qty);
                                    }
                                })

                                if (!hasid) {

                                    mycartobj.push(item);
                                }

                                localStorage.setItem('mycart', JSON.stringify(mycartobj));
                            }

                            if (grand_total == null) {

                                localStorage.setItem('grandTotal', JSON.stringify(total_amount));

                            } else {

                                var grand_total_obj = JSON.parse(grand_total);

                                grand_total_obj.sub_total = total_price + grand_total_obj.sub_total;

                                grand_total_obj.total_qty = parseInt(value) + parseInt(grand_total_obj.total_qty);

                                localStorage.setItem('grandTotal', JSON.stringify(grand_total_obj));
                            }

                            showmodal();

                            $("#qr_code").val("");
                            $("#qr_code").focus();
                        }
                    }

                });
            }

            function getCountingUnit(item_id) {
                var html = "";

                $.ajax({

                    type: 'POST',

                    url: '/getCountingUnitsByItemId',

                    data: {
                        "_token": "{{ csrf_token() }}",
                        "item_id": item_id,

                    },

                    success: function(data) {

                        $.each(data, function(i, unit) {

                            html += `<tr class="text-center">
                            <input type="hidden" id="item_name" value="${unit.item.item_name}">
                            <input type="hidden" id="qty_${unit.id}" value="${unit.current_quantity}">
                            <td>${unit.item.item_name}</td>
                            <td id="name_${unit.id}">${unit.unit_name}</td>
                            <td><select class='form-control' id="price_${unit.id}"><option value='${unit.normal_sale_price}'>Normal Sale - ${unit.normal_sale_price}</option><option value='${unit.whole_sale_price}'>Whole Sale - ${unit.whole_sale_price}</option><option value='${unit.order_price}'>Order Sale - ${unit.order_price}</option></select></td>

                            <td><i class="btn btn-primary" onclick="tgPanel(${unit.id})" ><i class="fas fa-plus"></i> Add</i></td>
                      </tr>`;
                        });

                        $("#count_unit").html(html);

                        $("#unit_table_modal").modal('show');
                    }

                });
            }

            $('#search_wif_typing').on('change','#counting_unit_select',function(){

            // })
            // $('#search_wif_typing #counting_unit_select').change(function() {
                var id = $('#counting_unit_select').val();
                var itemname = $(this).find(":selected").data('itemname');
                var purchase_price = $(this).find(":selected").data('normal');
                var currentqty = $(this).find(":selected").data('currentqty');
                var po_type = $('#po_type').val();

                
                if(po_type == 9){
                    var total_price = purchase_price * 1;
                    var eachsub = purchase_price * 1;
                    var total_sub_yards = 1;
                    
                    var item = {
                        id: parseInt(id),
                        item_name: itemname,
                        rolls: 1,
                        yards_per_roll: 1,
                        sub_yards: 1,
                        purchase_price: purchase_price,
                        each_sub: eachsub,
                        remark:"",
                    };

                    var total_amount = {
                        sub_total: total_price,
                        total_rolls: 1,
                        total_yards: 1
                    };

                    var mycart = localStorage.getItem('mycart');

                    var grand_total = localStorage.getItem('grandTotal');

                    if (mycart == null) {

                        mycart = '[]';

                        var mycartobj = JSON.parse(mycart);

                        mycartobj.push(item);

                        localStorage.setItem('mycart', JSON.stringify(mycartobj));

                    } else {

                        var mycartobj = JSON.parse(mycart);

                        var hasid = false;

                        $.each(mycartobj, function(i, v) {

                            if (v.id == id) {

                                hasid = true;
                                v.rolls += 1;
                                v.sub_yards = parseInt(v.rolls) * parseInt(v.yards_per_roll);
                                total_sub_yards += parseInt(1) * parseInt(v.yards_per_roll);
                                v.each_sub = parseInt(v.purchase_price) * parseInt(v.sub_yards);
                                console.log(v.each_sub);
                            }
                        })

                        if (!hasid) {

                            mycartobj.push(item);
                        }

                        localStorage.setItem('mycart', JSON.stringify(mycartobj));
                    }

                    if (grand_total == null) {

                        localStorage.setItem('grandTotal', JSON.stringify(total_amount));

                    } else {

                        var grand_total_obj = JSON.parse(grand_total);

                        grand_total_obj.sub_total += eachsub;

                        grand_total_obj.total_rolls += 1;
                        
                        grand_total_obj.total_yards +=1;

                        localStorage.setItem('grandTotal', JSON.stringify(grand_total_obj));
                    }
                }else if(po_type == 10){
                    var total_price = purchase_price * 1;
                    var eachsub = purchase_price * 1;
                    var order_qty = 1;
                    
                    var item = {
                        id: parseInt(id),
                        item_name: itemname,
                        order_qty: order_qty,
                        purchase_price: purchase_price,
                        each_sub: eachsub,
                        remark:"",
                    };

                    var total_amount = {
                        sub_total: total_price,
                        total_qty: 1,
                    };

                    var mycart = localStorage.getItem('mycart');

                    var grand_total = localStorage.getItem('grandTotal');

                    if (mycart == null) {

                        mycart = '[]';

                        var mycartobj = JSON.parse(mycart);

                        mycartobj.push(item);

                        localStorage.setItem('mycart', JSON.stringify(mycartobj));

                    } else {

                        var mycartobj = JSON.parse(mycart);

                        var hasid = false;

                        $.each(mycartobj, function(i, v) {

                            if (v.id == id) {

                                hasid = true;
                                v.order_qty += parseInt(1) + parseInt(v.order_qty);
                                v.each_sub = parseInt(v.purchase_price) * parseInt(v.order_qty);
                                console.log(v.each_sub);
                            }
                        })

                        if (!hasid) {

                            mycartobj.push(item);
                        }

                        localStorage.setItem('mycart', JSON.stringify(mycartobj));
                    }

                    if (grand_total == null) {

                        localStorage.setItem('grandTotal', JSON.stringify(total_amount));

                    } else {

                        var grand_total_obj = JSON.parse(grand_total);

                        grand_total_obj.sub_total += eachsub;

                        grand_total_obj.total_qty += 1;

                        localStorage.setItem('grandTotal', JSON.stringify(grand_total_obj));
                    }
                }

                    $("#unit_table_modal").modal('hide');

                    // for a5 voucher
                    var mycart = localStorage.getItem('mycart');

                    var arr = [];

                    $('#lenn').html(mycart);


                    // $.ajax({

                    //     type:'POST',

                    //     url:'/getItemForA5',

                    //     data:{
                    //         "_token":"{{ csrf_token() }}",
                    //         "items":mycart,
                    //     },

                    //     success:function(data){
                    //         var arr_item = [];
                    //         arr_item.push(data);
                    //         console.log(data);
                    //         htmllen = "";
                    //         htmllen+=`${arr_item}`;
                    //         $('#lenn').html(data);

                    //     }
                    // });
                    var grand_total = localStorage.getItem('grandTotal');

                    var grand_total_obj = JSON.parse(grand_total);
                    
                        var sub_total = grand_total_obj.sub_total;
                    
                    $('#voucher_total').val(sub_total);
                    $('#gtot').val(sub_total);
                    $('#with_dis_total').val(sub_total);

                    showmodal();
                
            })

            function tgPanel(id) {

                var item_name = $('#item_name').val();

                var item_price_check = $('#price_' + id).val();

                var name = $('#name_' + id).text();

                var qty_check = $('#qty_' + id).val();

                var qty = parseInt(qty_check);

                var price = parseInt(item_price_check);

                if (item_price_check == "") {

                    swal({
                        title: "Please Check",
                        text: "Please Select Price To Sell",
                        icon: "info",
                    });
                } else {

                    swal("Please Enter Quantity:", {
                            content: "input",
                        })

                        .then((value) => {
                            if (value.toString().match(/^\d+$/)) {
                                if (value > qty) {

                                    swal({
                                        title: "Can't Add",
                                        text: "Your Input is higher than Current Quantity!",
                                        icon: "info",
                                    });

                                } else {

                                    var total_price = price * value;

                                    var item = {
                                        id: id,
                                        item_name: item_name,
                                        unit_name: name,
                                        current_qty: qty,
                                        order_qty: value,
                                        selling_price: price
                                    };

                                    var total_amount = {
                                        sub_total: total_price,
                                        total_qty: value
                                    };

                                    var mycart = localStorage.getItem('mycart');

                                    var grand_total = localStorage.getItem('grandTotal');

                                    //console.log(item);

                                    if (mycart == null) {

                                        mycart = '[]';

                                        var mycartobj = JSON.parse(mycart);

                                        mycartobj.push(item);

                                        localStorage.setItem('mycart', JSON.stringify(mycartobj));

                                    } else {

                                        var mycartobj = JSON.parse(mycart);

                                        var hasid = false;

                                        $.each(mycartobj, function(i, v) {

                                            if (v.id == id) {

                                                hasid = true;

                                                v.order_qty = parseInt(value) + parseInt(v.order_qty);
                                            }
                                        })

                                        if (!hasid) {

                                            mycartobj.push(item);
                                        }

                                        localStorage.setItem('mycart', JSON.stringify(mycartobj));
                                    }

                                    if (grand_total == null) {

                                        localStorage.setItem('grandTotal', JSON.stringify(total_amount));

                                    } else {

                                        var grand_total_obj = JSON.parse(grand_total);

                                        grand_total_obj.sub_total = total_price + grand_total_obj.sub_total;

                                        grand_total_obj.total_qty = parseInt(value) + parseInt(grand_total_obj.total_qty);

                                        localStorage.setItem('grandTotal', JSON.stringify(grand_total_obj));
                                    }

                                    $("#unit_table_modal").modal('hide');

                                    showmodal();
                                }
                            } else {
                                swal({
                                    title: "Input Invalid",
                                    text: "Please only input english digit",
                                    icon: "info",
                                });
                            }
                        })

                }
            }

            function rollplus(id) {
                var now_qty = parseInt($(`#nowrolls${id}`).val());
                count_change(id, 'roll', now_qty);
                $(`#nowrolls${id}`).focus();
                var num = $(`#nowrolls${id}`).val();
                $(`#nowrolls${id}`).focus().val('').val(num);

            }
            
            function yardplus(id) {
                var now_qty = parseInt($(`#nowyardsperroll${id}`).val());
                count_change(id, 'yard', now_qty);
                $(`#nowyardsperroll${id}`).focus();
                var num = $(`#nowyardsperroll${id}`).val();
                $(`#nowyardsperroll${id}`).focus().val('').val(num);

            }
            
            function qtyplus(id) {
                var now_qty = parseInt($(`#nowqty${id}`).val());
                count_change(id, 'qty', now_qty);
                $(`#nowqty${id}`).focus();
                var num = $(`#nowqty${id}`).val();
                $(`#nowqty${id}`).focus().val('').val(num);

            }

            function minus(id) {

                count_change(id, 'minus', 1);
            }

            function plusfive(id) {

                count_change(id, 'plus', 5);
            }

            function minusfive(id) {

                count_change(id, 'minus', 5);
            }

            function remove(id, qty) {
                count_change(id, 'remove', qty)
            }

            function count_change(id, action, qty) {

                var grand_total = localStorage.getItem('grandTotal');

                var mycart = localStorage.getItem('mycart');

                var mycartobj = JSON.parse(mycart);

                var grand_total_obj = JSON.parse(grand_total);

                var item = mycartobj.filter(item => item.id == id);

                if (action == 'qty') {

                    

                        item[0].order_qty = qty;
                        
                            item[0].each_sub = parseInt(item[0].purchase_price) * qty;
                        

                        new_total = 0;
                        new_total_qty = 0;
                        $.each(mycartobj, function(i, value) {
                            new_total += value.each_sub;
                            new_total_qty += value.order_qty
                        })

                        grand_total_obj.sub_total = new_total;

                        grand_total_obj.total_qty = new_total_qty;

                        localStorage.setItem('mycart', JSON.stringify(mycartobj));

                        localStorage.setItem('grandTotal', JSON.stringify(grand_total_obj));

                        count_item();

                        showmodal();

                    
                } else if (action == 'minus') {

                    if (item[0].order_qty <= qty) {

                        //var ans=confirm('Are you sure');

                        swal({
                            title: "Are you sure?",
                            text: "The item will be remove from cart list",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: '#DD6B55',
                            confirmButtonText: 'Yes',
                            cancelButtonText: "No",
                            closeOnConfirm: false,
                            closeOnCancel: false
                        }).then(
                            function(isConfirm) {
                                if (isConfirm) {

                                    let item_cart = mycartobj.filter(item => item.id !== id);

                                    grand_total_obj.sub_total -= parseInt(item[0].selling_price) * qty;

                                    grand_total_obj.total_qty -= qty;

                                    console.log("yes");
                                    localStorage.setItem('mycart', JSON.stringify(item_cart));

                                    localStorage.setItem('grandTotal', JSON.stringify(grand_total_obj));

                                    count_item();

                                    showmodal();

                                } else {

                                    item[0].order_qty;
                                    console.log("no");
                                    localStorage.setItem('mycart', JSON.stringify(mycartobj));

                                    localStorage.setItem('grandTotal', JSON.stringify(grand_total_obj));

                                    count_item();

                                    showmodal();
                                }
                            });



                    } else {
                        console.log("hello");
                        item[0].order_qty -= qty;

                        grand_total_obj.sub_total -= parseInt(item[0].selling_price) * qty;
                        item[0].each_sub -= parseInt(item[0].selling_price) * qty;
                        grand_total_obj.total_qty -= qty;

                        localStorage.setItem('mycart', JSON.stringify(mycartobj));

                        localStorage.setItem('grandTotal', JSON.stringify(grand_total_obj));

                        count_item();

                        showmodal();
                    }
                } else if (action == 'remove') {
                    //var ans=confirm('Are you sure?');

                    swal({
                        title: "Are you sure?",
                        text: "The item will be remove from cart list",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: '#DD6B55',
                        confirmButtonText: 'Yes',
                        cancelButtonText: "No",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    }).then(
                        function(isConfirm) {

                            if (isConfirm) {
                                let item_cart = mycartobj.filter(item => item.id !== id);
                                console.log(item_cart);
                                grand_total_obj.sub_total = grand_total_obj.sub_total - (parseInt(item[0].selling_price) *
                                    qty);

                                grand_total_obj.total_qty = grand_total_obj.total_qty - qty;

                                localStorage.setItem('mycart', JSON.stringify(item_cart));

                                localStorage.setItem('grandTotal', JSON.stringify(grand_total_obj));

                                count_item();

                                showmodal();

                            } else {
                                item[0].order_qty;

                                localStorage.setItem('mycart', JSON.stringify(mycartobj));

                                localStorage.setItem('grandTotal', JSON.stringify(grand_total_obj));

                                count_item();

                                showmodal();
                            }
                        });

                    // if(ans){



                    // }else{


                    // }
                }else if(action == 'roll'){
                        console.log('roll add');

                        item[0].rolls = qty;
                        
                        item[0].sub_yards = qty * parseInt(item[0].yards_per_roll);
                        
                            item[0].each_sub = parseInt(item[0].purchase_price) * item[0].sub_yards;
                        

                        new_total = 0;
                        new_total_rolls = 0;
                        new_total_yards = 0;
                        $.each(mycartobj, function(i, value) {
                            new_total += value.each_sub;
                            new_total_rolls += value.rolls;
                            new_total_yards += value.sub_yards;
                        })

                        grand_total_obj.sub_total = new_total;

                        grand_total_obj.total_rolls = new_total_rolls;
                        
                        grand_total_obj.total_yards = new_total_yards;
                        
                        localStorage.setItem('mycart', JSON.stringify(mycartobj));

                        localStorage.setItem('grandTotal', JSON.stringify(grand_total_obj));

                        //count_item();

                        showmodal();

                    
                }else if(action == 'yard'){
                        console.log('yard add');

                        item[0].yards_per_roll = qty;
                        
                        item[0].sub_yards = qty * parseInt(item[0].rolls);
                        
                            item[0].each_sub = parseInt(item[0].purchase_price) * item[0].sub_yards;
                        

                        new_total = 0;
                        new_total_rolls = 0;
                        new_total_yards = 0;
                        $.each(mycartobj, function(i, value) {
                            new_total += value.each_sub;
                            new_total_rolls += value.rolls;
                            new_total_yards += value.sub_yards;
                        })

                        grand_total_obj.sub_total = new_total;

                        grand_total_obj.total_rolls = new_total_rolls;
                        
                        grand_total_obj.total_yards = new_total_yards;
                        
                        localStorage.setItem('mycart', JSON.stringify(mycartobj));

                        localStorage.setItem('grandTotal', JSON.stringify(grand_total_obj));

                        //count_item();

                        showmodal();

                    
                }

            }

            function showmodal() {

                var mycart = localStorage.getItem('mycart');

                var grandTotal = localStorage.getItem('grandTotal');

                var grandTotal_obj = JSON.parse(grandTotal);
                
                var po_type = $('#po_type').val();

                if (mycart) {

                    var mycartobj = JSON.parse(mycart);

                    var html = '';

                    if (mycartobj.length > 0) {
                        
                        

                        $.each(mycartobj, function(i, v) {

                            if(po_type == 9){
                            var id = v.id;

                            var item = v.item_name;

                            var rolls = v.rolls;
                            
                            var yards_per_roll = v.yards_per_roll;
                            
                            var purchase_price = v.purchase_price;
                            
                            var each_sub = v.each_sub;

                            //var count_name = v.unit_name;

                            
                            // <i class="fa fa-plus-circle btnplus font-18" onclick="plusfive(${id})" id="${id}"></i>
                            // <i class="fa fa-minus-circle btnminus font-18   "  onclick="minusfive(${id})" id="${id}"></i>
                            html += `<tr class="text-center">




                            <td>${item}</td>

                            <td class="text-black w-15 m-0 p-0" onkeyup="rollplus(${id})" id="${id}">
                                <input type="number" class="form-control w-100 text-black text-center p-0 mt-1" name="" id="nowrolls${id}" value="${rolls}" style="border: none;border-color: transparent;">
                            </td>
                            
                            <td class="text-black w-20 m-0 p-0" onkeyup="yardplus(${id})" id="${id}">
                                <input type="number" class="form-control w-100 text-black text-center p-0 mt-1" name="" id="nowyardsperroll${id}" value="${yards_per_roll}" style="border: none;border-color: transparent;">
                            </td>

                            <td class="text-black w-20 m-0 p-0" data-price="${purchase_price}" >
                                <input onkeyup="table_edit_price(${v.id},${purchase_price})" type="number" class=" form-control w-100 text-black text-center p-0 mt-1" id="nowprice${id}" value="${purchase_price}" style="border: none;border-color: transparent;">
                            </td>

                            <td class="text-black text-center w-20 m-0 p-0">${each_sub ?? 0}</td>

                            <td class="text-black w-20 m-0 p-0">
                                <input onkeyup="storeRemark(${v.id})" type="text" class=" form-control w-100 text-black text-center p-0 mt-1" id="nowremark${id}" value="remark" style="border: none;border-color: transparent; font-size:14px;" placeholder="remark">
                            </td>

                            <td><i class="fa fa-times" onclick="remove(${id},${v.sub_yards})" id="${id}"></i> </td>
                            </tr>`;
                            }else if(po_type == 10){
                            var id = v.id;

                            var item = v.item_name;

                            var order_qty = v.order_qty;
                            
                            var purchase_price = v.purchase_price;
                            
                            var each_sub = v.each_sub;
                            
                            html = `<td>${item}</td>

                            <td class="text-black w-20 m-0 p-0" onkeyup="qtyplus(${id})" id="${id}">
                                <input type="number" class="form-control w-100 text-black text-center p-0 mt-1" name="" id="nowqty${id}" value="${order_qty}" style="border: none;border-color: transparent;">
                            </td>

                            <td class="text-black w-20 m-0 p-0" data-price="${purchase_price}" >
                                <input onkeyup="table_edit_price(${v.id},${purchase_price})" type="number" class=" form-control w-100 text-black text-center p-0 mt-1" id="nowprice${id}" value="${purchase_price}" style="border: none;border-color: transparent;">
                            </td>

                            <td class="text-black text-center w-20 m-0 p-0">${each_sub ?? 0}</td>

                            <td class="text-black w-20 m-0 p-0">
                                <input onkeyup="storeRemark(${v.id})" type="text" class=" form-control w-100 text-black text-center p-0 mt-1" id="nowremark${id}" value="remark" style="border: none;border-color: transparent; font-size:14px;" placeholder="remark">
                            </td>

                            <td><i class="fa fa-times" onclick="remove(${id},${v.order_qty})" id="${id}"></i> </td>
                            </tr>`;
                        }

                        });
                        
                    }

                //     var htmlslip = "";
                //     var id = $('#counting_unit_select').val();
                //     $.each(mycartobj, function(i, v) {
                //         if (parseInt(v.discount) == 0) {
                //             var purchase_price = v.purchase_price;
                //         } else {
                //             var purchase_price = v.discount;
                //         }
                //         var totalslip = parseInt(purchase_price) * parseInt(v.order_qty);
                //         htmlslip += `
                //          <tr>
                //             <td style="font-size:15px;">${v.item_name}</td>
                //             <td style="font-size:15px;">${v.order_qty} * ${purchase_price}</td>
                //             <td style="font-size:15px;" id="subtotal">${totalslip}</td>
                //         </tr>
                // `;
                //     });

                    // if (grandTotal_obj.vou_discount == 0) {
                    //     var sub_total = grandTotal_obj.sub_total;
                    //     var total_wif_discount = grandTotal_obj.sub_total;
                    // } else if (grandTotal_obj.vou_discount == "foc") {
                    //     var sub_total = grandTotal_obj.sub_total;
                    //     var total_wif_discount = 0;

                    // } else {
                    //     var sub_total = grandTotal_obj.sub_total;
                    //     var total_wif_discount = grandTotal_obj.sub_total - grandTotal_obj.vou_discount;
                    // }

                   // $('#slip_live').html(htmlslip);
                   // $('#total_charges').text(total_wif_discount);
                   // var pay = $('#payable').val();

                    if(po_type == 9){
                    $("#total_rolls").text(grandTotal_obj.total_rolls);
                    $("#total_yards").text(grandTotal_obj.total_yards);
                    }else if(po_type == 10){
                        $('#total_quantity').text(grandTotal_obj.total_qty);
                    }
                    $("#total_amount").text(grandTotal_obj.sub_total);

                    // $("#sub_total").text(total_wif_discount);
                    // $('#gtot').val(sub_total);
                    // $('#with_dis_total').val(total_wif_discount)

                     $("#sale").html(html);

                }
                //show_a5();
            }


            function count_item() {

                var mycart = localStorage.getItem('mycart');

                if (mycart) {

                    var mycartobj = JSON.parse(mycart);

                    var total_count = 0;

                    $.each(mycartobj, function(i, v) {

                        total_count += v.order_qty;

                    })

                    $(".item_count_text").html(total_count);

                } else {

                    $(".item_count_text").html(0);

                }
            }

            $('#sale').on('dblclick', '.editprice', function() {
                var id = $(this).data('id');
                var price = $(this).data('price');
                $('#count_id').val(id);
                $('#price_change').val(price);
                $('#or_price').val(price);
                console.log(id, price);
                $('#editprice').modal("show");
            })

            $('#price_change_btn').click(function() {

                var count_id = $('#count_id').val();
                // alert(count_id);
                var price_change = $('#price_change').val();
                // alert(price_change);
                var grand_total = localStorage.getItem('grandTotal');

                var mycart = localStorage.getItem('mycart');

                var discart = localStorage.getItem('mydiscart');

                var focflagcart = localStorage.getItem('myfocflag');

                var hasdiscart = localStorage.getItem('myhasdis');

                var mycartobj = JSON.parse(mycart);

                var grand_total_obj = JSON.parse(grand_total);

                var dis_cart_obj = JSON.parse(discart);

                var foc_flag_obj = JSON.parse(focflagcart);

                var has_dis_obj = JSON.parse(hasdiscart);

                var foc = {
                    foc_flag: 1
                };

                var hasdis = {
                    hasdis: 1
                };




                $.each(dis_cart_obj, function(i, v) {
                    // alert(v.discount_flag);

                    var discart = localStorage.getItem('mydiscart');
                    var dis_cart_obj = JSON.parse(discart);

                    // alert(dis_cart_obj[i].id);
                    if (dis_cart_obj[i].id == count_id) {
                        // var dis={id:dis_cart_obj[i].id,item_name:dis_cart_obj[i].itemname,unit_name:dis_cart_obj[i].unitname,current_qty:dis_cart_obj[i].currentqty,order_qty:1,original_price:dis_cart_obj[i].saleprice,discount:price_change};

                        if (price_change == 0) {
                            dis_cart_obj[i].discount = price_change;
                            dis_cart_obj[i].different = parseInt(dis_cart_obj[i].original_price) - parseInt(
                                price_change);
                            dis_cart_obj[i].discount_flag = 1;
                        } else {
                            dis_cart_obj[i].discount = price_change;
                            dis_cart_obj[i].different = parseInt(dis_cart_obj[i].original_price) - parseInt(
                                price_change);
                            var hasdiscart = localStorage.getItem('myhasdis');
                            var has_dis_obj = JSON.parse(hasdiscart);
                            localStorage.setItem('myhasdis', JSON.stringify(hasdis));
                        }



                        localStorage.setItem('mydiscart', JSON.stringify(dis_cart_obj));
                        // alert("done");
                    }
                });

                if (price_change == 0) {
                    var focflagcart = localStorage.getItem('myfocflag');
                    var foc_flag_obj = JSON.parse(focflagcart);
                    localStorage.setItem('myfocflag', JSON.stringify(foc));
                }

                // alert(dis_cart_obj.length);
                //discount cart




                //End discount cart

                var item = mycartobj.filter(item => item.id == count_id);

                grand_total_obj.sub_total -= parseInt(item[0].selling_price);

                grand_total_obj.sub_total += parseInt(price_change);

                // item[0].selling_price= parseInt(price_change);

                item[0].each_sub = parseInt(price_change);

                localStorage.setItem('mycart', JSON.stringify(mycartobj));

                localStorage.setItem('grandTotal', JSON.stringify(grand_total_obj));

                showmodal();

                $('#editprice').modal("hide");

            })


//clearLocalstorate in masterblade


            $('#percent_for_price').click(function() {
                var idArray = [];
                $("input:checkbox[name=percent_for_price]:checked").each(function() {
                    idArray.push(parseInt($(this).val()));
                });
                if (idArray.length > 0) {
                    $('#percent_price').removeAttr('disabled');
                    $('#percent_price').focus();
                } else {
                    $('#percent_price').attr('disabled', 'disabled');
                }
                //    var percent_for_price=$('#percent_for_price').val();
            })
            $('#percent_price').keyup(function() {
                var percent_price = $('#percent_price').val();
                var or_price = $('#or_price').val();
                var discount_amount = parseInt(or_price * (percent_price / 100));
                var change_percent_price = parseInt(or_price) + discount_amount;
                $('#discount_amount').html(discount_amount);
                $('#price_change').val(change_percent_price);
            })

            $('#foc').click(function() {
                var idArray = [];
                $("input:checkbox[name=foc]:checked").each(function() {
                    idArray.push(parseInt($(this).val()));
                });
                var price_change = $('#price_change').val();
                var or_price = $('#or_price').val();
                if (idArray.length > 0) {
                    $('#price_change').val(0);
                } else {
                    $('#price_change').val(or_price);
                }
                //    var percent_for_price=$('#percent_for_price').val();
            })

            function showCheckOut() {


                var now_customer = $('#now_customer').val();

                var mycart = localStorage.getItem('mycart');

                var grand_total = localStorage.getItem('grandTotal');

                var discount = localStorage.getItem('mydiscart');

                var focflag = localStorage.getItem('myfocflag');

                var hasdis = localStorage.getItem('myhasdis');


                if (!mycart) {

                    swal({
                        title: "Please Check",
                        text: "Item Cannot be Empty to Check Out",
                        icon: "info",
                    });

                } else {

                    $("#item").attr('value', mycart);

                    $("#grand").attr('value', grand_total);

                    $('#right_now_customer').val(now_customer);

                    $('#discount').attr('value', discount);

                    $('#foc_flag').attr('value', focflag);

                    $('#has_dis').attr('value', hasdis);

                    $("#vourcher_page").submit();

                }
            }

            function getCustomerInfo(value) {

                $.ajax({

                    type: 'POST',

                    url: '/getCustomerInfo',

                    data: {
                        "_token": "{{ csrf_token() }}",
                        "customer_id": value,
                    },

                    success: function(data) {

                        $("#phone").val(data.phone);

                        $("#address").val(data.address);
                    },


                });
            }

            function storePurchaseOrder() {

                var item = localStorage.getItem('mycart');

                var grand_total = localStorage.getItem('grandTotal');

                var po_number = $('#po_number').val();

                var po_date = $('#po_date').val();
                
                var po_type = $('#po_type').val();

                var receive_date = $('#receive_date').val();

               
                var requested_by = $('#requested_by').val();
                 var approved_by = $('#approved_by').val();
                var file_data = $('#attach_file').prop('files')[0];
                var form_data = new FormData();
                form_data.append("_token","{{ csrf_token() }}");
                form_data.append("file",file_data);
                form_data.append("item",item);
                form_data.append("grand_total",grand_total);
                form_data.append("po_number",po_number);
                form_data.append("po_date",po_date);
                form_data.append("po_type",po_type);
                form_data.append("receive_date",receive_date);
                
                form_data.append("requested_by",requested_by);
                form_data.append("approved_by",approved_by);
                console.log(form_data);

                // var customer_name = $('#customer_name').val();

                // var customer_phone = $('#customer_phone').val();

                // var order_date = $('#order_date').val();

                //var delivered_date = $('#delivered_date').val();

                //var employee = $('#employee').val();

               // var customer_address = $('#customer_address').val();

               // alert(order_date);


                if (!item || !grand_total) {

                    swal({
                        title: "@lang('lang.please_check')",
                        text: "@lang('lang.cannot_checkout')",
                        icon: "info",
                    });

                } else {

                    //alert(customer_name);

                    $.ajax({

                        type: 'POST',

                        url: '/storePurchaseOrder',

                        // data: {
                        //     "_token": "{{ csrf_token() }}",
                        //     "item": item,
                        //     "grand_total": grand_total,
                        //     "po_number": po_number,
                        //     "po_date": po_date,
                        //     "receive_date": receive_date,
                        //     "requested_by": requested_by,
                        //     "attach_file": form_data,
                        //     // "delivered_date": delivered_date,
                        //     // "employee": employee,
                        // },
                        
                        data: form_data,
                        
                        cache: false,
                        contentType: false,
                        processData: false,
                        
                        success: function(data) {

                            console.log(data);
                            localStorage.clear();

                            swal({
                                title: "Success",
                                text: "Order is Successfully Stored",
                                icon: "success",
                            });
                            
                            localStorage.clear();
                               
                               setTimeout(function () {
                                    location.reload(true);
                                }, 1000);


                        },

                        error: function(status) {

                            swal({
                                title: "Something Wrong!",
                                text: "Something Wrong, Cannot store the order",
                                icon: "error",
                            });
                        }
                    });

                }
            }

            $('.pending-voucher').on('click', '.buttonrelative .deletevoucher', function() {
                var now_customer = $('#now_customer').val();
                var pendingvoucherno = $(this).data('pendingvoucherno');
                var cartname = "mycart_" + pendingvoucherno;
                var grand_totalname = "grandTotal_" + pendingvoucherno;

                var local_customer = localStorage.getItem('local_customer_lists');
                var local_customer_array = JSON.parse(local_customer);
                $.each(local_customer_array, function(i, v) {
                    if (v == pendingvoucherno) {
                        local_customer_array.splice(i, 1);
                    }
                })
                localStorage.setItem('local_customer_lists', JSON.stringify(local_customer_array));
                localStorage.removeItem(cartname);
                localStorage.removeItem(grand_totalname);

                if (now_customer == pendingvoucherno) {
                    localStorage.removeItem('mycart');
                    localStorage.removeItem('grandTotal');
                    $('.now_customer').hide();
                    $('#now_customer').val(0);
                    $('#total_quantity').empty();
                    $('#sub_total').empty();
                    $('#sale').empty();
                }

                local_customer_lists();
                showmodal();


            });

            function local_customer_lists() {
                var cust_name = $('#pending_cust').val();
                if (cust_name) {
                    var cust = cust_name;

                    // alert("null");
                } else {
                    var cust = "Customer";
                    // alert("has");
                }
                // alert(cust);
                var local_customer_lists = localStorage.getItem('local_customer_lists');

                var local_customer_array = JSON.parse(local_customer_lists);

                $('.pending-voucher').empty();

                $.each(local_customer_array, function(i, v) {

                    var btnpending = `

            <div class="buttonrelative mb-2">
                <button class="btn btn-warning mx-2" data-pendingvoucherno="${v}"><i class="fas fa-arrow-alt-circle-up"></i> ${cust} ${v}</button>
            <p class="bg-danger text-white deletevoucher rounded" data-pendingvoucherno="${v}">x</p>
            </div>

            `;
                    $('.pending-voucher').append(btnpending);
                })
            }

            $('.pending-voucher').on('click', '.buttonrelative button', function() {

                var pendingvoucherno = $(this).data('pendingvoucherno');

                $('#now_customer').val(pendingvoucherno);
                $('#now_customer_no').text(pendingvoucherno);

                $('.now_customer').show();
                var cartname = "mycart_" + pendingvoucherno;
                var grand_totalname = "grandTotal_" + pendingvoucherno;


                var mycart_pending_vocher = localStorage.getItem(cartname);

                var grand_total_pending_voucher = localStorage.getItem(grand_totalname);

                localStorage.setItem('mycart', mycart_pending_vocher);

                localStorage.setItem("grandTotal", grand_total_pending_voucher);

                showmodal();

            })

            function storePendingVoucher() {
                var cust_name = $('#pending_cust').val();
                if (cust_name) {
                    var cust = cust_name;

                    // alert("null");
                } else {
                    var cust = "Customer";
                    // alert("has");
                }
                var mycart = localStorage.getItem('mycart');

                var grand_total = localStorage.getItem('grandTotal');

                var nextvoucherno = parseInt(pendingvoucherno) + 1;

                var now_customer = $('#now_customer').val();

                var local_customer_lists = localStorage.getItem('local_customer_lists');
                var local_last_customer_no = localStorage.getItem('last_customer_no');
                if (!mycart) {

                    swal({
                        title: "Please Check",
                        text: "Item Cannot be Empty to Store Voucher",
                        icon: "info",
                    });

                } else {

                    if (now_customer == 0) {
                        // 0 means new customer

                        var last_customer_no = JSON.parse(local_last_customer_no);
                        var local_customer_obj = JSON.parse(local_customer_lists);

                        if (local_customer_obj) {
                            // console.log("not null ="+local_customer_obj.length);
                            // console.log("not nullllllll");
                            if (!local_customer_obj.length == 0) {
                                console.log("!local_customer_obj.length==0");
                                var pendingvoucherno = last_customer_no + 1;
                            } else {
                                var pendingvoucherno = 1;
                            }
                        } else {
                            // console.log("in null"+local_customer_obj);
                            var pendingvoucherno = 1;
                            var local_customer_obj = [];
                        }

                        localStorage.setItem('last_customer_no', JSON.stringify(pendingvoucherno));
                        local_customer_obj.push(parseInt(pendingvoucherno));
                        localStorage.setItem('local_customer_lists', JSON.stringify(local_customer_obj));
                        var cartname = "mycart_" + pendingvoucherno;
                        var grand_totalname = "grandTotal_" + pendingvoucherno;

                        var btnpending = `
        <div class="buttonrelative mb-2">
            <button class="btn btn-warning mx-2" data-pendingvoucherno="${pendingvoucherno}"><i class="fas fa-arrow-alt-circle-up"></i> ${cust} ${pendingvoucherno}</button>
        <p class="bg-danger text-white deletevoucher rounded" data-pendingvoucherno="${pendingvoucherno}">x</p>
        </div>

        `;
                        $('.pending-voucher').append(btnpending);
                    } else {
                        var cartname = "mycart_" + now_customer;
                        var grand_totalname = "grandTotal_" + now_customer;

                    }
                    localStorage.setItem(cartname, mycart);
                    localStorage.setItem(grand_totalname, grand_total);

                    localStorage.removeItem('mycart');
                    localStorage.removeItem('grandTotal');
                    $('.now_customer').hide();
                    $('#now_customer').val(0);
                    $('#total_quantity').empty();
                    $('#sub_total').empty();
                    $('#sale').empty();
                    showmodal();

                }

                function local_customer_lists() {

                    var local_customer_lists = localStorage.getItem('local_customer_lists');

                    var local_customer_array = JSON.parse(local_customer_lists);

                    $('.pending-voucher').empty();

                    $.each(local_customer_array, function(i, v) {

                        var btnpending = `

            <div class="buttonrelative mb-2">
                <button class="btn btn-warning mx-2" data-pendingvoucherno="${v}"><i class="fas fa-arrow-alt-circle-up"></i> Customer${v}</button>
            <p class="bg-danger text-white deletevoucher rounded" data-pendingvoucherno="${v}">x</p>
            </div>

            `;
                        $('.pending-voucher').append(btnpending);
                    })
                }

            }

            function getCreditAmount(pay_amount) {

                var total_charges = parseInt($('#with_dis_total').val());

                var has_credit = parseInt($('#credit').val());
                var previous_credit = $('#previous_credit').val();
                // alert(total_charges);alert
                if (pay_amount > total_charges) {
                    var credit_amt = 0;
                    $('#current_change').val(parseInt(pay_amount) - parseInt(total_charges));
                } else {
                    var credit_amt = parseInt(total_charges) - parseInt(pay_amount);
                    var hascre = parseInt(previous_credit) + parseInt(credit_amt);
                }
                $('#pay').text(pay_amount);
                $("#credit").val(hascre);
                $('#current_credit').val(credit_amt);
            }

            function fillCustomer(value) {

                var customer_id = value;


                $.ajax({
                    type: 'POST',
                    url: '{{ route('AjaxGetCustomerwID') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "customer_id": customer_id,
                    },
                    success: function(data) {
                        $("#name").val(data.sale_cust.name);
                        $("#custphone").val(data.sale_cust.phone);
                        $('#pending_cust').val(data.sale_cust.name);
                        //  $("#credit").val(data.credit_amount);
                        if (data.sale_credit != null) {
                            $('#credit').val(data.sale_cust.credit_amount);
                            $('#previous_credit').val(data.sale_cust.credit_amount);
                        } else {
                            $('#credit').val(0);
                            $('#previous_credit').val(0);
                        }
                    },
                });
            }

            var last_row_id = 0;
            $("#save").click(function() {
                var name = $('#name').val();
                var phone = $('#custphone').val();
                var credit_amount = $('#credit').val();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('AjaxStoreCustomer') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "name": name,
                        "phone": phone,
                        "credit_amount": credit_amount,
                    },
                    success: function(data) {
                        console.log(data.last_row);
                        if (data.success == 1) {
                            last_row_id = data.last_row.id;
                            //$lastRecord = DB::table('sales_customers')->orderBy('id', 'DESC')->first();

                        }
                    }
                });

            });
            var salescustomer = null;

            $("#deletesaleuser").click(function() {
                var salecustomer_id = $('#salescustomer_list').children("option:selected").val();
                console.log(salecustomer_id);
                var salescustomer = null;

                $("#deletesaleuser").click(function() {
                    var salecustomer_id = $('#salescustomer_list').children("option:selected").val();
                    console.log(salecustomer_id);
                    swal({
                            title: "@lang('lang.confirm')",
                            icon: 'warning',
                            buttons: ["@lang('lang.no')", "@lang('lang.yes')"]
                        })
                        .then((isConfirm) => {
                            if (isConfirm) {
                                $.ajax({
                                    type: 'POST',
                                    dataType: 'json',
                                    url: '{{ route('saleCustomerDelete') }}',
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        "salecustomer_id": salecustomer_id,

                                    },
                                    success: function() {

                                        swal({
                                            title: "Success!",
                                            text: "Successfully Deleted!",
                                            icon: "success",
                                        });
                                        setTimeout(function() {
                                            window.location.reload();
                                        }, 1000);

                                    },
                                });
                            }


                        });
                });

            });

            $(".store_voucher").click(function() {
                // alert("hello");

                var custphone = $('#custphone').val();

                var from_id = $('#fid').val();

                var exitvoucher = localStorage.getItem('exitvoucher');
                if (exitvoucher == null) {
                    voucher_id = 0;
                } else {
                    voucher_id = exitvoucher;
                }


                var salecustomer_id = $('#salescustomer_list').children("option:selected").val();

                var now_customer = $('#now_customer').val();

                var mycart = localStorage.getItem('mycart');

                var grand_total = localStorage.getItem('grandTotal');
                var editvoucher = localStorage.getItem('editvoucher');

                var item = mycart;
                var grand = grand_total;
                var discount = discount;
                var voucher_code = $('#voucherCode').val();
                var right_now_customer = now_customer;
                var cus_pay = $('#payable').val();

                // alert(vou_Dis);

                var repaymentDate = $('#repaymentDate').val();

                var name = $('#name').val();

                var id = $('#salescustomer_list').children("option:selected").val();

                var credit = $('#current_credit').val();
                // alert(id);
                if (!cus_pay) {
                    swal({
                        icon: 'error',
                        title: 'ပေးငွေ ထည့်ပါ!',
                        text: 'Customer Pay cannot be null!!!',
                        footer: '<a href>Why do I have this issue?</a>'
                    })
                } else if (id) {
                    // alert("in");
                    $.ajax({
                        type: 'POST',
                        url: '/testVoucher',
                        dataType: 'json',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "item": item,
                            "grand": grand,
                            "voucher_code": voucher_code,
                            "sales_customer_id": id,
                            "sales_customer_name": name,
                            "credit_amount": credit,
                            "repaymentDate": repaymentDate,
                            "voucher_id": parseInt(voucher_id),
                            "cus_pay": cus_pay,
                            "editvoucher": editvoucher ?? 0 ,
                        },
                        success: function(data) {
                            if (data.status == 0) {
                                swal({
                                    icon: 'error',
                                    title: 'မှားယွင်းနေပါသည်.',
                                    text: 'ပြန်စစ်ပါ..',
                                })
                            } else {
                                $('#voucherCode').val(data.voucher_code);
                                $('.vou_code').empty();
                                $('.vou_code').text(data.voucher_code);
                                localStorage.setItem('exitvoucher', JSON.stringify(data.id));
                                clearLocalstorage(right_now_customer);
                                formReset();
                                $('#counting_unit_select').empty();

                                var item_html = ``;

                                $.each(data.items, function(i, item) {

                                    if (item.counting_units) {
                                        $.each(item.counting_units, function(j, counting_unit) {

                                            $.each(counting_unit.stockcount, function(k,
                                                stock) {

                                                if (stock.from_id == from_id) {
                                                    stockcountt = stock.stock_qty;
                                                }
                                            })
                                            item_html += `
                                    <option class="text-black" data-unitname="${counting_unit.unit_name}"
                                        data-itemname="${item.item_name }"
                                        data-normal="${counting_unit.normal_sale_price }"
                                        data-whole="${counting_unit.whole_sale_price }"
                                        data-order="${counting_unit.order_price }" data-currentqty="${ stockcountt }"
                                        value="${counting_unit.id }">${counting_unit.unit_code }-
                                        ${counting_unit.unit_name }&nbsp;&nbsp; ${stockcountt}ခု&nbsp;&nbsp;
                                        ${counting_unit.normal_sale_price}ကျပ်</option>
                                    `;
                                        })
                                    }

                                })
                                var main_html = `
                                <select class="p-4 select form-control text-black" name="item" id="counting_unit_select">
                                <option></option>` + item_html + `
                                </select>
                                `;

                                $('#search_wif_typing').html(main_html);

                                $("#search_wif_typing .select").select2({
                                    placeholder: "ရှာရန်",
                                });
                                swal({
                                    icon: 'success',
                                    title: 'သိမ်းဆည်းပြီး!',
                                    text: 'Voucher သိမ်းဆည်းပြီးပါပြီ!!',
                                    button: false,
                                    timer: 1500,
                                })
                            }



                        }
                    });
                } else {
                    //last_row_id
                    // alert("out");
                    $.ajax({
                        type: 'POST',
                        url: '/testVoucher',
                        dataType: 'json',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "item": item,
                            "grand": grand,
                            "voucher_code": voucher_code,
                            "sales_customer_id": last_row_id,
                            "sales_customer_name": name,
                            "credit_amount": credit,
                            "voucher_id": parseInt(voucher_id),
                            "cus_pay": cus_pay,
                            "editvoucher": editvoucher ?? 0 ,
                        },
                        success: function(data) {
                            if (data.status == 0) {
                                swal({
                                    icon: 'error',
                                    title: 'မှားယွင်းနေပါသည်.',
                                    text: 'ပြန်စစ်ပါ..',
                                })
                            } else {
                                $('#voucherCode').val(data.voucher_code);
                                $('.vou_code').empty();
                                $('.vou_code').text(data.voucher_code);
                                localStorage.setItem('exitvoucher', JSON.stringify(data.id));
                                clearLocalstorage(right_now_customer);
                                formReset();
                                $('#counting_unit_select').empty();

                                var item_html = ``;

                                $.each(data.items, function(i, item) {

                                    if (item.counting_units) {
                                        $.each(item.counting_units, function(j, counting_unit) {

                                            $.each(counting_unit.stockcount, function(k,
                                                stock) {

                                                if (stock.from_id == from_id) {
                                                    stockcountt = stock.stock_qty;
                                                }
                                            })
                                            item_html += `
                                    <option class="text-black" data-unitname="${counting_unit.unit_name}"
                                        data-itemname="${item.item_name }"
                                        data-normal="${counting_unit.normal_sale_price }"
                                        data-whole="${counting_unit.whole_sale_price }"
                                        data-order="${counting_unit.order_price }" data-currentqty="${ stockcountt }"
                                        value="${counting_unit.id }">${counting_unit.unit_code }-
                                        ${counting_unit.unit_name }&nbsp;&nbsp; ${stockcountt}ခု&nbsp;&nbsp;
                                        ${counting_unit.normal_sale_price}ကျပ်</option>
                                    `;
                                        })
                                    }

                                })
                                var main_html = `
                    <select class="p-4 select form-control text-black" name="item" id="counting_unit_select">
                        <option></option>` + item_html + `
                    </select>
                            `;

                                $('#search_wif_typing').html(main_html);

                                $("#search_wif_typing .select").select2({
                                    placeholder: "ရှာရန်",
                                });

                                swal({
                                    icon: 'success',
                                    title: 'သိမ်းဆည်းပြီး!',
                                    text: 'Voucher သိမ်းဆည်းပြီးပါပြီ!!',
                                    button: false,
                                    timer: 1500,
                                })
                            }

                        }
                    });
                    //end last_row_id
                }
            });
            $("#repaymentDate").datetimepicker({
                format: 'YYYY-MM-DD'
            });
            // Begin Print
            $("#print").click(function() {
                var exitvoucher = localStorage.getItem('exitvoucher');
                if (exitvoucher == null) {
                    voucher_id = 0;
                } else {
                    voucher_id = exitvoucher;
                }
                var now_customer = $('#now_customer').val();

                var from_id = $('#fid').val();

                var mycart = localStorage.getItem('mycart');

                var grand_total = localStorage.getItem('grandTotal');
                var editvoucher = localStorage.getItem('editvoucher');

                var item = mycart;
                var grand = grand_total;
                var discount = discount;
                var voucher_code = $('#voucherCode').val();
                var right_now_customer = now_customer;
                var cus_pay = $('#payable').val();

                var pay = $('#payable').val();
                var name = $('#name').val();

                var phone = $('#phone').val();
                var repaymentDate = $("#repaymentDate").val();

                var credit = $('#current_credit').val();
                var total_charges = parseInt($('#total_charges').text());
                var changes = pay - total_charges;
                //isset
                var id = $('#salescustomer_list').children("option:selected").val()
                // ? $('#salescustomer_list').children("option:selected").val() : last_row_id;
                $("#changes").text(changes);

                $("#pay").text(pay);

                $("#changes_1").text(changes);

                $("#pay_1").text(pay);

                $('#total_charges_a5').text(total_charges);

                $("#cus_name").text(name);

                $("#cus_phone").text(phone);

                $("#credit_amount").text(credit);
                $("#credit").val(credit);
                if (!pay) {
                    swal({
                        icon: 'error',
                        title: 'ပေးငွေ ထည့်ပါ ..',
                        text: 'Customer Pay cannot be null!!!',
                        footer: '<a href>Why do I have this issue?</a>'
                    })
                }
                // else if(pay < total_charges){
                //     swal({
                //         icon: 'error',
                //         title: 'Check Customer Pay Again!',
                //         text: 'Customer Pay must be greater than or equal Total Amount!!!',
                //         footer: '<a href>Why do I have this issue?</a>'
                //     })
                // }
                else if (id) {
                    $.ajax({
                        type: 'POST',
                        url: '/testVoucher',
                        dataType: 'json',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "item": item,
                            "grand": grand,
                            "voucher_code": voucher_code,
                            "sales_customer_id": id,
                            "sales_customer_name": name,
                            "credit_amount": credit,
                            "repaymentDate": repaymentDate,
                            "is_print": 1,
                            "voucher_id": parseInt(voucher_id),
                            "cus_pay": pay,
                            "editvoucher": editvoucher ?? 0 ,
                        },
                        success: function(data) {
                            if (data.status == 0) {
                                swal({
                                    icon: 'error',
                                    title: 'မှားယွင်းနေပါသည်.',
                                    text: 'ပြန်စစ်ပါ..',
                                })
                            } else {

                                $('#voucherCode').val(data.voucher_code);
                                $('.vou_code').empty();
                                $('.vou_code').text(data.voucher_code);
                                localStorage.setItem('exitvoucher', JSON.stringify(data.id));
                                clearLocalstorage(right_now_customer);
                                formReset();

                                $('#counting_unit_select').empty();

                                var item_html = ``;

                                $.each(data.items, function(i, item) {

                                    if (item.counting_units) {
                                        $.each(item.counting_units, function(j, counting_unit) {

                                            $.each(counting_unit.stockcount, function(k,
                                                stock) {

                                                if (stock.from_id == from_id) {
                                                    stockcountt = stock.stock_qty;
                                                }
                                            })
                                            item_html += `
                                    <option class="text-black" data-unitname="${counting_unit.unit_name}"
                                        data-itemname="${item.item_name }"
                                        data-normal="${counting_unit.normal_sale_price }"
                                        data-whole="${counting_unit.whole_sale_price }"
                                        data-order="${counting_unit.order_price }" data-currentqty="${ stockcountt }"
                                        value="${counting_unit.id }">${counting_unit.unit_code }-
                                        ${counting_unit.unit_name }&nbsp;&nbsp; ${stockcountt}ခု&nbsp;&nbsp;
                                        ${counting_unit.normal_sale_price}ကျပ်</option>
                                    `;
                                        })
                                    }

                                })
                                var main_html = `
                                <select class="p-4 select form-control text-black" name="item" id="counting_unit_select">
                                <option></option>` + item_html + `
                                </select>
                                `;

                                $('#search_wif_typing').html(main_html);

                                $("#search_wif_typing .select").select2({
                                    placeholder: "ရှာရန်",
                                });

                                var mode = 'iframe'; //popup
                                var close = mode == "popup";
                                var options = {
                                    mode: mode,
                                    popClose: close
                                };
                                $(".tab-pane.active div.printableArea").printArea(options);
                            }
                        },
                    });

                } else {

                    //last_row_id
                    {
                        $.ajax({
                            type: 'POST',
                            url: '/testVoucher',
                            dataType: 'json',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "item": item,
                                "grand": grand,
                                "voucher_code": voucher_code,
                                "sales_customer_id": last_row_id,
                                "sales_customer_name": name,
                                "credit_amount": credit,
                                "is_print": 1,
                                "voucher_id": parseInt(voucher_id),
                                "cus_pay": pay,
                                "editvoucher": editvoucher ?? 0 ,

                            },
                            success: function(data) {
                                if (data.status == 0) {
                                    swal({
                                        icon: 'error',
                                        title: 'မှားယွင်းနေပါသည်.',
                                        text: 'ပြန်စစ်ပါ..',
                                    })
                                } else {
                                    $('#voucherCode').val(data.voucher_code);
                                    $('.vou_code').empty();
                                    $('.vou_code').text(data.voucher_code);
                                    clearLocalstorage();
                                    formReset();
                                    localStorage.setItem('exitvoucher', JSON.stringify(data.id));

                                    $('#counting_unit_select').empty();

                                    var item_html = ``;

                                    $.each(data.items, function(i, item) {

                                        if (item.counting_units) {
                                            $.each(item.counting_units, function(j, counting_unit) {

                                                $.each(counting_unit.stockcount, function(k,
                                                    stock) {

                                                    if (stock.from_id == from_id) {
                                                        stockcountt = stock.stock_qty;
                                                    }
                                                })
                                                item_html += `
                                        <option class="text-black" data-unitname="${counting_unit.unit_name}"
                                            data-itemname="${item.item_name }"
                                            data-normal="${counting_unit.normal_sale_price }"
                                            data-whole="${counting_unit.whole_sale_price }"
                                            data-order="${counting_unit.order_price }" data-currentqty="${ stockcountt }"
                                            value="${counting_unit.id }">${counting_unit.unit_code }-
                                            ${counting_unit.unit_name }&nbsp;&nbsp; ${stockcountt}ခု&nbsp;&nbsp;
                                            ${counting_unit.normal_sale_price}ကျပ်</option>
                                        `;
                                            })
                                        }

                                    })
                                    var main_html = `
                                    <select class="p-4 select form-control text-black" name="item" id="counting_unit_select">
                                    <option></option>` + item_html + `
                                    </select>
                                    `;

                                    $('#search_wif_typing').html(main_html);

                                    $("#search_wif_typing .select").select2({
                                        placeholder: "ရှာရန်",
                                    });

                                    var mode = 'iframe'; //popup
                                    var close = mode == "popup";
                                    var options = {
                                        mode: mode,
                                        popClose: close
                                    };

                                    $(".tab-pane.active div.printableArea").printArea(options);
                                }

                            },
                        });
                    }
                    //end last_row
                }
            });

            function formReset() {

                $('#sale').empty();
                $('#total_quantity').empty();
                $('#sub_total').empty();
                $('#credit').val("");
                $('#gtot').val(0);
                $('#with_dis_total').val(0);
                $('#payable').val("");
                $('#current_credit').val("");
                $('#current_change').val(0);
                $('#discount_amount').val(0);
            }

            function insert_total() {
                var grand_total = localStorage.getItem('grandTotal');

                var grand_total_obj = JSON.parse(grand_total);
                $('#voucher_total').val(grand_total_obj.sub_total);
                $('#vou_price_change').val(0);
                $('#voudiscount').modal('show');
            }

            $('#vou_price_change_btn').click(function() {


                var grand_total = localStorage.getItem('grandTotal');

                var grand_total_obj = JSON.parse(grand_total);

                var price_change = $('#vou_price_change').val();

                if ($('#voufoc').is(':checked')) {

                    var totaL = 0;
                    var discount_amount_text = 'foc';
                    var discount_amount = 0;

                } else {
                    var totaL = $('#gtot').val();
                    var discount_amount_text = totaL - price_change;
                    var discount_amount = totaL - price_change;
                }

                $('#discount_amount').val(discount_amount);

                $('#with_dis_total').val(parseInt(price_change));

                $('#sub_total').empty();

                $('#sub_total').text(parseInt(price_change));

                $('#total_charges_a5').empty();
                $('#total_charges_a5').text(parseInt(price_change));
                $('#total_charges').empty();
                $('#total_charges').text(parseInt(price_change));

                grand_total_obj.vou_discount = discount_amount_text;

                localStorage.setItem('grandTotal', JSON.stringify(grand_total_obj));

                $('#voudiscount').modal('hide');

            })

            function storeRemark(id){
                var remark = $(`#nowremark${id}`).val();

                var mycart = localStorage.getItem('mycart');

                var grand_total = localStorage.getItem('grandTotal');

                var mycartobj = JSON.parse(mycart);

                var item = mycartobj.filter(item => item.id == id);

                item[0].remark = remark;

                localStorage.setItem('mycart', JSON.stringify(mycartobj));


            }

            function table_edit_price(id, old_price) {

                var price_change = parseInt($(`#nowprice${id}`).val());
                
                var po_type = $('#po_type').val();
                
                console.log(price_change);

                var mycart = localStorage.getItem('mycart');

                var grand_total = localStorage.getItem('grandTotal');

                var mycartobj = JSON.parse(mycart);

                var grand_total_obj = JSON.parse(grand_total);

                var item = mycartobj.filter(item => item.id == id);

                
                if(po_type == 9){
                item[0].each_sub = item[0].sub_yards * price_change ?? 0;
                }else if(po_type == 10){
                    item[0].each_sub = item[0].order_qty * price_change ?? 0;
                }
                
                item[0].purchase_price = price_change;

                new_total = 0;
                        new_total_rolls = 0;
                        new_total_yards = 0;
                        new_total_qty = 0;
                        $.each(mycartobj, function(i, value) {
                            new_total += value.each_sub;
                            if(po_type == 9){
                            new_total_rolls += value.rolls;
                            new_total_yards += value.sub_yards;
                            }else if(po_type == 10){
                                new_total_qty += value.order_qty;
                            }
                        })

                        grand_total_obj.sub_total = new_total;
                        
                        if(po_type == 9){

                        grand_total_obj.total_rolls = new_total_rolls;
                        
                        grand_total_obj.total_yards = new_total_yards;
                        }else if(po_type == 10){
                            grand_total_obj.total_qty = new_total_qty;
                        }
                        localStorage.setItem('mycart', JSON.stringify(mycartobj));

                        localStorage.setItem('grandTotal', JSON.stringify(grand_total_obj));

                        //count_item();

                        
                        showmodal();
                        
                        
                        var num = $(`#nowprice${id}`).val();
                    $(`#nowprice${id}`).focus().val('').val(num);
                        
                        

                
            }


            $('#voufoc').click(function() {
                // alert($("input:checkbox[name=foc]:checked").val());

                var price_change = $('#vou_price_change').val();
                var or_price = $('#vou_or_price').val();
                if ($("input:checkbox[name=voufoc]:checked").val() == 1) {
                    $('#vou_price_change').val(0);
                } else {
                    $('#vou_price_change').val(or_price);
                }
                //    var percent_for_price=$('#percent_for_price').val();
            })
            $('#vou_percent_for_price').click(function() {
                var idArray = [];
                $("input:checkbox[name=vou_percent_for_price]:checked").each(function() {
                    idArray.push(parseInt($(this).val()));
                });
                if (idArray.length > 0) {
                    $('#vou_percent_price').removeAttr('disabled');
                    $('#vou_percent_price').focus();
                } else {
                    $('#vou_percent_price').attr('disabled', 'disabled');
                }
                //    var percent_for_price=$('#percent_for_price').val();
            })
            $('#vou_percent_price').keyup(function() {
                var percent_price = $('#vou_percent_price').val();
                var or_price = $('#voucher_total').val();
                // alert(percent_price+"---"+or_price);
                var discount_amount = parseInt(or_price * (percent_price / 100));
                var change_percent_price = parseInt(or_price) + discount_amount;
                $('#vou_discount_amount').html(discount_amount);
                $('#vou_price_change').val(change_percent_price);
            })

            function show_a5() {
                $("#a5_body").empty();

                var k = 1;
                var mycart = localStorage.getItem('mycart');
                var mycartobj = JSON.parse(mycart);
                //Begin A5 Voucher

                var len = mycartobj.length;
                var htmlcountitem = "";
                var j = 1;

                var i = 0;
                var each_sub_total = 0;
                $.each(mycartobj, function(i, value) {

                    if (value.discount == 0) {
                                var selling_price = value.selling_price;
                            } else if (value.discount == 'foc') {
                                var selling_price = 0;
                            } else if (value.discount == null) {
                                var selling_price = null;
                            } else {
                                var selling_price = value.discount;
                            }

                            var each_sub_total = value.order_qty * selling_price ?? 0;

                    htmlcountitem += `
                <tr>
                <td style="font-size:20px;height: 8px; border: 2px solid black;">${i++ }</td>
                <td style="font-size:20px;height: 8px; border: 2px solid black;">${value.unit_name}</td>
                <td style="font-size:20px;height: 8px; border: 2px solid black;">${value.order_qty} </td>
                <td style="font-size:20px;height: 8px; border: 2px solid black;">${selling_price} </td>
                <td style="font-size:20px;height: 8px; border: 2px solid black;">${each_sub_total} </td>
            </tr>
                `;
                })
                htmlcountitem += `
                <tr>
                    <td colspan="3"></td>
                    <td style="font-size:20px;height: 8px; border: 2px solid black;">ကျသင့်ငွေ</td>
                    <td style="font-size:20px;height: 8px; border: 2px solid black;">
                        <span id="total_charges_a5"></span></td>
                </tr>
                <tr>
                    <td colspan="3"></td>
                    <td style="font-size:20px;height: 8px; border: 2px solid black;">ပေးငွေ</td>
                    <td style="font-size:20px;height: 8px; border: 2px solid black;">
                        <span id="pay_1"> </span></td>
                </tr>
                <tr>
                    <td colspan="3"></td>
                    <td style="font-size:20px;height: 8px; border: 2px solid black;">ကြွေးကျန်</td>
                    <td style="font-size:20px;height: 8px; border: 2px solid black;">
                        <span id="credit_amount"> </span></td>
                </tr>
                <tr>
                    <td colspan="3"></td>
                    <td style="font-size:20px;height: 8px; border: 2px solid black;">အမ်းငွေ</td>
                    <td style="font-size:20px;height: 8px; border: 2px solid black;">
                        <span id="changes_1"> </span></td>
                </tr>
            `;

                $("#a5_body").html(htmlcountitem);

                //End A5 Voucher
            }
        </script>

    @endsection
