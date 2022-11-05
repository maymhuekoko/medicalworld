@extends('master')

@section('title','Item Adjust Lists')

@section('place')

@endsection


@section('content')
    <section id="plan-features">
        

        <div class="row ml-2 mt-3">
            @csrf
            <div class="col-md-2">
                <label class="control-label font-weight-bold">From Date</label>
                <input type="date" name="from_date" id="from_date" class="form-control" value="{{ $current_date }}" required>
            </div>
            
            <div class="col-md-2">
                <label class="control-label font-weight-bold">To Date</label>
                <input type="date" name="to_date" id="to_date" class="form-control" value="{{ $current_date }}" required>
            </div>
            
            <div class="col-md-1 m-t-30">
                <button class="btn btn-info px-4" id="search_itemadjust">Search</button>
            </div>
            
        </div>
        <br />

        <div class="container">
            <div class="card">
                <div class="card-body shadow">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive text-black">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang('lang.date')</th>
                            <th>@lang('lang.item') @lang('lang.name')</th>
                            <th>Old Qty</th>
                            <th>Adjust Qty</th>
                            <th>@lang('lang.new_qty')</th>
                            <th>Changed By</th>]
                            <th>Remark</th>
                            
                            {{-- <th class="text-center">@lang('lang.action')</th> --}}
                        </tr>
                    </thead>
                    <tbody id="item_list">
                        <?php $i=1;?>
                        @foreach($item_adjusts as $item_adjust)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$item_adjust->adjust_date}}</td>
                                <td>{{$item_adjust->counting_unit->unit_name}}</td>
                                <td>{{$item_adjust->oldstock_qty}}</td>
                                <td>{{$item_adjust->adjust_qty}}</td>
                                <td>{{$item_adjust->newstock_qty}}</td>
                                <td>{{$item_adjust->user->name}}</td>
                                <td>{{$item_adjust->adjust_remark ?? '-'}}</td>
                          
                             
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

        
    </section>

@endsection

@section('js')

    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>

    {{-- <script src="{{asset('assets/js/jquery.slimscroll.js')}}"></script> --}}
    <script src="{{ asset('js/jquery.PrintArea.js') }}" type="text/JavaScript"></script>

    <script type="text/javascript">
        $('#item_table').DataTable({

            "paging": false,
            "ordering": true,
            "info": false

        });

        // $('#slimtest2').slimScroll({
        //     color: '#00f',
        //     height: '600px'
        // });

        // $('#slimtest3').slimScroll({
        //     color: '#00f',
        //     height: '600px'
        // });
        $(document).ready(function() {
            
        });
        
        $('#search_itemadjust').click(function(){
            
            
            var from = $('#from_date').val();
            var to = $('#to_date').val();
            console.log(from,to);
            $.ajax({

            type: 'POST',

            url: '{{ route('search_itemadjust') }}',

            data: {
                "_token": "{{ csrf_token() }}",
                'to' : to,
                "from" : from,
            },

            success: function(data) {
                console.log(data);
                if (data.length >0) {
                    var html = '';
                    $.each(data, function(i, itemadjust) {
                       
                        html += `
                    <tr class="text-center">
                          <td class="text-left">${++i}</td>
                                <td class="text-left">${itemadjust.adjust_date}</td>
                                <td class="text-left">${itemadjust.counting_unit.unit_name}</td>
                                <td class="text-left">${itemadjust.oldstock_qty}</td>
                                <td class="text-left">${itemadjust.adjust_qty}</td>
                                <td class="text-left">${itemadjust.newstock_qty}</td>
                                <td class="text-left">${itemadjust.user.name}</td>          
                    </tr>
                    `;
                    

                    })
                    
                    $('#item_list').empty();
                        $('#item_list').html(html);
                        

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
        
    </script>

@endsection
