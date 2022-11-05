@extends('master')

@section('title', 'Factory Order Details')

@section('place')
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="my-2">
                <div class="col-12 m-auto">
                    <h3>Factory Order Details</h3>

                    <div class="card my-2 py-2 px-2">
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-1 d-flex justify-content-center">
                                    <div class="col-4">Factory Order No :</div>
                                    <div class="col-8">{{$factoryOrder->factory_order_number}}</div>
                                </div>
                                <div class="mb-1 d-flex justify-content-center">
                                    <div class="col-4">Department Name : </div>
                                    <div class="col-8">{{$factoryOrder->department_name}}</div>
                                </div>
                                <div class="mb-1 d-flex justify-content-center">
                                    <div class="col-4">Remark : </div>
                                    <div class="col-8">{{$factoryOrder->remark}}</div>
                                </div>
                                <div class="mb-1 d-flex justify-content-center">
                                    <div class="col-4">Order Quantity : </div>
                                    <div class="col-8">{{$order_quantity}}</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-1 d-flex justify-content-center">
                                    <div class="col-5">Factory Order Date : </div>
                                    <div class="col-4">{{$factoryOrder->created_at->format("Y-m-d")}}</div>
                                </div>
                                <div class="mb-1 d-flex justify-content-center">
                                    <div class="col-5">Plan Date :</div>
                                    <div class="col-4">{{$factoryOrder->plan_date}}</div>
                                </div>
                                <div class="mb-1 d-flex justify-content-center">
                                    <div class="col-5">Showroom :</div>
                                    <div class="col-4">{{ucfirst($factoryOrder->showroom)}}</div>
                                </div>
                                <div class="mb-1 d-flex justify-content-center">
                                    <div class="col-4 offset-3">Factory Quantity : </div>
                                    <div class="col-8">{{$factory_item_quantity}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card py-5 px-5">
                        <table class="table table-bordered">
                            <thead>
                            <tr class="text-center text-info">
                                <th>Person Name</th>
                                <th>Person Id</th>
                                <th>Design</th>
                                <th>Fabric</th>
                                <th>Colour</th>
                                <th>PP Design</th>
                                <th>PP Color</th>
                                <th>Male</th>
                                <th>Female</th>
                                <th>Quantity</th>
                                <th>Remark</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($factoryItems as $factory)
                                <tr class="text-center" style="font-size: 13px;">
                                    <td>{{$factory->person_name}}</td>
                                    <td>{{$factory->person_id}}</td>
                                    <td>{{$factory->design_name}}</td>
                                    <td>{{$factory->fabric_name}}</td>
                                    <td>{{$factory->colour_name}}</td>
                                    <td>{{$factory->pp_design_name}}</td>
                                    <td>{{$factory->pp_colour_name}}</td>
                                    <td>{{$factory->male_size_name?? "-"}}</td>
                                    <td>{{$factory->female_size_name?? "-"}}</td>
                                    <td>{{$factory->quantity}}</td>
                                    <td style="width: 150px;">{{$factory->remark?? "-"}}</td>
                                </tr>
                            @empty
                            @endforelse

                            </tbody>
                        </table>

                    </div>
                    <div class="d-flex justify-content-center">
                        
                <select class="mr-2" id="type_select">
                    <option value="1">Portrait</option>
                   <option value="2">Landscape</option>
                </select>
            
                        @if($factoryOrder->status == 1 || $factoryOrder->status == 3)
                        <button id="print" class="btn btn-sm btn-info mr-2"><i class="fas fa-print mr-1"></i>Print</button>
                        <button class="btn btn-sm btn-primary mr-2" title="Deliver Factory Order" data-toggle="modal" data-target="#deliver{{$factoryOrder->id}}">
                            Finish
                        </button>
{{--                        Deliver Modal --}}
                        
                        
                        
                        
                        @elseif($factoryOrder->status == 2)
                            <button id="print" class="btn btn-sm btn-info mr-2"><i class="fas fa-print mr-1"></i>Print</button>
                        @endif
                    </div>

                    <div class="modal fade" id="deliver{{$factoryOrder->id}}" role="dialog" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title text-primary font-weight-bold">Finish Factory Order</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body py-3 px-5">
                                    <form action="{{route('deliverFactoryOrder',$factoryOrder->id)}}" method="post">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="">Finish Date</label>
                                            <input type="date" name="delivery_date" class="form-control form-control-sm">
                                        </div>
                                        <div class="mb-3">
                                            <label for="">Finish Remark</label>
                                            <input type="text" name="delivery_remark" class="form-control form-control-sm">
                                        </div>
                                        <div class="d-flex justify-content-center align-items-center">
                                            <div class="">
                                                <button class="btn btn-sm btn-info">Save</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card card-body border-0 px-5 py-5 printableArea d-none" id="print_area">
                        <h3 class="text-center text-info mb-3 font-weight-bold">Factory Order Details</h3>
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-1 d-flex justify-content-center">
                                    <div class="col-5">Factory Order No :</div>
                                    <div class="col-7">{{$factoryOrder->factory_order_number}}</div>
                                </div>
                                <div class="mb-1 d-flex justify-content-center">
                                    <div class="col-5">Department Name : </div>
                                    <div class="col-7">{{$factoryOrder->department_name}}</div>
                                </div>
                                <div class="mb-1 d-flex justify-content-center">
                                    <div class="col-5">Remark : </div>
                                    <div class="col-7">{{$factoryOrder->remark}}</div>
                                </div>
                                <div class="mb-1 d-flex justify-content-center">
                                    <div class="col-4">Order Quantity : </div>
                                    <div class="col-8">{{$order_quantity}}</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-1 d-flex justify-content-center">
                                    <div class="col-5">Factory Order Date : </div>
                                    <div class="col-4">{{$factoryOrder->created_at->format("Y-m-d")}}</div>
                                </div>
                                <div class="mb-1 d-flex justify-content-center">
                                    <div class="col-5">Delivery  Date :</div>
                                    <div class="col-4">{{$factoryOrder->delivery_date}}</div>
                                </div>
                                <div class="mb-1 d-flex justify-content-center">
                                    <div class="col-5">Showroom :</div>
                                    <div class="col-4">{{ucfirst($factoryOrder->showroom)}}</div>
                                </div>
                                <div class="mb-1 d-flex justify-content-center">
                                    <div class="col-4 offset-3">Factory Quantity : </div>
                                    <div class="col-8">{{$factory_item_quantity}}</div>
                                </div>
                            </div>
                            <table class="table table-bordered border-dark my-3">
                                <thead>
                                <tr class="text-center text-info" >
                                    <th style="border: 1px solid black;">Person Name</th>
                                    <th style="border: 1px solid black;">Person Id</th>
                                    <th style="border: 1px solid black;">Design</th>
                                    <th style="border: 1px solid black;">Fabric</th>
                                    <th style="border: 1px solid black;">Colour</th>
                                    <th style="border: 1px solid black;">PP Design</th>
                                    <th style="border: 1px solid black;">PP Color</th>
                                    <th style="border: 1px solid black;">Male</th>
                                    <th style="border: 1px solid black;">Female</th>
                                    <th style="border: 1px solid black;">Quantity</th>
                                    <th style="border: 1px solid black;">Remark</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($factoryItems as $factory)
                                    <tr class="text-center" style="font-size: 13px;">
                                        <td style="border: 1px solid black;">{{$factory->person_name}}</td>
                                        <td style="border: 1px solid black;">{{$factory->person_id}}</td>
                                        <td style="border: 1px solid black;">{{$factory->design_name}}</td>
                                        <td style="border: 1px solid black;">{{$factory->fabric_name}}</td>
                                        <td style="border: 1px solid black;">{{$factory->colour_name}}</td>
                                        <td style="border: 1px solid black;">{{$factory->pp_design_name}}</td>
                                        <td style="border: 1px solid black;">{{$factory->pp_colour_name}}</td>
                                        <td style="border: 1px solid black;">{{$factory->male_size_name?? "-"}}</td>
                                        <td style="border: 1px solid black;">{{$factory->female_size_name?? "-"}}</td>
                                        <td style="border: 1px solid black;">{{$factory->quantity}}</td>
                                        <td style="border: 1px solid black;width: 150px;">{{$factory->remark?? "-"}}</td>
                                    </tr>
                                @empty
                                @endforelse

                                </tbody>
                            </table>
                        </div>

                    </div>
            </div>
        </div>
        <input type="hidden" id="order_id" value="{{$factoryOrder->id}}">
        <input type="hidden" id="print_status" value="{{$factoryOrder->print_status}}">
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            $("#print").click(function() {
                var order_id = $('#order_id').val();
                var print_status = $('#print_status').val();
                var print_type = $('#type_select').val();
                var degree = 90;
                if(print_status == 0){
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('changePrintStatus') }}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "order_id": order_id,
                        },
                        success: function(data) {
                            if(data == 1){
                                console.log("status change success");
                            }
                        }
                    });
                }
                $(".printableArea").toggleClass("d-none");
                var mode = 'iframe'; //popup
                var close = mode == "popup";
                var options = {
                    mode: mode,
                    popClose: close,
                };
                if(print_type == 2){
                    $("#print_area").css({ transform: 'rotate(' + degree + 'deg)',width:'250mm',height: '270mm'});
                    
                }
               
                $("div.printableArea").printArea(options);
                
                $(".printableArea").toggleClass("d-none");
                if(print_type == 2){
                     $("#print_area").css({ transform: 'rotate(' + 360 + 'deg)'});
                     
                }
                
            });
        });
    </script>
@endsection




