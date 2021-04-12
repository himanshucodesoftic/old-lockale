<header class="version_1"  >
  <div class="layer"></div><!-- Mobile menu overlay mask -->

  <div class="main_header Sticky">
    <div class="container">
      <div class="row small-gutters">
        <div class="col-xl-3 col-lg-2 d-lg-flex align-items-center">
          <div id="logo">
            <a href="{{ URL::to('/')}}">
            @if($result['commonContent']['settings']['sitename_logo']=='logo')
            <img class="img-fluid" src="{{asset('').$result['commonContent']['settings']['website_logo']}}"
              alt="<?=stripslashes($result['commonContent']['settings']['website_name'])?>" width="100" height="35">
            @endif
            
            </a>            
          </div>
        </div>
        <nav class="col-xl-6 col-lg-7" style="border:2px solid red;">
          <a class="open_close" href="javascript:void(0);">
            <div class="hamburger hamburger--spin">
              <div class="hamburger-box">
                <div class="hamburger-inner"></div>
              </div>
            </div>
          </a>
          <!-- Mobile menu button -->
          <div class="main-menu">
            <div id="header_menu">
              <a href="{{ URL::to('/')}}">
              @if($result['commonContent']['settings']['sitename_logo']=='logo')
              <img class="img-fluid" src="{{asset('').$result['commonContent']['settings']['website_logo']}}"
                alt="<?=stripslashes($result['commonContent']['settings']['website_name'])?>" width="100" height="35">
              @endif            
              </a>
              <a href="#" class="open_close" id="close_in"><i class="ti-close"></i></a>
            </div>

            <ul>
              @foreach($result['commonContent']["menuData"] as $menu)
              <li class="@if(isset($menu->childs) && count($menu->childs) > 0) submenu @endif">
                <a href="{{ URL::to(''.$menu->link)}}" class="show-submenu">{{$menu->name}}</a>
                @if(isset($menu->childs) && count($menu->childs) > 0)
                  <ul>
                  @foreach($menu->childs as $submenu)
                    <li><a href="{{ URL::to(''.$submenu->link)}}">{{$submenu->name}}</a></li>
                  @endforeach
                  </ul>
                @endif
              </li>
              @endforeach              
                            
            </ul>
          </div>
          <!--/main-menu -->
        </nav>
        <div class="col-xl-3 col-lg-3 d-lg-flex align-items-center justify-content-end text-right d-flex top_line version_1">
          <ul class="top_links" >
            <li>
              <div class="styled-select lang-selector">
                @if(count($languages) > 1)
                  @if(session('language_name') == "English")
                  <!-- <input type="button" value="{{session('ar_id')}}" onclick="changeLang(this)"> -->
                  <button onclick="changeLangHeader({{session('ar_id')}})" style="border: none; color: white; background-color: rgb(255 255 255 / 1%); height: 30px; padding: 0 11px;">العربية</button>
                  @elseif(session('language_name') == "Arabic")
                  <!-- <input type="button" value="{{session('en_id')}}" onclick="changeLang(this)"> -->
                  <button onclick="changeLangHeader({{session('en_id')}})" style="border: none; color: white; background-color: rgb(255 255 255 / 1%); height: 30px; padding: 0 11px;">English</button>
                  @endif
                  <!-- <select id="language_select" onchange="changeLang(this)">
                    @foreach($languages as $language)                  
                    <option value="{{$language->languages_id}}" @if($language->name == session('language_name')) selected @endif>{{$language->name}}</option>
                    @endforeach
                  </select> -->
                  @include('web.common.scripts.changeLanguage')
                @else
                <select>
                  <option value="1" selected>{{session('language_name')}}</option>                
                </select>
                @endif
              </div>
            </li>
            
            <!--<li>-->
            <!--  <div class="styled-select currency-selector">                        -->
            <!--    @if(count($currencies) > 1)-->
            <!--      <select id="currency_select" onchange="changeCurrency(this)">-->
            <!--        @foreach($currencies as $currency)-->
            <!--        <option value="{{$currency->id}}" @if($currency->code == session('currency_code')) selected @endif>{{$currency->code}}</option>                -->
            <!--        @endforeach-->
            <!--      </select>-->
            <!--      @include('web.common.scripts.changeCurrency')-->
            <!--    @else-->
            <!--    <select>-->
            <!--      <option value="1" selected>{{session('currency_code')}}</option>                -->
            <!--    </select>-->
            <!--    @endif-->
            <!--  </div>-->
            <!--</li>							-->
          </ul>
        </div>
      </div>
      <!-- /row -->
    </div>
  </div>
  <!-- /main_header -->
  
  <div class="main_nav Sticky">
    <div class="container">
      <div class="row small-gutters">
        <div class="col-xl-3 col-lg-3 col-md-3">
          <nav class="categories" >
            @include('web.common.HeaderCategories')
            <ul class="clearfix">
              <li>
                <span>
                  <a href="#">
                    <span class="hamburger hamburger--spin">
                      <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                      </span>
                    </span>
                    @lang('website.Categories')
                  </a>
                </span>
                <div id="menu">
                  <ul>
                    @php productCategories(); @endphp
                  </ul>
                </div>
              </li>
            </ul>
          </nav>
        </div>
        <div class="col-xl-6 col-lg-7 col-md-6 d-none d-md-block">
          <div class="custom-search-input">
            <form class="form-inline" action="{{ URL::to('/shop')}}" method="get">              
              <input type="hidden" name="category" class="category-value" value="">
              <input type="text" name="search" placeholder="@lang('website.Search entire store here')..."
                data-toggle="tooltip" data-placement="bottom" title="@lang('website.Search Products')"
                value="{{ app('request')->input('search') }}">              
              <button type="submit"><i class="header-icon_search_custom"></i></button>
            </form>            
          </div>
        </div>
        <div class="col-xl-3 col-lg-2 col-md-3">
          <ul class="top_tools">
            @include('web.headers.cartButtons.cartButton9')

            <li>
              <a href="{{url('wishlist')}}" class="total_wishlist wishlist"><strong>{{$result['commonContent']['total_wishlist']}}</strong></a>
            </li>

            <li>
              <div class="dropdown dropdown-access">
                <a class="access_link"><span>Account</span></a>
                <div class="dropdown-menu">                  
                  <?php if(auth()->guard('customer')->check()){ ?>
                  <ul>
                    <!-- <li>
                      <a href="#"><i class="ti-truck"></i>Track your Order</a>
                    </li> -->
                    <li>
                      <a href="{{url('orders')}}"><i class="ti-package"></i>@lang('website.Orders')</a>
                    </li>
                    <li>
                      <a href="{{url('profile')}}"><i class="ti-user"></i>@lang('website.Profile')</a>
                    </li>
                    <li>
                      <a href="{{url('shipping-address')}}"><i class="ti-help-alt"></i>@lang('website.Shipping Address')</a>
                    </li>
                    @if(session('role_id') != session('vendor_role'))
                    <li>
                      <a href="{{URL::to('/vendorForm')}}"><i class="ti-help-alt"></i>@lang('website.BecomeVendor')</a>
                    </li>
                    @endif
                    @if(session('role_id') == session('vendor_role'))
                    <li>
                      <a href="{{URL::to('/getmyproduct')}}"><i class="ti-help-alt"></i>@lang('website.MyProducts')</a>
                    </li>
                    <li>
                      <a href="{{URL::to('/addProduct')}}"><i class="ti-help-alt"></i>@lang('website.addProduct')</a>
                    </li>
                    @endif
                    <li>
                      <a href="{{url('logout')}}"><i class="ti-help-alt"></i>@lang('website.Logout')</a>
                    </li>
                  </ul>
                  <?php }else{ ?>
                    <a href="{{ URL::to('/login')}}" class="btn_1">@lang('website.Login/Register')</a>
                    <a class="btn_1 outline" href="{{URL::to('/vendorForm')}}" style="margin-top: 10px;">@lang('website.BecomeVendor')</a>
                  <?php } ?>
                </div>
              </div>
              <!-- /dropdown-access-->
            </li>
            <li class="btn_search_mob">
              @lang('website.Search')
              <a href="javascript:void(0);" class="btn_search_mob" style="margin-left: 5px;"><span>Search</span></a>
            </li>
            <!--<li>-->
            <!--  <a href="#menu" class="btn_cat_mob">-->
            <!--    <div class="hamburger hamburger--spin" id="hamburger">-->
            <!--      <div class="hamburger-box">-->
            <!--        <div class="hamburger-inner"></div>-->
            <!--      </div>-->
            <!--    </div>-->
            <!--    @lang('website.Categories')-->
            <!--  </a>-->
            <!--</li>-->
          </ul>
        </div>
      </div>
      <!-- /row -->
    </div>
    <div class="search_mob_wp">
      <form class="form-inline" action="{{ URL::to('/shop')}}" method="get">
        <input type="text" class="form-control" id="inlineFormInputGroup0" name="search" placeholder="@lang('website.Search entire store here')...">
        <button class="btn_1 full-width" type="submit">
          <i class="fas fa-search"></i>
        </button>
      </form>
    </div>
    <!-- /search_mobile -->
  </div>
  
  <script>
    $('.dropdown-cart, .dropdown-access').hover(function () {
      $(this).find('.dropdown-menu').stop(true, true).delay(50).fadeIn(300);
    }, function () {
      $(this).find('.dropdown-menu').stop(true, true).delay(50).fadeOut(300);
    });

    $('.dropdown-cart, .dropdown-access').on('click',function () {
      console.log('=============================')
      $(this).find('.dropdown-menu').css('display', 'block');
    });
  </script>
  <!-- /main_nav -->
</header>