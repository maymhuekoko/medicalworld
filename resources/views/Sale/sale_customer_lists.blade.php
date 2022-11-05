@extends('master')

@section('title','Sale Page')

@section('place')
  
@endsection
@section('content')
<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 col-8 align-self-center">
                <h4 class="text-themecolor m-b-0 m-t-0">Sale Customer Lists</h4>
               
            </div>
            <button class="btn btn-sm rounded btn-primary" onclick=collect_data()>Run</button>
        </div>
        <section id="plan-features">
            <div class="container">
                <div class="card">
                    <div class="card-body shadow">
                        <div class="tab-content br-n pn">
                            <div id="navpills-1" class="tab-pane active">
                            <table class="table table-striped text-black">
                                <thead>
                                <tr>
                                <th>No</th>
                                    
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Purchase Amount</th>
                                    <th>Purchase Quantity</th>
                                    <th>Purchase Times</th>
                                    <th>Last Purchase Date</th>
                                    <th>Credit Amount</th>
                                    <th>Detail</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $j=1;
                                ?>
                                @foreach($sale_customer as $list)
                                
                                <tr>
                                <td>{{$j++}}</td>
                                <td>{{$list->name}}</td>
                                <td>{{$list->phone}}</td>
                                <td>{{$list->total_purchase_amount}}</td>
                                <td>{{$list->total_purchase_quantity}}</td>
                                <td>{{$list->total_purchase_times}}</td>
                                <td>{{$list->last_purchase_date ?? '-'}}</td>
                                <td>{{$list->credit_amount ?? 0}}</td>
                                <td><a href="{{route('credit',$list['id'])}}"><button type="button" class="btn btn-primary">Credit Detail</button></a></td>

                                </tr>
       
                                @endforeach
                                </tbody>
                            </table>
                            @endsection


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>
</div>

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
    
    function collect_data() {

            $.ajax({
                            type: 'POST',
                            url: 'collect_salescustomer_data',
                            dataType: 'json',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                
                            },

                            success: function(data) {

                                if(data == 1){
                                swal({
                                    title: "Success!",
                                    text: "Successfully Deleted!",
                                    icon: "success",
                                });
                                }

                                setTimeout(function() {
                                    window.location.reload();
                                }, 1000);


                            },
                        });
        }

</script>

@endsection










 

