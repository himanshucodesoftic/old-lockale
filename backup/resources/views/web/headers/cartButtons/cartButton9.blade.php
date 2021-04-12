<?php $qunatity=0; ?>
@foreach($result['commonContent']['cart'] as $cart_data)
<?php $qunatity += $cart_data->customers_basket_quantity; ?>
@endforeach

<li>
  <div class="dropdown dropdown-cart">
    <a href="#" class="cart_bt"><strong>{{ $qunatity }}</strong></a>
    @if(count($result['commonContent']['cart'])>0)
    <div class="dropdown-menu">
      <?php
        $total_amount=0;
        $qunatity=0;
      ?>
      <ul>
        @foreach($result['commonContent']['cart'] as $cart_data)
        <?php
          $total_amount += $cart_data->final_price*$cart_data->customers_basket_quantity;
        ?>
        <li>
          <a>
            <figure>
              <img src="{{asset('').$cart_data->image}}" alt="{{$cart_data->products_name}}" alt="" width="50" height="50" class="lazy">              
            </figure>
            <strong><span>{{$cart_data->customers_basket_quantity}} x {{$cart_data->products_name}}</span>{{Session::get('symbol_left')}}{{$cart_data->final_price*session('currency_value')}}{{Session::get('symbol_right')}}</strong>
          </a>
          <a href="{{ URL::to('/deleteCart?id='.$cart_data->customers_basket_id)}}" class="action"><i class="ti-trash"></i></a>
        </li>        
        @endforeach
      </ul>
      <div class="total_drop">
        <div class="clearfix"><strong>@lang('website.SubTotal')</strong><span>{{Session::get('symbol_left')}}{{ $total_amount*session('currency_value') }}{{Session::get('symbol_right')}}</span></div>
        <a href="{{ URL::to('/viewcart')}}" class="btn_1 outline">@lang('website.View Cart')</a>
        <a href="{{ URL::to('/checkout')}}" class="btn_1">@lang('website.Checkout')</a>
      </div>
    </div>
    @endif
  </div>
  <!-- /dropdown-cart-->
</li>