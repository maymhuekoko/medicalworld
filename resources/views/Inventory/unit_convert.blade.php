@extends('master')

@section('title','Unit Converter')

@section('place')

{{-- <div class="col-md-5 col-8 align-self-center">
    <h3 class="text-themecolor m-b-0 m-t-0">Branch</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('index')}}">Item List</a></li>
        <li class="breadcrumb-item active">Unit Converter</li>
    </ol>
</div> --}}

@endsection

@section('content')

<div class="row justify-content-center">
    <div class="col-md-9">
        <div class="card shadow">
                <div class="card-body">
                    <h4 class="card-title font-weight-bold text-center">Unit Converter</h4>
                    
                    <div class="row">
                        <div class="form-group col-md-6">	
                            <label class="font-weight-bold">From Unit</label>
                            <input type="text" class="form-control" value="{{$unit->to_unit_detail->unit_name}}" disabled>
                            <input type="hidden" id="from" value="{{$unit->to_unit}}">
                        </div>
                        
                        <div class="form-group col-md-6">	
                            <label class="font-weight-bold">To Unit</label>
                            <input type="text" class="form-control" value="{{$unit->from_unit_detail->unit_name}}" disabled>
                            <input type="hidden" id="to" value="{{$unit->from_unit}}">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Quantity</label>
                            <input type="number" id="qty" class="form-control" placeholder="Enter Quantity"> 
                        </div>
                    </div>
                    
                    <button class="btn btn-primary justify-content-center" onclick="myFunction({{$unit->id}})">Convert</button>
                </div>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    
    <div class="col-md-9">
        <div class="card shadow">
            <div class="card-body">
                <h4 class="card-title font-weight-bold text-center">Balance Result</h4>
                        
                <h5 class="card-title font-weight-bold">From Unit Balance Result</h5>
                <div class="row">
                    
                    <div class="form-group col-md-6">
                        <label>Unit</label>
                        <input type="text" id="from_unit" class="form-control" readonly> 
                        
                    </div>
                    
                    <div class="form-group col-md-6">   
                        <label>Unit Quantity</label>
                        <input type="number" id="from_unit_qty" name="from_unit_qty" class="form-control" readonly>
                    </div>
                    
                </div>
                
                <h5 class="card-title font-weight-bold">To Unit Balance Result</h5>
                <div class="row">
                    
                    <div class="form-group col-md-6">
                        <label>Unit</label>
                        <input type="text" id="to_unit"  class="form-control" readonly> 
                        
                    </div>
                    
                    <div class="form-group col-md-6">   
                        <label>Unit Quantity</label>
                        <input type="number" id="to_unit_qty" name="to_unit_qty" class="form-control" readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>
@endsection

@section('js')

<script type="text/javascript">

    $("#btn_submit").prop( "disabled", true );
    
    $(".select2").select2();
    
    function myFunction(id) {
        
        var from_id= $('#unique_from_id').val();

        var unit_id = id;
        
        var from = $( "#from" ).val();
            
        var to = $( "#to" ).val();
        
        var qty = $("#qty").val();
        
        console.log(from,to,qty, from_id);

        if($.trim(from) == '' || $.trim(to) == '' || $.trim(qty) == ''){

            swal({
    	            title:"Failed!",
    	            text:"Please Select Unit and Enter Quantity",
    	            icon:"info",
    	            timer: 3000,
    	        });
    	        
        }
        else{
            
            $.ajax({

               type:'POST',
    
               url:'/ajaxConvertResult',
    
               data:{
                "_token":"{{csrf_token()}}",
                "unit_id":unit_id,
                "from":from,
                "to":to,
                "qty":qty
               },
    
                success:function(data){
                    
                    $("#from_unit_qty").val(data.from_unit_quantity);
                    $("#from_unit").val(data.from_unit);
                    $("#to_unit_qty").val(data.to_unit_quantity);
                    $("#to_unit").val(data.to_unit);
                    
                }

            });
        }
    }
    
</script>

@endsection