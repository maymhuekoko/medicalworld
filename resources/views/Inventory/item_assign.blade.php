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
@php
$from = session()->get('from');
@endphp
{{-- <div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h2 class="font-weight-bold">@lang('lang.item') @lang('lang.list')</h2>
    </div>
</div> --}}


<div class="row">
    <div class="col-3 offset-md-2 mb-2">
        <select class='form-control' id="from_id">
            @foreach ($shops as $shop)
            <option value='{{$shop->id}}'
            @if ($from==$shop->id)
            selected
            @endif    
            > {{$shop->name}}</option>
                
            @endforeach
        </select>
    </div>
    <div class="col-2">
        <button type="button" id="assign_btn" class="btn btn-primary">@lang("lang.assign_item")</button>
    </div>
    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-header">

                <h4 class="font-weight-normal mt-2">@lang('lang.item') @lang('lang.list')</h4>



        
            </div>
            <div class="card-body">
           
                <div class="row">
                    <div class="col-12">
                 
                        <div class="tab-content br-n pn">
                     
                            <div id="navpills-1" class="tab-pane active">
                                <div class="table-responsive text-black">
                                    <table class="table" id="example23">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>@lang('lang.item') @lang('lang.code')</th>
                                                <th>@lang('lang.item') @lang('lang.name')</th>
                                                <th>@lang('lang.related_category')</th>
                                                <th>@lang('lang.related_subcategory')</th>
                                            </tr>
                                        </thead>
                                    
                                        <tbody id="item">
                                            @foreach($item_lists as $item)
                                            @if (count($item->froms)>0)
                                            @php
                                                $idarr=[];
                                            @endphp
                                            @for ($i=0;$i<count($item->froms);$i++)
                                                @php
                                                    $checked= "";
                                                    array_push($idarr,$item->froms[$i]->pivot->from_id);
                                                    if(in_array($from,$idarr)){
                                                    $checked= "checked";
                                                    }
                                                @endphp
                                                   
                                            @endfor
                                            @else
                                            @php
                                                    $checked= "";
                                            
                                            @endphp
                                            @endif
                                            <tr>
                                                <td>
                                                    <div class="col-6 form-check form-switch">
                                                        <input class="form-check-input" name="assign_check" type="checkbox" value="{{$item->id}}" id="assign_check{{$item->id}}" {{$checked}}>
                                                        <label class="form-check-label" for="assign_check{{$item->id}}"></label>
                                                    </div>
                                                </td>
                                                @php
                                                    $checked="";
                                                @endphp
                                                <td>{{$item->item_code}} , {{$item->id}}</td>
                                                <td>{{$item->item_name}}</td>
                                                <td>{{$item->category->category_name ?? "Default Category"}}</td>
                                                <td>{{$item->sub_category->name??""}}</td>
                    
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
                //print button
                $('#assign_btn').click(function(){

                    var searchvalue= $('.dataTables_filter input').val();
                    console.log(searchvalue.length);
                    if(searchvalue.length !=0){

                
                        swal({
                            title:"Error",
                            text:"Search Box ကို ရှင်းပေးပါ !",
                            icon:"warning",
                            button:false,
                            timer:1500,
                        });
                        $('.dataTables_filter input').focus();

                    }else{
                        var idArray= [];
                        $("input:checkbox[name=assign_check]:checked").each(function(){
                        idArray.push(parseInt($(this).val()));
                        });
              
                var from_id = $('#from_id').val();

                if(idArray.length >0){

                    $.ajax({

                    type:'POST',

                    url:'/assign-item-ajax',

                    data:{
                        "_token":"{{csrf_token()}}",
                        "from_id":from_id,
                        "item_array": idArray,
                    },

                    success:function(data){

                        if(data){
                            swal({
                            title:"Success",
                            text:"Successfully added !",
                            icon:"success",
                        });
                        }
                        else{
                            swal({
                            title:"Error",
                            text:"Something wrong !",
                            icon:"error",
                        });
                        }
                    },


                    }); 
                }
            }

        
                })
               
        });


            $(".select2").select2();

            $('#example23').DataTable({

                "paging": false,
                "ordering": true,
                "info": false,

            });
            
        $('#from_id').change(function(){
            var from_id = $('#from_id option:selected').val();
 
            $.ajax({

            type:'POST',

            url:'/assign-itemshop',

            data:{
                "_token":"{{csrf_token()}}",
                "shop_id":from_id,
            },

            success:function(data){
                
                if(data){
                    var html= "";
                    $.each(data,function(i,v){
                        if(typeof(v.sub_category) != "undefined" && v.sub_category !==null){

                            var subcategory_name = v.sub_category.name;
                        }
                        else{
                            var subcategory_name = "";
                            
                        }
                        if(v.froms.length>0){
                            var idarr=[];
                            for (let i = 0; i < v.froms.length; i++) {
                                var checked= "";
                                idarr.push(v.froms[i].id);
                                if($.inArray(parseInt(from_id),idarr) != -1){
                                    console.log("formid",from_id,"idarr",idarr,"checked");
                                var checked= "checked";
                                }
                            }
                        }
                        else{
                            var checked= "";

                        }

                        html += `
                        <tr>
                            <td>
                                <div class="col-6 form-check form-switch">
                                    <input class="form-check-input" name="assign_check" type="checkbox" value="${v.id}" id="assign_check${v.id}" ${checked}>
                                    <label class="form-check-label" for="assign_check${v.id}"></label>
                                </div>
                            </td>
                            @php
                                $checked="";
                            @endphp
                            <td>${v.item_code} , ${v.id}</td>
                            <td>${v.item_name}</td>
                            <td>${v.category.category_name ?? ""}</td>
                            <td>${subcategory_name}</td>
                        </tr>
                        `;
                        checked="";

                    })
                    $('#item').empty();
                    $('#item').html(html);
                    swal({
                    title:"Change",
                    text:"Successfully changed !",
                    icon:"success",
                });
                }
                else{
                    swal({
                    title:"Error",
                    text:"Something wrong !",
                    icon:"error",
                });
                }
            },


            }); 
        })

    </script>
    @endsection
