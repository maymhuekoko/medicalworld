@extends('master')

@section('title','Website User')

@section('place')
  
@endsection
@section('content')
<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 col-8 align-self-center">
                <h4 class="text-themecolor" style="margin-left: 70px;">Website User Lists</h4>
            </div>
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
                                    <th>Username</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>registered Date</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $j=1;
                                ?>
                                @foreach($website_users as $list)
                                
                                <tr>
                                <td>{{$j++}}</td>
                                <td>{{$list->name}}</td>
                                <td>{{$list->username}}</td>
                                <td>{{$list->phone}}</td>
                                <td>{{$list->address}}</td>
                                <td>{{$list->registered_date}}</td>
                                <td><a href="{{route('orderdetail_list', [$list->id])}}" class="btn btn-primary text-white">Order Details</a></td>
                                

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











 

