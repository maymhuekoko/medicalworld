@extends('master')

@section('title','Stock Count and Price')

@section('place')

{{-- <div class="col-md-5 col-8 align-self-center">
    <h3 class="text-themecolor m-b-0 m-t-0">@lang('lang.stock_count') and Price</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('index')}}">@lang('lang.back_to_dashboard')</a></li>
        <li class="breadcrumb-item active">@lang('lang.stock_count')</li>
    </ol>
</div> --}}

@endsection

@section('content')
@php
$from_id = session()->get('from')
@endphp
<input type="hidden" id="isowner" value="{{session()->get('user')->role}}">
<input type="hidden" id="isshop" value="{{session()->get('from')}}">
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h4 class="font-weight-normal">Daily Fabric Count</h4>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                
                
                
                <div class="row ml-4 mt-3">
          
            <div class="col-md-2">
                <label class="control-label font-weight-bold">From Date</label>
                <input type="date" name="entry_date" id="entry_date" class="form-control" value="" required>
            </div>
            
            <div class="col-md-1 m-t-30">
                <button class="btn btn-info px-4" id="search_entry" onclick="searchEntry()">Search</button>
            </div>
            <div class="col-md-1 m-t-30 ml-2">
                <button class="btn btn-success px-4" id="save_entry" >Save</button>
            </div>
            
            <div class="col-md-4 m-t-10 ml-4">
                <label class="control-label text-black font-weight-bold">@lang('lang.select_item')</label>
                <select class="form-control select2" id="item_list">
                    <option></option>
                    @foreach ($fabric_entry_items as $item)
                    <option value="{{$item->factory_item_id}}">{{$item->factory_item_name ?? "name"}}-{{$item->instock_qty ?? 0}}</option>
                                    @endforeach
                </select>
            </div>
            
            <div class="col-md-1 m-t-30 ml-2">
                <button class="btn btn-success px-4" id="search_entry" data-toggle="modal" data-target="#new_entry">New Entry</button>
                        
            </div>
            
            <div class="modal fade" id="new_entry" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">New Entry Form</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <form class="form-material m-t-40" method="post" action="{{route('fabricentry_store')}}">
                                    @csrf
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">@lang('lang.category')</label>
                                                    <select style="width: 210px" name="category" class="form-control" id="category" onchange="searchSubCategory(this.value)">
                    <option value="">Category</option>
                    @foreach($categories as $cat)
                        <option value="{{$cat->id}}">{{$cat->category_name}}</option>
                    @endforeach
                </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">@lang('lang.subcategory')</label>
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

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Factory Item</label>
                                                    <select style="width: 210px" name="item_id" class="form-control" id="factory_item_select" >
                    <option value="">Factory Items</option>
                    @foreach($factory_items as $item)
                        <option value="{{$item->id}}"  data-instockqty="{{$item->instock_qty}}">
                            {{$item->item_name}}
                        </option>
                    @endforeach
                </select>
                                                </div>
                                            </div>
                                            

                                        </div>

                                        <div class="row">
                                            
                                            
                                           
                                            
                                            
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Instock Qty</label>
                                                    <input type="number" name="instock_qty" id="instock_qty" class="form-control">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                <label class="control-label">To Entry</label>
                                                <select class="form-control" name="entry_flag">
                                                    <option value="">@lang('lang.select')</option>
                                                    <option value="1">@lang('lang.yes')</option>
                                                    <option value="2">@lang('lang.no')</option>
                                                </select>
                                            </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Count Date</label>
                                                    <input type="date" name="count_date" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-actions">
                                            <div class="row">
                                                <div class=" col-md-9">
                                                    <button type="submit" class="btn btn-success">@lang('lang.submit')</button>
                                                    <button type="button" class="btn btn-inverse" data-dismiss="modal">@lang('lang.cancel')</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            
            
            
        </div>
        
        <!--<div class="row ml-4 mt-3">-->
        <!--            <div class="col-md-6">-->
        <!--                <form action="{{route('fabricCountImport')}}" enctype="multipart/form-data" method="POST">-->
        <!--                    @csrf-->
        <!--                    <input type="file" name="import_file">-->
        <!--                    <button type="submit" class="btn btn-danger">Import</button>-->
        <!--                </form>-->
        <!--    </div> -->
            
            
            
        <!--        </div>-->
                



            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-lg-12">

        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">@lang('lang.counting_unit') @lang('lang.list')</h4>
            </div>

            <div class="card-body">
                <div class="table-responsive text-black">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th class="text-center">@lang('lang.item') @lang('lang.name')</th>
                                <th>Opening @lang('lang.quantity')</th>
                                <th>In</th>
                                <th>Out</th>
                                <th>Closing @lang('lang.quantity')</th>
                                <th>Remark</th>
                            </tr>
                        </thead>
                        <tbody id="items_table">
                            @php
                            $jj=1;
                            @endphp


                                @foreach ($fabric_entry_items as $item)
                                <tr>
                                    <td>{{$jj++}}</td>

                                    
                                    <td style="width: 300px;" class="text-center">{{$item->factory_item_name}}</td>

                                    {{-- @if(session()->get('user')->role == "Owner") --}}
                                    <td>
                                        <input type="number" class="form-control w-50 openstock text-black" data-openstockid="openstock{{$item->factory_item_id}}" id="openstock{{$item->factory_item_id}}" data-id="{{$item->factory_item_id}}"value="{{$item->instock_qty}}">
                                    </td>
                                    
                                    <td>
                                        <input type="number" class="form-control w-50 instock text-black" data-instockid="instock{{$item->factory_item_id}}" id="instock{{$item->factory_item_id}}" data-id="{{$item->factory_item_id}}"value=0>
                                    </td>
                                    
                                    <td>
                                        <input type="number" class="form-control w-50 outstock text-black" data-outstockid="outstock{{$item->factory_item_id}}" id="outstock{{$item->factory_item_id}}" data-id="{{$item->factory_item_id}}"value=0>
                                    </td>
                                    
                                    <td>
                                        <input type="number" class="form-control w-50 closestock text-black" data-closestockid="closestock{{$item->factory_item_id}}" id="closestock{{$item->factory_item_id}}" data-id="{{$item->factory_item_id}}"value="{{$item->instock_qty}}">
                                    </td>
                                    
                                    <td>
                                        <input type="text" class="form-control w-75 remark text-black" data-remarkid="remark{{$item->factory_item_id}}" id="remark{{$item->factory_item_id}}" data-id="{{$item->factory_item_id}}"value="">
                                    </td>
                                    
                                   
                                </tr>
                                @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <input type="hidden" id="entry_items" value="{{$fabric_entry_items}}">
    
</div>
@endsection

@section('js')

<script>

    $(document).ready(function(){

        $(".select2").select2();
        $("#item_list").select2({
            placeholder:"ကုန်ပစ္စည်း ရှာရန်",
        });
        
        var entry_items = $("#entry_items").val();
        var entryitemsobj = JSON.parse(entry_items);
        
        var myentryCart = '[]';
        var myentryCartobj = JSON.parse(myentryCart);
        $.each(entryitemsobj, function(i, item) {
            var entryItem = {
                id: item.factory_item_id,
                item_name: item.factory_item_name,
                open_stock: item.instock_qty,
                in_stock: 0,
                out_stock: 0,
                close_stock: item.instock_qty,
                remark: ''
            };
            myentryCartobj.push(entryItem);
        });
        
        localStorage.setItem('myentryCart', JSON.stringify(myentryCartobj));
    });

    function getItems(value){

        var shop_id = value;

        $.ajax({

            type:'POST',

            url:'{{route('AjaxGetItem')}}',

            data:{
                "_token":"{{csrf_token()}}",
                "shop_id": shop_id,
            },

            success:function(data){
                console.log(data);
                $('#item_list').empty();

                $('#item_list').append($('<option>').text("ရှာရန်").attr('value', ""));
                var html = "";
                $.each(data, function(i, value) {

                $('#item_list').append($('<option>').text(value.item_name).attr('value', value.id));

                $.each(value.counting_units,function(j,unit){
                    var stockcountt=0;
                    $.each(unit.stockcount,function(k,stock){
                        if(stock.from_id==shop_id){
                             stockcountt= unit.stockcount[k].stock_qty;
                        }
                    })
                    html += `
                    <tr>
                                    <td>${unit.unit_code}</td>
                                    <td>${unit.unit_name}</td>
                                    <td>
                                        <input type="number" class="form-control w-25 stockinput text-black" data-stockinputid="stockinput${unit.id}" id="stockinput${unit.id}" data-id="${unit.id}" value="${stockcountt}">
                                        </td>
                                    <td>${unit.reorder_quantity}</td>
                                    <td>
                                        <div class="row">
                                            <a href="#" class="btn btn-warning unitupdate"
                                            data-unitid="${unit.id}" data-code="${unit.unit_code}" data-unitname="${unit.unit_name}"

                                            >
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button class="btn btn-danger delete_stock" data-id="${unit.id}">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>

                                    </td>
                                </tr>
                    `;
                });


            }),
            $('#units_table').empty();
            $('#units_table').html(html);
            swal({
                toast:true,
                position:'top-end',
                title:"Success",
                text:"Shop Changed!",
                button:false,
                timer:500
            });
        }

    })
}
    $('.delete_stock').click(function(){
        var id = $(this).data('id');
        var idArray= [];
        $("input:checkbox[name=assign_check]:checked").each(function(){
        idArray.push(parseInt($(this).val()));
        });
        if(idArray.length >0){
            var unit_ids = idArray;
            var multi_delete = 1;
        }else{
            var unit_ids = id;
            var multi_delete = 0;
        }
        $.ajax({

            type:'POST',

            url:'{{route('delete_units')}}',

            data:{
                "_token":"{{csrf_token()}}",
                "unit_ids": unit_ids,
                "multi_delete":multi_delete
            },

            success:function(data){
                swal({
                    title: "@lang('lang.success')!",
                    text : "@lang('lang.successfully_deleted')!",
                    icon : "success",
                        });

                setTimeout(function(){
                window.location.reload();
            }, 1000);

            },
            });
    })
    

        $('.row').on('click','.unitupdate',function(){
              event.preventDefault()
        var id = $(this).data('unitid');
        var code = $(this).data('code');
        var name = $(this).data('unitname');
        console.log(id,code,name);
        $("#unit_id").val(id);
        $("#unique_unit_code").val(code);
        $("#unique_unit_name").val(name);
        $("#edit_unit_qty").modal("show");
        })




    $('#items_table').on('keypress','.instock',function(){
        var keycode= (event.keyCode ? event.keyCode : event.which);
        if(keycode=='13'){
            // var shop_id = $('#shop_id option:selected').val();
            var id = $(this).data('id');
            var qty = $(this).val();
            console.log(id,qty);
            var myentryCart = localStorage.getItem('myentryCart');
            
            var myentryCartobj = JSON.parse(myentryCart);

            $.each(myentryCartobj, function (i, v) {

                if (v.id == id) {
                    v.in_stock = parseFloat(qty) + parseFloat(v.in_stock);
                    v.close_stock = parseFloat(qty) + parseFloat(v.close_stock);
                    $("#closestock"+id).val(v.close_stock);
                }
            })
            
            localStorage.setItem('myentryCart', JSON.stringify(myentryCartobj));
        }
    })
    
    $('#items_table').on('keypress','.outstock',function(){
        var keycode= (event.keyCode ? event.keyCode : event.which);
        if(keycode=='13'){
            // var shop_id = $('#shop_id option:selected').val();
            var id = $(this).data('id');
            var qty = $(this).val();
            console.log(id,qty);
            var myentryCart = localStorage.getItem('myentryCart');
            
            var myentryCartobj = JSON.parse(myentryCart);

            $.each(myentryCartobj, function (i, v) {

                if (v.id == id) {
                    v.out_stock = parseFloat(qty) + parseFloat(v.out_stock);
                    v.close_stock = parseFloat(v.close_stock)-parseFloat(qty);
                    $("#closestock"+id).val(v.close_stock);
                }
            })
            
            localStorage.setItem('myentryCart', JSON.stringify(myentryCartobj));
        }
    })
    
    $('#save_entry').click(function(){
            
            var items = localStorage.getItem('myentryCart');
            var entry_date = $('#entry_date').val();
            
            
            console.log(items,entry_date);
            $.ajax({

            type: 'POST',

            url: '{{ route('saveFabricCount') }}',

            data: {
                "_token": "{{ csrf_token() }}",
               'items': items,
               'entry_date': entry_date
            },

            success: function (data) {

                                console.log(data);
                                 swal({
                                     title: "Success",
                                     text: "Order is Successfully Stored",
                                     icon: "success",
                                 });
                                
                                

                            },

                            error: function (status) {
                                console.log(status);

                                swal({
                                    title: "Something Wrong!",
                                    text: "Something Wrong When Store Customer Order",
                                    icon: "error",
                                });
                            }
            });
        })
        
        function searchEntry(){
            
            
            var entry_date = $('#entry_date').val();
            
            console.log(entry_date);
            $.ajax({

            type: 'POST',

            url: '{{ route('search_fabric_entry') }}',

            data: {
                "_token": "{{ csrf_token() }}",
                'entry_date' : entry_date,
                
            },

            success: function(data) {
                console.log(data);
                if (data.length >0) {
                    var html = '';
                     $('#item_list').empty();
                    $('#item_list').append($('<option>').text('All Items').attr('value', 0));
                    
                    var myentryCart = '[]';
        var myentryCartobj = JSON.parse(myentryCart);
        
        
        
                    
                    $.each(data, function(i, entry) {
                        var remark = '';
                        if(entry.remark != null){
                            remark = entry.remark;
                        }
                        var entryItem = {
                id: entry.factory_item_id,
                item_name: entry.factory_item_name,
                open_stock: entry.open_stock,
                in_stock: entry.in_stock,
                out_stock: entry.out_stock,
                close_stock: entry.close_stock,
                remark: remark
            };
            myentryCartobj.push(entryItem);
            
                       $('#item_list').append($('<option>').text(entry.factory_item_name +"-"+
                                entry.open_stock).attr('value', entry.factory_item_id));
                        html += `
                    <tr>
                                    <td>${++i}</td>

                                    
                                    <td style="width: 300px;" class="text-center">${entry.factory_item_name}</td>

                                    
                                    <td>
                                        <input type="number" class="form-control w-50 openstock text-black" data-openstockid="openstock${entry.factory_item_id}" id="openstock${entry.factory_item_id}" data-id="${entry.factory_item_id}"value=${entry.open_stock}>
                                    </td>
                                    
                                    <td>
                                        <input type="number" class="form-control w-50 instock text-black" data-instockid="instock${entry.factory_item_id}" id="instock${entry.factory_item_id}" data-id="${entry.factory_item_id}"value=${entry.in_stock}>
                                    </td>
                                    
                                    <td>
                                        <input type="number" class="form-control w-50 outstock text-black" data-outstockid="outstock${entry.factory_item_id}" id="outstock${entry.factory_item_id}" data-id="${entry.factory_item_id}"value=${entry.out_stock}>
                                    </td>
                                    
                                    <td>
                                        <input type="number" class="form-control w-50 closestock text-black" data-closestockid="closestock${entry.factory_item_id}" id="closestock${entry.factory_item_id}" data-id="${entry.factory_item_id}"value=${entry.close_stock}>
                                    </td>
                                    
                                    <td>
                                        <input type="text" class="form-control w-75 remark text-black" data-remarkid="remark${entry.factory_item_id}" id="remark${entry.factory_item_id}" data-id="${entry.factory_item_id}"value=${entry.remark ?? ''}>
                                    </td>
                                    
                                   
                                </tr>
                    `;
                    

                    })
                    
                    
                    
                    $('#items_table').empty();
                        $('#items_table').html(html);
                        localStorage.setItem('myentryCart', JSON.stringify(myentryCartobj));
                        

                } else {
                    var html = `
                    
                    <tr>
                        <td colspan="9" class="text-danger text-center">No Data Found</td>
                    </tr>

                    `;
                    $('#items_table').empty();
                    $('#items_table').html(html);
                
                }
            },
            });
        }
    
    $('#item_list').change(function(){

        //shop id for owner . isshop for counter
        var item_id = $('#item_list').val();
        var entry_date = $('#entry_date').val();
        
        

        $('#items_table').empty();
        if(item_id == 0){
            searchEntry();
        }else{
        $.ajax({

            type:'POST',

            url:'{{route('get_fabricentry_item')}}',

            data:{
                "_token":"{{csrf_token()}}",
                "item_id": item_id,
                "entry_date":entry_date
            },

            success:function(data){
                    console.log(data);
                    var entry = data;

                    let open_stock = `<input type="number" class="form-control w-50 openstock text-black" data-openstockid="openstock${entry.factory_item_id}" id="openstock${entry.factory_item_id}" data-id="${entry.factory_item_id}"value=${entry.open_stock}>`;
                    
                    let in_stock = `<input type="number" class="form-control w-50 instock text-black" data-instockid="instock${entry.factory_item_id}" id="instock${entry.factory_item_id}" data-id="${entry.factory_item_id}"value=${entry.in_stock}>`;

                    let out_stock = `<input type="number" class="form-control w-50 outstock text-black" data-outstockid="outstock${entry.factory_item_id}" id="outstock${entry.factory_item_id}" data-id="${entry.factory_item_id}"value=${entry.out_stock}>`;
                    
                    let close_stock = `<input type="number" class="form-control w-50 closestock text-black" data-closestockid="closestock${entry.factory_item_id}" id="closestock${entry.factory_item_id}" data-id="${entry.factory_item_id}"value=${entry.close_stock}>`;
                    
                    let remark = `<input type="text" class="form-control w-75 remark text-black" data-remarkid="remark${entry.factory_item_id}" id="remark${entry.factory_item_id}" data-id="${entry.factory_item_id}"value=${entry.remark}>`;
                    
                        $('#items_table').append($('<tr>')).append($('<td>').text(1)).append($('<td>').text(entry.factory_item_name)).append($('<td>').append(open_stock)).append($('<td>').append(in_stock)).append($('<td>').append(out_stock)).append($('<td>').append(close_stock)).append($('<td>').append(remark));
                    




            },
        });
        }

    })

    function searchSubCategory(value){
                    let cat_id = value;
                    // alert(cat_id);

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
                    $('#factory_item_select').empty();
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
                                $('#factory_item_select').append($('<option>').text('Factory Items'));
                                $.each(data, function(i, value) {
                                    $('#factory_item_select').append($('<option>').text(value.item_name).attr('value', value.id));
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
                
                $('#search_factoryitem').on('change','#factory_item_select',function(){
                    
                    var instockqty = $(this).find(":selected").data('instockqty');
                    console.log(instockqty);
                    
                    $('#instock_qty').val(instockqty);
                })

            


</script>
@endsection
