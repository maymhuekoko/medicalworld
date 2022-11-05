@extends('master')

@section('title', 'itemrequest Details')

@section('place')

@endsection

@section('content')

    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h4 class="font-weight-normal">@lang('lang.itemrequest') @lang('lang.details') @lang('lang.page')</h4>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header">
                    <h4 class="font-weight-bold mt-2">@lang('lang.itemrequest') @lang('lang.details')</h4>
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-6">

                            <div class="row">
                                <div class="font-weight-bold text-primary col-md-5">အမှီပို့ရမည့် Date</div>
                                <h5 class="font-weight-bold col-md-4 mt-1">
                                    {{ date('d-m-Y', strtotime($itemrequest->date)) }}
                                </h5>
                            </div>

                            <div class="row mt-1">
                                <div class="font-weight-bold text-primary col-md-5">ပေးပို့အရေတွက် @lang('lang.quantity')
                                </div>
                                <h5 class="font-weight-bold col-md-4 mt-1">{{ $itemrequest->total_quantity }}</h5>
                            </div>

                            <div class="row mt-1">
                                <div class="font-weight-bold text-primary col-md-5">Request By</div>
                                <h5 class="font-weight-bold col-md-4 mt-1">{{ $itemrequest->user->name }}</h5>
                            </div>
                            <div class="row mt-1">
                                <div class="font-weight-bold text-primary col-md-5">From</div>
                                <h5 class="font-weight-bold col-md-4 mt-1">{{ $itemrequest->from->name }}</h5>
                            </div>
                            <div class="row mt-1">
                                <div class="font-weight-bold text-primary col-md-5">Status</div>

                                @if ($itemrequest->status)
                                    <span class="badge badge-success pt-2">Send</span>
                                    <button id="print" class="btn btn-primary float-right ml-5">Print</button>

                                    @if (session()->get('user')->role == 'Owner')
                                        {{-- <button id="print" class="btn btn-primary float-right ml-5">Print</button> --}}
                                    @endif
                                @else
                                    <span class="badge badge-danger pt-1">pending</span>

                                @endif
                            </div>
                            <div class="row mt-4">
                                <button id="print" class="btn btn-primary float-right ml-5">Print</button>
                            </div>

                        </div>
                        <form id="requestitem_form" action="{{ route('requestitemssend') }}" method="post">
                            {{-- 0 = can submit form (no error) - 1 stock error (no submit form) --}}
                            <input type="hidden" value="0" id="checkstockerror">
                            @csrf
                            <div class="col-md-8" style="margin-left:auto;margin-right:auto;">
                                <h4 class="font-weight-bold mt-2 text-primary text-center">Request Items</h4>
                                <div class="table-responsive text-black">
                                    <table class="table" id="example23">
                                        <thead>
                                            <tr>
                                                <th>@lang('lang.index')</th>
                                                <th>@lang('lang.unit') @lang('lang.name')</th>
                                                <th>@lang('lang.request_qty')</th>
                                                @if (session()->get('user')->role == 'Owner')
                                                    <th>@lang('lang.current_qty')</th>
                                                @endif
                                                <th>@lang('lang.send_qty')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i = 1;
                                            @endphp
                                            @foreach ($itemrequest->counting_units as $unit)
                                                @foreach ($items as $item)
                                                    @if ($item->counting_units)
                                                        @foreach ($item->counting_units as $counting_unit)
                                                            @foreach ($counting_unit->stockcount as $stock)
                                                                @if ($stock->from_id == 1 && $stock->counting_unit_id == $unit->id)
                                                                    <tr>
                                                                        <td>{{ $i++ }}</td>
                                                                        <td>{{ $unit->unit_name }}</td>
                                                                        <td>{{ $unit->pivot->quantity }}</td>
                                                                        @if (session()->get('user')->role == 'Owner')
                                                                            <td>{{ $stock->stock_qty }}</td>
                                                                        @endif
                                                                        @if (session()->get('user')->role == 'Owner')
                                                                            <td>
                                                                                <input type="number" @if ($itemrequest->status == 1)
                                                                                disabled
                                                                        @endif
                                                                        value="{{ $unit->pivot->send_quantity ?? 0 }}"
                                                                        class="form-control text-black check_stock"
                                                                        data-currentstock="{{ $stock->stock_qty }}"
                                                                        data-id="{{ $unit->id }}" name="sentqty[]">
                                                                        <p id="stockerror{{ $unit->id }}"
                                                                            style="font-size: 12px;"
                                                                            class="text-danger font-weight-bold d-none">
                                                                            stock မရှိပါ</p>
                                                                        </td>
                                                                    @else
                                                                        <td><input type="text"
                                                                                value="{{ $unit->pivot->send_quantity ?? 0 }}"
                                                                                class="form-control" readonly></td>
                                                                @endif
                                                                </tr>
                                                                <input type="hidden" value="{{ $itemrequest->id }}"
                                                                    name="itemrequest_id">
                                                                <input type="hidden" value="{{ $unit->id }}"
                                                                    name="counting_units[]">
                                                                <input type="hidden" value="{{ $itemrequest->from_id }}"
                                                                    name="shop_id">
                                                            @endif
                                                        @endforeach

                                                    @endforeach
                                                @endif
                                            @endforeach

                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @if (session()->get('user')->role == 'Owner' && $itemrequest->status == 0)
                                    <div class="row justify-content-center">
                                        <button id="senditemrequest" class="btn btn-info px-3">Send</button>
                                    </div>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="navpills-2" class="tab-pane d-none">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card card-body printableArea">
                    <div style="display:flex;justify-content:space-around">
                        <div>
                            <img src="{{ asset('image/Shwe_Kyar_Phyu.png') }}">
                        </div>

                        <div>
                            <h3 class="mt-1 text-center"> &nbsp;<b
                                    style="font-size: 40px;">ရွှေကြာဖြူ</b><span>(ပင်လယ်စာနှင့်အကင်အမျိုးမျိုး)</span></h3>

                            <p class="mt-2" style="font-size: 20px;"> အမှတ်-၆၆၃၊ သမိန်ဗရမ်းလမ်း၊ ၃၅ရပ်ကွက်၊
                                ဒဂုံမြို့သစ်မြောက်ပိုင်းမြို့နယ်၊ ရန်ကုန်မြို့။
                                <br /><i class="fas fa-mobile-alt"></i> 09-420022490 , 09-444345502 , 09-955132320
                            </p>
                        </div>

                        <div></div>
                    </div>
                    <div class="row text-black">

                        <div class="col-md-12">
                            <h3 class=" mt-2 text-black" style="font-size : 25px">@lang('lang.date') Name :
                                {{ $itemrequest->user->name }} </h3>
                        </div>
                        <div class="col-md-12">
                            <h3 class=" mt-2 text-black" style="font-size : 25px; color:black">@lang('lang.date') ဆိုင်သို့
                                : {{ $itemrequest->from->name }} </h3>
                        </div>
                        <div class="col-md-12">
                            <h3 class=" mt-2 text-black" style="font-size : 25px">@lang('lang.date') အမှီပို့ရန် :
                                {{ $itemrequest->date }} </h3>
                            <br>
                        </div>
                    </div>

					
                    <div class="row">
                        <div class="col-md-12">
                            <table style="width: 100%; ">
                                <thead class="text-center">
                                    <tr>
                                        <th
                                            style="font-size:20px; font-weight:bold; height: 15px; border: 2px solid black;">
                                            @lang('lang.number')</th>
                                        <th
                                            style="font-size:20px; font-weight:bold; height: 15px; border: 2px solid black;">
                                            @lang('lang.item')</th>
                                        <th
                                            style="font-size:20px; font-weight:bold; height: 15px; border: 2px solid black;">
                                            တောင်းခံ အရေတွက်</th>
                                        <th
                                            style="font-size:20px; font-weight:bold; height: 15px; border: 2px solid black;">
                                            လက်ရှိအရေတွက်</th>
                                        <th
                                            style="font-size:20px; font-weight:bold; height: 15px; border: 2px solid black;">
                                            ပေးပို့အရေတွက်</th>

                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    @php
                                        $i = 1;
                                        $totalvalue = 0;
                                    @endphp

                                    @foreach ($itemrequest->counting_units as $key => $unit)
                                        @php
                                            $totalvalue += (int) $unit->purchase_price;
                                        @endphp
                                        <tr>
                                            <td style="font-size:20px;height: 8px; border: 2px solid black;">
                                                {{ $i++ }}</td>
                                            <td style="font-size:20px;height: 8px; border: 2px solid black;">
                                                {{ $unit->unit_name }}</td>
                                            <td style="font-size:20px;height: 8px; border: 2px solid black;">
                                                {{ $unit->pivot->quantity }}</td>
                                            @foreach ($unit->stockcount as $stock)

                                                @if ($stock->from_id == 1 && $stock->counting_unit_id == $unit->id)

                                                    <td style="font-size:20px;height: 8px; border: 2px solid black;">
                                                        {{ $stock->stock_qty }}</td>

                                                @endif
                                            @endforeach
                                            <td style="font-size:20px;height: 8px; border: 2px solid black;">
                                                {{ $itemrequest->status ? $unit->pivot->send_quantity : '' }}</td>
                                        </tr>

                                    @endforeach
                                    <tr>
                                        <td colspan="3"></td>
                                        <td style="font-size:20px;height: 8px; border: 2px solid black;">Total (MMK)</td>
                                        <td style="font-size:20px;height: 8px; border: 2px solid black;">
                                            {{ $totalvalue }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        {{-- <br>
					<br> --}}
                        {{-- <div class="row mt-2">
						<div class="col-md-6">
							<h3 class="text-info font-weight-bold" style="font-size:20px;">
								Name - {{$itemrequest->user->name}}<span id="cus_name"> </span>
							</h3>
						</div>

						<div class="col-md-6 text-right">
							<h3 class="text-info font-weight-bold" style="font-size:20px;">
								ဆိုင်သို့ - <span id=""> {{$itemrequest->from->name}} </span>
							</h3>
						</div>
					</div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')

    <script src="{{ asset('js/jquery.PrintArea.js') }}" type="text/JavaScript"></script>


    <script type="text/javascript">
        $('#print').click(function() {
            var mode = 'iframe'; //popup
            var close = mode == "popup";
            var options = {
                mode: mode,
                popClose: close
            };

            $(".tab-pane div.printableArea").printArea(options);
        });

        $('.check_stock').keyup(function() {
            var currentstock = $(this).data('currentstock');
            var id = $(this).data('id');
            var sendqty = parseInt($(this).val());
            if (sendqty > currentstock) {
                $('#checkstockerror').val(1);
                $(this).addClass('is-invalid');
                $(`#stockerror${id}`).removeClass('d-none');
                console.log(`#stockerror${id}`);
            } else {
                $('#checkstockerror').val(0);
                $(this).removeClass('is-invalid');
                $(this).addClass('is-valid');
                $(`#stockerror${id}`).addClass('d-none');
            }

        })
        $('#senditemrequest').click(function(e) {
            e.preventDefault();
            var checkstockerror = parseInt($('#checkstockerror').val());
            if (checkstockerror == 1) {
                swal({
                    title: "Error",
                    text: "Stock ပြန်စစ်ပါ!",
                    icon: "error",
                });
            } else {
                $('#requestitem_form').submit();
            }
        })
    </script>
@endsection
