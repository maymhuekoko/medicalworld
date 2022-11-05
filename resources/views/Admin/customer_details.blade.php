@extends('master')

@section('title','Customer Details')

@section('place')

{{-- <div class="col-md-5 col-8 align-self-center">
    <h3 class="text-themecolor m-b-0 m-t-0">@lang('lang.customer') @lang('lang.details')</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('index')}}">@lang('lang.back_to_dashboard')</a></li>
        <li class="breadcrumb-item active">@lang('lang.customer') @lang('lang.details')</li>
    </ol>
</div> --}}

@endsection

@section('content')

<div class="row">
    <!-- Column -->
    <div class="col-lg-4 col-xlg-3 col-md-5">
        <div class="card">
            <div class="card-body">
                <center class="m-t-30"> <img src="{{asset('image/'. $customer->user->photo_path)}}" class="img-circle" width="150" />
                    <h4 class="card-title m-t-10">{{$customer->user->name}}</h4>
                    <h6 class="card-subtitle">{{$customer->user->role}}</h6>
                    <div class="row text-center justify-content-md-center">
                        <div class="col-6">
                        	<a href="#" class="link">
                        		<i class="mdi mdi-account-card-details"></i> 
                        		<font class="font-medium">{{$customer->user->user_code}}</font>
                        	</a>
                        </div>
                    </div>
                </center>
            </div>
            <div>
                <hr> </div>
            <div class="card-body"> 
            	<small class="text-muted">Email address </small>
                <h6>{{$customer->user->email}} </h6> 
                <small class="text-muted p-t-30 db">Phone</small>
                <h6>{{$customer->phone}}</h6>
                <small class="text-muted p-t-30 db">Address</small>
                <h6>{{$customer->address}}</h6>
                <small class="text-muted p-t-30 db">Password</small>
                <a href="#" class="btn btn-success" onclick="changePassword({{$customer->user_id}})">
                 Change Password
                </a>
                <br/>
                <button class="btn btn-circle btn-secondary"><i class="mdi mdi-facebook"></i></button>
                <button class="btn btn-circle btn-secondary"><i class="mdi mdi-youtube-play"></i></button>
            </div>
        </div>
    </div>
    <!-- Column -->
    <!-- Column -->
    <div class="col-lg-8 col-xlg-9 col-md-7">
        <div class="card">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs profile-tab" role="tablist">
                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#profile" role="tab">Timeline</a> </li>
                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#settings" role="tab">Update Customer</a> </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active" id="profile" role="tabpanel">
                    <div class="card-body">
                        @foreach($order_lists as $order)
                        <div class="row">
                            <div class="col-md-3 col-xs-6 b-r"> <strong>Order Date</strong>
                                <br>
                                <p class="text-muted">{{date('d-m-Y', strtotime($order->order_date))}}</p>
                            </div>
                            <div class="col-md-3 col-xs-6 b-r"> <strong>Mobile</strong>
                                <br>
                                <p class="text-muted">{{$order->customer->phone}}</p>
                            </div>
                            <div class="col-md-3 col-xs-6 b-r"> <strong>Total Quantity</strong>
                                <br>
                                <p class="text-muted">{{$order->total_quantity}}</p>
                            </div>
                            <div class="col-md-3 col-xs-6"> <strong>Location</strong>
                                <br>
                                <p class="text-muted">{{$order->address}}</p>
                            </div>
                        </div>

                        <div class="row">
                            @foreach($order->counting_unit as $unit)
                            <div class="col-md-4 col-xs-6"> 
                                <strong>Unit Name</strong>
                                <br>
                                <p class="text-muted">Item Name -> {{$unit->item->item_name}}</p>
                                <p class="text-muted">Unit Name ->{{$unit->unit_name}}</p>
                                <p class="text-muted">Quantity -> {{$unit->pivot->quantity}}</p>
                            </div>
                            @endforeach                            

                        </div>
                        <hr>
                        @endforeach
                    </div>
                </div>
                
                <div class="tab-pane" id="settings" role="tabpanel">
                    <div class="card-body">
                        <form class="form-horizontal form-material" action="{{route('customer_update', $customer->id)}}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label class="col-md-12">Customer Name</label>
                                <div class="col-md-12">
                                    <input type="text" class="form-control form-control-line" name="name" value="{{$customer->user->name}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="example-email" class="col-md-12">Email</label>
                                <div class="col-md-12">
                                    <input type="email" class="form-control form-control-line" name="email" value="{{$customer->user->email}}">
                                </div>
                            </div>
                       
                            <div class="form-group">
                                <label class="col-md-12">Phone No</label>
                                <div class="col-md-12">
                                    <input type="text"  class="form-control form-control-line" name="phone" value="{{$customer->phone}}">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-md-12">Address</label>
                                <div class="col-md-12">
                                    <input type="text"  class="form-control form-control-line" name="address" value="{{$customer->address}}">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-12">
                                    <button class="btn btn-success">Update Profile</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Column -->
</div>

@endsection

@section('js')
<script type="text/javascript">
    function changePassword(user_id){
        swal("Please Enter New Password:", {
                    content: "input",
                }).then((value) => {
                    $.ajax({
                        type: 'POST',
                        url: '/changeCustomerPassword',
                        data: {
                            "_token":"{{csrf_token()}}",
                            "user_id": user_id,
                            "new_password": value,
                        },
                        success: function(data){
                            swal({
                                    title:"Change Password",
                                    text:"Customer Password is changed successfully!",
                                    icon:"info",
                                });        
                        }
                    });
                });
    }
    
    
    
</script>
@endsection