<!-- contact Content -->
<style>
.contact-content .contact-info li {
  width: 100%;
  text-overflow: ellipsis;
  overflow: hidden;
  white-space: nowrap;
}
</style>
<div class="container-fuild">
  <nav aria-label="breadcrumb">
    <div class="container">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ URL::to('/')}}">@lang('website.Home')</a></li>
        <li class="breadcrumb-item active" aria-current="page">@lang('website.Contact Us')</li>
      </ol>
    </div>
  </nav>
</div>

<section class="pro-content">
  <link href="{!! asset('web/css/theme_css/contact.css') !!}" rel="stylesheet">
  <!-- <div class="container">
    <div class="page-heading-title">
      <h2> @lang('website.Contact Us')
      </h2>
    </div>
  </div> -->

  <section class="contact-content bg_gray">

    <div class="container margin_60">
      <div class="main_title">
        <h2>@lang('website.Contact Us')</h2>        
      </div>
      <div class="row justify-content-center">
        <div class="col-lg-4">
          <div class="box_contacts">
            <i class="ti-support"></i>
            <h2>@lang('website.Help Center')</h2>
            <a href="#0">{{$result['commonContent']['setting'][11]->value}}</a> - <a href="#0">{{$result['commonContent']['setting'][3]->value}}</a>
            <small>MON to FRI 9am-6pm SAT 9am-2pm</small>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="box_contacts">
            <i class="ti-map-alt"></i>
            <h2>@lang('website.Showroom')</h2>
            <div>{{$result['commonContent']['setting'][4]->value}}
                {{$result['commonContent']['setting'][5]->value}} {{$result['commonContent']['setting'][6]->value}},
                {{$result['commonContent']['setting'][7]->value}}
                {{$result['commonContent']['setting'][8]->value}}</div>
            <small>MON to FRI 9am-6pm SAT 9am-2pm</small>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="box_contacts">
            <i class="ti-package"></i>
            <h2>@lang('website.Orders')</h2>
            <a href="#0">{{$result['commonContent']['setting'][11]->value}}</a> - <a href="#0">{{$result['commonContent']['setting'][70]->value}}</a>
            <small>MON to FRI 9am-6pm SAT 9am-2pm</small>
          </div>
        </div>
      </div>
      <!-- /row -->
    </div>

    <form enctype="multipart/form-data" action="{{ URL::to('/processContactUs')}}" method="post">
      <input name="_token" value="{{ csrf_token() }}" type="hidden">

      <div class="bg_white">
        <div class="container margin_60_35">
          <h4 class="pb-3">@lang('website.Drop Us a Line')</h4>
          <div class="row">
            <div class="col-lg-4 col-md-6 add_bottom_25">
              <div class="form-group">
                <input type="text" class="form-control" id="name" name="name" placeholder="@lang('website.Please enter your name')" aria-describedby="inputGroupPrepend" required>
                <div class="help-block error-content invalid-feedback" hidden>@lang('website.Please enter your name')</div>
              </div>
              <div class="form-group">                
                <input type="email" name="email" class="form-control" id="validationCustomUsername"
                      placeholder="@lang('website.Enter Email here').." aria-describedby="inputGroupPrepend" required>
                <div class="help-block error-content invalid-feedback" hidden>@lang('website.Please enter your valid email address')</div>
              </div>
              <div class="form-group">                
                <textarea type="text" class="form-control" name="message" style="height: 150px;" placeholder="@lang('website.write your message here')..."></textarea>
                <div class="help-block error-content invalid-feedback" hidden>@lang('website.Please enter your message')</div>
              </div>
              <div class="form-group">
                <input class="btn_1 full-width" type="submit" value="@lang('website.Submit')">
              </div>
            </div>
            <div class="col-lg-8 col-md-6 add_bottom_25">
              <iframe class="map_contact"
                src="https://maps.google.com/maps?width=949&amp;height=400&amp;hl=en&amp;q=Salhiya St, Kuwait City, Kuwait&amp;t=&amp;z=11&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"
                style="border: 0" allowfullscreen></iframe>
                
            </div>
          </div>
          <!-- /row -->
        </div>
        <!-- /container -->
      </div>
    </form>


    <!-- <div class="container">
      <div class="row">
        <div class="col-12 col-sm-12">
          <div class="row">
            <div class="col-12 col-lg-8">

              <div class="form-start">
                @if(session()->has('success') )
                <div class="alert alert-success">
                  {{ session()->get('success') }}
                </div>
                @endif
                <form enctype="multipart/form-data" action="{{ URL::to('/processContactUs')}}" method="post">
                  <input name="_token" value="{{ csrf_token() }}" type="hidden">

                  <label class="first-label" for="email">@lang('website.Full Name')</label>
                  <div class="input-group">

                    <input type="text" class="form-control" id="name" name="name"
                      placeholder="@lang('website.Please enter your name')" aria-describedby="inputGroupPrepend"
                      required>
                    <div class="help-block error-content invalid-feedback" hidden>@lang('website.Please enter your name')</div>

                  </div>
                  <label for="email">@lang('website.Email')</label>
                  <div class="input-group">
                    <input type="email" name="email" class="form-control" id="validationCustomUsername"
                      placeholder="@lang('website.Enter Email here').." aria-describedby="inputGroupPrepend" required>
                    <div class="help-block error-content invalid-feedback" hidden>@lang('website.Please enter your valid email address')</div>
                  </div>
                  <label for="email">@lang('website.Message')</label>
                  <textarea type="text" name="message" placeholder="@lang('website.write your message here')..."
                    rows="5" cols="56"></textarea>
                  <div class="help-block error-content invalid-feedback" hidden>@lang('website.Please enter your message')</div>

                  <button type="submit" class="btn btn-secondary swipe-to-top">@lang('website.Submit') <i
                      class="fas fa-location-arrow"></i>

                </form>
              </div>
            </div>
            <div class="col-12 col-lg-4 contact-main">
              <div class="row">
                <div class="col-6">

                  <ul class="contact-logo pl-0 mb-0">
                    <li> <i class="fas fa-mobile-alt"></i><br>@lang('website.CONTACT US') </li>
                    <li> <i class="fas fa-map-marker"></i><br>@lang('website.ADDRESS')
                    </li>
                    <li> <i class="fas fa-envelope"></i><br>@lang('website.EMAIL ADDRESS') </li>
                    <li> <i class="fas fa-tty"></i><br>
                      <phone dir="ltr">@lang('website.FAX')</phone>
                    </li>
                  </ul>
                </div>
                <div class="col-6 right">
                  <ul class="contact-info  pl-0 mb-0">
                    <li>
                      <font>
                        <a href="#" dir="ltr"><br>{{$result['commonContent']['setting'][11]->value}}</a>
                      </font>
                    </li>
                    <li>
                      <font><a href="#">{{$result['commonContent']['setting'][4]->value}}
                        <br>
                {{$result['commonContent']['setting'][5]->value}} {{$result['commonContent']['setting'][6]->value}},
                {{$result['commonContent']['setting'][7]->value}}
                {{$result['commonContent']['setting'][8]->value}}</a></font>
                    </li>
                    <li>
                      <font><a
                          href="mailto:{{$result['commonContent']['setting'][3]->value}}"><br>{{$result['commonContent']['setting'][3]->value}}</a>
                      </font>
                    </li>
                    <li>
                      <font><a href="#" dir="ltr"><br>{{$result['commonContent']['setting'][11]->value}}</a> </font>
                    </li>
                  </ul>
                </div>
              </div>

              <p style="margin-top:30px;"">
              @lang('website.Contact us text')
              </p>
            </div>       
           
          </div>
        </div>
      </div>
    
    </div> -->

  </section>

</section>