<div class="grid_item" id="prod_detail_<?php echo $products->products_id; ?>">

  <?php 
    $current_date = date("Y-m-d", strtotime("now"));

    $string = substr($products->products_date_added, 0, strpos($products->products_date_added, ' '));
    $date=date_create($string);
    date_add($date,date_interval_create_from_date_string($web_setting[20]->value." days"));
    $after_date = date_format(date_add($date,date_interval_create_from_date_string($web_setting[20]->value." days")),"Y-m-d");
    if($after_date>=$current_date){
      print '<span class="ribbon new">';
      print __('website.New');
      print '</span>';
    }
  ?>
  <?php
    $orignal_price = $products->products_price * session('currency_value');
  ?>

  <figure>
    <?php
      if(!empty($products->discount_price)){

        $discount_price = $products->discount_price * session('currency_value');

        if(($orignal_price+0)>0){
          $discounted_price = $orignal_price-$discount_price;
          $discount_percentage = $discounted_price/$orignal_price*100;
        }else{
          $discount_percentage = 0;
          $discounted_price = 0;
        }
    ?>
    <span class="ribbon off" style="right: 10px; left: auto;" data-toggle="tooltip" title="<?php echo (int)$discount_percentage; ?>% @lang('website.off')"><?php echo (int)$discount_percentage; ?>%</span>    
    <?php } ?>
  
    @if($products->is_feature == 1)      
      <span class="ribbon hot" style="right: 10px; left: auto;">@lang('website.Featured')</span>
    @endif

    <a href="{{ URL::to('/product-detail/'.$products->products_slug)}}" id="@if(!empty($products->hover_img))prod_img_default_<?php echo $products->products_id; ?>@endif">
      <img class="img-fluid lazy" src="{{asset('').$products->image_path}}"
        data-src="{{asset('').$products->image_path}}" alt="{{$products->products_name}}">
      <div class="short_info opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0.1)" style="background-color: rgba(0, 0, 0, 0.1);">
      </div>
    </a>

    @if(!empty($products->hover_img))
    <a href="{{ URL::to('/product-detail/'.$products->products_slug)}}" id="prod_img_other_<?php echo $products->products_id; ?>" style="display: none;">
      <img class="img-fluid lazy" src="{{asset('').$products->hover_img}}"
        data-src="{{asset('').$products->hover_img}}" alt="{{$products->products_name}}">
      <div class="short_info opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0.1)" style="background-color: rgba(0, 0, 0, 0.1);">
      </div>
    </a>
    @endif    

    <!-- <div class="pro-timer countdown" id="counter_{{$products->products_id}}" data-placement="bottom" title="@lang('website.Countdown Timer')" >
      <div style="margin-left: 16px;">0D 00:00:00</div>
    </div> -->    
  </figure>

  <div class="rating">
  @if($products->avarage_rate == 1)
  <i class="icon-star voted"></i>
  <i class="icon-star"></i>
  <i class="icon-star"></i>
  <i class="icon-star"></i>
  <i class="icon-star"></i>
  @elseif($products->avarage_rate == 2)
  <i class="icon-star voted"></i>
  <i class="icon-star voted"></i>
  <i class="icon-star"></i>
  <i class="icon-star"></i>
  <i class="icon-star"></i>
  @elseif($products->avarage_rate == 3)
  <i class="icon-star voted"></i>
  <i class="icon-star voted"></i>
  <i class="icon-star voted"></i>
  <i class="icon-star"></i>
  <i class="icon-star"></i>
  @elseif($products->avarage_rate == 4)
  <i class="icon-star voted"></i>
  <i class="icon-star voted"></i>
  <i class="icon-star voted"></i>
  <i class="icon-star voted"></i>
  <i class="icon-star"></i>
  @elseif($products->avarage_rate == 5)
  <i class="icon-star voted"></i>
  <i class="icon-star voted"></i>
  <i class="icon-star voted"></i>
  <i class="icon-star voted"></i>
  <i class="icon-star voted"></i>
  @else
  <i class="icon-star"></i>
  <i class="icon-star"></i>
  <i class="icon-star"></i>
  <i class="icon-star"></i>
  <i class="icon-star"></i>
  @endif
  </div>

  <a href="{{ URL::to('/product-detail/'.$products->products_slug)}}">
    <h3>{{$products->products_name}}</h3>
  </a>
  <div class="price_box">
    @if(!empty($products->discount_price))
      <span class="new_price">{{Session::get('symbol_left')}}&nbsp;{{$discount_price+0}}&nbsp;{{Session::get('symbol_right')}}</span>
      <span class="old_price">{{Session::get('symbol_left')}}{{$orignal_price+0}}{{Session::get('symbol_right')}}</span>
    @else
      <span class="new_price">{{Session::get('symbol_left')}}{{$orignal_price+0}}{{Session::get('symbol_right')}}</span>
    @endif    
  </div>
  <ul>
    <li><a href="javascript:void(0)" class="tooltip-1 is_liked" data-toggle="tooltip" data-placement="left" title="@lang('website.Wishlist')" products_id="<?=$products->products_id?>"><i class="ti-heart"></i><span>@lang('website.Wishlist')</span></a></li>    
    <li><a onclick="myFunction3({{$products->products_id}})" class="tooltip-1" data-toggle="tooltip" data-placement="left" title="@lang('website.Compare')"><i class="ti-control-shuffle"></i><span>@lang('website.Compare')</span></a></li>
    @if($products->products_type==0)
      @if($result['commonContent']['settings']['Inventory'])
        @if($products->defaultStock>0)
        <li><a products_id="{{$products->products_id}}" class="tooltip-1 cart" data-toggle="tooltip" data-placement="left" title="@lang('website.Add to Cart')"><i class="ti-shopping-cart"></i><span>@lang('website.Add to Cart')</span></a></li>
        @endif
      @else
      <li><a products_id="{{$products->products_id}}" class="tooltip-1 cart" data-toggle="tooltip" data-placement="left" title="@lang('website.Add to Cart')"><i class="ti-shopping-cart"></i><span>@lang('website.Add to Cart')</span></a></li>
      @endif
    @else
    <li><a href="{{ URL::to('/product-detail/'.$products->products_slug)}}" class="tooltip-1" data-toggle="tooltip"
      data-placement="left" title="@lang('website.View Detail')"><i class="fas fa-shopping-bag"></i><span>@lang('website.View Detail')</span></a></li>
    @endif
  </ul>
  <script type="text/javascript">
    jQuery("#prod_detail_" + <?php echo $products->products_id; ?>).on('mouseenter',function(e) {      
      jQuery('#prod_img_default_' + <?php echo $products->products_id; ?>).css('display','none');
      jQuery('#prod_img_other_' + <?php echo $products->products_id; ?>).css('display','block');
    });
    jQuery("#prod_detail_" + <?php echo $products->products_id; ?>).on('mouseleave',function(e) {      
      jQuery('#prod_img_default_' + <?php echo $products->products_id; ?>).show();
      jQuery('#prod_img_other_' + <?php echo $products->products_id; ?>).hide();
    });
  </script>
</div>
