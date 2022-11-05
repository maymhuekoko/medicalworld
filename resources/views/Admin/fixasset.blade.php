@extends('master')

@section('title','Fix Asset Page')

@section('place')

@endsection
@section('content')

<div class='container'>
<div class="row mb-3">
    <div class="col-md-6">
        <h4 class="text-black">Fixed Asset Lists</h4>
    </div>
    <div class="col-md-6">
        <a href="{{route('addasset')}}" class="btn bg-primary text-white float-right"><i class="fas fa-plus mr-2"></i>Add Asset</a>
    </div>
</div>


<div class="card">
    <div class="card-body">
        <table class="table table-striped text-black">
            <thead class="bg-info text-white">
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>Start Date</th>
                <th>Purchase Initial Price</th>
                <th>Salvage Value</th>
                {{-- <th>Current Value</th> --}}
                <th>Depreciate Total</th>
                <th>Used Life</th>
                <th class="text-center">Action</th>
              </tr>
            </thead>
            <tbody>
                <?php $i=1 ?>
              @foreach ($done as $asset)
              <tr>
                 <td>{{$i++}}</td>
                 <td>{{$asset->name}}</td>
                 <td>{{$asset->start_date}}</td>
                 <td>{{$asset->initial_purchase_price}}</td>
                 <td>{{$asset->salvage_value}}</td>
                 {{-- <td>{{$asset->current_value}}</td> --}}
                 <td>{{$asset->depriciation_total}}</td>
                 <td>{{$asset->used_years}}</td>
                 <td>
                    <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#sell_end{{$asset->id}}" onclick="precheck('{{$asset->id}}','{{$asset->used_years}}','{{$asset->use_life}}')">Sell/End</button>

                 </td>
              </tr>



  <!--start Sell / End Modal -->
  <div class="modal fade" id="sell_end{{$asset->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-info">
          <h5 class="modal-title text-white" id="exampleModalLabel">{{$asset->name}}'s Sell/End </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{route('store_sell_end')}}" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{$asset->id}}">
         <div class="modal-body">

           <div class="row offset-md-3">

            <div class="form-check form-check-inline ml-5" id="sellhide{{$asset->id}}">
                <input class="form-check-input" type="radio" name="exist_asset" id="sell{{$asset->id}}" value="1" onclick="show_sell('{{$asset->id}}')">
                <label class="form-check-label text-success" for="sell{{$asset->id}}">Sell</label>
              </div>
              <div class="form-check form-check-inline" id="endhide{{$asset->id}}">

                <input class="form-check-input" type="radio" name="exist_asset" id="end{{$asset->id}}" value="2" onclick="show_end('{{$asset->id}}','{{$asset->used_years}}','{{$asset->use_life}}')">
                <label class="form-check-label text-success" for="end{{$asset->id}}">End</label>
            </div>
          </div>

        <div class="form-group current_value" id="current_value{{$asset->id}}">
            <label for="">Current Value</label>
            <input type="text" class="form-control" name="current_value" readonly value="{{$asset->current_value}}">
        </div>
        <div class="form-group sell_price" id="sell_price{{$asset->id}}" oninput="profitloss('{{$asset->id}}',{{$asset->current_value}})">
            <label for="">Sell Price</label>
            <input type="text" class="form-control" name="sell_price" id="selll{{$asset->id}}">
        </div>
        <div class="form-group sell_date" id="sell_date{{$asset->id}}">
            <label for="">Sell Date</label>

            <input type="date" name="sell_date{{$asset->id}}" id="sell_dater{{$asset->id}}" class="form-control">

        </div>
        <div class="form-group profit_loss" id="profit_loss{{$asset->id}}">
            <label for="">Profit/Loss</label>
            <input type="text" class="form-control" name="profit_loss" readonly id="pfloss{{$asset->id}}">
        </div>
        <div class="form-group used_year" id="used_year{{$asset->id}}">
            <label for="">Used Year</label>
            <input type="text" class="form-control" name="used_year" disabled value="{{$asset->used_years}}">
        </div>
        <div class="form-group remaining_year" id="remaining_year{{$asset->id}}">
            <label for="">Remaining Year</label>
            <input type="text" class="form-control" name="remaining_year" readonly id="remain_year{{$asset->id}}">
        </div>
        <div class="form-group remark" id="remark{{$asset->id}}">
            <label for="">Remark</label>

            <input type="text" name="remark" id="remarkk{{$asset->id}}" class="form-control">
        </div>
        <div class="form-group end_date" id="end_date{{$asset->id}}">
            <label for="">End Date</label>
            <input type="date" name="end_date" id="end_dater{{$asset->id}}" class="form-control">

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
      </div>
    </div>
  </div>
 <!--end Sell / End Modal -->
              @endforeach
            </tbody>
        </table>
    </div>
</div>

</div>


@endsection

@section('js')
<script>
$(document).ready(function(){





    $('.used_year').hide();
   $('.remaining_year').hide();
   $('.remark').hide();
   $('.end_date').hide();


})

// function sell(){
//     $('.used_year').hide();
//    $('.remaining_year').hide();
//    $('.remark').hide();
//    $('.end_date').hide();

//    $('.current_value').show();
//    $('.sell_price').show();
//    $('.sell_date').show();
//    $('.profit_loss').show();
// }

// function end(){
//    $('.current_value').hide();
//    $('.sell_price').hide();
//    $('.sell_date').hide();
//    $('.profit_loss').hide();

//    $('.used_year').show();
//    $('.remaining_year').show();
//    $('.remark').show();
//    $('.end_date').show();
// }

function precheck(value,used,use)
{
    $('#sell'+value).prop('checked',true);
    $.ajax({

          type:'POST',

          url:'/getsell_end',

          data:{
          "_token":"{{csrf_token()}}",
          "asset_id":value,
          },

          success:function(data){
            // $('#remaining_year'+value).val(remain);
              if(data.flag == 1)
              {
                $('#endhide'+value).hide();
                $('#sellhide'+value).hide();
                $('#selll'+value).val(data.asset.sell_price);
                $('#sell_dater'+value).val(data.asset.sell_date);
                $('#pfloss'+value).val(data.asset.profit_loss_value);

              }
              else if(data.flag == 2)
              {
                var remain = use - used;
                // alert(remain);
                $('#remain_year'+value).val(remain);
                $('#endhide'+value).hide();
                $('#sellhide'+value).hide();
                $('#current_value'+value).hide();
                $('#sell_price'+value).hide();
                $('#sell_date'+value).hide();
                $('#profit_loss'+value).hide();
                $('#remaining_year'+value).show();
                $('#used_year'+value).show();


                $('#remark'+value).show();
                $('#end_date'+value).show();


                $('#remarkk'+value).val(data.asset.end_remark);
                $('#end_dater'+value).val(data.asset.end_date);
              }
          }
    });

}
function show_sell(id)
{
  $('#current_value'+id).show();
   $('#sell_price'+id).show();
   $('#sell_date'+id).show();
   $('#profit_loss'+id).show();

  $('#used_year'+id).hide();
   $('#remaining_year'+id).hide();
   $('#remark'+id).hide();
   $('#end_date'+id).hide();

}
function show_end(id,used,use_life)
{
  $('#current_value'+id).hide();
   $('#sell_price'+id).hide();
   $('#sell_date'+id).hide();
   $('#profit_loss'+id).hide();

   $('#used_year'+id).show();
   $('#remaining_year'+id).show();
   $('#remark'+id).show();
   $('#end_date'+id).show();

//    alert(used);
    //   alert(use_life);
   var remain = use_life - used;
//    alert(remain);
   $('#remain_year'+id).val(remain);
}

function profitloss(val,curr){
    // alert(val);
   var sell =  $('#selll'+val).val();
   var profit_loss =  parseInt(sell - curr) ;
    // alert(profit_loss);
    $('#pfloss'+val).val(profit_loss);
}

</script>

@endsection


