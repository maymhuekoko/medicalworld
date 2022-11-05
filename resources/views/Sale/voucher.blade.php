@extends('master')

@section('title','Voucher Page')

@section('place')
<style>
    .discount{
        cursor: pointer
    }
</style>
<div class="col-md-5 col-8 align-self-center">
    <h4 class="text-themecolor m-b-0 m-t-0">Sale Page</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('index')}}">Back to Dashborad</a></li>
        <li class="breadcrumb-item active">Sale Page</li>
        {{-- Voucher Discount --}}
        <button id="voucher_discount" class="btn btn-warning ml-5" type="button" data-toggle="modal" data-target="#discount"><span><i class="fa fa-save mr-3"></i>Voucher Discount</span></button>
        {{-- End Voucher Discount --}}
    </ol>
</div>
{{-- Begin Discount Modal --}}
<div class="modal fade" id="discount" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h4 class="modal-title text-white">Item Price</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="#close_modal">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body" id="checkout_modal_body">
                <input type="text" id="vou_discount" name="vou_discount">
                {{-- <div class="form-group">
                    <label class="form-control font-weight-bold">Voucher Total</label>
                    <input type="text" class="form-control" readonly id="voucher_total" value="{{$grand->sub_total}}">
                </div> --}}
                <div class="form-check form-switch float-right">
                    <input class="form-check-input" name="foc" type="checkbox" id="foc" value="1">
                    <label class="form-check-label" for="foc">FOC</label>
                  </div>
                <div class="form-group">
                    <label class="font-weight-bold">@lang('lang.price') <span id="discount_amount" class="text-danger"></span> mmk<span>(Voucher Total)</span></label>
                    <input type="number" id="price_change" class="form-control" required value="{{$grand->sub_total}}">
                    <input type="hidden" id="or_price" value="{{$grand->sub_total}}">
                </div>
                <div class="row">
                    <div class="col-6 form-check form-switch">
                        <input class="form-check-input" name="percent_for_price" type="checkbox" value="1" id="percent_for_price">
                        <label class="form-check-label" for="percent_for_price">(%)</label>
                    </div>
                    <div class="form-group col-6">
                        <input type="number" id="percent_price" class="form-control" disabled>
                    </div>
                </div>

                  <button type="button" class="btn btn-info" id="price_change_btn" btn-lg btn-block">Change Price</button>
            </div>


        </div>
    </div>
</div>
{{-- End Discount Modal --}}
@endsection

@section('content')

<style>

    h6{
        font-size:15px;
        font-weight:600;
        line-height: 80%;
        letter-spacing: -1px;
    }
</style>

<div class="row">
   <div class="card col-md-9">
        <div class="card-body">
            <ul class="nav nav-pills m-t-30 m-b-30">
                <li class="nav-item">
                    <a href="#navpills-1" class="nav-link active" data-toggle="tab" aria-expanded="false">
                        Option One
                    </a>
                </li>
                <li class=" nav-item">
                    <a href="#navpills-2" class="nav-link" data-toggle="tab" aria-expanded="false">
                        Option Two
                    </a>
                </li>
            </ul>
            <br />
            <div class="tab-content br-n pn">
                <div id="navpills-1" class="tab-pane active">
                        <div class="row justify-content-center">
                            <div class="col-md-5 printableArea" style="width:45%;">
                                <div class="card card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="text-center">
                                                <address>
                                                    <h5> &nbsp;<b class="text-center text-black">ရွှေကြာဖြူ</b></h5>
                                                    <h6 class="text-black">ပင်လယ်စာနှင့်အကင်အမျိုးမျိုး လက်လီ/လက်ကားဖြန့်ချီရေး</h6>
                                                    <h6 class="text-black">အမှတ်-၆၆၃၊ သမိန်ဗရမ်းလမ်း၊ ၃၅ရပ်ကွက်</h6>
                                                    <h6 class="text-black">ဒဂုံမြို့သစ်မြောက်ပိုင်းမြို့နယ်၊ ရန်ကုန်မြို့။</h6>
                                                    <h6 class="text-black"><i class="fas fa-mobile-alt"></i> 09 - 420022490</h6>
                                                </address>
                                            </div>
                                            <div class="pull-right text-left">
                                                <h6 class="text-black">Date : <i class="fa fa-calendar"></i> {{$today_date}}</h6>
                                                <h6 class="text-black">Voucher Number : {{$voucher_code}}</h6>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="table-responsive text-black" style="clear: both;">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr class="text-black">
                                                            <th>Name</th>
                                                            <th>Price*Qty</th>
                                                            <th>Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="text-black">
                                                        @foreach($items as $item)
                                                        <tr>
                                                            <td style="font-size:15px;">{{$item->item_name}}</td>
                                                            <td style="font-size:15px;">{{$item->selling_price}} * {{$item->order_qty}} {{$item->unit_name}}</td>
                                                            <td style="font-size:15px;" id="subtotal">{{$item->selling_price * $item->order_qty}}</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot class="text-black">
                                                        <tr>
                                                            <td></td>
                                                            <td class="text-right" style="font-size:18px;">Total</td>
                                                            <td id="total_charges" class="font-weight-bold" style="font-size:18px;"> {{$grand->sub_total}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td class="text-right" style="font-size:18px;">Pay</td>
                                                            <td id="pay" style="font-size:18px;"></td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td class="text-right" style="font-size:18px;">Change</td>
                                                            <td id="changes" style="font-size:18px;"></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                                <h6 class="text-center font-weight-bold text-black">**ကျေးဇူးတင်ပါသည်***</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>

                <div id="navpills-2" class="tab-pane ">
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            <?php
                            $countitem = count($items);
                            
                            if ($countitem <= 12) {
                                $z = 1;
                            }
                            if ($countitem > 12 && $countitem < 31) {
                                $z = 2;
                            }
                            if ($countitem > 30 && $countitem < 49) {
                                $z = 3;
                            }
                            if ($countitem > 48) {
                                $z = 4;
                            }

                            $i = 1;
                            ?>
                            @for($j=1;$j <= $z;$j++)
                            <?php
                                if ($j == 1) {
                                    if ($countitem < 13) {
                                ?>
                            <div class="card card-body printableArea" id="a5_body">
                                <div style="display:flex;justify-content:space-around">
                                    <div>
                                        <img src="{{asset('image/Shwe_Kyar_Phyu.png')}}">
                                    </div>

                                    <div>
                                        <h3 class="mt-1 text-center"> &nbsp;<b style="font-size: 40px;">ရွှေကြာဖြူ</b><span>(ပင်လယ်စာနှင့်အကင်အမျိုးမျိုး)</span></h3>

                                        <p class="mt-2" style="font-size: 20px;"> အမှတ်-၆၆၃၊ သမိန်ဗရမ်းလမ်း၊ ၃၅ရပ်ကွက်၊ ဒဂုံမြို့သစ်မြောက်ပိုင်းမြို့နယ်၊ ရန်ကုန်မြို့။
                                            <br /><i class="fas fa-mobile-alt"></i> 09-420022490 , 09-444345502 , 09-955132320
                                        </p>
                                    </div>

                                    <div></div>
                                </div>
                                <div class="row">

                                    <div class="col-md-12">

                                        <h3 class="text-info mt-3" style="font-size : 25px"><b>@lang('lang.invoice') @lang('lang.number') :</b> {{$voucher_code}} </h3>

                                        <h3 class="text-info mt-2" style="font-size : 25px"><b>@lang('lang.invoice') @lang('lang.date') :</b> {{$today_date}} </h3>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <table style="width: 100%; ">
                                            <thead class="text-center">
                                                <tr>
                                                    <th style="font-size:30px; font-weight:bold; height: 15px; border: 2px solid black;">@lang('lang.number')</th>
                                                    <th style="font-size:30px; font-weight:bold; height: 15px; border: 2px solid black;">@lang('lang.item')</th>
                                                    <th style="font-size:30px; font-weight:bold; height: 15px; border: 2px solid black;">@lang('lang.order_voucher_qty')</th>
                                                    <th style="font-size:30px; font-weight:bold; height: 15px; border: 2px solid black;">@lang('lang.price')</th>
                                                    <th style="font-size:30px; font-weight:bold; height: 15px; border: 2px solid black;">@lang('lang.total')</th>

                                                </tr>
                                            </thead>
                                            <tbody class="text-center">
                                                @foreach($items as $key=> $unit)
                                                <tr>
                                                    <td style="font-size:35px; font-weight:bold; height: 8px; border: 2px solid black;">{{$i++}}</td>
                                                    <td style="font-size:35px; font-weight:bold; height: 8px; border: 2px solid black;">{{$unit->item_name}}</td>
                                                    <td style="font-size:35px; font-weight:bold; height: 8px; border: 2px solid black;">{{$unit->order_qty}}</td>
                                                    <td style="font-size:35px; font-weight:bold; height: 8px; border: 2px solid black;">{{$unit->selling_price}}</td>
                                                    <td style="font-size:35px; font-weight:bold; height: 8px; border: 2px solid black;">{{$unit->selling_price * $unit->order_qty}}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="row mt-2">

                                        <div class="col-md-6">
                                            <h3 class="text-info font-weight-bold" style="font-size:35px;">
                                                Name - <span id="cus_name"> </span>
                                            </h3>
                                        </div>

                                        <div class="col-md-6 text-right">
                                            <h3 class="text-info font-weight-bold" style="font-size:35px;">
                                                @lang('lang.total') - <span id="total_charges"> {{$grand->sub_total}} </span>
                                            </h3>
                                        </div>

                                        <div class="col-md-6">
                                            <h3 class="text-info font-weight-bold" style="font-size:35px;">
                                                Phone - <span id="cus_phone"> </span>
                                            </h3>
                                        </div>

                                        <div class="col-md-6 text-right">
                                            <h3 class="text-info font-weight-bold" style="font-size:35px;">
                                                Pay - <span id="pay_1"> </span>
                                            </h3>
                                        </div>

                                        <div class="col-md-6">
                                            <h3 class="text-info font-weight-bold" style="font-size:35px;">
                                                Credit - <span id="credit_amount"> </span>
                                            </h3>
                                        </div>

                                        <div class="col-md-6 text-right">
                                            <h3 class="text-info font-weight-bold" style="font-size:35px;">
                                                Change - <span id="changes_1"> </span>
                                            </h3>
                                        </div>

                                    </div>
                                </div>
                            </div>
                    <?php
                    }
                    else
                    {
                        $endpt = 14;
                    ?>
                        <div class="card card-body printableArea">
                            <div style="display:flex;justify-content:space-around">
                                <div>
                                    <img src="{{asset('image/Shwe_Kyar_Phyu.png')}}">
                                </div>
                                <div>
                                    <h3 class="mt-1 text-center"> &nbsp;<b style="font-size: 40px;">ရွှေကြာဖြူ</b><span>(ပင်လယ်စာနှင့်အကင်အမျိုးမျိုး)</span></h3>
                                    <p class="mt-2" style="font-size: 20px;"> အမှတ်-၆၆၃၊ သမိန်ဗရမ်းလမ်း၊ ၃၅ရပ်ကွက်၊ ဒဂုံမြို့သစ်မြောက်ပိုင်းမြို့နယ်၊ ရန်ကုန်မြို့။
                                        <br /><i class="fas fa-mobile-alt"></i> 09-420022490 , 09-444345502 , 09-955132320
                                    </p>
                                </div>
                                <div></div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <h3 class="text-info mt-3" style="font-size : 25px"><b>@lang('lang.invoice') @lang('lang.number') :</b> {{$voucher_code}} </h3>
                                    <h3 class="text-info mt-2" style="font-size : 25px"><b>@lang('lang.invoice') @lang('lang.date') :</b> {{$today_date}} </h3>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <table style="width: 100%; ">
                                        <thead class="text-center">
                                            <tr>
                                                <th style="font-size:30px; font-weight:bold; height: 15px; border: 2px solid black;">@lang('lang.number')</th>
                                                <th style="font-size:30px; font-weight:bold; height: 15px; border: 2px solid black;">@lang('lang.item')</th>
                                                <th style="font-size:30px; font-weight:bold; height: 15px; border: 2px solid black;">@lang('lang.order_voucher_qty')</th>
                                                <th style="font-size:30px; font-weight:bold; height: 15px; border: 2px solid black;">@lang('lang.price')</th>
                                                <th style="font-size:30px; font-weight:bold; height: 15px; border: 2px solid black;">@lang('lang.total')</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">
                                            <?php foreach ($items as  $key => $unit) {

                                        if ($key == $endpt) {
                                            break;
                                        }
                                            ?>
                                                <tr>
                                                    <td style="font-size:35px; font-weight:bold; height: 8px; border: 2px solid black;">{{$i++}}</td>
                                                    <td style="font-size:35px; font-weight:bold; height: 8px; border: 2px solid black;">{{$unit->item_name}}</td>
                                                    <td style="font-size:35px; font-weight:bold; height: 8px; border: 2px solid black;">{{$unit->order_qty}}</td>
                                                    <td style="font-size:35px; font-weight:bold; height: 8px; border: 2px solid black;">{{$unit->selling_price}}</td>
                                                    <td style="font-size:35px; font-weight:bold; height: 8px; border: 2px solid black;">{{$unit->selling_price * $unit->order_qty}}</td>
                                                </tr>
                        <?php
                        }
                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <?php
                        }
                    }
                    // middle loop
                    else if ($j > 1 && $j < $z) {
                        echo "middle";
                        $startpt = $endpt;
                        $endpt = $startpt + 18;
                        if ($j == 3) {
                            $startpt = 32;
                            $endpt = 50;
                            
                        }
                    ?>
                    <div class="card card-body printableArea">
                        <div class="row">
                            <div class="col-md-12">
                                <table style="width: 100%; ">
                                    <thead class="text-center">
                                        <tr>
                                            <th style="font-size:30px; font-weight:bold; height: 15px; border: 2px solid black;">@lang('lang.number')</th>
                                            <th style="font-size:30px; font-weight:bold; height: 15px; border: 2px solid black;">@lang('lang.item')</th>
                                            <th style="font-size:30px; font-weight:bold; height: 15px; border: 2px solid black;">@lang('lang.order_voucher_qty')</th>
                                            <th style="font-size:30px; font-weight:bold; height: 15px; border: 2px solid black;">@lang('lang.price')</th>
                                            <th style="font-size:30px; font-weight:bold; height: 15px; border: 2px solid black;">@lang('lang.total')</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        @foreach($items as $key=>$unit)
                                        <?php
                                        if ($key >= $startpt && $key < $endpt) {
                                        ?>
                                            <tr>                                            <td style="font-size:35px; font-weight:bold; height: 8px; border: 2px solid black;">{{$i++}}</td>
                                                <td style="font-size:35px; font-weight:bold; height: 8px; border: 2px solid black;">{{$unit->item_name}}</td>
                                                <td style="font-size:35px; font-weight:bold; height: 8px; border: 2px solid black;">{{$unit->order_qty}}</td>
                                                <td style="font-size:35px; font-weight:bold; height: 8px; border: 2px solid black;">{{$unit->selling_price}}</td>
                                                <td style="font-size:35px; font-weight:bold; height: 8px; border: 2px solid black;">{{$unit->selling_price * $unit->order_qty}}</td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php
                }
                                            //last loop
                else {
                    echo "last";
                $startpt = $endpt;
                ?>
                    <div class="card card-body printableArea">
                        <div class="row">
                            <div class="col-md-12">
                                <table style="width: 100%; ">
                                    <thead class="text-center">
                                        <tr>
                                            <th style="font-size:30px; font-weight:bold; height: 15px; border: 2px solid black;">@lang('lang.number')</th>
                                            <th style="font-size:30px; font-weight:bold; height: 15px; border: 2px solid black;">@lang('lang.item')</th>
                                            <th style="font-size:30px; font-weight:bold; height: 15px; border: 2px solid black;">@lang('lang.order_voucher_qty')</th>
                                            <th style="font-size:30px; font-weight:bold; height: 15px; border: 2px solid black;">@lang('lang.price')</th>
                                            <th style="font-size:30px; font-weight:bold; height: 15px; border: 2px solid black;">@lang('lang.total')</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        @foreach($items as $key=>$unit)
                                        <?php
                                        if ($key >= $startpt)
                                        {
                                        ?>
                                            <tr>
                                                <td style="font-size:35px; font-weight:bold; height: 8px; border: 2px solid black;">{{$i++}}</td>
                                                <td style="font-size:35px; font-weight:bold; height: 8px; border: 2px solid black;">{{$unit->item_name}}</td>
                                                <td style="font-size:35px; font-weight:bold; height: 8px; border: 2px solid black;">{{$unit->order_qty}}</td>
                                                <td style="font-size:35px; font-weight:bold; height: 8px; border: 2px solid black;">{{$unit->selling_price}}</td>
                                                <td style="font-size:35px; font-weight:bold; height: 8px; border: 2px solid black;">{{$unit->selling_price * $unit->order_qty}}</td>
                                            </tr>
                                        <?php
                                            }
                                        ?>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <h3 class="text-info font-weight-bold" style="font-size:35px;">
                                        Name - <span id="cus_name"> </span>
                                    </h3>
                                </div>
                                <div class="col-md-6 text-right">
                                    <h3 class="text-info font-weight-bold" style="font-size:35px;">
                                        @lang('lang.total') - <span id="total_charges"> {{$grand->sub_total}} </span>
                                    </h3>
                                </div>
                                <div class="col-md-6">
                                    <h3 class="text-info font-weight-bold" style="font-size:35px;">
                                        Phone - <span id="cus_phone"> </span>
                                    </h3>
                                </div>
                                <div class="col-md-6 text-right">
                                    <h3 class="text-info font-weight-bold" style="font-size:35px;">
                                        Pay - <span id="pay_1"> </span>
                                    </h3>
                                </div>
                                <div class="col-md-6">
                                    <h3 class="text-info font-weight-bold" style="font-size:35px;">
                                        Credit - <span id="credit_amount"> </span>
                                    </h3>
                                </div>
                                <div class="col-md-6 text-right">
                                    <h3 class="text-info font-weight-bold" style="font-size:35px;">
                                        Change - <span id="changes_1"> </span>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
                @endfor
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="row">
            <div class="col-md-12">

                <label class="control-label text-black">Enter Customer Name</label>
                <select class="form-control text-black" id="salescustomer_list" onchange="fillCustomer(this.value)">
                    <option value="" class="text-black">Select Customers</option>

                    @foreach($salescustomers as $salescustomer)
                        <option value="{{$salescustomer->id}}">{{$salescustomer->name}}</option>
                    @endforeach
                </select>
                <input type="text" class="form-control" id="name" value="customer">

            </div>
            <div class="col-md-12">
                <label class="control-label text-black">Enter Customer Phone</label>
                <input type="number" class="form-control" id="phone" value="09">

            </div>



            <div class="col-md-12">
                <label class="control-label text-black">Enter Credit Amount</label>
                <input type="number" class="form-control" value="0" id="credit" >
            </div>
            <br/>
            <div class=" col-md-12">
                                <label class="text-black">Repayment Date </label>

                                <input type="text" class="form-control" id="repaymentDate" name="request_date">

                            </div>
                            <br/><br/><br>
            <br/>
            <div class="col-md-12">
                <button id="save" class="btn btn-info" type="button"><span><i class="fa fa-save"></i>Save Customer</span></button>

                <a href="#" class="btn btn-outline-danger" id="deletesaleuser"></i>
                                    <i class="fas fa-trash-alt"></i></a>

            </div>



            <div class="col-md-12">
                <label class="control-label">Enter Customer Pay </label>
                <label class="control-label" style="font-size:17px; font-weight:bold; height: 5px;">(Voucher Total: {{$grand->sub_total}} MMK) </label>
                <input type="number" onchange="getCreditAmount(this.value)" class="form-control" id="payable">
            </div>
        </div><br/>
        <div class="row">
            <div class="col-md-6">
                <button id="print" class="btn btn-info" type="button"> <span><i class="fa fa-print"></i> Print</span> </button>
            </div>
            <div class="col-md-6">
                <button id="store_voucher" class="btn btn-info" type="button"> <span><i class="fa fa-calendar-check"></i> Store Voucher</span> </button>
            </div>
            <div class="col-md-6 mt-2">
                <a href="{{route('sale_page')}}" class="btn btn-danger">Return to Sale Page</a>
            </div>
        </div>
    </div>

</div>



@endsection

@section('js')

<script src="{{asset('js/jquery.PrintArea.js')}}" type="text/JavaScript"></script>

<script type="text/javascript">
  $(document).ready(function(){
       $(".select2").select2();
       //getCustomers();
       var right_now_customer= @json($right_now_customer);
    });
    //jquery
    $("#repaymentDate").datetimepicker({
            format: 'YYYY-MM-DD'
        });

  function getCreditAmount(pay_amount){
    var total_charges = parseInt($('#total_charges').text());
    // alert(total_charges);alert
    if(pay_amount>total_charges){
          var credit_amt = 0;
    }
    else{
          var credit_amt = total_charges - pay_amount;
    }

    $("#credit").val(credit_amt);
  }
    var salescustomer = null;

    $("#deletesaleuser").click(function(){
        var salecustomer_id = $('#salescustomer_list').children("option:selected").val();
        console.log(salecustomer_id);
swal({
    title: "@lang('lang.confirm')",
    icon:'warning',
    buttons: ["@lang('lang.no')", "@lang('lang.yes')"]
})
.then((isConfirm)=>{
if(isConfirm){
  $.ajax({
      type:'POST',
        dataType:'json',
        url:'{{route('saleCustomerDelete')}}',
        data:{
              "_token":"{{csrf_token()}}",
              "salecustomer_id":salecustomer_id,

            },
      success: function(){

              swal({
                    title: "Success!",
                    text : "Successfully Deleted!",
                    icon : "success",
                });
                setTimeout(function(){
       window.location.reload();
    }, 1000);

            },
        });
}


    });
    });



    function getCustomers(){
        $.ajax({
            type:'POST',
            url:'{{route('AjaxGetCustomerList')}}',
            data:{
                "_token":"{{csrf_token()}}",
            },
            success:function(data){
                salescustomer = data;
                $('#salescustomer_list').empty();
                $('#salescustomer_list').append($('<option>').text("Select Customers").attr('value', ""));

                $.each(data, function(i, value) {
                $('#salescustomer_list').append($('<option>').text(value.name).attr('value',value.id));

                });
            },
        });
    }
     function fillCustomer(value){

        var customer_id = value;


        $.ajax({
            type:'POST',
            url:'{{route('AjaxGetCustomerwID')}}',
            data:{
              "_token":"{{csrf_token()}}",
              "customer_id": customer_id,
            },
            success:function(data){
              $("#name").val(data.name);
              $("#phone").val(data.phone);
            //  $("#credit").val(data.credit_amount);
            },
        });
    }

    var last_row_id = 0;
    $("#save").click(function(){
       var name = $('#name').val();
       var phone = $('#phone').val();
       var credit_amount = $('#credit').val();
       $.ajax({
           type:'POST',
           url:'{{route('AjaxStoreCustomer')}}',
           data:{
               "_token":"{{csrf_token()}}",
               "name": name,
               "phone": phone,
               "credit_amount": credit_amount,
           },
           success:function(data){
               console.log(data.last_row);
                if(data.success == 1){
                    alert(data.message);
                    last_row_id = data.last_row.id;
                    //$lastRecord = DB::table('sales_customers')->orderBy('id', 'DESC')->first();

               }
           }
       });

    });


    $("#print").click(function() {
        var exitvoucher = localStorage.getItem('exitvoucher');
        if(exitvoucher==null){
            voucher_id = 0;
        }
        else{
            voucher_id = exitvoucher;
        }
        var item = @json($items);
        console.log(item);
        var grand = @json($grand);
        var right_now_customer = @json($right_now_customer);
        var voucher_code = @json($voucher_code);
        var pay = $('#payable').val();
        var name = $('#name').val();
        var vou_Dis = $('#vou_discount').val();

        // Added

        var discount = @json($discount);
        var voucher_code = @json($voucher_code);
        var foc_flag = @json($foc);
        var has_dis = @json($has_dis);
        //End Added

        var phone = $('#phone').val();
        var repaymentDate=$("#repaymentDate").val();

        var credit = $('#credit').val();
        var total_charges = parseInt($('#total_charges').text());
        console.log(total_charges);
        var changes = pay - total_charges;
        //isset
        var id = $('#salescustomer_list').children("option:selected").val()
        // ? $('#salescustomer_list').children("option:selected").val() : last_row_id;
        $("#changes").text(changes);

        $("#pay").text(pay);

        $("#changes_1").text(changes);

        $("#pay_1").text(pay);

        $("#cus_name").text(name);

        $("#cus_phone").text(phone);

        $("#credit_amount").text(credit);
        $("#credit").val(credit);
        if(!pay){
            swal({
                icon: 'error',
                title: 'Check Customer Pay Again!',
                text: 'Customer Pay cannot be null!!!',
                footer: '<a href>Why do I have this issue?</a>'
            })
        }
        // else if(pay < total_charges){
        //     swal({
        //         icon: 'error',
        //         title: 'Check Customer Pay Again!',
        //         text: 'Customer Pay must be greater than or equal Total Amount!!!',
        //         footer: '<a href>Why do I have this issue?</a>'
        //     })
        // }
        else if(id){
            $.ajax({
                type:'POST',
                url:'Voucher',
                dataType:'json',
                data:{
                  "_token": "{{ csrf_token() }}",
                  "item": item,
                  "grand": grand,
                  "voucher_code": voucher_code,
                  "sales_customer_id": id,
                  "sales_customer_name": name,
                  "credit_amount": credit,
                  "repaymentDate":repaymentDate,
                  "is_print":1,

                  "discount": discount,
                  "foc_flag":foc_flag,
                  "has_dis":has_dis,
                  "sales_customer_id": id,
                  "sales_customer_name":name,
                  "vou_discount":vou_Dis,
                  "voucher_id":parseInt(voucher_id),
                },
                success: function(data){
                    localStorage.setItem('exitvoucher',JSON.stringify(data.id));
                    var mode = 'iframe'; //popup
                    var close = mode == "popup";
                    var options = {
                        mode: mode,
                        popClose: close
                    };

                    $(".tab-pane.active div.printableArea").printArea(options);
                },
            });
            clearLocalstorage(right_now_customer);

        }
        else{
            //last_row_id
            {
$.ajax({
    type:'POST',
    url:'Voucher',
    dataType:'json',
    data:{
      "_token": "{{ csrf_token() }}",
      "item": item,
      "grand": grand,
      "voucher_code": voucher_code,
      "sales_customer_id": last_row_id,
      "sales_customer_name": name,
      "credit_amount": credit,
      "is_print":1,
      "voucher_id":parseInt(voucher_id),

    },
    success: function(){
        localStorage.setItem('exitvoucher',JSON.stringify(data.id));
        var mode = 'iframe'; //popup
        var close = mode == "popup";
        var options = {
            mode: mode,
            popClose: close
        };

        $(".tab-pane.active div.printableArea").printArea(options);
    },
});
clearLocalstorage();
}
            //end last_row
        }
    });
    $("#store_voucher").click(function(){

        var exitvoucher = localStorage.getItem('exitvoucher');
        if(exitvoucher==null){
            voucher_id = 0;
        }
        else{
            voucher_id = exitvoucher;
        }

        var right_now_customer= @json($right_now_customer);
        var salecustomer_id = $('#salescustomer_list').children("option:selected").val();
        console.log("hello"+salecustomer_id);
        var item = @json($items);
        var grand = @json($grand);
        var discount = @json($discount);
        var voucher_code = @json($voucher_code);
        var foc_flag = @json($foc);
        var has_dis = @json($has_dis);
        var cus_pay = $('#payable').val();
        var vou_Dis = $('#vou_discount').val();
        // alert(vou_Dis);
        var total = parseInt($('#total_charges').text());

        var repaymentDate=$('#repaymentDate').val();

        var name = $('#name').val();

        var id = $('#salescustomer_list').children("option:selected").val();

        var credit = $('#credit').val();
        if(!cus_pay){
            swal({
                icon: 'error',
                title: 'Check Customer Pay Again!',
                text: 'Customer Pay cannot be null!!!',
                footer: '<a href>Why do I have this issue?</a>'
            })
        }
        // else if(cus_pay < total){
        //     swal({
        //         icon: 'error',
        //         title: 'Check Customer Pay Again!',
        //         text: 'Customer Pay must be greater than or equal Total Amount!!!',
        //         footer: '<a href>Why do I have this issue?</a>'
        //     })
        // }
        else if(id){
            $.ajax({
                type:'POST',
                url:'Voucher',
                dataType:'json',
                data:{
                  "_token": "{{ csrf_token() }}",
                  "item": item,
                  "grand": grand,
                  "discount": discount,
                  "foc_flag":foc_flag,
                  "has_dis":has_dis,
                  "voucher_code": voucher_code,
                  "sales_customer_id": id,
                  "sales_customer_name":name,
                  "credit_amount": credit,
                  "repaymentDate":repaymentDate,
                  "vou_discount":vou_Dis,
                  "voucher_id":parseInt(voucher_id),
                },
                success: function(data){
                    localStorage.setItem('exitvoucher',JSON.stringify(data.id));

                    console.log(data);
                    swal({
                        icon: 'success',
                        title: 'Successfully Stored Voucher!',
                        text: 'Voucher is Successfully stored!!!',
                    })
                    clearLocalstorage(right_now_customer);
                    setTimeout(function(){
                        window.location.href = "{{ route('sale_page')}}";
                    }, 500);
                },
            });
        }
        else{
            //last_row_id
            $.ajax({
                type:'POST',
                url:'Voucher',
                dataType:'json',
                data:{
                  "_token": "{{ csrf_token() }}",
                  "item": item,
                  "grand": grand,
                  "discount": discount,
                  "has_dis":has_dis,
                  "foc_flag":foc_flag,
                  "voucher_code": voucher_code,
                  "sales_customer_id": last_row_id,
                  "sales_customer_name":name,
                  "credit_amount": credit,
                  "vou_discount":vou_Dis,
                  "voucher_id":parseInt(voucher_id),
                },
                success: function(data){
                    localStorage.setItem('exitvoucher',JSON.stringify(data.id));

                    console.log(data);
                    swal({
                        icon: 'success',
                        title: 'Successfully Stored Voucher!',
                        text: 'Voucher is Successfully stored!!!',
                    })
                    clearLocalstorage(right_now_customer);
                    setTimeout(function(){
                        window.location.href = "{{ route('sale_page')}}";
                    }, 1000);
                },
            });
            //end last_row_id
        }
    });
    function clearLocalstorage(right_now_customer){
    if(right_now_customer!=0){

    var cartname = "mycart_"+right_now_customer;
    var grand_totalname = "grandTotal_"+ right_now_customer;
    console.log(cartname);

    var local_customer = localStorage.getItem('local_customer_lists');
    var local_customer_array = JSON.parse(local_customer);
    $.each(local_customer_array,function(i,v){
        if(v==right_now_customer){
            local_customer_array.splice(i,1);
        }
    })
    localStorage.setItem('local_customer_lists',JSON.stringify(local_customer_array));
    localStorage.removeItem(cartname);
    localStorage.removeItem(grand_totalname);
    }
    localStorage.removeItem('mycart');
    localStorage.removeItem('grandTotal');
    }
    $('#foc').click(function(){
        // alert($("input:checkbox[name=foc]:checked").val());

        var price_change= $('#price_change').val();
        var or_price= $('#or_price').val();
        if($("input:checkbox[name=foc]:checked").val() == 1)
        {
            $('#price_change').val(0);
        }
        else{
            $('#price_change').val(or_price);
        }
        //    var percent_for_price=$('#percent_for_price').val();
        }
    )
    $('#percent_for_price').click(function(){
        var idArray= [];
            $("input:checkbox[name=percent_for_price]:checked").each(function(){
            idArray.push(parseInt($(this).val()));
        });
        if(idArray.length>0){
            $('#percent_price').removeAttr('disabled');
            $('#percent_price').focus();
        }
        else{
            $('#percent_price').attr('disabled','disabled');
        }
        //    var percent_for_price=$('#percent_for_price').val();
        }
    )
    $('#percent_price').keyup(function(){
        var percent_price= $('#percent_price').val();
        var or_price= $('#or_price').val();
        var discount_amount = parseInt (or_price * (percent_price/100));
        // alert(percent_price+"---"+or_price);
        var change_percent_price = parseInt(or_price) + discount_amount;
        $('#discount_amount').html(discount_amount);
        $('#price_change').val(change_percent_price);
    })
    $('#price_change_btn').click(function(){
        var price_change= $('#price_change').val();
        // alert(price_change);
        var old_price = $('#or_price').val();
        var disvoucart = localStorage.getItem('mydisvoucart');
        var dis_vou_cart_obj = JSON.parse(disvoucart);
        var dif = parseInt(old_price) - parseInt(price_change);
        disvou = {voucher_discount:price_change,different:dif};
        if(disvoucart == null ){

            disvoucart = '[]';

            var dis_vou_cart_obj = JSON.parse(disvoucart);

            localStorage.setItem('mydisvoucart',JSON.stringify(disvou));



            }else{

            var dis_vou_cart_obj = JSON.parse(disvoucart);
            dis_vou_cart_obj.voucher_discount = price_change;
            localStorage.setItem('mydisvoucart',JSON.stringify(dis_vou_cart_obj));


            }

            var grand_total = localStorage.getItem('grandTotal');
            var grand_total_obj = JSON.parse(grand_total);
            grand_total_obj.sub_total = price_change;
            localStorage.setItem('grandTotal',JSON.stringify(grand_total_obj));
            var disvoucart = localStorage.getItem('mydisvoucart');
            $("#vou_discount").attr('value', disvoucart);
            var htmltotalvou = "";
            var htmlchangetotal = "";
            htmlchangetotal +=`
            <label class="control-label" style="font-size:17px; font-weight:bold; height: 5px;">(Voucher Total: ${price_change} MMK) </label>
            `;
            htmltotalvou+=`
            <h3 class="text-info font-weight-bold" style="font-size:35px;">
                @lang('lang.total') - <span id="total_charges">${price_change}</span>
            </h3>
            `;
            $('#total_charges').text(price_change);
            $('#change_total').html(htmlchangetotal);
            $('#total_vou').html(htmltotalvou);
    })
</script>

@endsection
