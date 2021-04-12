@if($result['flash_sale']['success']==1)
<!-- Products content -->

<section class="pro-content pro-fs-content" >
  <div class="container"> 
    <div class="products-area ">
      <div class="row justify-content-center">
        <div class="col-12 col-lg-6">
          <div class="pro-heading-title">
            <h2> @lang('website.Flash Sale')
            </h2>
            <!--<p> -->
            <!--  @lang('website.Flash Sale Text')-->
            <!--</p>-->
          </div>
        </div>    
      </div>
    

      <div class="pro-info blink">
        @lang('website.Super deal of the Month')                       
      </div>

      <div style="display: flex;">
        @foreach($result['flash_sale']['product_data'] as $key=>$products)
          @if( date("Y-m-d", $products->server_time) >= date("Y-m-d", $products->flash_start_date))
          <div class="col-6 col-md-4 col-xl-3 col-lg-3" id="prod_detail_<?php echo $products->products_id; ?>">
            <div class="grid_item">
              
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
                  if(!empty($products->flash_price)){

                    $discount_price = $products->flash_price * session('currency_value');

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
                  <div class="short_info opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0.1)">        
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

                <div class="countdown" id="counter_{{$products->products_id}}" data-placement="bottom" title="@lang('website.Countdown Timer')" >
                  <div class="custom_countdown">0D 00:00:00</div>
                </div>
                <!-- <div data-countdown="2019/05/15" class="countdown"></div> -->
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
                @if(!empty($products->flash_price))
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
            </div>
          </div>
          @else
          <div class="col-6 col-md-4 col-xl-3 col-lg-3" id="prod_detail_<?php echo $products->products_id; ?>">
            <div class="grid_item">
              
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
                  if(!empty($products->flash_price)){

                    $discount_price = $products->flash_price * session('currency_value');

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

                <a href="{{ URL::to('/product-detail/'.$products->products_slug)}}" id="prod_img_default_<?php echo $products->products_id; ?>">
                  <img class="img-fluid lazy" src="{{asset('').$products->image_path}}"
                    data-src="{{asset('').$products->image_path}}" alt="{{$products->products_name}}">
                  <div class="short_info opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0.1)">        
                  </div>
                </a>

                <a href="{{ URL::to('/product-detail/'.$products->products_slug)}}" id="prod_img_other_<?php echo $products->products_id; ?>" style="display: none;">
                  <img class="img-fluid lazy" src="{{asset('').$products->hover_img}}"
                    data-src="{{asset('').$products->hover_img}}" alt="{{$products->products_name}}">
                  <div class="short_info opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0.1)" style="background-color: rgba(0, 0, 0, 0.1);">
                  </div>
                </a>

                <div class="pro-timer countdown" id="counter_{{$products->products_id}}" data-placement="bottom" title="@lang('website.Countdown Timer')" >
                  <div style="margin-left: 16px;">Expired</div>
                </div>
                <!-- <div data-countdown="2019/05/15" class="countdown"></div> -->
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
                @if(!empty($products->flash_price))
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
            </div>
          </div>
          @endif

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

        @endforeach
      </div>
      
    </div>
  </div>

</section>


@endif

<script>

jQuery(document).ready(function(e) {

   @if(!empty($result['flash_sale']['success']) and $result['flash_sale']['success']==1)
       @foreach($result['flash_sale']['product_data'] as $key=>$products)
	   @if( date("Y-m-d",$products->server_time) >= date("Y-m-d",$products->flash_start_date))
	    var product_div_{{$products->products_id}} = 'product_div_{{$products->products_id}}';
		var  counter_id_{{$products->products_id}} = 'counter_{{$products->products_id}}';
		var inputTime_{{$products->products_id}} = "{{date('M d, Y H:i:s' ,$products->flash_expires_date)}}";

		// Set the date we're counting down to
		var countDownDate_{{$products->products_id}} = new Date(inputTime_{{$products->products_id}}).getTime();

		// Update the count down every 1 second
		var x_{{$products->products_id}} = setInterval(function() {

		  // Get todays date and time
		  var now = new Date().getTime();

		  // Find the distance between now and the count down date
		  var distance_{{$products->products_id}} = countDownDate_{{$products->products_id}} - now;

		  // Time calculations for days, hours, minutes and seconds
		  var days_{{$products->products_id}} = Math.floor(distance_{{$products->products_id}} / (1000 * 60 * 60 * 24));

		  var hours_{{$products->products_id}} = Math.floor((distance_{{$products->products_id}} % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      if (hours_{{$products->products_id}} < 10) hours_{{$products->products_id}} = '0' + hours_{{$products->products_id}};

		  var minutes_{{$products->products_id}} = Math.floor((distance_{{$products->products_id}} % (1000 * 60 * 60)) / (1000 * 60));
      if (minutes_{{$products->products_id}} < 10) minutes_{{$products->products_id}} = '0' + minutes_{{$products->products_id}};

		  var seconds_{{$products->products_id}} = Math.floor((distance_{{$products->products_id}} % (1000 * 60)) / 1000);
      if (seconds_{{$products->products_id}} < 10) seconds_{{$products->products_id}} = '0' + seconds_{{$products->products_id}};

      var days_text = "@lang('website.Days')";
		  // Display the result in the element with id="demo"
		  // document.getElementById(counter_id_{{$products->products_id}}).innerHTML = "<span class='days'>"+days_{{$products->products_id}} + "<small>@lang('website.Days')</small></span> <span class='hours'>" + hours_{{$products->products_id}} + "<small>@lang('website.Hours')</small></span> <span class='mintues'> "
		  // + minutes_{{$products->products_id}} + "<small>@lang('website.Minutes')</small></span> <span class='seconds'>" + seconds_{{$products->products_id}} + "<small>@lang('website.Seconds')</small></span> ";

      document.getElementById(counter_id_{{$products->products_id}}).innerHTML = "<div class='custom_countdown'>"+days_{{$products->products_id}} + "D " + hours_{{$products->products_id}} + ":" + minutes_{{$products->products_id}} + ":" + seconds_{{$products->products_id}} + "</div>";

		  // If the count down is finished, write some text
		  if (distance_{{$products->products_id}} < 0) {
			clearInterval(x_{{$products->products_id}});
			//document.getElementById(counter_id_{{$products->products_id}}).innerHTML = "EXPIRED";
			document.getElementById('product_div_{{$products->products_id}}').remove();
		  }
		}, 1000);
  	   @endif
	 @endforeach
   @endif

	@if(!empty($result['detail']['product_data'][0]->flash_start_date))
		@if( $result['detail']['product_data'][0]->server_time >= $result['detail']['product_data'][0]->flash_start_date)

			var inputTime = "{{date('M d, Y H:i:s' ,$result['detail']['product_data'][0]->flash_expires_date)}}";

			var countDownDate = new Date(inputTime).getTime();

			// Update the count down every 1 second
			var x = setInterval(function() {

			  // Get todays date and time
			  var now = new Date().getTime();

			  // Find the distance between now and the count down date
			  var distance = countDownDate - now;

			  // Time calculations for days, hours, minutes and seconds
			  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
			  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
			  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
			  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

			  // Display the result in the element with id="demo"
			  document.getElementById("counter_product").innerHTML = days + "d " + hours + "h "
			  + minutes + "m " + seconds + "s ";
				document.getElementById("counter_product").style.display = 'block';
			  // If the count down is finished, write some text
			  if (distance < 0) {
				clearInterval(x);
				document.getElementById("counter_product").innerHTML = "EXPIRED";
				document.getElementById("add-to-Cart").style.display = 'none';
			  }
			}, 1000);
		@endif
	@endif
});
</script>
