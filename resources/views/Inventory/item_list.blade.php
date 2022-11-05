@extends('master')

@section('title','Product List')

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

<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h4 class="font-weight-normal">Product @lang('lang.list')</h4>
    </div>
</div>


<div class="row">
    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-header">

                <div class="row">
                    <div class="col-md-6">
                        <div class="d-flex">
                            <form action="{{route('itemImport')}}" enctype="multipart/form-data" method="POST">
                                @csrf
                                <input type="file" name="import_file" required>
                                <button type="submit" class="btn btn-danger">ItemImport</button>
                            </form>
                            <form action="{{route('countingUnitImport')}}" enctype="multipart/form-data" method="POST">
                                @csrf
                                <input type="file" name="import_file" required>
                                <button type="submit" class="btn btn-danger">UnitImport</button>
                            </form>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <a href="{{ route('itemExport') }}" class="btn btn-primary mx-2">Export</a>
                    </div>

                    <div class="col-md-2">
                        <a href="#" class="btn btn-outline-primary float-right" data-toggle="modal" data-target="#create_item">
                            <i class="fas fa-plus"></i>
                           Add Product
                        </a>
                    </div>

                </div>



                <div class="modal fade" id="create_item" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">@lang('lang.create_item_form')</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <form class="form-material m-t-40" method="post" action="{{route('item_store')}}" enctype='multipart/form-data'>
                                    @csrf
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">@lang('lang.category')</label>
                                                    <select class="form-control select2 m-b-10" name="category_id" style="width: 100%" onchange="showSubCategory(this.value)">
                                                        <option value="">@lang('lang.select_category')</option>
                                                        @foreach($categories as $category)
                                                        <option value="{{$category->id}}">{{$category->category_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">@lang('lang.subcategory')</label>
                                                    <select class="form-control select2" style="width: 100%" id="sub_category" name="sub_category_id">
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4 mt-2">
                                                <label class="control-label">@lang('lang.customer_console')</label>
                                                <div class="switch">
                                                    <label>@lang('lang.on')
                                                        <input type="checkbox" checked name="customer_console"><span class="lever"></span>@lang('lang.off')</label>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">@lang('lang.item_photo')</label>
                                                    <input type="file" name="photo_path" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">@lang('lang.item') @lang('lang.code')</label>
                                                    <input type="text" name="item_code" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">@lang('lang.item') @lang('lang.name')</label>
                                                    <input type="text" name="item_name" class="form-control">
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
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <label class="control-label">@lang('lang.category')</label>
                        <select class="form-control" onchange="showRelatedSubCategory(this.value)">
                            <option value="">@lang('lang.select')</option>
                            @foreach($categories as $category)
                            <option value="{{$category->id}}">{{$category->category_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="control-label">@lang('lang.subcategory')</label>
                        <select class="form-control" id="subcategory" onchange="showRelatedItemList(this.value)">
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <ul class="nav nav-pills m-t-30 m-b-30 ">
                            <li class="nav-item">
                                <a href="#navpills-1" class="nav-link active" data-toggle="tab" aria-expanded="false">
                                    Item Lists
                                </a>
                            </li>
                            <li class=" nav-item">
                                <a href="#navpills-2" class="nav-link" data-toggle="tab" aria-expanded="false">
                                    Total Inventory Value
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content br-n pn">
                            <div id="navpills-2" class="tab-pane">
                            <button id="print" style="margin-top: -60px;" class="btn btn-info float-right" type="button">
                                <span class="float-right"><i class="fa fa-print"></i>Print</span>
                            </button>
                            <div class="clearfix"></div>
                                <div class="row">

                                    <div class="col-md-12">
                                        <div class="card shadow">
                                            <div class="card-body printableArea">
                                                <h4 class="card-title">@lang('lang.inventory') @lang('lang.list') </h4>
                                               

                                                <div class="table-responsive text-black">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th style="overflow:hidden;white-space: nowrap;"> @lang('lang.itemname')</th>
                                                                <th>@lang('lang.unit') @lang('lang.name')</th>
                                                                <th style="overflow:hidden;white-space: nowrap;">@lang('lang.current') @lang('lang.quantity')</th>

                                                                <!-- <th class="groundqty" style="overflow:hidden;white-space: nowrap;">@lang('lang.ground') @lang('lang.quantity')</th>
                                                                <th class="groundqty" style="overflow:hidden;white-space: nowrap;">@lang('lang.differences')</th> -->

                                                                <th style="overflow:hidden;white-space: nowrap;">@lang('lang.purchase_price')</th>
                                                                <th style="overflow:hidden;white-space: nowrap;">@lang('lang.subtotal')</th>

                                                            </tr>
                                                        </thead>
                                                        <br>
                                                        <tbody>
                                                           @php
                            $allTotal = 0;
                            $stockTotal = 0;
                            $i=1;
                        @endphp
                            

                                @foreach ($counting_units as $unit)
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>{{$unit->unit_code ?? ''}}</td>
                                    <td>{{$unit->unit_name ?? ''}}</td>
                                    
                                    <td>
                                      {{$unit->current_quantity ?? 0}}
                                      @php
                                            $allTotal+= $unit->purchase_price * $unit->current_quantity;
                                            $stockTotal+= $unit->current_quantity;
                                      @endphp
                                    </td>
                                    <td>{{$unit->purchase_price}}</td>
                                    <td >{{$unit->purchase_price * $unit->current_quantity}}</td>
                                </tr>

                                @endforeach

                           
                            <tr>
                                <td></td>
                                <td></td>
                                <td class="text-info">Stock Total</td>
                                <td class="font-bold">{{$stockTotal}}</td>
                                <td class="text-info">Total</td>
                                <td class="text-right font-bold">{{$allTotal}}</td>
                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                            <div id="navpills-1" class="tab-pane active">

                                <div class="table-responsive text-black">
                                    <table class="table" id="example23">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Product @lang('lang.code')</th>
                                                <th>Product @lang('lang.name')</th>
                                                <th>@lang('lang.related_category')</th>
                                                <th>@lang('lang.related_subcategory')</th>
                                                <th>@lang('lang.unit') @lang('lang.list')</th>
                                                <th>@lang('lang.unit') @lang('lang.conversion')</th>
                                                <th class="text-center">@lang('lang.action')</th>
                                            </tr>
                                        </thead>
                                        <tbody id="item">
                                            @foreach($item_lists as $item)
                                            <tr>
                                                <td>{{$item->id}}</td>
                                                <td>{{$item->item_code}}</td>
                                                <td>{{$item->item_name}}</td>
                                                <td>{{$item->category->category_name ?? "Defaut Category"}}</td>
                                                <td>{{$item->sub_category->name??""}}</td>
                                                <td>
                                                    <a href="{{route('count_unit_list',$item->id)}}" class="btn btn-outline-info">
                                                        @lang('lang.check')</a>
                                                </td>
                                                <td>
                                                    <a href="{{route('unit_relation_list',$item->id)}}" class="btn btn-outline-info">
                                                        @lang('lang.change_unit')</a>
                                                </td>
                                                <td class="text-center">
                                                    <div class="d-flex">
                                                        <a href="#" class="btn btn-sm btn-outline-warning" data-toggle="modal" data-target="#edit_item{{$item->id}}">
                                                            <i class="fas fa-edit"></i></a>

                                                        <a href="#" class="btn btn-sm btn-outline-danger" onclick="ApproveLeave('{{$item->id}}')">
                                                            <i class="fas fa-trash-alt"></i></a>
                                                    </div>

                                                </td>

                                                <div class="modal fade" id="edit_item{{$item->id}}" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">@lang('lang.edit_category_form')</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>

                                                            <div class="modal-body">
                                                                <form class="form-material m-t-40" method="post" action="{{route('item_update',$item->id)}}" enctype='multipart/form-data'>
                                                                    @csrf

                                                                    <div class="form-group">
                                                                        <label class="font-weight-bold">@lang('lang.code')</label>
                                                                        <input type="text" name="item_code" class="form-control" value="{{$item->item_code}}">
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label class="font-weight-bold">@lang('lang.name')</label>
                                                                        <input type="text" name="item_name" class="form-control" value="{{$item->item_name}}">
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label class="control-label">@lang('lang.item_photo')</label>
                                                                        <input type="file" name="photo_path" class="form-control">
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label class="font-weight-bold">@lang('lang.related_category')</label>
                                                                        <select class="form-control select2 m-b-10" name="category_id" style="width: 100%">
                                                                            @foreach($categories as $category)
                                                                            <option value="{{$category->id}}" @if($item->category_id === $category->id) selected='selected' @endif >{{$category->category_name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="font-weight-bold">@lang('lang.related_subcategory')</label>
                                                                        <select class="form-control select2 m-b-10" name="sub_category_id" style="width: 100%">
                                                                            @foreach($sub_categories as $sub_category)
                                                                            @if($sub_category->category_id == $item->category_id)
                                                                            <option value="{{$sub_category->id}}" @if($item->sub_category_id === $sub_category->id) selected='selected' @endif>{{$sub_category->name}}</option>
                                                                            @endif
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <input type="submit" name="btnsubmit" class="btnsubmit float-right btn btn-primary" value="@lang('lang.save')">
                                                                </form>
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

        function ApproveLeave(value) {

            var item_id = value;

            swal({
                    title: "@lang('lang.confirm')",
                    icon: 'warning',
                    buttons: ["@lang('lang.no')", "@lang('lang.yes')"]
                })

                .then((isConfirm) => {

                    if (isConfirm) {

                        $.ajax({
                            type: 'POST',
                            url: 'item/delete',
                            dataType: 'json',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "item_id": item_id,
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
        }

        function showSubCategory(value) {

            var category_id = value;

            $('#sub_category').empty();

            $.ajax({
                type: 'POST',
                url: '/showSubCategory',
                dataType: 'json',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "category_id": category_id,
                },

                success: function(data) {

                    console.log(data);

                    $.each(data, function(i, value) {

                        $('#sub_category').append($('<option>').text(value.name).attr('value', value.id));
                    });

                }

            });

        }

        function showRelatedSubCategory(value) {

            console.log(value);

            $('#subcategory').prop("disabled", false);

            var category_id = value;

            $('#subcategory').empty();

            $.ajax({
                type: 'POST',
                url: '/showSubCategory',
                dataType: 'json',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "category_id": category_id,
                },

                success: function(data) {

                    console.log(data);

                    $.each(data, function(i, value) {

                        $('#subcategory').append($('<option>').text(value.name).attr('value', value.id));
                    });

                }

            });
        }

        function showRelatedItemList(value) {

            $('#item').empty();

            console.log(value);

            var sub_category_id = value;

            var items = @json($item_lists);

            var html = "";

            console.log(items);

            $.each(items, function(i, v) {

                if (v.sub_category_id == sub_category_id) {

                    var related_category = v.category.category_name;

                    if (v.sub_category) {

                        var related_subcategory = v.sub_category.name;

                    } else {

                        var related_subcategory = "";
                    }

                    var url1 = '{{route('count_unit_list',":item_id")}}';

                    url1 = url1.replace(':item_id', v.id);


                    var url2 = '{{route('unit_relation_list',":item_id")}}';

                    url2 = url2.replace(':item_id', v.id);

                    html += `
                        <tr>
                            <td>${v.item_code}</td>
                            <td>${v.item_name}</td>
                            <td>${related_category}</td>
                            <td>${related_subcategory}</td>
                            <td>
                                <a href="${url1}" class="btn btn-outline-info">
                                @lang('lang.check')</a>
                            </td>
                            <td>
                                <a href="${url2}" class="btn btn-outline-info">
                                @lang('lang.change_unit')</a>
                            </td>
                            <td class="text-center">
                                <a href="#" class="btn btn-outline-warning" data-toggle="modal" data-target="#edit_item${v.id}">
                                    <i class="fas fa-edit"></i></a>

                                <a href="#" class="btn btn-outline-danger" onclick="ApproveLeave('${v.id}')">
                            <i class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>`

                    $('#item').html(html);
                }

            });
        }

        function searchCategory(value){
            let cat_id = value;
            // alert(cat_id);
            $.ajax({
                type: 'POST',
                url: 'search_item',
                dataType: 'json',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "category_id": cat_id,
                },

                success: function(data) {
                    console.log(data);
                    swal({
                        title: "Success",
                        text: "Order is Successfully Stored",
                        icon: "success",
                    });
                },

                error: function(status) {
                    swal({
                        title: "Something Wrong!",
                        text: "Something Wrong When Store Customer Order",
                        icon: "error",
                    });
                }

            });

        }
    </script>
    @endsection
