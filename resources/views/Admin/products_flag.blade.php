

@extends('master')

@section('title','Product Flag Control')

@section('place')

@endsection
@section('content')
<h2 class="text-center">Products Flag Control</h2>
    @if(session()->has('success'))<p  class="text-center text-success">{{ session('success') }}</p>@endif
        <div class="w-100 d-flex justify-content-center p-4">
        <div class="w-50">
        <form method="POST" action="settingflag">
            @csrf
        <div class="form-row">
            <div class="form-group col-md-6">
            <label for="product">Products</label>
            <!-- <input type="text" name="" class="form-control" id="product" placeholder=""> -->
            <input class="form-control" list="products" name="item">
            <datalist id="products">
                @foreach ($allproducts as $product)
                    <option style="padding: 5px;" value="{{ $product->item_name }}">
                @endforeach
            </datalist>
            </div>
            <div class="mt-4" style="display:block;">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" value="" name="new_arr" id="new_arr">
                    <label class="form-check-label" for="new_arr">Set as New Arrival Item</label>
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" value="" name="promo" id="promo">
                    <label class="form-check-label" for="promo">Set as Promotion Item</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" name="hot_sale" id="hot">
                    <label class="form-check-label" for="hot">Set as Hot Sale Item</label>
                </div>
            </div>
        </div>

        <hr>

        <p>If product is set to new arrival, please set arrival date</p>
        <details class="mt-1">
            <summary class="btn btn-warning">Set Arrival Date</summary>
            <div class="form-row mt-2">
                <div class="form-group col-md-6">
                <label for="arr_date">Arrival Date</label>
                <input type="date" name="arr_date" class="form-control" id="arr_date" placeholder="">
                </div>
            </div>
        </details>

        <br>
        <p>If product is set to promotion, please set discount value</p>
        <details class="mt-2">
            <summary class="btn btn-warning">Set Promotion Price</summary>
            <div class="form-row mt-2">
                <div class="form-group col-md-6">
                <label for="promo_price">Promotion Price</label>
                <input type="text" name="dis_price" class="form-control" id="promo_price" placeholder="">
                </div>
            </div>
        </details>
        
        <button type="submit" class="btn btn-primary mt-4">Change Flag</button>
        </form>
  </div>
</div>
@endsection

