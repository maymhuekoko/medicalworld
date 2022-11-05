@extends('master')

@section('title','Add Asset Registration')

@section('place')

@endsection
@section('content')
<div class="container">
    <div class="card">
    <div class="card-header bg-info">
      <h3 class="card-title text-white" id="exampleModalLabel">New Asset Registration</h3>
    </div>
    <div class="card-body">
        <div class="row">
        <div class="col-md-6">
        <form action="{{route('store_asset')}}" method="post">
            @csrf
        <div class="form-group">
            <label class="text-success">Name</label>
            <input type="text" class="form-control" name="asset_name" placeholder="Enter Asset Name">
        </div>
        <div class="form-group">
            <label class="text-success">Description</label>
            <input type="text" class="form-control" name="asset_description" placeholder="Enter Asset Description">
        </div>
        <div class="form-group">
            <label class="text-success">Type</label>
            <select id="asset_type" name="type" class="form-control">
                <option value="0" selected hidden>Select Asset Type</option>
                <option value="1">Home</option>
                <option value="2">Vehicle</option>
                <option value="3">Machinery</option>
            </select>
        </div>
        <div class="form-group">
            <label class="text-success">Purchase Initial Price</label>
            <input type="text" class="form-control" name="purchase_initial_price" id="initial_price" placeholder="Enter Purchase Initial Price" value="0">
        </div>
        <div class="form-group">
            <label class="text-success">Salvage Value</label>
            <input type="text" class="form-control" name="salvage_value" id="salvage" placeholder="Enter Salvage Value" value="0">
        </div>
        <div class="form-group">
            <label class="text-success">Use Life</label>
            <input type="text" class="form-control" name="use_life" id="uselife" placeholder="Enter Use Life" onkeyup="calculate_year_dep(this.value)">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="text-success">Year Depriciation</label>
            <input type="text" class="form-control" name="year_depriciation" id="year_dep" readonly>
        </div>
        <div class="form-group">
            <label class="text-success">Existing Asset</label>
            <div class="form-check form-check-inline ml-5">
                <input class="form-check-input" type="radio" name="exist_asset" id="inlineRadio1" value="1" onclick="oldradio()">
                <label class="form-check-label text-success" for="inlineRadio1">Yes</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="exist_asset" id="inlineRadio2" value="2" onclick="newradio()">
                <label class="form-check-label text-success" for="inlineRadio2">No</label>
              </div>
        </div>
        <div class="form-group" id="used_year">
            <label class="text-success">Used Year</label>
            <input type="text" class="form-control" name="used_year" id="use_year" placeholder="Enter Used Year">
        </div>
        <div class="form-group" id="dept_tot">
            <label class="text-success">Depriciation Total</label>
            <input type="text" class="form-control" name="depriciation_total" id="dep_total" placeholder="Enter Depriciation Total" readonly>
        </div>
        <div class="form-group">
            <label class="text-success">Current Price</label>
            <input type="text" class="form-control" name="current_value" id="current_price" placeholder="Enter Current Value" readonly>
        </div>
        <div class="form-group">
            <label class="text-success">Start Date</label>
            <input type="date" class="form-control" name="start_date">
        </div>
    </div>
        </div>
    </div>
    <div class="card-footer">
      <button type="submit" class="btn btn-primary float-right">Save</button>
    </div>
  </form>
    </div>
  </div>

  @endsection
  @section('js')
  <script>
      $( document ).ready(function() {
            $('#used_year').hide();
            $('#dept_tot').hide();
       });
function calculate_year_dep(value){
    // alert("idiot");
    var initial_price = $('#initial_price').val();
    var salvage = $('#salvage').val();
    // alert(initial_price+"----"+salvage);
    var year_dep =parseInt((initial_price-salvage)/value);
    $('#year_dep').val(year_dep);
}
function oldradio(){
    // alert('old');
    $('#used_year').show();
    $('#dept_tot').show();
}
function newradio(){
    // alert('new');
    $('#used_year').hide();
    $('#dept_tot').hide();
    var initial_price = $('#initial_price').val();
    $('#current_price').val(initial_price);
}

$( "#used_year" ).keyup(function() {
//   alert( "Handler for .keyup() called." );
    var dep_tot = $('#use_year').val() * $('#year_dep').val();
    $('#dep_total').val(dep_tot);
    var current_price = $('#initial_price').val() - $('#dep_total').val();
    $('#current_price').val(current_price);
});

  </script>
  @endsection
