@extends('master')

@section('title','Capital Cash Bank Panel')

@section('content')

<div class="row page-titles">
    {{-- <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor m-b-0 m-t-0">Capital Cash</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('index')}}">Back to Dashborad</a></li>
            <li class="breadcrumb-item active">Capital Cash (Bank) Panel</li>
        </ol>
    </div> --}}

    <div class="container">
        <ul class="nav nav-pills m-t-30 m-b-10  nav-justified">
            <li class="nav-item">
                <a href="#navpills-1" class="nav-link border border-primary active" data-toggle="tab" aria-expanded="false">
                <label class="font-weight-bold">CAPITAL</label>
                </a>
            </li>
            <li class="nav-item">
                <a href="#navpills-2" class="nav-link border border-primary" data-toggle="tab" aria-expanded="false" >
                <label class="font-weight-bold">CASH</label>
                </a>
            </li>
            <li class="nav-item">
                <a href="#navpills-2" class="nav-link border border-primary" data-toggle="tab" aria-expanded="false" >
                <label class="font-weight-bold">BANK</label>
                </a>
            </li>
        </ul>
        <div class="card">
            <div class="card-body shodow">
                <div class="row">
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-2 mt-2">
                            <label class="text-info font-weight-bold">View</label>
                            </div>
                            <div class="col-md-10">

                                <select id="select_type" class="form-control border border-info" onchange="select_type(this.value)">

                                <option value="1" selected>General</option>
                                <option value="2">Detail</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8" id="lockk">
                        <div class="offset-md-8">
                            <button class="btn btn-danger" onclick="locker()"><i class="fas fa-lock pr-2 pl-2"></i><span id="locked"></span></button>
                            <button class="btn btn-info" onclick="unlocker()"><i class="fas fa-lock-open pr-2 pl-2"></i><span id="unlocked"></span></button>
                        </div>
                    </div>
                </div>
                <form  action="{{route('store_capital')}}" method="post"  id="generall">
                    @csrf
                    <input type="hidden" name="general_id" id="general_id">
                <h3 class="font-weight-bold offset-md-4 pl-5">General Information Register</h3>
                <div class="form-group mt-5">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold text-success">@lang('lang.Bussiness Name')</label>
                                <input type="text" class="form-control border border-info" id="buss_name" name="buss_name">
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold text-success">@lang('lang.Total Starting Capital')</label>
                                <input type="number" class="form-control border border-info" id="start_capital" name="start_capital">
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold text-success">@lang('lang.Reinvestment')</label>
                                <input type="text" class="form-control border border-info" id="reinvest" name="reinvest">
                            </div>
                            <div class="col-md-8 form-group">
                                <div class="row">
                                    <div class="col-md-10">
                                    <label class="font-weight-bold mr-3 text-success">@lang('lang.ShareHolder Details')</label>
                                    <button type="button" class="btn btn-warning" id="add_plus" onclick="add_new()"><i class="fas fa-plus"></i></button>
                                    </div>
                                    <input type="hidden" id="share_count" value="0">
                                    <div class="col-md-2">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="from-group">
                                <label class="font-weight-bold text-success">@lang('lang.Bussiness Type')</label>
                                <select id="select_typing" name="buss_type" class="form-control border border-info">
                                    <option value="1" selected>Sole Proprietory</option>
                                    <option value="2">Partner Ship</option>
                                    <option value="3">Limited Liability Company</option>
                                </select>
                            </div>
                            <div class="form-group mt-4">
                                <label class="font-weight-bold text-success">@lang('lang.Number of Share-holder')</label>
                                <input type="hidden" id="old_sharer">
                                <input type="number" class="form-control border border-info" id="sharer" name="sharer" onkeyup="open_but(this.value)">
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold text-success">@lang('lang.Cash In Hand')</label>
                                <input type="text" class="form-control border border-info" id="cashin" name="cashin">
                            </div>

                            <div class="form-group">
                                <div class="card">
                                    <div class="card-body shadow">
                                        <h4 class="font-weight-bold offset-md-5 text-secondary">@lang('lang.Current')</h4>
                                        <!-- <hr> -->
                                        <div class="row">
                                            <div class="col-md-4">
                                            <span class="text-secondary">@lang('lang.Fixed Asset')<span><br>
                                            <span class="badge badge-success ml-3">{{$current_asset}}</span>
                                            </div>
                                            <div class="col-md-4">
                                            <span class="text-secondary">@lang('lang.Customer Credit')</span><br>
                                            <span class="badge badge-success ml-3">{{$total_sale_credit}}</span>
                                            </div>
                                            <div class="col-md-4">
                                            <span class="text-secondary">@lang('lang.Supplier Credit')</span><br>
                                            <span class="badge badge-success ml-3">{{$total_sup_credit}}</span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            <input type="hidden" name="currentasset" value="{{$current_asset}}">
                            <input type="hidden" name="sale_credit" value="{{$total_sale_credit}}">
                            <input type="hidden" name="sup_credit" value="{{$total_sup_credit}}">
                            </div>

                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body shadow">
                        <div class="form-group" id="holder_place">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="font-weight-bold text-info">@lang('lang.ShName')</label>
                                </div>
                                <div class="col-md-3">
                                    <label class="font-weight-bold text-info">@lang('lang.NRC/Passport')</label>
                                </div>
                                <div class="col-md-2">
                                    <label class="font-weight-bold text-info">@lang('lang.Position')</label>
                                </div>
                                <div class="col-md-2 text-info">
                                    <label class="font-weight-bold">@lang('lang.% of Share')</label>
                                </div>
                                <div class="col-md-2">
                                    <label class="font-weight-bold text-info">Divident %</label>
                                </div>
                            </div>
                            <div class="row" id="add_new_place">

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer" id="footer">
                <div class="col-md-12 offset-md-3">
                <input type="hidden" id="total_amt" value="100">
                <input type="hidden" id="total">
                    <div id="change_but">
                    <button type="submit" class="btn btn-success col-md-5 btn-block savee"><i class="far fa-edit mr-2"></i>Save General Info</button>
                    </div>
                </div>


            </div>
        </form>
            {{-- Begin detail Page --}}
            <div class="container m-2" class="detaill" id="detaill">
                <div class="form-group" >
                <div class="row offset-9">
                    <a href="" class="btn  btn-primary" data-toggle="modal" data-target="#reinvest_modal">@lang('lang.Reinvest')</a>
                    <a href="" class="btn  btn-primary ml-3" data-toggle="modal" data-target="#withdraw_modal">@lang('lang.Withdraw')</a>
                </div>

    <!--start Reinvest Modal -->
        <div class="modal fade" id="reinvest_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
            <h5 class="modal-title text-white" id="exampleModalLabel">Reinvest</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            <form action="{{route('store_reinvest')}}" method="POST">
                @csrf
                <input type="hidden" id="total_cap" name="total_capital_modal">
                <input type="hidden" id="total_cas" name="total_cash_modal">
                <input type="hidden" id="generalID" name="general_id">
                <input type="hidden"  name="proof" value="3">
                <h2 class="text-center">Reinvest</h2>
                <div class="form-group">
                    <label for="" class="text-success">Source</label>
                    <select id="reinvest_type" name="reinvest_type" class="form-control" onchange="reinvest_typee(this.value)">
                        <option value="" disabled hidden  selected>Choose Source</option>
                        <option value="1">Cash</option>
                        <option value="2">Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="" class="text-success">Amount</label>
                    <input type="text" name="reinvest_amount" class="form-control">
                </div>
                <div class="form-group">
                    <label for="" class="text-success">Date</label>
                    <input type="date" name="reinvest_date" class="form-control">
                </div>
                <div class="form-group" id="reinvest_remarkk">
                    <label for="" class="text-success" >Remark</label>
                    <input type="text" name="reinvest_remark" class="form-control" id="reinvest_remark">
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
        </div>
        </div>
        </div>
    {{-- End Reinvest Modal --}}

    <!--start Withdraw Modal -->
    <div class="modal fade" id="withdraw_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
            <h5 class="modal-title text-white" id="exampleModalLabel">Withdraw</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <form action="{{route('store_withdraw')}}" method="POST">
                    @csrf
                    <input type="hidden" id="total_cap" name="total_capital_modal">
                    <input type="hidden" id="total_cas" name="total_cash_modal">
                    <input type="hidden" id="generalIDE" name="general_id">
                    <input type="hidden"  name="proof" value="4">
                    <h2 class="text-center">Withdraw</h2>
                    <div class="form-group">
                        <label for="" class="text-success">Source</label>
                        <select id="withdraw_type" name="withdraw_type" class="form-control" onchange="withdraw_typee(this.value)">
                            <option value="" disabled hidden selected>Choose Source</option>
                            <option value="1">Cash</option>
                            <option value="2">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="" class="text-success">Amount</label>
                        <input type="text" name="withdraw_amount" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="" class="text-success">Date</label>
                        <input type="date" name="withdraw_date" class="form-control">
                    </div>
                    <div class="form-group" id="withdraw_remarkk">
                        <label for="" class="text-success" >Remark</label>
                        <input type="text" name="withdraw_remark" class="form-control" id="withdraw_remark">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
        </div>
        </div>
        </div>
    {{-- End Withdraw Modal --}}
                    <div class="form-group mt-2">
                        <div class="row">
                        <div class="col-md-4">
                        <label for="" class="font-weight-bold">Total Equity:</label>
                        <input type="text"  id="tot_equity" class="form-control border border-info" readonly>
                        </div>
                        <div class="col-md-4">
                        <label for="" class="font-weight-bold">Total Capital:</label>
                        <input type="text"  id="tot_capital" class="form-control border border-info" readonly>
                        </div>
                        <div class="col-md-4">
                        <label for="" class="font-weight-bold">Total Cash:</label>
                        <input type="text"  id="tot_cash" class="form-control border border-info" readonly>
                        </div>
                        </div>
                        <div class="row">
                        <div class="col-md-4">
                        <label for="" class="font-weight-bold">Reinvest%:</label>
                        <input type="text"  id="reinvest" class="form-control border border-info">
                        </div>
                        <div class="col-md-4">
                        <label for="" class="font-weight-bold">Devident%:</label>
                        <input type="text"  id="discount" class="form-control border border-info">
                        </div>
                        </div>
                    </div>

                    <h3 class="text-info font_weight_bold">Transaction List</h3>
                    <div class="card">
                        <div class="card-body">
                        <table class="table table-striped">
                            <thead class="bg-info text-white">
                                <th>#</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th>Source</th>
                                <th>Remark</th>
                       </thead>
                       <tbody>
                           <?php $i =1; ?>
                            @foreach($transition as $tran)
                            <tr>
                                <td>{{$i++}}</td>
                                @if($tran->type == 1)
                                <td class="font-weight-bold text-danger">Reinvest</td>
                                @elseif($tran->type == 2)
                                <td class="font-weight-bold text-info">Withdraw</td>
                                @endif
                                <td>{{$tran->amount}}</td>
                                <td>{{$tran->date}}</td>
                                @if($tran->source == 1)
                                <td><span class="badge badge-pill badge-warning">Cash</span></td>
                                @elseif($tran->source == 2)
                                <td><span class="badge badge-pill badge-secondary">Other</span></td>
                                @endif
                                @if($tran->remark != null)
                                <td>{{$tran->remark}}</td>
                                @else
                                <td> - </td>
                                @endif
                                
                            </tr>
                            @endforeach
                       </tbody>
                    </table>
                 </div>
                </div>
                </div>
                </div>
            {{-- End detail Page --}}



        </div>
    </div>


</div>

@endsection
@section('js')
<script>
$(document).ready(function(){

    //  alert($('#select_type').val());
    $('#detaill').hide();
    // $('#generall').show();
    $('#reinvest_remarkk').hide();
    $('#withdraw_remarkk').hide();
    $('#add_plus').attr('disabled',true);
    var gene = @json($general_information);
    var sharer = @json($share_holder);  
    // alert(sharer.length);
    // alert(sharer.length);
    
    $('#share_count').val(sharer.length);
    $.each(sharer,function(i,v){
        var htmlsharer = "";
        htmlsharer +=`
        <input type="hidden" value="${i+1}" id="count">
        <input type="hidden" value="${v.id}" name="sharer_id[]">
        <div class="col-md-3 form-group">
            <input type="text" class="form-control border border-info namee" name="name[]" id="name${i+1}" value="${v.name}">
        </div>
        <div class="col-md-3 form-group">
            <input type="text" class="form-control border border-info passportt" name="nrc[]" id="nrc${i+1}" value="${v.nrc_passport}">
        </div>
        <div class="col-md-2 form-group">
            <input type="text" class="form-control border border-info positionn" name="position[]" id="position${i+1}" value="${v.position}">
        </div>
        <div class="col-md-2 form-group">
            <input type="text" class="form-control border border-info sharerr" name="amount[]" id="amount${i+1}" onkeyup="changeall('{$i+1}')" value="${v.share_percent}">
        </div>
        <div class="col-md-2 form-group">
            <input type="text" class="form-control border border-info dividd" name="divid[]" id="divid${i+1}" value="${v.devident_percent}">
        </div>
        
        `;
        $('#add_new_place').append(htmlsharer);
    });
    $.each(gene,function(i,v){
        // fill general info
        $('#old_sharer').val(v.number_shareholder);
        $('#general_id').val(v.id);
        $('#generalID').val(v.id);
        $('#generalIDE').val(v.id);
        $('#buss_name').val(v.bussiness_name);
        $('#start_capital').val(v.total_starting_capital);
        $('#reinvest').val(v.reinvest_percent);
        if(v.business_type == 1)
        {
            $(`#select_typing option[value='1']`).prop('selected', true);
        }
        else if(v.business_type == 2)
        {
            $(`#select_typing option[value='2']`).prop('selected', true);
        }
        else if(v.business_type == 3)
        {
            $(`#select_typing option[value='3']`).prop('selected', true);
        }
        $('#sharer').val(v.number_shareholder);
        $('#cashin').val(v.current_cash);
        var htmlbut = "";
        htmlbut +=`
        <button type="submit" onclick="update_submit()" class="btn btn-danger col-md-5 btn-block updatee"><i class="far fa-edit mr-2"></i>Update</button>
        `;
        $('#change_but').html(htmlbut);
        
        // end fill general info
        $('#tot_equity').val(v.current_equity);
        $('#tot_capital').val(v.current_capital);
        $('#tot_cash').val(v.current_cash);

        $('#total_cap').val(v.current_capital);
        $('#total_cas').val(v.current_cash);
    })
})
function open_but(value)
{
    $('#add_plus').attr('disabled',false);
    

}
var count = 0;
function add_new()
{
    var sharer = $('#sharer').val();
    var sharecount = $('#share_count').val();
    
    var old = $('#old_sharer').val();
    if( old > sharer)
    {
        // alert("hello");
        swal({
                title:"Less than Old value :-(",
                text:"No Less than Old Number of Sharer Holder!!",
                icon:"error",
            });
            $('#sharer').val(old);
    }


     count +=1;
     var realcount = parseInt(count) + parseInt(sharecount);
    //  alert(sharecount+count);
     var realcount = parseInt(count) + parseInt(sharecount);
    //  alert(realcount);
    if(realcount > parseInt(sharer))
    {

        swal({
                title:"Adding Sharer Problem :-(",
                text:"You can add Sharer's Info in range "+sharer+" sharer",
                icon:"error",
            });
            // $('#sharer').val(old);
    }
    else
    {
    // alert("add");
    htmladd = "";
    htmladd +=`

        <input type="hidden" value="${realcount}" id="count">
        <input type="hidden" value="${realcount}" name="sharer_id[]">
        <div class="col-md-3 form-group">
            <input type="text" class="form-control border border-info namee" name="name[]" id="name${realcount}">
        </div>
        <div class="col-md-3 form-group">
            <input type="text" class="form-control border border-info passportt" name="nrc[]" id="nrc${realcount}">
        </div>
        <div class="col-md-2 form-group">
            <input type="text" class="form-control border border-info positionn" name="position[]" id="position${realcount}">
        </div>
        <div class="col-md-2 form-group">
            <input type="text" class="form-control border border-info sharerr" name="amount[]" id="amount${realcount}" onkeyup="changeall('${realcount}')">
        </div>
        <div class="col-md-2 form-group">
            <input type="text" class="form-control border border-info dividd" name="divid[]" id="divid${realcount}">
        </div>

    `;
    $('#add_new_place').append(htmladd);
    // alert(count);

    }
}

var remark = 0;
function sharer_percent(count){
var check = $('#total_amt').val();
var num = $('#sharer').val();
var amt = $('#amount'+count).val();
// var total = 100;
remark +=1;
// alert(check);

    if(remark == 1 )
    {
        var total_amt = check - amt;
        $('#total_amt').val(total_amt);
        var check = $('#total_amt').val();
        if(check < 0)
        {
            alert("error");
            var checkin = parseInt($('#total_amt').val()) + parseInt($('#amount'+count).val());
            $('#total_amt').val(checkin);
            $('#amount'+count).val("");

        }
    }
    else
    {
        var tamt = $('#total_amt').val();
        var blur =tamt - amt;
        $('#total_amt').val(blur);
        var check = $('#total_amt').val();
        if(check < 0)
        {
            alert("error");
            var checkin = parseInt($('#total_amt').val()) + parseInt($('#amount'+count).val());
            $('#total_amt').val(checkin);
            $('#amount'+count).val("");

        }
    }






}
function changeall(count)
{
    // alert("hello");
    var num = $('#sharer').val();
    // alert($('#amount'+count).val());
    var i=1;
   var arr = [];
    for(i=1;i<=num;i++)
    {
        var amt = $('#amount'+i).val();
        // alert(amt);
        if(amt == 0)
        {
            amount = 0;
        }

        else if(amt == null)
        {
            amount = 0;
        }

        else
        {
            amount = amt;
        }
        arr.push(parseInt(amount));

    }
    // alert(arr);
    var total = 0;
    var j=0;
    for (j=0;j<arr.length;j++) {
    total += parseInt(arr[j]);
    }
    // alert(total);
    if(total > 100)
    {


        swal({
                title:"Over 100 percent :-(",
                text:"% of Sharer must share within 100 percent to each!!",
                icon:"error",
            });
            $('#amount'+count).val("");
    }
    // alert(total);



}

function locker()
{
    $('#unlocked').hide();
    var htmllock = "";
    htmllock +=`
        <span class="text-white">Locked</span>
    `;
    $('#locked').html(htmllock);
    $('#locked').show();
    //add disabled
    $('#buss_name').attr('disabled',true);
    $('#start_capital').attr('disabled',true);
    $('#reinvest').attr('disabled',true);
    $('#buss_name').attr('disabled',true);
    $('#select_typing').attr('disabled',true);
    $('#sharer').attr('disabled',true);
    $('#cashin').attr('disabled',true);
    $('.namee').attr('disabled',true);
    $('.passportt').attr('disabled',true);
    $('.positionn').attr('disabled',true);
    $('.sharerr').attr('disabled',true);
    $('.dividd').attr('disabled',true);
    $('.savee').attr('disabled',true);
    $('.updatee').attr('disabled',true);
}
function unlocker()
{
    $('#locked').hide();

    var htmlunlock = "";
    htmlunlock +=`
        <span class="text-white">UnLocked</span>
    `;
    $('#unlocked').html(htmlunlock);
    $('#unlocked').show();
    //all un disabled
    $('#buss_name').attr('disabled',false);
    $('#start_capital').attr('disabled',false);
    $('#reinvest').attr('disabled',false);
    $('#buss_name').attr('disabled',false);
    $('#select_typing').attr('disabled',false);
    $('#sharer').attr('disabled',false);
    $('#cashin').attr('disabled',false);
    $('.namee').attr('disabled',false);
    $('.passportt').attr('disabled',false);
    $('.positionn').attr('disabled',false);
    $('.sharerr').attr('disabled',false);
    $('.dividd').attr('disabled',false);
    $('.savee').attr('disabled',false);
    $('.updatee').attr('disabled',false);
}

function select_type(type){
    // alert(type);
    if(type == 2){
        // alert('detail');
        $('#detaill').show();
        $('#generall').hide();
        $('#lockk').hide();
        $('#footer').hide();
    }
    else if(type == 1){
        // alert('general');
        $('#detaill').hide();
        $('#generall').show();
        $('#lockk').show();
        $('#footer').show();
    }
}

function reinvest_typee(type){
    // alert(type);
    if(type == 1){
        // alert('cash');
        $('#reinvest_remarkk').hide();

    }
    else if(type == 2){
        // alert('other');
        $('#reinvest_remarkk').show();

    }
}


function withdraw_typee(type){
    // alert(type);
    if(type == 1){
        // alert('cash');
        $('#withdraw_remarkk').hide();

    }
    else if(type == 2){
        // alert('other');
        $('#withdraw_remarkk').show();

    }
}
function update_submit()
{
    $('#generall').submit();
}
</script>
@endsection

<!-- by zawshine -->
{{-- by nps --}}
{{-- by maymyar --}}
