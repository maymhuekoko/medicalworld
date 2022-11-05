@extends('master')

@section('title','Incomes List')

@section('place')

@section('place')

{{-- <div class="col-md-5 col-8 align-self-center">
    <h3 class="text-themecolor m-b-0 m-t-0">@lang('lang.expenses') @lang('lang.list')</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('index')}}">@lang('lang.dashboard')</a></li>
        <li class="breadcrumb-item active">@lang('lang.expenses') @lang('lang.list')</li>
    </ol>
</div> --}}

@endsection

@section('content')
        <div class="row">
            <div class="col-6">
                <a href="#" class="btn btn-info" data-toggle="modal" data-target="#add_incomes" >Add Income</a>
                <div class="modal fade" id="add_incomes" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"> Create @lang('lang.incomes')</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                            </div>
                            <div class="modal-body" id="slimtest2">
                                <form action="{{route('store_income')}}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label">Income Type</label>
                                                <select class="form-control" onchange="showPeriod(this.value)" name="type">
                                                    <option value="">@lang('lang.select_income_type')</option>
                                                    <option value="1">@lang('lang.fixed')</option>
                                                    <option value="2">@lang('lang.variable')</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">@lang('lang.period')</label>
                                                <select class="form-control" id="period" name="period">
                                                    <option value="">@lang('lang.select')</option>
                                                    <option value="1">@lang('lang.daily')</option>
                                                    <option value="2">@lang('lang.weekly')</option>
                                                    <option value="3">@lang('lang.monthly')</option>
                                                </select>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">@lang('lang.date')</label>
                                                <input type="text" class="form-control" id="mdate" name="date">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">@lang('lang.title')</label>
                                                <input type="text" class="form-control" name="title">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">@lang('lang.description')</label>
                                                <input type="text" class="form-control" name="description">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">@lang('lang.amount')</label>
                                                <input type="number" class="form-control" name="amount">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">@lang('lang.applied_to_profit_loss')</label>
                                                <select class="form-control" name="profit_loss_flag">
                                                    <option value="">@lang('lang.select')</option>
                                                    <option value="1">@lang('lang.yes')</option>
                                                    <option value="2">@lang('lang.no')</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <div class="row">
                                            <div class="col-md-6 float-right">
                                                <div class="row">
                                                    <div class=" col-md-9">
                                                        <button type="submit" class="btn btn-success">@lang('lang.submit')</button>
                                                        <button type="button" class="btn btn-inverse btn-dismiss" data-dismiss="modal">@lang('lang.cancel')</button>
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
            </div>
        </div><br/>
        <div class="card">
            <div class="card-body">
                <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Income Type</th>
                                <th>@lang('lang.period')</th>
                                <th>@lang('lang.date')</th>
                                <th>@lang('lang.title')</th>
                                <th>@lang('lang.description')</th>
                                <th>@lang('lang.amount')</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $i = 1;
                        ?>
                        @foreach($incomes as $income)
                        <tr>
                            <td>{{$i++}}</td>
                            @if($income->type == 1)
                            <td>@lang('lang.fixed')</td>
                            @else
                            <td>@lang('lang.variable')</td>
                            @endif
                            @if($income->period == 1)
                            <td>@lang('lang.daily')</td>
                            @elseif($income->period == 2)
                            <td>@lang('lang.weekly')</td>
                            @else
                            <td>@lang('lang.monthly')</td>
                            @endif
                            @if($income->type == 1)
                            <td>ရက်စွဲမရှိပါ</td>
                            @else
                            <td>{{$income->date}}</td>
                            @endif
                            <td>{{$income->title}}</td>
                            <td>{{$income->description}}</td>
                            <td>{{$income->amount}}</td>
                            
                            <td class="text-center">
                                                    <div class="d-flex">
                                                        <a href="#" class="btn btn-sm btn-outline-warning" data-toggle="modal" data-target="#edit_income{{$income->id}}">
                                                            <i class="fas fa-edit"></i></a>

                                                        <a href="#" class="btn btn-sm btn-outline-danger" onclick="deleteIncome('{{$income->id}}')">
                                                            <i class="fas fa-trash-alt"></i></a>
                                                    </div>

                                                </td>
                            
                            <div class="modal fade" id="edit_income{{$income->id}}" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Update @lang('lang.incomes')</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                            </div>
                            <div class="modal-body" id="slimtest2">
                                <form action="{{route('update_income',$income->id)}}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label">Income Type</label>
                                                <select class="form-control" onchange="showPeriod(this.value)" name="type">
                                                    <option value="">@lang('lang.select_income_type')</option>
                                                    <option value="1" @if($income->type === 1) selected='selected' @endif>@lang('lang.fixed')</option>
                                                    <option value="2" @if($income->type === 2) selected='selected' @endif>@lang('lang.variable')</option>
                                                </select>
                                            </div>
                                        </div>                              
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">@lang('lang.period')</label>
                                                <select class="form-control" id="period" name="period">
                                                    <option value="">@lang('lang.select')</option>
                                                    <option value="1" @if($income->period === 1) selected='selected' @endif>@lang('lang.daily')</option>
                                                    <option value="2" @if($income->period === 2) selected='selected' @endif>@lang('lang.weekly')</option>
                                                    <option value="3" @if($income->period === 3) selected='selected' @endif>@lang('lang.monthly')</option>
                                                </select>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">@lang('lang.date')</label>
                                                <input type="text" class="form-control" id="mdate" name="date" value="{{$income->date}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">@lang('lang.title')</label>
                                                <input type="text" class="form-control" name="title" value="{{$income->title}}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">@lang('lang.description')</label>
                                                <input type="text" class="form-control" name="description" value="{{$income->description}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">@lang('lang.amount')</label>
                                                <input type="number" class="form-control" name="amount" value="{{$income->amount}}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">@lang('lang.applied_to_profit_loss')</label>
                                                <select class="form-control" name="profit_loss_flag">
                                                    <option value="">@lang('lang.select')</option>
                                                    <option value="1" @if($income->profit_loss_flag === 1) selected='selected' @endif>@lang('lang.yes')</option>
                                                    <option value="2" @if($income->profit_loss_flag === 2) selected='selected' @endif>@lang('lang.no')</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <div class="row">
                                            <div class="col-md-6 float-right">
                                                <div class="row">
                                                    <div class=" col-md-9">
                                                        <button type="submit" class="btn btn-success">@lang('lang.submit')</button>
                                                        <button type="button" class="btn btn-inverse btn-dismiss" data-dismiss="modal">@lang('lang.cancel')</button>
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
            </div>
        </div>
    </div>
</div>


@endsection

@section('js')

<script src="{{asset('assets/plugins/dropify/dist/js/dropify.min.js')}}"></script>

<script type="text/javascript">

    $('.dropify').dropify();

    $('#mdate').bootstrapMaterialDatePicker({ weekStart: 0, time: false });

    $('#mdate').prop("disabled",true);
    $('#period').prop("disabled",true);

    function showPeriod(value){

        var show_options = value;
        //  alert(show_options);
        if( show_options == 1){
            $('#mdate').prop("disabled",true);
            $('#period').prop("disabled",false);
            }

        else{

            $('#mdate').prop("disabled",false);
            $('#period').prop("disabled",true);
        }
    }
    
    function deleteIncome(value) {

            var income_id = value;

            swal({
                    title: "@lang('lang.confirm')",
                    icon: 'warning',
                    buttons: ["@lang('lang.no')", "@lang('lang.yes')"]
                })

                .then((isConfirm) => {

                    if (isConfirm) {

                        $.ajax({
                            type: 'POST',
                            url: 'deleteIncome',
                            dataType: 'json',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "income_id": income_id,
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

</script>

@endsection
