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

<div class="card mt-5">
    <div class="card-body p-b-0">
        <h2 class="card-title text-info">Bank Account List</h2>
        <a href="#" class="float-right btn btn-info m-3" data-toggle="modal" data-target="#bank_register">
            Bank Register
        </a>
        
        <div class="modal fade bs-example-modal-lg" id="bank_register" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                 <div class="modal-header">
                        <h4 class="modal-title text-info">Bank Registeration Form</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('store_bank_acc')}}" method="POST">
                            @csrf
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label text-info">Bank Name</label>
                                        <input type="text" class="form-control" name="bank_name">
                                    </div>
                                </div> 
    
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label text-info">Bank Address</label>
                                        <input type="text" class="form-control" name="bank_address">
                                    </div>
                                </div>                              
                            </div>    
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label text-info">Bank Contact</label>
                                        <input type="text" class="form-control" placeholder="" name="bank_contact">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label text-info">Bank Account Number</label>
                                        <input type="number" class="form-control" placeholder="" name="acc_number">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label text-info">Account Holder Name</label>
                                        <input type="text" class="form-control" placeholder="" name="holder_name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label text-info">Opening Date</label>
                                        <input type="text" class="form-control" placeholder="" name="opening_date" id="mdate">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label text-info">Current Balance</label>
                                        <input type="text" class="form-control" value="1000" name="current_balance">
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class=" col-md-9">
                                                <button type="submit" class="btn btn-success">Submit</button>
                                                <button type="button" class="btn btn-inverse" data-dismiss="modal">Cancel</button>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                           </div>                            
                        </div>
                    </form>             
                </div>
                 
                </div>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="bg-info">
                    <tr>
                        <th>#</th>
                        <th>Bank Name</th>
                        <th>Account Number</th>
                        <th>Holder Name</th>
                        <th>Opening Date</th>
                        <th>Balance</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 1;
                    ?>
                    @foreach($bank as $bankacc)
                    <tr>
                        <td>{{$i++}}</td>
                        <td>{{$bankacc->bank_name}}</td>
                        <td>{{$bankacc->account_number}}</td>
                        <td>{{$bankacc->account_holder_name}}</td>
                        <td>{{$bankacc->opening_date}}</td>
                        <td>{{$bankacc->balance}}</td>
                        <td><a href="#" class="btn btn-sm btn-outline-warning" data-toggle="modal" data-target="#edit_account_{{$bankacc->id}}">
                            <i class="far fa-edit"></i></a></td>
                            <div class="modal fade bs-example-modal-lg" id="edit_account_{{$bankacc->id}}" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title text-info">Edit Bank Info</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{route('update_account_info', $bankacc->id)}}" method="POST">
                                            @csrf
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label text-info">Bank Name</label>
                                                        <input type="text" class="form-control" name="bank_name" value="{{$bankacc->bank_name}}">
                                                    </div>
                                                </div> 
                
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label text-info">Bank Address</label>
                                                        <input type="string" class="form-control" name="bank_address" value="{{$bankacc->bank_address}}">
                                                    </div>
                                                </div>                              
                                            </div>    
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label text-info">Bank Contact</label>
                                                        <input type="text" class="form-control" placeholder="" name="bank_contact" value="{{$bankacc->bank_contact}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label text-info">Bank Account Number</label>
                                                        <input type="number" class="form-control" placeholder="" name="acc_number" value="{{$bankacc->account_number}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label text-info">Account Holder Name</label>
                                                        <input type="text" class="form-control" placeholder="" name="holder_name" value="{{$bankacc->account_holder_name}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label text-info">Opening Date</label>
                                                        <input type="text" class="form-control" placeholder="" name="opening_date" id="mdate1" value="{{$bankacc->opening_date}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label text-info">Current Balance</label>
                                                        <input type="text" class="form-control" value="{{$bankacc->balance}}" name="balance">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-actions">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <div class=" col-md-9">
                                                                <button type="submit" class="btn btn-success">Submit</button>
                                                                <button type="button" class="btn btn-inverse" data-dismiss="modal">Cancel</button>
                                                            </div>
                                                        </div>
                                                    </div> 
                                                </div>
                                           </div>                            
                                        </div>
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


@endsection

@section('js')

<script src="{{asset('assets/plugins/select2/dist/js/select2.full.min.js')}}" type="text/javascript"></script>

<script src="{{asset('assets/plugins/bootstrap-select/bootstrap-select.min.js')}}"  type="text/javascript"></script>

<script type="text/javascript" src="{{asset('assets/plugins/multiselect/js/jquery.multi-select.js')}}"></script>

<script>
    
    $('#mdate').bootstrapMaterialDatePicker({ weekStart: 0, time: false });
    $('#mdate1').bootstrapMaterialDatePicker({ weekStart: 0, time: false });
    $('#mdate2').bootstrapMaterialDatePicker({ weekStart: 0, time: false });
    
    $( document ).ready(function() {
        
        $('#expense').hide();
    });
    
    function hideExpenseType(value){
        
        if(value == 1){
            
            $('#expense').hide();
        }
        
        else if(value == 2){
            
            $('#expense').show();
        }
        
        else{
            
            $('#expense').hide();
        }
    
    }
    
</script>


@endsection