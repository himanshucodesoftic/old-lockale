<!-- //footer style Six -->

<footer id="footerMobile" class="revealed d-lg-none d-xl-none">
  <div class="container">
    <div class="row">
      <div class="col-lg-3 col-md-6 collapse_div">
        <h3 data-target="#collapse_1">@lang('website.Information')</h3>
        <div class="collapse dont-collapse-sm links" id="collapse_1">
          <ul>
            @if(count($result['commonContent']['pages']))
            @foreach($result['commonContent']['pages'] as $page)
            <li><a href="{{ URL::to('/page?name='.$page->slug)}}">{{$page->name}}</a></li>
            @endforeach
            @endif
            <li><a href="{{ URL::to('/profile')}}">@lang('website.My Account')</a></li>
            <li><a href="{{ URL::to('/contact')}}">@lang('website.Contact Us')</a></li>
          </ul>
        </div>
      </div>

      <div class="col-lg-3 col-md-6 collapse_div">
        <h3 data-target="#collapse_2">@lang('website.Categories')</h3>
        <div class="collapse dont-collapse-sm links" id="collapse_2">
          <ul>
            @foreach($result['categories'] as $cate)
            <li><a href="{{ URL::to('/shop?category='.$cate->slug)}}">{{$cate->categories_name}}</a></li>
            @endforeach            
          </ul>
        </div>
      </div>

      <div class="col-lg-3 col-md-6 collapse_div">
        <h3 data-target="#collapse_3">@lang('website.Contact Us')</h3>
        <div class="collapse dont-collapse-sm contacts" id="collapse_3">
          <ul>
            <!-- <li><i class="ti-home"></i>{{$result['commonContent']['setting'][4]->value}}
                {{$result['commonContent']['setting'][5]->value}} {{$result['commonContent']['setting'][6]->value}},
                {{$result['commonContent']['setting'][7]->value}}
                {{$result['commonContent']['setting'][8]->value}}</li> -->
            <li><i class="ti-headphone-alt"></i>{{$result['commonContent']['setting'][11]->value}}</li>
            <li><i class="ti-email"></i><a href="mailto:{{$result['commonContent']['setting'][3]->value}}">{{$result['commonContent']['setting'][3]->value}}</a></li>
          </ul>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 collapse_div">
        <h3 data-target="#collapse_4">@lang('website.Keep in touch')</h3>
        <div class="collapse dont-collapse-sm" id="collapse_4">
          <div id="newsletter">
            <form class="form-inline">
              <div class="form-group">                
                <input type="email" name="email" id="email" class="form-control" placeholder="@lang('website.Your email address here')">                    
                <button type="submit" id="submit-newsletter"><i class="ti-angle-double-right"></i></button>
              </div>
            </form>
          </div>
          <div class="follow_us">
            <h5>@lang('website.Follow Us')</h5>
            <ul>
              <!-- <li>
                @if(!empty($result['commonContent']['setting'][52]->value))
                  <a href="{{$result['commonContent']['setting'][52]->value}}" target="_blank"><img
                    src="{{asset('images/img/twitter_icon.svg')}}"
                    data-src="{{asset('images/img/twitter_icon.svg')}}" alt="" class="lazy"></a>
                  @else
                  <a href="#" class="fab fa-twitter"></a>
                @endif
              </li> -->
              <!-- <li>
                @if(!empty($result['commonContent']['setting'][50]->value))
                  <a href="{{$result['commonContent']['setting'][50]->value}}" target="_blank"><img
                    src="{{asset('images/img/facebook_icon.svg')}}"
                    data-src="{{asset('images/img/facebook_icon.svg')}}" alt="" class="lazy"></a>
                @else
                  <a href="#" class="fab fa-facebook-f"></a>
                @endif                
              </li> -->
              <li>
                <!-- @if(!empty($result['commonContent']['setting'][51]->value))
                  <a href="https://www.instagram.com/lokal_kw/" target="_blank"><img
                    src="{{asset('images/img/instagram_icon.svg')}}"
                    data-src="{{asset('images/img/instagram_icon.svg')}}" alt="" class="lazy"></a>
                  @else
                  <a href="#"><i class="fab fa-google"></i></a>
                @endif -->
                <a href="https://www.instagram.com/lokal_kw/" target="_blank"><img
                    src="{{asset('images/img/instagram_icon.svg')}}"
                    data-src="{{asset('images/img/instagram_icon.svg')}}" alt="" class="lazy"></a>
              </li>
              <!-- <li>
                @if(!empty($result['commonContent']['setting'][53]->value))
                  <a href="{{$result['commonContent']['setting'][53]->value}}" target="_blank"><img
                    src="{{asset('images/img/youtube_icon.svg')}}"
                    data-src="{{asset('images/img/youtube_icon.svg')}}" alt="" class="lazy"></a>
                  @else
                  <a href="#" class="fab fa-linkedin-in"></a>
                @endif              
              </li> -->
            </ul>
          </div>
        </div>
      </div>
    </div>
    <!-- /row-->
    <hr>
    <div class="row add_bottom_25">
      <div class="col-lg-6">
        <ul class="footer-selector clearfix">
          <li>
            <div class="styled-select lang-selector">
              @if(count($result['languages']) > 1)
                <!--<select id="language_select" onchange="changeLang(this)">-->
                <!--  @foreach($result['languages'] as $language)                  -->
                <!--  <option value="{{$language->languages_id}}" @if($language->name == session('language_name')) selected @endif>{{$language->name}}</option>-->
                <!--  @endforeach-->
                <!--</select>-->
                
                @if(session('language_name') == "English")                  
                  <button onclick="changeLangHeader({{session('ar_id')}})" style="border: none; color: white; background-color: rgb(255 255 255 / 0%); height: 30px; padding: 0 11px;">العربية</button>

                @elseif(session('language_name') == "Arabic")
                  <button onclick="changeLangHeader({{session('en_id')}})" style="border: none; color: white; background-color: rgb(255 255 255 / 0%); height: 30px; padding: 0 11px;">English</button>
                @endif
                
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
          <!--    @if(count($result['currencies']) > 1)-->
          <!--      <select id="currency_select" onchange="changeCurrency(this)">-->
          <!--        @foreach($result['currencies'] as $currency)-->
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
          <!--</li>-->
          <!-- <li>
            <img src="{{asset('images/payment_gateway.png')}}"
              data-src="{{asset('images/payment_gateway.png')}}" alt="" width="198" height="30" class="lazy">
          </li>           -->
        </ul>
      </div>
      <div class="col-lg-6">
        <ul class="additional_links">          
          <!-- <li><a href="{{url('/page?name=term-services')}}">@lang('website.Terms & Condtions')</a></li>
          <li><a href="{{url('/page?name=refund-policy')}}">@lang('website.Privacy')</a></li> -->
          <li><span>© @lang('website.Copy Rights')</span></li>
        </ul>
      </div>
    </div>
  </div>
</footer>
