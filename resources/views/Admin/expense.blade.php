@extends('master')

@section('title','Expenses List')

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
                    
                    <div class="ml-2">
                        <h3>Expense List</h3>
                    </div>
                    
            <div class="col-2 ml-5">
                <a href="#" class="btn btn-info" data-toggle="modal" data-target="#add_expenses" >@lang('lang.add_expenses')</a>
                <div class="modal fade" id="add_expenses" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Create @lang('lang.expenses')</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                            </div>
                            <div class="modal-body" id="slimtest2">
                                <form action="{{route('store_expense')}}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label">@lang('lang.expense_type')</label>
                                                <select class="form-control" onchange="showPeriod(this.value)" name="type">
                                                    <option value="">@lang('lang.select_expense_type')</option>
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

        <div class="row justify-content-start">
        <div class="col-8">
           <div class="mb-4">
                <div class="row">
                      <?php
                    //$from = date('Y-m-d',strtotime(now()));
                    //$to = date('Y-m-d',strtotime(now()));;
                    $from = date('Y-m-d',strtotime(now()));
                    $to = date('Y-m-d',strtotime(now()));
                    $id = 0;
                ?>
                    <div class="col-2">
                        <label class="">@lang('lang.from')</label>
                        <input type="date" name="from" id="from" class="form-control form-control-sm" onChange="setFrom(this.value)" required>
                    </div>
                    <div class="col-2">
                        <label class="">@lang('lang.to')</label>
                        <input type="date" name="to" id="to" class="form-control form-control-sm" onChange="setTo(this.value)" required>
                    </div>
                   

                    <div class="col-md-2 m-t-30">
                        <button class="btn btn-sm rounded btn-outline-info" id="search_expenses">
                            <i class="fas fa-search mr-2"></i>Search
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
         @if(session()->get('user')->role != "Partner")
         <div class="col-md-4 mt-4">
             
             <form id="exportForm" onsubmit="return exportForm()" method="get">
                 <div class="row">
                <input type="hidden" name="export_from" id="export_from" class="form-control form-control-sm hidden" required>
                <input type="hidden" name="export_to" id="export_to" class="form-control form-control-sm hidden" required>
                <div class="col-3">
                     <select name="export_data_type" id="export_data_type" class="form-control form-control-sm select2" style="font-size: 12px;">
                                <option value=1 selected>Vouchers</option>
                                <option value=2 >Items</option>
                        </select>  
                    
                </div>
                <div class="col-3">
                     <select name="export_type" id="export_type" class="form-control form-control-sm select2" style="font-size: 12px;">
                                <option value=1 selected>Excel</option>
                                <option value=2 >PDF</option>
                        </select>  
                    
                </div>
                
                <div class="col-6">
                <input type="submit" class="btn btn-sm rounded btn-outline-info col-4" value=" Export ">
                </div>
                </div>            
                        
            </form>
            
            
        </div>
        @endif

       

    </div>

        
        <div class="card">
            
            <div class="card-body">
                <div class="row">
            <div class="col-md-12">
                <div class="row p-2 offset-10">
                        <input  type="text" id="table_search" placeholder="Quick Search" onkeyup="search_table()" >    
                    </div>
                    
                <div class="table-responsive">
                    <table class="table table-hover" id="expense_table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('lang.expense_type')</th>
                                <th>@lang('lang.period')</th>
                                <th>@lang('lang.date')</th>
                                <th>@lang('lang.title')</th>
                                <th>@lang('lang.description')</th>
                                <th>@lang('lang.amount')</th>
                            </tr>
                        </thead>
                        <tbody id="expense_list">
                        <?php
                            $i = 1;
                        ?>
                        @foreach($expenses as $expense)
                        <tr>
                            <td>{{$i++}}</td>
                            @if($expense->type == 1)
                            <td>@lang('lang.fixed')</td>
                            @else
                            <td>@lang('lang.variable')</td>
                            @endif
                            @if($expense->period == 1)
                            <td>@lang('lang.daily')</td>
                            @elseif($expense->period == 2)
                            <td>@lang('lang.weekly')</td>
                            @else
                            <td>@lang('lang.monthly')</td>
                            @endif
                            @if($expense->type == 1)
                            <td>ရက်စွဲမရှိပါ</td>
                            @else
                            <td>{{$expense->date}}</td>
                            @endif
                            <td>{{$expense->title}}</td>
                            <td>{{$expense->description}}</td>
                            <td>{{$expense->amount}}</td>
                            
                                    <td class="text-center">
                                                    <div class="d-flex">
                                                        <a href="#" class="btn btn-sm btn-outline-warning" data-toggle="modal" data-target="#edit_expense{{$expense->id}}">
                                                            <i class="fas fa-edit"></i></a>

                                                        <a href="#" class="btn btn-sm btn-outline-danger" onclick="deleteExpense('{{$expense->id}}')">
                                                            <i class="fas fa-trash-alt"></i></a>
                                                    </div>

                                                </td>
                            
                            <div class="modal fade" id="edit_expense{{$expense->id}}" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Update @lang('lang.expenses')</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                            </div>
                            <div class="modal-body" id="slimtest2">
                                <form action="{{route('update_expense',$expense->id)}}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label">@lang('lang.expense_type')</label>
                                                <select class="form-control" onchange="showPeriod(this.value)" name="type">
                                                    <option value="">@lang('lang.select_expense_type')</option>
                                                    <option value="1" @if($expense->type === 1) selected='selected' @endif>@lang('lang.fixed')</option>
                                                    <option value="2" @if($expense->type === 2) selected='selected' @endif>@lang('lang.variable')</option>
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
                                                    <option value="1" @if($expense->period === 1) selected='selected' @endif>@lang('lang.daily')</option>
                                                    <option value="2" @if($expense->period === 2) selected='selected' @endif>@lang('lang.weekly')</option>
                                                    <option value="3" @if($expense->period === 3) selected='selected' @endif>@lang('lang.monthly')</option>
                                                </select>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">@lang('lang.date')</label>
                                                <input type="text" class="form-control" id="mdate" name="date" value="{{$expense->date}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">@lang('lang.title')</label>
                                                <input type="text" class="form-control" name="title" value="{{$expense->title}}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">@lang('lang.description')</label>
                                                <input type="text" class="form-control" name="description" value="{{$expense->description}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">@lang('lang.amount')</label>
                                                <input type="number" class="form-control" name="amount" value="{{$expense->amount}}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">@lang('lang.applied_to_profit_loss')</label>
                                                <select class="form-control" name="profit_loss_flag">
                                                    <option value="">@lang('lang.select')</option>
                                                    <option value="1" @if($expense->profit_loss_flag === 1) selected='selected' @endif>@lang('lang.yes')</option>
                                                    <option value="2" @if($expense->profit_loss_flag === 2) selected='selected' @endif>@lang('lang.no')</option>
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
    
    function setFrom(value){
        $("#exportForm :input[name=export_from]").val(value);
    }
    
     function setTo(value){
        $("#exportForm :input[name=export_to]").val(value);
    }
    
    function exportForm(){
       
        var from = $("#exportForm :input[name=export_from]").val();
        var to = $("#exportForm :input[name=export_to]").val();
        
        console.log(from,to);
        
        
         let url = `/export-expensehistory/${from}/${to}`;
         window.location.href= url;
   
        return false;
    };
    
    function search_table(){
            var input, filter, table,tr,td,i;
            input = document.getElementById("table_search");
            filter = input.value.toUpperCase();
            table = document.getElementById("expense_table");
            tr = table.getElementsByTagName("tr");
            
            var searchColumn = [1,2,3,4,5,6,7];
            
            for(i = 0; i < tr.length; i++){
                if($(tr[i]).parent().attr('class') == 'head'){
                    continue;
                }
                
                var found = false;
                
                for(var k=0; k < searchColumn.length; k++){
                    td = tr[i].getElementsByTagName("td")[searchColumn[k]];
                    if(td){
                        if(td.innerHTML.toUpperCase().indexOf(filter) > -1){
                            found=true;
                        }
                    }
                }
                if(found == true){
                    tr[i].style.display = "";
                }else{
                    tr[i].style.display = "none";
                }
            }
        }
    
    $('#search_expenses').click(function(){
       
        
        
        var from = $('#from').val();
        var to = $('#to').val();
       
        $.ajax({

            type: 'POST',

            url: '{{ route('search_expense_history') }}',

            data: {
                "_token": "{{ csrf_token() }}",
                "from" : from,
                "to" : to,
            },

            success: function(data) {
                if (data.length >0) {
                    console.log(data);
                    var html = '';
                    var expense_type = '';
                    var period_type = '';
                    var date = '';
                    
                    $.each(data, function(i, expense) {
                       
                        if(expense.type == 1){
                            expense_type = "Fixed";
                        }else{
                            expense_type = "Variable";
                        } 
                        
                        if(expense.period == 1){
                            period_type = "Daily";
                        }else  if(expense.period == 2){
                            period_type = "Weekly";
                        }else{
                            period_type = "Monthly";
                        }
                        
                        if(expense.type == 1){
                            date = "ရက်စွဲမရှိပါ"
                        }else{
                            date = expense.date;
                        }
                        html += `
                           <tr>
                            <td>${++i}</td>
                           
                            <td>${expense_type}</td>
                           
                           
                            <td>${period_type}</td>
                           
                            
                            
                            <td>${date}</td>
                            
                            <td>${expense.title}</td>
                            <td>${expense.description}</td>
                            <td>${expense.amount}</td>
                            
                        </tr>
                    `;

                        $('#expense_list').empty();
                       $('#expense_list').html(html);
                    })
                    
                  // $('#item_table').DataTable().clear().draw();
                    // $('#item_table').DataTable( {

                    //     "paging":   false,
                    //     "ordering": true,
                    //     "info":     false,
                    //     "destroy": true
                    // });

                    // swal({
                    //     toast:true,
                    //     position:'top-end',
                    //     title:"Success",
                    //     text:"Orders Changed!",
                    //     button:false,
                    //     timer:500,
                    //     icon:"success"  
                    // });

                } else {
                    var html = `
                    
                    <tr>
                        <td colspan="9" class="text-danger text-center">No Data Found</td>
                    </tr>

                    `;
                    $('#item_list').empty();
                    $('#item_list').html(html);
                
                }
            },
            });
        
    })
    
    function showPeriod(value){
        
        var show_options = value;

        if( show_options == 1){
            $('#mdate').prop("disabled",true);
            $('#period').prop("disabled",false);
            }

        else{

            $('#mdate').prop("disabled",false);
            $('#period').prop("disabled",true);
        }
    }
    
    function deleteExpense(value) {

            var expense_id = value;

            swal({
                    title: "@lang('lang.confirm')",
                    icon: 'warning',
                    buttons: ["@lang('lang.no')", "@lang('lang.yes')"]
                })

                .then((isConfirm) => {

                    if (isConfirm) {

                        $.ajax({
                            type: 'POST',
                            url: 'deleteExpense',
                            dataType: 'json',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "expense_id": expense_id,
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
