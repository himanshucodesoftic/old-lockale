<section class="new-products-content pro-content">
  <div class="container">
    <div class="products-area">
      <div class="row justify-content-center">
        <div class="col-12 col-lg-6">
          <div class="pro-heading-title">
            <h2> @lang('website.Top Selling of the Week')

            </h2>
            <!--<p>-->
            <!--  @lang('website.Top Sellings Of the Week Detail')</p>-->
          </div>
        </div>
      </div>

      <div class="row small-gutters">
        @if($result['weeklySoldProducts']['success']==1)
        @foreach($result['weeklySoldProducts']['product_data'] as $key=>$products)
        @if($key==0)

        <div class="col-12 col-lg-6">
          @include('web.common.product')          
        </div>

        @endif
        @endforeach
        @endif

        @if($result['weeklySoldProducts']['success']==1)
          @foreach($result['weeklySoldProducts']['product_data'] as $key=>$products)
            @if($key!=0)
              @if($key<=6) 
              <div class="col-6 col-md-4 col-xl-3 col-lg-3">
                @include('web.common.product')
              </div>
              @endif
            @endif
          @endforeach
        @endif

      </div>
    </div>
  </div>
</section>