@extends('master')

@section('title','Reorder Items')

@section('place')

{{-- <div class="col-md-5 col-8 align-self-center">
    <h3 class="text-themecolor m-b-0 m-t-0">Reorder Items</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('index')}}">@lang('lang.back_to_dashboard')</a></li>
        <li class="breadcrumb-item active">Reorder Items</li>
    </ol>
</div> --}}

@endsection

@section('content')
@php
$from_id = session()->get('from')
@endphp 
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">        
        <h4 class="font-weight-normal">Reorder Items</h4>
    </div>
</div>


<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mt-4">
                <select name="category" class="form-control" id="category" onchange="searchSubCategory(this.value)">
                    <option value="">Category</option>
                    @foreach($categories as $cat)
                        <option value="{{$cat->id}}">{{$cat->category_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 mt-4">
                <select style="width: 250px" name="subcategory" class="form-control" id="subcategory">
                    <option value="">Subcategory</option>
                    @foreach($sub_categories as $sub_category)
                        <option value="{{$sub_category->id}}">
                            {{$sub_category->name}}
                        </option>
                    @endforeach
                </select>
            </div>
            
                    <!--/span-->
            <div class="col-md-1 mt-4">
                <button class="btn btn-info px-4" id="search_orders"  onclick="searchCountingUnit()">Search Unit</button>
            </div>
            
                </div>




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
                                <th>#</th>
                                <th>@lang('lang.unit') @lang('lang.name')</th>
                                <th>@lang('lang.unit') @lang('lang.code')</th>
                                <th>@lang('lang.current') @lang('lang.quantity')</th>
                                <th>@lang('lang.reorder_quantity')</th>
                            </tr>
                        </thead>
                        <tbody id="units_table">
                                @php
                                    $i = 1;
                                @endphp
                            
                                @foreach ($counting_units as $unit)
                                
                                @if($unit->current_quantity < $unit->reorder_quantity)
                                @php
                                    $stockcount= $unit->current_quantity;
                                @endphp
                                        <tr>
                                            <td>{{$i++}}</td>
                                            <td>{{$unit->unit_name}}</td>
                                            <td>{{$unit->unit_code}}</td>
                                            <td>{{$stockcount}}</td>
                                            <td>{{$unit->reorder_quantity}}</td>
                                           
                                        </tr>        
                                    
                                @endif
                    
                           
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

    $(document).ready(function(){

        $(".select2").select2();
        $("#item_list").select2({
            placeholder:"ကုန်ပစ္စည်း ရှာရန်",
        });
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
                        if(stock.from_id==shop_id && unit.stockcount[k].stock_qty<= unit.reorder_quantity){
                             stockcountt= unit.stockcount[k].stock_qty;
                             html += `
                                    <tr>
                                                    <td>${value.category.category_name}</td>
                                                    <td>${value.item_name}</td>
                                                    <td>${unit.unit_name}</td>
                                                    <td>${stockcountt}</td>
                                                    <td>${unit.reorder_quantity}</td>
                                                </tr>
                                    `;

                        }
                    })
                  
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


    function checkUnit(){

        let shop_id = $('#shop_id').val();

        let item = $('#item_list').val();

        $('#units_table').empty();

        $.ajax({

            type:'POST',

            url:'{{route('AjaxGetCountingUnit')}}',

            data:{
                "_token":"{{csrf_token()}}",
                "item": item,
                "shop_id":shop_id
            },

            success:function(data){
                $.each(data , function(i, value) {                 

                    var stockcountt=0;
                    $.each(value.stockcount,function(k,stock){
                        if(stock.from_id==shop_id && stock.stock_qty<= value.reorder_quantity){
                             stockcountt= stock.stock_qty;

                            $('#units_table').append($('<tr>')).append($('<td>').text(value.item.category.category_name)).append($('<td>').text(value.item.item_name)).append($('<td>').text(value.unit_name)).append($('<td>').append(stockcountt)).append($('<td>').append(value.reorder_quantity));
                        }
                    })
                    
                
               
                });


                
            },
        });

    }
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

            function searchCountingUnit(){

                let sub_id = $('#subcategory').val();
                let cat_id = $('#category').val();
                $('#item_list').empty();
                $.ajax({
                    type: 'POST',
                    url: '/unit_search',
                    dataType: 'json',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "category_id" : cat_id,
                        "subcategory_id": sub_id,
                    },


                    success: function(data) {
                        console.log(data);
                        var html="";
                        
                        $.each(data,function(i,v){
                            if(v.current_quantity < v.reorder_qty){
                                
                            html += `
                    <tr>
                                    <td>${++i}</td>
                                    <td>${v.unit_code}</td>
                                    <td>${v.unit_name}</td>
                                    <td${v.current_quantity}</td>
                                    <td>${v.reorder_quantity}</td>

                                    
                                </tr>
                    `;
                            }
                        })
                        $('#units_table').empty();
            $('#units_table').html(html);

                    },
                    error: function(status) {
                        console.log(status);
                        swal({
                            title: "Something Wrong!",
                            text: "Error in searching units",
                            icon: "error",
                        });
                    }
                });
            }


    function getModal(value){

        event.preventDefault()

        $("#edit_unit_qty").modal("show");

        $("#unit_id").attr('value', value);
    }
  

</script>
@endsection