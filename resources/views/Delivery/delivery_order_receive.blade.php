@extends('master')

@section('title','Delivery Receive From')

@section('place')

{{-- <div class="col-md-5 col-8 align-self-center">
    <h3 class="text-themecolor m-b-0 m-t-0">@lang('lang.branch')</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('index')}}">@lang('lang.back_to_dashboard')</a></li>
        <li class="breadcrumb-item active">Delivery Order Receive Form</li>
    </ol>
</div> --}}

@endsection

@section('content')

<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">        
        <h4 class="font-weight-normal">Delivery Order Receive Form</h4>
    </div>
</div>


<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card shadow">
            <div class="card-body">
                <form class="form-material m-t-40" method="post" action="{{route('deliveryorderreceive.store')}}" id="delivery_receive_store">
                    @csrf
                    <div class="form-group row">    
                        <label class="font-weight col-md-3 offset-md-2">@lang('lang.customer') @lang('lang.name')</label>
                        <input type="text" name="customername" class="form-control col-md-6 @error('customername') is-invalid @enderror">

                        @error('customername')
                            <span class="invalid-feedback alert alert-danger" role="alert"  height="100">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-group row">    
                        <label class="font-weight col-md-3 offset-md-2">@lang('lang.customer') @lang('lang.phone')</label>
                        <input type="text" name="customerphone" class="form-control col-md-6 @error('customerphone') is-invalid @enderror">

                        @error('customerphone')
                            <span class="invalid-feedback alert alert-danger" role="alert"  height="100">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>


                    <div class="form-group row">    
                        <label class="font-weight col-md-3 offset-md-2">Pick Up</label>
                        <div class="col-md-6 row">
                            <div class="form-check col-md-3">
                                <input class="form-check-input" type="radio" name="pickup" id="pickupYes" value="0" checked>
                                <label class="form-check-label" for="pickupYes">
                                Yes 
                                </label>
                            </div>
                            <div class="form-check col-md-3">
                                <input class="form-check-input" type="radio" name="pickup" id="pickupNo" value="1">
                                <label class="form-check-label" for="pickupNo">
                                No
                                </label>
                            </div>
                        </div>

                        @error('pickup')
                            <span class="invalid-feedback alert alert-danger" role="alert"  height="100">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-group row">    
                        <label class="font-weight col-md-3 offset-md-2">Pickup @lang('lang.address')</label>
                        <input type="text" name="pickupaddress" class="form-control col-md-6 @error('pickupaddress') is-invalid @enderror" >

                        @error('pickupaddress')
                            <span class="invalid-feedback alert alert-danger" role="alert"  height="100">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    
                    <div class="form-group row">    
                        <label class="font-weight col-md-3 offset-md-2">@lang('lang.township')</label>
                        <select class="form-control col-md-6" name="pickuptownship" >
                            <option value="1">@lang('lang.select')</option>
                            <option value="2">Township One</option>
                            <option value="3">Township One</option>
                            <option value="4">Township One</option>
                            <option value="5">Township One</option>
                        </select>

                        @error('pickuptownship')
                            <span class="invalid-feedback alert alert-danger" role="alert"  height="100">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>

                    <div class="form-group row">    
                        <label class="font-weight col-md-3 offset-md-2">Pickup @lang('lang.charges')</label>
                        <input type="number" name="pick_charges" class="form-control col-md-6 @error('pick_charges') is-invalid @enderror" placeholder="MMK" >

                        @error('pick_charges')
                            <span class="invalid-feedback alert alert-danger" role="alert"  height="100">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-group row">    
                        <label class="font-weight col-md-3 offset-md-2">Contact name @ Pickup</label>
                        <input type="text" name="contactn_at_pickup" class="form-control col-md-6 @error('contactn_at_pickup') is-invalid @enderror">

                        @error('contactn_at_pickup')
                            <span class="invalid-feedback alert alert-danger" role="alert"  height="100">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="form-group row">    
                        <label class="font-weight col-md-3 offset-md-2">Contact @lang('lang.phone') @ Pickup</label>
                        <input type="text" name="contactp_at_pickup" class="form-control col-md-6 @error('contactp_at_pickup') is-invalid @enderror" >

                        @error('contactp_at_pickup')
                            <span class="invalid-feedback alert alert-danger" role="alert"  height="100">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-group row">    
                        <label class="font-weight col-md-3 offset-md-2">Destination @lang('lang.address')</label>
                        <input type="text" name="destination_add" class="form-control col-md-6 @error('destination_add') is-invalid @enderror" >

                        @error('destination_add')
                            <span class="invalid-feedback alert alert-danger" role="alert"  height="100">
                                {{ $message }}
                            </span>
                        @enderror 
                    </div>

                    <div class="form-group row">    
                        <label class="font-weight col-md-3 offset-md-2">@lang('lang.township')</label>
                        <select class="form-control col-md-6" name="destination_township" >
                            <option value="1">@lang('lang.select')</option>
                            <option value="2">Township One</option>
                            <option value="3">Township One</option>
                            <option value="4">Township One</option>
                            <option value="5">Township One</option>
                        </select>

                        @error('destination_township')
                            <span class="invalid-feedback alert alert-danger" role="alert"  height="100">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-group row">    
                        <label class="font-weight col-md-3 offset-md-2">Delivery @lang('lang.charges')</label>
                        <input type="number" name="deliverycharges" class="form-control col-md-6 @error('deliverycharges') is-invalid @enderror" placeholder="MMK" required>

                        @error('deliverycharges')
                            <span class="invalid-feedback alert alert-danger" role="alert"  height="100">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-group row">    
                        <label class="font-weight col-md-3 offset-md-2">Contact Name @ Destination</label>
                        <input type="text" name="nameDestination" class="form-control col-md-6 @error('nameDestination') is-invalid @enderror" required>

                        @error('nameDestination')
                            <span class="invalid-feedback alert alert-danger" role="alert"  height="100">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="form-group row">    
                        <label class="font-weight col-md-3 offset-md-2">Contact @lang('lang.phone') @ Destination</label>
                        <input type="text" name="contactph" class="form-control col-md-6 @error('contactph') is-invalid @enderror" required>

                        @error('contactph')
                            <span class="invalid-feedback alert alert-danger" role="alert"  height="100">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <input type="hidden" name="package_type" id="package_types">
                    <input type="hidden" name="dimension" id="dimen">
                    <input type="hidden" name="pick_delivery" id="pick_delivery">
                    <input type="hidden" name="qty" id="q_ty">
                    <input type="hidden" name="price" id="p_rice">
                    <div class="form-group row">    
                        <label class="font-weight col-md-3 offset-md-2">Package @lang('lang.list')</label>
                        <a href="#" class="btn btn-sm btn-danger btn-rounded " data-toggle="modal" data-target="#doc_exp"><i class="fas fa-plus"></i> Add </a>
                    </div>

                      <div class="table-responsive">
                        <table class="table table-hover table-white" id="doc_exp_table"> 
                            <thead>
                                <tr>
                                    <th>Package Type</th>
                                    <th>Dimension</th>
                                    <th>PickupOrDelivery</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                    <input type="submit" name="btnsubmit" id="add_doc_btn" class="btnsubmit float-right btn btn-primary" value="Submit">
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="doc_exp" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title pinkcolor">Add Package</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="#close_modal">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body p-4">
              
                <div class="form-group row">    
                    <label class="font-weight col-md-6">Package Type</label>
                    <select class="form-control col-md-6" id="packageType">
                        <option value="1">@lang('lang.select')</option>
                        @foreach ($packageTypes as $packagetype)

                            <option value="{{$packagetype->id}}">{{$packagetype->name}}</option>
                            
                        @endforeach
                    </select>

                </div>
                <div class="form-group row">    
                    <label class="font-weight col-md-6">Size Dimension</label>
                    <input type="text" class="form-control col-md-6" placeholder="" id="dimension" >
                </div>
                <div class="form-group row">    
                    <label class="font-weight col-md-6">Weight (kg)</label>
                    <input type="number" name="pickupaddress" class="form-control col-md-6" placeholder="" id="weight">
                </div>
                <div class="form-group row">    
                    <label class="font-weight col-md-6">Package mg Requierd</label>
                    <div class="col-md-6 row">
                        <div class="form-check col-md-3">
                            <input class="form-check-input" type="radio" name="pickup" id="pickupYes" value="yes" checked>
                            <label class="form-check-label" for="pickupYes">
                            Yes 
                            </label>
                        </div>
                        <div class="form-check col-md-3">
                            <input class="form-check-input" type="radio" name="pickup" id="pickupNo" value="no">
                            <label class="form-check-label" for="pickupNo">
                            No
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">    
                    <label class="font-weight col-md-6">Qty</label>
                    <input type="number" name="pickupaddress" class="form-control col-md-6" id="qty" >
                </div>
                <div class="form-group row">    
                    <label class="font-weight col-md-6">Price</label>
                    <input type="number" name="pickupaddress" class="form-control col-md-6" id="price">
                </div>
              <div class="form-actions mt-2">
                  <button type="submit" class="btn btn-success" id="add_package"> <i class="fa fa-check"></i> Save</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
            </div>
         
        </div>
    </div>
</div>
@endsection


@section('js')

<script type="text/javascript">
    var count = 1;

    packageType = "";
    dimension = "";
    pickupOrdelivery= "";

    qty ="";
    price = "";

    $(document).on('click', '.remove', function(){
        var delete_row = $(this).data("row");
        $('#' + delete_row).remove();
    });

        $('#add_package').click(function(){

        count = count + 1;

        packageType = $('#packageType').val();
        packageTypename = $('#packageType :selected').text();
        dimension = $('#dimension').val();
        pickupOrdelivery= $('input[name="pickup"]:checked').val();

        qty = $('#qty').val();
        price = $('#price').val();

        if($.trim(pickupOrdelivery) == '' || $.trim(packageType) == '' )
        {

            swal({
                title:"Failed!",
                text:"Please fill all basic unit Field",
                icon:"info",
                timer: 3000,
            });
            
        }else{

            var html_code = "<tr id='row"+count+"' >";
            html_code += "<td class='packageType' data-id="+packageType+">"+packageTypename+"</td>";
            html_code += "<td class='dimension'>"+dimension+"</td>";
            html_code += "<td class='pickupOrdelivery'>"+pickupOrdelivery+"</td>";
            html_code += "<td class='qty'>"+qty+"</td>";
            html_code += "<td class='price'>"+price+"</td>";
            html_code += "<td><button type='button' name='remove' data-row='row"+count+"' class='btn btn-danger remove'>Remove</button></td>";
            html_code += "</tr>";          

            $('#doc_exp_table').append(html_code);

            $('#doc_exp').modal().find("input").val('').end();

            $('#doc_exp').modal('hide');


        }


        });
	
        $('#add_doc_btn').click(function(){

var packageTypes = [];
var dimensions = [];
var pickupOrdeliveries = [];
var qties = [];
var prices = [];

$('.packageType').each(function(){
     packageTypes.push($(this).data('id'));
});

$('.dimension').each(function(){
 dimensions.push($(this).text());
});

$('.pickupOrdelivery').each(function(){
    pickupOrdeliveries.push($(this).text());
});

$('.qty').each(function(){
 qties.push($(this).text());
});

$('.price').each(function(){
  prices.push($(this).text());
});

$('#package_types').val(packageTypes);
$('#dimen').val(dimensions);
$('#q_ty').val(qties);
$('#pick_delivery').val(pickupOrdeliveries);
$('#p_rice').val(prices);
$('#delivery_receive_store').submit();

console.log(packageTypes,dimensions,pickupOrdeliveries,qties,prices);






});
</script>

@endsection