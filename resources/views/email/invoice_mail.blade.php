<div class="card">
<div class="card-body" style="width: 40vw;margin:auto;">
    <div>

<div class="col-12 text-center">
<div style="margin-left:30px;">
   <img src="https://medicalworldinvpos.kwintechnologykw09.com/image/medicalWorld.png" style="width : 390px;margin-left:30px;"/>
</div>

<div>
   <p style="margin-top: 20px;text-align : center;">No.28, 3rd Street, Hlaing Yadanar Mon Avenue, Hlaing Township, Yangon
       <br /> 09 777 00 5861, 09 777 00 5862
   </p>
</div>
<div>
   <h3 style=" text-align : center;color : secondary;font-weight : bold;">Profoma E Invoice</h3>
</div>
</div>
</div>
<div>
<span style="color : secondary;">Customer Name  : {{$name}}</span>
<span style=" float : right;color : secondary;">Customer Phone : {{$phone}}</span>
</div>
@if ($type == 1)
<table class="table table-striped" style=" width: 100%;height: auto;padding: 10px;margin-top: 20px;border-radius: 20px;border: 1px solid rgba(2,127,157,1);">
    <tr class="text-center">
        <th>No</th>
        <th>Item</th>
        <th>Color</th>
        <th>Size</th>
        <th>Qty</th>
        <th>Price</th>
        <th>Total</th>
        <?php $i = 1;$total_amount = 0; ?>
    </tr>
    @foreach ($preorders as $pre)
    <tr class="text-center">
     <td>{{$i++}}</td>
     <td>{{ explode(' ', $pre['testname'])[0]}}{{ explode(' ', $pre['testname'])[2]}}</td>
     <td>{{ explode(' ', $pre['testname'])[3]}}</td>
     <td>{{ explode(' ', $pre['testname'])[4]}}</td>
     <td>{{$pre['testqty']}}</td>
     <td>{{$pre['testprice']}}</td>
     <td>{{$pre['testqty']*$pre['testprice']}}</td>
     <?php $total_amount += $pre['testqty']*$pre['testprice'] ?>
    </tr>

    @endforeach

</table>
@elseif ($type == 2)
<table class="table table-striped" style=" width: 100%;height: auto;padding: 10px;margin-top: 20px;border-radius: 20px;border: 1px solid rgba(2,127,157,1);">
    <tr class="text-center">
        <th>No</th>
        <th>Item</th>
        <th>Description</th>
        <th>Qty</th>
        <th>Price</th>
        <th>Total</th>
        <?php $i = 1;$total_amount = 0; ?>
    </tr>
    @foreach ($attachs as $pre)
    <tr class="text-center">
     <td>{{$i++}}</td>
     <td><img src="" width="100px" height="auto"></td>
     <td>{{$pre['description']}}</td>
     <td>{{$pre['testqty']}}</td>
     <td>{{$pre['testprice']}}</td>
     <td>{{$pre['testqty']*$pre['testprice']}}</td>
     <?php $total_amount += $pre['testqty']*$pre['testprice'] ?>
    </tr>

    @endforeach

</table>
@endif

       <div class="row">
        <div class="col-6 mt-3">
            <span style="float :left;color : secondary;margin-top:20px;">Customer Address : {{$address}}</span>
        </div>
        <div class="col-6 mt-3">
            <span style=" float : right;color : secondary;margin-top:20px;">Total Amount : {{$total_amount}}</span>
        </div>

        </div>

        <div class="row mt-5">
            <h4 style="margin-top:50px;text-align:center;">Your preorders will be received within four to six weeks.</h4>
        </div>
</div>
</div>
