@extends('master')

@section('title','Item Detail')

@section('place')
  
@endsection
@section('content')
<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 col-8 align-self-center">
                <h4 class="text-themecolor" style="margin-left: 70px;">Item Details</h4>
            </div>
        </div>
        <section id="plan-features">
            <div class="container">
                <div class="card">
                    <div class="card-body shadow">
                        <div class="tab-content br-n pn">
                            <div id="navpills-1" class="tab-pane active">
                                <div class="card-header">
                                    Item Info
                                </div>
                            
                                <div style="width: 100%; display: flex; flex-wrap:wrap;">
                                    @foreach($unitarr as $unit)
                                    <div class="card-body" style="min-width: 50%;">
                                        <h5 class="card-title">Item id: &nbsp;<b>{{$unit->id}}</b></h5>
                                        <h5 class="card-title">Item name: &nbsp;<b>{{$unit->unit_name}}</b></h5>
                                        <h5 class="card-title">Item code: &nbsp;<b>{{$unit->unit_code}}</b></h5>
                                        <h5 class="card-title">Design id: &nbsp;<b>{{$unit->design_id}}</b></h5>
                                        <h5 class="card-title">Fabric id: &nbsp;<b>{{$unit->fabric_id}}</b></h5>
                                        <h5 class="card-title">Color id: &nbsp;<b>{{$unit->colour_id}}</b></h5>
                                        <h5 class="card-title">Size id: &nbsp;<b>{{$unit->size_id}}</b></h5>
                                        <h5 class="card-title">Gender id: &nbsp;<b>{{$unit->gender_id}}</b></h5>
                                        <h5 class="card-title">Item id: &nbsp;<b>{{$unit->item_id}}</b></h5>
                                        <!-- <a href="" class="btn btn-primary"></a> -->
                                    </div>
                                    @endforeach
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection











 

