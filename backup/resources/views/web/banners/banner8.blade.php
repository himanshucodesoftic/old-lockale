<!-- //banner eight -->
<div class="banner-eight">

  <ul id="banners_grid" class="clearfix">
    @if(count($result['commonContent']['homeBanners'])>0)
      @foreach(($result['commonContent']['homeBanners']) as $homeBanners)
        @if($homeBanners->type==15 || $homeBanners->type==16 || $homeBanners->type==17)
        <li>
          <a href="{{ $homeBanners->banners_url}}" class="img_container">
            <img src="{{asset('').$homeBanners->path}}" data-src="{{asset('').$homeBanners->path}}" alt="" class="lazy">
            <div class="short_info opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0.2)">
              <!-- <h3>Men's Collection</h3> -->
              <div><span class="btn_1">Shop Now</span></div>
            </div>
          </a>
        </li>
        @endif
      @endforeach
    @endif    
  </ul>
</div>