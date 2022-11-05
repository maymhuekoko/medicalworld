@extends('master')

@section('title','Way Planning Form')

@section('place')

{{-- <div class="col-md-5 col-8 align-self-center">
    <h3 class="text-themecolor m-b-0 m-t-0">Way Planning Form</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('index')}}">@lang('lang.back_to_dashboard')</a></li>
        <li class="breadcrumb-item active">Way Planning Form</li>
    </ol>
</div> --}}

@endsection

@section('content')
<section id="plan-features">
 
            <div class="row">
                <div class="flex col-md-3 offset-6 float-right">
                    <div class="text-center">
                        <a href="#" class="btn btn-outline-primary float-right" data-toggle="modal" data-target="#create_item">
                            <i class="fas fa-plus"></i>
                            New Way
                        </a>
                    </div>
                </div>
            </div>
                        
                {{-- Modal   --}}
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
                                <form action="{{route('wayplanning.store')}}" method="POST" class="form">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="control-label font-weight-bold">Way No</label>
                                            <input type="text" name="wayno" class="form-control" required>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <label class="font-weight-bold">Delivery Person</label>
                                            <select class="form-control" name="delivery_id" required>
                                                <option value="1">@lang('lang.select')</option>
                                                <option value="2">Township One</option>
                                                <option value="3">Township One</option>
                                                <option value="4">Township One</option>
                                                <option value="5">Township One</option>
                                            </select>
                                        </div>
                        
                                        <div class="col-md-4">
                                            <label class="control-label font-weight-bold">Date</label>
                                            <input type="date" name="date" class="form-control" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="control-label font-weight-bold"></label>
                                            <div class="row">
                                                
                                            <div class="form-check col-md-4">
                                                <input class="form-check-input" type="radio" name="pickup" id="pickupYes" value="1" checked>
                                                <label class="form-check-label" for="pickupYes">
                                                PickUp
                                                </label>
                                            </div>
                                            <div class="form-check col-md-4">
                                                <input class="form-check-input" type="radio" name="pickup" id="pickupNo" value="0">
                                                <label class="form-check-label" for="pickupNo">
                                                Delivery
                                                </label>
                                            </div>
                                        </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="font-weight-bold">Township</label>
                                            <select class="form-control" name="township_id" required>
                                                <option value="1">@lang('lang.select')</option>
                                                <option value="2">Township One</option>
                                                <option value="3">Township One</option>
                                                <option value="4">Township One</option>
                                                <option value="5">Township One</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="control-label font-weight-bold">Start Time</label>
                                            <input type="time" name="start_time" class="form-control" required>
                                        </div>
                        
                                        <div class="col-md-4">
                                            <label class="control-label font-weight-bold">End Time</label>
                                            <input type="time" name="end_time" class="form-control" required>
                                        </div>
                                  
                                    </div>
                                    <div class="row mt-3">
                                        <div class=" col-md-9">
                                            <button type="submit" class="btn btn-success">@lang('lang.submit')</button>
                                            <button type="button" class="btn btn-inverse" data-dismiss="modal">@lang('lang.cancel')</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


    <br/>

    <div class="container">
        <div class="card">
            <div class="card-body shadow">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive" id="slimtest2">
                            <table class="table" id="item_table">
                                <thead>
                                    <tr>
                                        <th class="font-weight-bold text-themecolor">#</th>
                                        <th class="font-weight-bold text-themecolor">Way No.</th>
                                        <th class="font-weight-bold text-themecolor">Delivery Person</th>
                                        <th class="font-weight-bold text-themecolor">Date</th>
                                        <th class="font-weight-bold text-themecolor">Pickup/Delivery </th>
                                        <th class="font-weight-bold text-themecolor">Township</th>
                                        <th class="font-weight-bold text-themecolor">Total Order</th>
                                        <th class="font-weight-bold text-themecolor">@lang('lang.action')</th>
                                    </tr>
                                </thead>
                                <tbody id="item_list">
                                    @php
                                        $j=1;
                                    @endphp
                                    @foreach ($wayplanningLists as $wayplanning)

                                    <tr>
                                        <td class="font-weight-bold">{{$j++}}</td>
                                        <td class="font-weight-bold">{{$wayplanning->wayno}}</td>
                                        <td class="font-weight-bold">{{$wayplanning->delivery_id}}</td>
                                        <td class="font-weight-bold">
                                            {{$wayplanning->date}}
                                        </td>
                                        <td class="font-weight-bold">
                                            {{$wayplanning->pick_delivery}}
                                        </td>
                                        <td class="font-weight-bold">
                                            {{$wayplanning->township_id}}
                                        </td>
                                        <td class="font-weight-bold">
                                            4
                                        </td>
                                        <td style="text-align: center;">
                                            <a href="" class="btn btn-primary" style="color: white;">Detail</a>
                                            <a href="{{route('way_planing_form')}}" class="btn btn-primary" style="color: white;">Add</a>
                                        </td>
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
</section>

@endsection

@section('js')

<script src="{{asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>

<script src="{{asset('assets/js/jquery.slimscroll.js')}}"></script>

<script type="text/javascript">

	$('#item_table').DataTable( {

            "paging":   false,
            "ordering": true,
            "info":     false

    });
        
    $('#slimtest2').slimScroll({
        color: '#00f',
        height: '600px'
    });
	
</script>

@endsection